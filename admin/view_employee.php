<?php
include "../includes/db.php"; // Include database connection


// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM employees WHERE id = :id";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header("Location: view_employee.php");
        exit();
    } else {
        echo "<p style='color: var(--red-color);'>Failed to delete employee.</p>";
    }
}

// Handle editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $edit_name = $_POST['edit_name'];
    $edit_email = $_POST['edit_email'];

    $updateQuery = "UPDATE employees SET name = :name, email = :email WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':name', $edit_name);
    $stmt->bindParam(':email', $edit_email);
    $stmt->bindParam(':id', $edit_id);

    if ($stmt->execute()) {
        header("Location: view_employee.php");
        exit();
    } else {
        echo "<p style='color: var(--red-color);'>Failed to update employee.</p>";
    }
}

// Fetch employee data
$query = "SELECT * FROM employees ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: var(--white-color);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid var(--divider-color);
            width: 50%;
            border-radius: 5px;
        }
        .close {
            color: var(--red-color);
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>View Employees</h1>
    </header>
    <main>
        <section>
            <h2>Employee List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= $employee['id'] ?></td>
                                <td><?= $employee['name'] ?></td>
                                <td><?= $employee['email'] ?></td>
                                <td><?= $employee['created_at'] ?></td>
                                <td>
                                    <button onclick="openEditModal(<?= $employee['id'] ?>, '<?= $employee['name'] ?>', '<?= $employee['email'] ?>')" 
                                            style="color: var(--white-color);">Edit</button>
                                    <a href="view_employee.php?delete_id=<?= $employee['id'] ?>" 
                                       style="color: var(--red-color);" 
                                       onclick="return confirm('Are you sure you want to delete this employee?')">
                                        Delete Employee
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-gray-color);">
                                No employees found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="dashboard.php">Go back</a>
        </section>
    </main>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Employee</h2>
            <form method="POST" action="view_employee.php">
                <input type="hidden" id="edit_id" name="edit_id">
                <div>
                    <label for="edit_name">Name:</label>
                    <input type="text" id="edit_name" name="edit_name" required>
                </div>
                <div>
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" required>
                </div>
                <button type="submit" style="background-color: var(--primary-color); color: var(--white-color);">Update</button>
            </form>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editModal');

        function openEditModal(id, name, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            editModal.style.display = 'block';
        }

        function closeEditModal() {
            editModal.style.display = 'none';
        }

        // Close the modal when clicking outside the content
        window.onclick = function(event) {
            if (event.target === editModal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
