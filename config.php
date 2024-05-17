<?php

// Configuration
define('DB_HOST', 'localpost');
define('DB_NAME', 'tak23');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Connect to Database
function connect()
{
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection Error: " . $e->getMessage());
    }
}

// Disconnect from Database (if needed)
function disconnect($conn)
{
    $conn = null;
}

// Register a new user
function registerUser($username, $password)
{
    $conn = connect();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES (:username, :hashed_password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':hashed_password', $hashed_password);
    $result = $stmt->execute();
    disconnect($conn);
    return $result; // Returns true on successful insert, false otherwise
}

// Login a user (assuming username and password are submitted in a form)
function loginUser($username, $password)
{
    $conn = connect();
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    disconnect($conn);

    if ($user) {
        // Verify password using password_verify function
        if (password_verify($password, $user['password'])) {
            return $user; // Return user data on successful login
        } else {
            return false; // Invalid password
        }
    } else {
        return false; // Username not found
    }
}

// Add a new task
function addTask($user_id, $text, $status)
{
    $conn = connect();
    $sql = "INSERT INTO tasks (user_id, text, status, added_at) VALUES (:user_id, :text, :status, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':status', $status);
    $result = $stmt->execute();
    disconnect($conn);
    return $result; // Returns true on successful insert, false otherwise
}

// Get all tasks for a specific user
function getUserTasks($user_id)
{
    $conn = connect();
    $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    disconnect($conn);
    return $tasks; // Returns an array of tasks for the user
}

// Get a specific task by ID
function getTaskById($id)
{
    $conn = connect();
    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    disconnect($conn);
    return $task; // Returns a single task object or null if not found
}

// Edit a task
function editTask($id, $text, $status)
{
    $conn = connect();
    $sql = "UPDATE tasks SET text = :text, status = :status WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':status', $status);
    $result = $stmt->execute();
    disconnect($conn);
    return $result; // Returns true on successful update, false otherwise
}

// Delete a task
function deleteTask($id)
{
    $conn = connect();
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $result = $stmt->execute();
    disconnect($conn);
    return $result; // Returns true on successful delete, false otherwise
}
