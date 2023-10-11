<?php

include '../../config/db.php';
include '../../config/env.php';

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

    if(!empty($_POST['place_id'])) {

        $place_id = $_POST['place_id'];

        $select_photos_query = "SELECT filename from photo WHERE place_id={$place_id}";

        $result = mysqli_query($db_connection, $select_photos_query);

        if($result) {

            $photo_filenames = [];

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
                $photo_filenames[] = $row['filename'];
            }

        }

        $delete_photos_query = "DELETE FROM photo WHERE place_id={$place_id}";

        $delete_comments_query = "DELETE FROM comment WHERE place_id={$place_id}";

        $delete_place_query = "DELETE FROM place WHERE place_id={$place_id}";

        mysqli_query($db_connection, $delete_photos_query);

        mysqli_query($db_connection, $delete_comments_query);

        mysqli_query($db_connection, $delete_place_query);


        $allFilesRemoved = true;

        if(count($photo_filenames)) {

            foreach($photo_filenames as $filename) {

                $fileRemoved = unlink($BASE_DIR . $filename);

                if(!$fileRemoved) {

                    $allFilesRemoved = false;
                }
            }
        }

        if($allFilesRemoved) {

            echo json_encode(
                [
                    'status' => 'success',
                    'message' => 'Place deleted successfully.'
                ]
            );

        }

        else {

            echo json_encode(
                [
                    'status' => 'success',
                    'message' => 'Place deleted.'
                ]
            );

        }

    }

    else {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not delete place.'
            ]
        );
    }
}