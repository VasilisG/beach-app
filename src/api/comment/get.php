<?php

require_once '../../config/db.php';

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

    if(isset($_GET['param_name']) && isset($_GET['param_value']) && !empty($_GET['param_name']) && !empty($_GET['param_value'])) {

        $select_comments_query = "SELECT c.*, u.username FROM comment AS c JOIN user AS u ON c.user_id=u.user_id WHERE {$_GET['param_name']}={$_GET['param_value']} ORDER BY comment_id ASC";

        $result = mysqli_query($db_connection, $select_comments_query);

        if($result) {

            $result_data = [];
    
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    
                $result_data[] = $row;
            }
    
            echo json_encode(
                [
                    'status' => 'success',
                    'message' => 'Comments section updated.',
                    'comments' => $result_data
                ]
            );
        }

    }

    else {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not refresh comments.'
            ]
        );

    }
}