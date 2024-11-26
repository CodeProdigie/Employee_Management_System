CREATE DATABASE EmployeeManagementSystem;

USE EmployeeManagementSystem;

-- Table for admin users
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table for employees
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for tasks
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    deadline DATE NOT NULL,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    submitted_at TIMESTAMP NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Add login credentials for admins
ALTER TABLE admin
ADD COLUMN email VARCHAR(100) UNIQUE NOT NULL AFTER username;

-- Add login credentials for employees
ALTER TABLE employees
ADD COLUMN password VARCHAR(255) AFTER email;


-- ALTER TABLE employees ADD password VARCHAR(255) NOT NULL;
-- ALTER TABLE employees ADD COLUMN password VARCHAR(255);
