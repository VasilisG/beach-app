<?php

include '../../config/db.php';

session_start();

if(!isset($_SESSION['token'])) {

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You need to log in first to delete a comment.'
        ]
    );

}

else {

    if(!isset($_POST['comment_id'])) {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not find POST param.'
            ]
        );

    }

    else {

        $delete_comment_query = "DELETE FROM comment WHERE comment_id={$_POST['comment_id']}";

        $result = mysqli_query($db_connection, $delete_comment_query);

        if($result) {

            echo json_encode(
                [
                    'status' => 'success',
                    'message' => 'Comment deleted from place.'
                ]
            );
        }

        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Could not delete comment from place.'
                ]
            );

        }

    }
}