<?php

include '../../config/db.php';
include '../../config/env.php';

session_start();

if(!isset($_SESSION['token'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'You need to log in first.'
    ]);

    return;
}

if(!isset($_POST['name'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Please provide a name.'
    ]);

    return;

}

if(!isset($_POST['latitude']) || !isset($_POST['longitude'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Coordinates are not correctly set.'
    ]);

    return;

}

$latitude = mysqli_escape_string($db_connection, $_POST['latitude']);

$longitude = mysqli_escape_string($db_connection, $_POST['longitude']);

$name = mysqli_escape_string($db_connection, $_POST['name']);

$name = trim($name);

$name = strip_tags($name);

$description = '';

if(!empty($_POST['description'])) {

    $description = mysqli_escape_string($db_connection, $_POST['description']);

    $description = trim($description);

    $description = strip_tags($description);

    $description = nl2br($description);

    $description = str_replace(['\r\n', '\r', '\n'], '<br>', $description);
}

$comment = '';

if(!empty($_POST['comment'])) {

    $comment = mysqli_escape_string($db_connection, $_POST['comment']);

    $comment = trim($comment);

    $comment = strip_tags($comment);
    
    $comment = str_replace(['\r\n', '\r', '\n'], '<br>', $comment);
}

if(isset($_POST['add-beach'])) {

    if(isset($_FILES['photos'])) {

        if(count($_FILES['photos']['tmp_name']) > $MAX_FILES_TO_UPLOAD) {

            echo json_encode([
                'status' => 'error',
                'message' => "Maximum of {$MAX_FILES_TO_UPLOAD} photos are allowed to be uploaded."
            ]);

            return;

        }

        foreach($_FILES['photos']['tmp_name'] as $photo) {
    
            $image_meta_data = getimagesize($photo);
    
            $image_mime_type = image_type_to_mime_type($image_meta_data[2]);
    
            if(!in_array($image_mime_type, $ALLOWED_MIME_TYPES)) {
    
                echo json_encode([
                    'status' => 'error',
                    'message' => "{$photo['name']}: Only JPEG or PNG file formats allowed."
                ]);
    
                return;
    
            }
    
            if($photo['size'] > $MAX_FILE_SIZE) {
    
                echo json_encode([
                    'status' => 'error',
                    'message' => "{$photo['name']}: Image size is larger than 2MB."
                ]);
    
                return;
            }
    
        }
    
    }

}

$placeCreated = false;

$commentAdded = false;

$photosUploaded = false;

$errorMessages = [];

$faultyPhotos = [];

$user_id = $_SESSION['user_id'];

$hasPhotos = isset($_FILES['photos']) && $_FILES['photos']['size'][0] != 0;

$photos = $hasPhotos ? count($_FILES['photos']['tmp_name']) : 0;

$comments = !empty($comment) ? 1 : 0;

$date_created = date('Y-m-d H:i:s');

$insert_place_query = "INSERT INTO place (user_id, latitude, longitude, name, description, photos, comments, date_created) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

$insert_place_stmt = mysqli_prepare($db_connection, $insert_place_query);

$bind_param = mysqli_stmt_bind_param($insert_place_stmt, 'issssiis', $user_id, $latitude, $longitude, $name, $description, $photos, $comments, $date_created);

$insert_stmt_execute = mysqli_stmt_execute($insert_place_stmt);

if($insert_stmt_execute) {
    
    $placeCreated = true;

}

else {

    echo json_encode([
        'status' => 'error',
        'message' => 'Could not create place: ' . mysqli_error($db_connection)
    ]);

    return;

}

$place_id = mysqli_insert_id($db_connection);

if(!empty($comment)) {

    $insert_comment_query = "INSERT INTO comment (place_id, user_id, content, date_created) VALUES(?, ?, ?, ?)";

    $insert_comment_stmt = mysqli_prepare($db_connection, $insert_comment_query);

    $bind_param = mysqli_stmt_bind_param($insert_comment_stmt, 'iiss', $place_id, $user_id, $comment, $date_created);

    $insert_stmt_execute = mysqli_stmt_execute($insert_comment_stmt);

    if($insert_stmt_execute) {

        $commentAdded = true;

    }

}

else {

    $commentAdded = true;

}

if(!empty($_FILES['photos'])) {
 
    $insert_photo_query = "INSERT INTO photo (place_id, user_id, filename, date_created) VALUES(?, ?, ?, ?)";

    $insert_photo_stmt = mysqli_prepare($db_connection, $insert_photo_query);

    foreach($_FILES['photos']['tmp_name'] as $index => $photo){

        $currentTimestamp = strval(time());

        $new_photo_name = $MEDIA_DIR . $currentTimestamp . '_' . $_FILES['photos']['name'][$index];

        if(move_uploaded_file($photo, $new_photo_name)){

            $new_photo_name = $APP_MEDIA_DIR . $currentTimestamp . '_' . $_FILES['photos']['name'][$index];

            $bind_param = mysqli_stmt_bind_param($insert_photo_stmt, 'iiss', $place_id, $user_id, $new_photo_name, $date_created);

            if(!mysqli_stmt_execute($insert_photo_stmt)) {

                $faultyPhotos[] = $photo;

            }

        }
        
        else {
            
            $errorMessages[] = 'Could not upload: ' . $photo;

        }
        
    }

}

if(count($faultyPhotos) == 0) {

    $photosUploaded = true;

}

if($placeCreated && $commentAdded && $photosUploaded) {

    echo json_encode([
        'status' => 'success',
        'message' => 'Place successfully saved.',
        'result' => json_encode([
            'lat' => $latitude,
            'lng' => $longitude,
            'name' => $name,
            'place_id' => $place_id
        ]),
        'files' => $_FILES['photos']
    ]);

}

else {

    if(!$commentAdded){

        $errorMessages[] = 'Comment could not be added.';

    }

    if(count($faultyPhotos) > 0) {

        $errorMessages[] = 'Photos could not be uploaded: ' . implode(', ', $faultyPhotos);

    }

    echo json_encode([
        'status' => 'error',
        'message' => json_encode($errorMessages) 
    ]);

}