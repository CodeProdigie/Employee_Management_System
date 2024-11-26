<?php
include "../includes/db.php";


// Fetch employee data
$query = "SELECT * FROM employees";
$employees = $conn->query($query);
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
        <h1>Admin Dashboard</h1>
    </header>
    <main>
    <div class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="EMS Logo" class="logo-img"> <!-- Replace with actual logo -->
            <h2>EMS Menu</h2>
        </div>
        <nav>
            <ul>
                <li><a href="./dashboard.php"><i class="icon">&#x1F464;</i> Create New Employee</a></li>
                <li><a href="assign_task.php"><i class="icon">&#x1F4DD;</i> Assign Task</a></li>
                <li><a href="manage_task.php"><i class="icon">&#x1F4C5;</i> View All Tasks</a></li>
                <li><a href="../logout.php"><i class="icon">&#x21BB;</i> Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <!-- Main content of the page goes here -->
    </div>
        <section class="section">
            <form action="create_employee.php" method="POST">
                <input type="text" name="name" placeholder="Employee Name" required>
                <input type="email" name="email" placeholder="Employee Email" required>
                <input type="password" name="password" placeholder="Employee Password" required> <!-- New password input -->
                <button type="submit">Add Employee</button>
            </form>
        </section>
           <footer>
    <p>&copy; Brandcode 2024</p>
</footer>

    </main>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>
