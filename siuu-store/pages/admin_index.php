<?php
include '../config/db.php';
include '../includes/auth.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .dashboard-container h2 {
            margin-bottom: 1rem;
        }
        .dashboard-container a {
            display: block;
            margin: 1rem 0;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
        .dashboard-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
        <a href="admin_product.php">Manage Products</a>
        <a href="admin_order_manage.php">View Orders</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
