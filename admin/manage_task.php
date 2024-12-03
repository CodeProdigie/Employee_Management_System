<?php
include "../includes/db.php";
$query = "SELECT tasks.*, employees.name AS employee_name FROM tasks JOIN employees ON tasks.employee_id = employees.id";
$tasks = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Manage Tasks</h1>
    </header>
    
    <main>
        <table>
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Employee</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Assigned On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= $task['id'] ?></td>
                        <td><?= $task['employee_name'] ?></td>
                        <td><?= $task['title'] ?></td>
                        <td><?= $task['description'] ?></td>
                        <td><?= $task['deadline'] ?></td>
                        <td><?= $task['status'] ?></td>
                        <td>
                            <a href="edit_task.php?id=<?= $task['id'] ?>">Edit</a>
                            <a href="delete_task.php?id=<?= $task['id'] ?>">Delete</a>
                        </td>
                        <td><?= $task['submitted_at'] ?: 'Not Submitted' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Go back</a>
    </main>
</body>
</html>
