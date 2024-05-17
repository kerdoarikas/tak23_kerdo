<?php

require '../config.php';

$username = $_POST['username'];
$password = $_POST['password'];

if (registerUser($username, $password)) {
    header("Location: ../login.php");
    exit;
}
