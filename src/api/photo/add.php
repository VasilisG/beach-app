<?php

include '../../config/env.php';
include '../../config/db.php';

session_start();

if(!isset($_SESSION['token'])) {

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You need to login first.'
        ]
    );

}

else {

    if(isset($_FILES['photos']) && (count($_FILES['photos']['name']) > 1 || (count($_FILES['photos']['name']) == 1 && $_FILES['photos']['name'][0] !== ''))) {

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
    
        }

        foreach($_FILES['photos']['size'] as $index => $size) {

            if($size > $MAX_FILE_SIZE) {

                $faultyFilename = $_FILES['photos']['name'][0];
    
                echo json_encode([
                    'status' => 'error',
                    'message' => "{$faultyFilename}: Image size is larger than 2MB."
                ]);
    
                return;
            }

        }

        $errorMessages = [];

        $place_id = $_POST['place_id'];
        
        $user_id = $_SESSION['user_id'];
         
        $insert_photo_query = "INSERT INTO photo (place_id, user_id, filename, date_created) VALUES(?, ?, ?, ?)";
    
        $insert_photo_stmt = mysqli_prepare($db_connection, $insert_photo_query);
    
        foreach($_FILES['photos']['tmp_name'] as $index => $photo){

            $currentTimestamp = strval(time());

            $date_created = date('Y-m-d H:i:s');
    
            $new_photo_name = $MEDIA_DIR . $currentTimestamp . '_' . $_FILES['photos']['name'][$index];
    
            if(move_uploaded_file($photo, $new_photo_name)){
    
                $new_photo_name = $APP_MEDIA_DIR . $currentTimestamp . '_' . $_FILES['photos']['name'][$index];
    
                $bind_param = mysqli_stmt_bind_param($insert_photo_stmt, 'iiss', $place_id, $user_id, $new_photo_name, $date_created);
    
                if(!mysqli_stmt_execute($insert_photo_stmt)) {
    
                    $errorMessages[] = $_FILES['photos']['name'][$index]. ' : ' . mysqli_error($db_connection);
    
                }
    
            }
            
            else {
                
                $errorMessages[] = 'Could not upload: ' . $photo;
    
            }
            
        }
        
        if(count($errorMessages) == 0) {
        
            echo json_encode(
                [
                    'status' => 'success',
                    'message' => 'Images uploaded to place.'
                ]
            );
        
        }

        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => json_encode($errorMessages)
                ]
            );

        }
    
    }

    else {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'No images to upload.'
            ]
        );

    }

}