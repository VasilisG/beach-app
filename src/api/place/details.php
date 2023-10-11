<?php

include '../../config/db.php';

if(!isset($_GET['place_id'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Could not find place parameter.'
    ]);

}

else {

    $marker_data = [];

    $select_place_query = "SELECT p.*, u.user_id, u.username FROM place AS p JOIN user AS u ON p.user_id=u.user_id WHERE p.place_id={$_GET['place_id']}";

    $result = mysqli_query($db_connection, $select_place_query);

    if($result) {

        $place = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $marker_data['place'] = $place;
    }

    $select_photos_query = "SELECT p.*, u.user_id, u.username FROM photo AS p JOIN user AS u ON p.user_id=u.user_id WHERE p.place_id={$_GET['place_id']}";

    $result = mysqli_query($db_connection, $select_photos_query);

    if($result) {

        $marker_data['photos'] = [];

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $marker_data['photos'][] = $row;
        }

    }

    $select_comments_query = "SELECT c.*, u.user_id, u.username FROM comment AS c JOIN user AS u ON c.user_id=u.user_id WHERE c.place_id={$_GET['place_id']} ORDER BY c.date_created ASC";

    $result = mysqli_query($db_connection, $select_comments_query);

    if($result) {

        $marker_data['comments'] = [];

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $marker_data['comments'][] = $row;

        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => $marker_data
    ]);
}