<?php
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Get password from form

    // Hash the password using crypt
    $hashed_password = crypt($password, base64_encode($password));

    // Insert employee into database
    $query = "INSERT INTO employees (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password); // Bind the hashed password

    if ($stmt->execute()) {
        echo "Employee added successfully!";
        header("Location: dashboard.php"); // Redirect to dashboard
    } else {
        echo "Failed to add employee.";
    }
}
?>