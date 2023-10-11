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

    if(!isset($_GET['user_id'])) {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not find user details.'
            ]
        );

    }

    else {

        $select_places_query = "SELECT place_id, name FROM place WHERE user_id={$_GET['user_id']}";

        $select_photos_query = "SELECT p.photo_id, p.filename, p.date_created, pl.place_id, pl.name FROM photo AS p JOIN place AS pl ON p.place_id=pl.place_id WHERE p.user_id={$_GET['user_id']} ORDER BY pl.date_created";

        $select_comments_query = "SELECT c.comment_id, c.content, c.date_created, pl.place_id, pl.name FROM comment AS c JOIN place AS pl ON c.place_id=pl.place_id WHERE c.user_id={$_GET['user_id']} ORDER BY pl.date_created";

        $places_result = mysqli_query($db_connection, $select_places_query);

        $photos_result = mysqli_query($db_connection, $select_photos_query);

        $comments_result = mysqli_query($db_connection, $select_comments_query);

        $user_data = [];

        if($places_result && $photos_result && $comments_result) {

            $user_data['places'] = [];

            $user_data['photos'] = [];

            $user_data['comments'] = [];

            while($row = mysqli_fetch_array($places_result, MYSQLI_ASSOC)) {
    
                $user_data['places'][$row['place_id']] = $row['name'];
            }

            while($row = mysqli_fetch_array($photos_result, MYSQLI_ASSOC)) {
    
                $user_data['photos'][$row['place_id']][] = $row;
            }

            while($row = mysqli_fetch_array($comments_result, MYSQLI_ASSOC)) {
    
                $user_data['comments'][$row['place_id']][] = $row;
            }

            echo json_encode(
                [
                    'status' => 'success',
                    'message' => $user_data
                ]
            );

        }

        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Could not get user data.'
                ]
            );

        }

    }
}