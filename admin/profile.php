<?php
session_start();
include "../includes/db.php";

// Fetch current admin details
$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM admin WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $admin_id);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $query = "UPDATE admin SET username = :name, email = :email WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $admin_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Failed to update profile.";
    }
}
?>

