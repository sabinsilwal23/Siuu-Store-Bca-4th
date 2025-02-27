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

include '../templates/admin_header1.php';
?>

<style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        color: #333;
        height: 100%;
        width: 100%;
    }

    .dashboard-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        margin: 2rem auto;
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

<div class="dashboard-container">
    <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
    <a href="manage_products.php">Manage Products</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
</div>

