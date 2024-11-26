<?php
include "../includes/db.php";

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Update task status to "Completed"
    $query = "UPDATE tasks SET status = 'Completed', submitted_at = NOW() WHERE id = :task_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':task_id', $task_id);

    if ($stmt->execute()) {
        echo "Task marked as completed!";
        header("Location: dashboard.php"); 
    } else {
        echo "Failed to update task.";
    }
}
?>
