<?php

include '../../config/db.php';
include '../../config/env.php';

if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])){

    echo json_encode(
        [
            'status' => 'error',
            'message' => 'You must fill all form field to register.'
        ]
    );

}

else {

    if(strlen($_POST['username']) > 24){
        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Username is too long.'
            ]
        );
    }

    if(strlen($_POST['password']) < 8){

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Password cannot be smaller than 8 characters.'
            ]
        );

    }
    elseif($_POST['password'] !== $_POST['confirm_password']){

        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Please verify your password.'
            ]
        );

    }
    else {

        $username = mysqli_real_escape_string($db_connection, $_POST['username']);

        $username = htmlspecialchars($username);

        $password = mysqli_real_escape_string($db_connection, $_POST['password']);

        $password = htmlspecialchars($password);

        $select_user_query = "SELECT * FROM user WHERE username='{$username}'";

        $result = mysqli_query($db_connection, $select_user_query);

        if($result){

            if(mysqli_num_rows($result) > 0){

                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => 'Try a different username'
                    ]
                );

            }
            else {

                $date_created = date('Y-m-d H:i:s');

                $last_login = date('Y-m-d H:i:s');

                $password_hash = hash('sha256', $password);

                $insert_user_query = "INSERT INTO user (username, password_hash, date_created, last_login) VALUES(?, ?, ?, ?)";

                $insert_user_stmt = mysqli_prepare($db_connection, $insert_user_query);

                if($insert_user_stmt){

                    $bind_param = mysqli_stmt_bind_param($insert_user_stmt, 'ssss', $username, $password_hash, $date_created, $last_login);

                    if($bind_param){

                        $insert_stmt_execute = mysqli_stmt_execute($insert_user_stmt);

                        if($insert_stmt_execute){

                            if(!mysqli_stmt_errno($insert_user_stmt)){

                                $token = hash('sha256', $username) . hash('sha256', $password_hash) . hash('sha256', $last_login);

                                session_start();

                                $_SESSION['user_id'] = mysqli_insert_id($db_connection);

                                $_SESSION['username'] = $username;

                                $_SESSION['last_login'] = $last_login;

                                $_SESSION['token'] = $token;

                                echo json_encode(
                                    [
                                        'status' => 'success',
                                        'message' => [
                                            'user_id' => $_SESSION['user_id'],
                                            'username' => $_SESSION['username'],
                                            'token' => $_SESSION['token']
                                        ]
                                    ]
                                );
                            }
                            else {

                                echo json_encode(
                                    [
                                        'status' => 'error',
                                        'message' => 'Could not execute insert statement: ' . mysqli_error($db_connection)
                                    ]
                                );

                            }
                        }
                        else {

                            echo json_encode(
                                [
                                    'status' => 'error',
                                    'message' => 'Could not execute statement: ' . mysqli_error($db_connection)
                                ]
                            );

                        }
                    }
                    else {

                        echo json_encode(
                            [
                                'status' => 'error',
                                'message' => 'Could not bind param: ' . mysqli_error($db_connection)
                            ]
                        );

                    }
                }
                else {

                    echo json_encode(
                        [
                            'status' => 'error',
                            'message' => 'Could not prepare insert statement: ' . mysqli_error($db_connection)
                        ]
                    );

                }
            }
        }
        else {

            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Could not execute select statement: ' . mysqli_error($db_connection)
                ]
            );

        }
    }
}