<?php

include '../../config/env.php';

session_start();

unset($_SESSION['username']);

unset($_SESSION['last_login']);

unset($_SESSION['token']);

session_destroy();