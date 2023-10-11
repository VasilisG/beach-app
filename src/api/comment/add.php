<?php

include '../../config/db.php';

session_start();

if(!isset($_SESSION['token'])){

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You need to log in to add a comment.'
        ]
    );

}

else {

    if(!isset($_POST['user-comment']) || !isset($_POST['place_id'])) {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Incorrect POST data.'
            ]
        );

    }

    else {
        
        if(strlen($_POST['user-comment']) > 0){

            $content = trim($_POST['user-comment']);

            $content = htmlspecialchars($content);
            
            $content = str_replace(['\r\n', '\r', '\n'], '<br>', $content);

            $date_created = date('Y-m-d H:i:s');

            $insert_comment_query = "INSERT INTO comment (place_id, user_id, content, date_created) VALUES(?, ?, ?, ?)";

            $insert_comment_stmt = mysqli_prepare($db_connection, $insert_comment_query);
        
            $bind_param = mysqli_stmt_bind_param($insert_comment_stmt, 'iiss', $_POST['place_id'], $_SESSION['user_id'], $content, $date_created);
        
            $insert_stmt_execute = mysqli_stmt_execute($insert_comment_stmt);

            if($insert_stmt_execute) {

                $last_comment_id = mysqli_insert_id($db_connection);

                $select_last_comment_query = "SELECT c.*, u.username FROM comment AS c JOIN user AS u ON c.user_id=u.user_id WHERE c.comment_id={$last_comment_id}";

                $result = mysqli_query($db_connection, $select_last_comment_query);

                if($result) {

                    $comment_data = [];

                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        $comment_data = $row;

                    }

                    echo json_encode(
                        [
                            'status' => 'success',
                            'message' => $comment_data
                        ]
                    );

                }
        
            }

            else {

                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'Could not add comment: ' . mysqli_error($db_connection)
                    ]
                );

            }

        }

        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Incorrect content data.'
                ]
            );

        }

    }
}