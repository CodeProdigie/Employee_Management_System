<?php
include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verify token and update password
    $query = "SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset) {
        $email = $reset['email'];
        $role = $_POST['role'];

        if ($role === 'admin') {
            $query = "UPDATE admin SET password = :password WHERE email = :email";
        } else {
            $query = "UPDATE employees SET password = :password WHERE email = :email";
        }

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo "Password updated successfully!";
            header("Location: index.php");
        } else {
            echo "Failed to update password.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Change Password</h1>
    </header>
    <main>
        <form method="POST" action="">
            <input type="hidden" name="token" value="<?= $_GET['token'] ?>" required>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
            <input type="password" name="password" placeholder="New Password" required>
            <button type="submit">Change Password</button>
        </form>
    </main>
</body>
</html>
