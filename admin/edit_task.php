<?php
session_start();
include "../includes/db.php";

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Fetch the task details
    $query = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Task not found.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for task update
    $taskId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    $query = "UPDATE tasks SET title = :title, description = :description, deadline = :deadline WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':deadline', $deadline);
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();

    header("Location: manage_task.php");
    exit();
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Edit Task</h1>
    </header>
    <main>
        <form method="POST" action="edit_task.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($task['title']) ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($task['description']) ?></textarea>

            <label for="deadline">Deadline:</label>
            <input type="date" name="deadline" id="deadline" value="<?= htmlspecialchars($task['deadline']) ?>" required>

            <button type="submit">Update Task</button>
        </form>
    </main>
</body>
</html>
