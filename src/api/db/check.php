<?php

include '../../config/db.php';

if(!$db_connection){
    return json_encode(
        [
            'status' => 'error',
            'error_code' => mysqli_connect_errno(),
            'error_message' => mysqli_connect_error()
        ]
    );
}
else {
    return json_encode(
        [
            'status' => 'success'
        ]
    );
}