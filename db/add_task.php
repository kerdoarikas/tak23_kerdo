<?php

require '../config.php';

$user_id = $_POST['user_id'];
$text = $_POST['text'];
$status = $_POST['status'];

if (addTask($user_id, $text, $status)) {
    header("Location: ../view_tasks.php");
    exit;
}