<?php

include '../../config/db.php';
include '../../config/env.php';

if(!isset($_POST['username']) || !isset($_POST['password'])){

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You must fill all form fields.'
        ]
    );

}
else {

    $username = mysqli_real_escape_string($db_connection, $_POST['username']);

    $username = htmlspecialchars($username);

    $password = mysqli_real_escape_string($db_connection, $_POST['password']);

    $password = htmlspecialchars($password);

    $password_hash = hash('sha256', $password);

    $select_user_query = "SELECT * FROM user WHERE username='{$username}' AND password_hash='{$password_hash}'";

    $result = mysqli_query($db_connection, $select_user_query);

    if($result) {

        if(mysqli_num_rows($result) > 0) {

            $user_data = mysqli_fetch_assoc($result);

            $new_last_login = date('Y-m-d H:i:s');

            $token = hash('sha256', $user_data['username']) . hash('sha256', $user_data['password_hash']) . hash('sha256', $user_data['last_login']);

            session_start();

            $_SESSION['user_id'] = $user_data['user_id'];

            $_SESSION['username'] = $user_data['username'];

            $_SESSION['last_login'] = $new_last_login;

            $_SESSION['token'] = $token;

            $update_last_login_query = "UPDATE user SET last_login='{$new_last_login}' WHERE username='{$username}' AND password_hash='{$password_hash}'";

            $login_query = mysqli_query($db_connection, $update_last_login_query);

            if($login_query) {

                echo json_encode(
                    [
                        'status' => 'success',
                        'message' => json_encode(
                            [
                                'user_id' => $_SESSION['user_id'],
                                'username' => $_SESSION['username'],
                                'last_login' => $_SESSION['last_login'],
                                'token' => $_SESSION['token']
                            ]
                        )
                    ]
                );

            }
            else {

                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'User could not log in.'
                    ]
                );

            }
        }
        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Invalid credentials.'
                ]
            );

        }
    }
    else {

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Could not get user.'
            ]
        );

    }
}