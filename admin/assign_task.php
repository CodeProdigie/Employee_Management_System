<?php
include "../includes/db.php";

$query = "SELECT * FROM employees";
$employees = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    // Insert task into the database
    $query = "INSERT INTO tasks (employee_id, title, description, deadline) VALUES (:employee_id, :title, :description, :deadline)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':deadline', $deadline);

    if ($stmt->execute()) {
        echo "Task assigned successfully!";
        header("Location: dashboard.php"); 
    } else {
        echo "Failed to assign task.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <h1>Admin Control Panel</h1>
    </header>
    <main>
    <div class="sidebar">
    <div class="logo">
            <img src="../image/logo.jpg"  alt="EMS Logo" class="logo-img"> 
            <h2>Mental Health Consulting</h2>
        </div>
        <nav>
            <ul>
                <li><a href="./dashboard.php"><i class="icon">&#x1F464;</i> Create New Employee</a></li>
                <li><a href="assign_task.php"><i class="icon">&#x1F4DD;</i> Assign Task</a></li>
                <li><a href="view_employee.php"><i class="icon">&#x1F465;</i> View All Employees</a></li>
                <li><a href="manage_task.php"><i class="icon">&#x1F4C5;</i> View All Tasks</a></li>
                <li><a href="../logout.php"><i class="icon">&#x21BB;</i>Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <!-- Main content of the page goes here -->
    </div>
    <section class="section">
            <form action="assign_task.php" method="POST">
                <select name="employee_id" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($employees as $employee): ?>
                        <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="title" placeholder="Task Title" required>
                <textarea name="description" placeholder="Task Description" required></textarea>
                <input type="date" name="deadline" required>
                <button type="submit">Assign Task</button>
            </form>
        </section>
        <footer>
    <p>&copy; Brandcode 2024</p>
</footer>

        </main>
</body>
</html>
