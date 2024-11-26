<?php
session_start();
include "./includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Either 'admin' or 'employee'

    if ($role === 'admin') {
        $query = "SELECT * FROM admin WHERE email = :email";
    } else {
        $query = "SELECT * FROM employees WHERE email = :email";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check password using crypt
        if (crypt($password, $user['password']) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;
            if ($role === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: employee/dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid email or role!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Employee Management System</h1>
    </header>
    <main>
        <form method="POST" action="">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p style="color: var(--red-color);"><?= $error ?></p>
            <?php endif; ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
