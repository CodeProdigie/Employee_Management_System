Employee Management System - Documentation
Overview
This Employee Management System is a web-based application developed in PHP (using MySQLi for database interactions) and styled with CSS. The application is designed to manage employees and their tasks efficiently. It consists of two dashboards: Admin Dashboard and Employee Dashboard.

The application adheres to clean and understandable code practices and ensures compatibility with PHP 5.4.12.

Features
Admin Features
Employee Management

Add new employees to the system.
View the list of all employees.
Task Assignment

Assign tasks to specific employees.
Provide task deadlines and detailed descriptions.
Task Management

Update, delete, and view assigned tasks.
View completed tasks submitted by employees.
Admin Management

Generate an admin account during setup.
Add additional admins directly through the database.
Employee Features
Task Dashboard

View assigned tasks, including all details such as:
Task description.
Deadline.
Status (pending/completed).
Task Completion

Submit a form upon task completion.
The submission is visible to the admin on their dashboard.
Login

Employees can securely log in to view their tasks.
Styling and Design
All styles adhere to predefined CSS variables for a consistent design:

Primary-color: #1E74FF
White-color: #FFFFFF
Background-color: #F6F9FE
Red-color: #FF0000
Text-color: #404040
Icon-color: #68686A
Text-Gray-Color: #BCBCBC
Purple-color: #4040F2
Divider-color: #C9C9C9
The design focuses on user-friendly interfaces and clean layouts to enhance usability.

How the Application Works
1. Setting Up the Application
Import the SQL file (employee_management.sql) into your MySQL database to create the required tables.
Update the db_config.php file with your database credentials:
php
Copy code
<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "employee_management";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
2. Admin Panel
Login: Access the admin dashboard with the default admin credentials generated during setup.
Employee Management:
Add a new employee by filling in their details (e.g., name, email).
Task Management:
Assign tasks to employees with descriptions and deadlines.
View a list of all tasks with the option to update or delete them.
View Completed Tasks:
Monitor submissions from employees to mark tasks as reviewed.
3. Employee Dashboard
Login: Employees log in using their credentials.
View Tasks:
Employees can view tasks assigned to them.
Complete Tasks:
Submit a form indicating task completion. This submission is visible to admins for review.
