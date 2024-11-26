<?php
session_start();
include "../includes/db.php";

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if the task ID is provided
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Delete the task
    $query = "DELETE FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();

    header("Location: manage_task.php");
    exit();
} else {
    die("Invalid request.");
}
?>
