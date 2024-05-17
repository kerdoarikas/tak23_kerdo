<?php

require '../config.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$user = loginUser($username, $password);

if ($user !== false) {
  $_SESSION['user'] = $user; // Store user data in session
  header("Location: ../view_tasks.php");
  exit;
} else {
  // Login failed
  echo "Invalid username or password!";
}
