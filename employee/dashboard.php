<?php
session_start(); // Make sure session is started at the beginning

include "../includes/db.php"; // Include database connection


// Check if the employee is logged in and has a valid session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

// Get the employee ID from the session (make sure this is set during login)
$employee_id = $_SESSION['user_id']; // Get the employee's ID from the session

// Fetch tasks assigned to this employee
$query = "SELECT * FROM tasks WHERE employee_id = :employee_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':employee_id', $employee_id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if tasks are fetched
if (empty($tasks)) {
    echo "No tasks assigned.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Employee Dashboard</h1>
    </header>
    <main>
        <section>
            <h2>Assigned Tasks/ <a href="../logout.php" class="logout-emp"><i class="icon">&#x21BB;</i>logout</a></h2>
            <?php if (!empty($tasks)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['id']) ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= htmlspecialchars($task['deadline']) ?></td>
                            <td><?= htmlspecialchars($task['status']) ?></td>
                            <td>
                                <?php if ($task['status'] === 'Pending'): ?>
                                    <a href="complete_task.php?id=<?= $task['id'] ?>">Mark as Completed</a>
                                <?php else: ?>
                                    <span>Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No tasks assigned.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
