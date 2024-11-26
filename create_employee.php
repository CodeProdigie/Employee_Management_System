<?php
session_start();
include "../includes/db.php";

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

function generateRandomPassword($length = 8) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : generateRandomPassword();

    // Hash the password using crypt()
    $salt = '$2y$10$' . bin2hex(random_bytes(11)); // Generate a salt for crypt
    $hashedPassword = crypt($password, $salt);

    // Insert employee into the database
    $query = "INSERT INTO employees (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();

    // Display the generated password (if applicable)
    $success = "Employee added successfully. Password: " . htmlspecialchars($password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Create Employee</h1>
    </header>
    <main>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password (optional):</label>
            <input type="password" name="password" id="password">

            <button type="submit">Create Employee</button>
        </form>
        <?php if (isset($success)): ?>
            <p style="color: var(--primary-color);"><?= $success ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
