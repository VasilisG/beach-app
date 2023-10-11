<?php

include '../../config/db.php';

$marker_data = [];

$get_markers_query = "SELECT place_id, latitude, longitude, user_id, name FROM place";

$result = mysqli_query($db_connection, $get_markers_query);

if($result) {

    while($row = mysqli_fetch_array($result)) {

        $marker_data[] = [
            'place_id' => $row['place_id'],
            'lat' => $row['latitude'],
            'lng' => $row['longitude'],
            'name' => $row['name'],
            'user_id' => $row['user_id']
        ];
    
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => $marker_data
    ]);

}
else {

    echo json_encode([
        'status' => 'error',
        'message' => mysqli_error($db_connection)
    ]);

}