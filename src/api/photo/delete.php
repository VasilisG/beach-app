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

    if(!empty($_POST['photo_id'])){

        $select_photo_query = "SELECT filename FROM photo WHERE photo_id={$_POST['photo_id']}";

        $select_result = mysqli_query($db_connection, $select_photo_query);

        if($select_result) {

            $resultData = mysqli_fetch_array($select_result, MYSQLI_ASSOC);

            $delete_photo_query = "DELETE FROM photo WHERE photo_id={$_POST['photo_id']}";

            $result = mysqli_query($db_connection, $delete_photo_query);
    
            if($result && $resultData) {

                $fileRemoved = unlink($BASE_DIR . $resultData['filename']);

                if($fileRemoved) {

                    echo json_encode(
                        [
                            'status' => 'success',
                            'message' => 'Photo deleted.'
                        ]
                    );

                }

                else {

                    echo json_encode(
                        [
                            'status' => 'success',
                            'message' => 'Photo removed from gallery.'
                        ]
                    );

                }

            }
    
            else {
    
                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'Could not delete photo.'
                    ]
                );
    
            }
        }

        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Could not delete photo.'
                ]
            );
        }
    }
}