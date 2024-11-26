<?php
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $role = $_POST['role'];

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
        // Generate reset token
        $token = bin2hex(random_bytes(16));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $query = "INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);
        $stmt->execute();

        echo "Reset link sent to your email! (Simulated here)";
        echo "<a href='change_password.php?token=$token'>Reset Password</a>";
    } else {
        echo "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Password Reset</h1>
    </header>
    <main>
        <form method="POST" action="">
            <h2>Enter Your Email</h2>
            <input type="email" name="email" placeholder="Email" required>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
            <button type="submit">Send Reset Link</button>
        </form>
    </main>
</body>
</html>
