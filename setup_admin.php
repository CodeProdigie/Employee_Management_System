<?php
// Include the database connection
include "includes/db.php";

try {
    // Created a hashed password for the admin 
    $password = crypt("adminpassword", "salt");

    // Inserted the admin user into the database
    $query = "INSERT INTO admin (username, email, password) VALUES ('admin', 'admin@example.com', :password)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    echo "Admin user created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
