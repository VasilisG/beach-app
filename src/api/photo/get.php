<?php

include '../../config/db.php';

session_start();

if(!isset($_SESSION['token'])) {

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You must login first.'
        ]
    );
}

else {

    if(isset($_GET['place_id'])) {

        $select_photo_query = "SELECT p.photo_id, p.filename, p.date_created, u.user_id, u.username FROM photo AS p JOIN user AS u ON p.user_id=u.user_id WHERE place_id={$_GET['place_id']}";

        $result = mysqli_query($db_connection, $select_photo_query);
    
        if($result) {
    
            $result_data = [];
    
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
                $result_data[] = $row;
            }
    
            echo json_encode(
                [
                    'status' => 'success',
                    'message' => json_encode($result_data)
                ]
            );
    
        }
    
        else {
    
            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Could not retrieve photos.'
                ]
            );
    
        }
    }

    else {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not retrieve photos.'
            ]
        );

    }
}