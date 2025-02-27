<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #007bff;
        }
        p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Confirmation</h2>
        <p>Your order has been placed successfully!</p>
        <p>Thank you for shopping with us.</p>
        <a href="products.php">Continue Shopping</a>
    </div>
</body>
</html>

<?php include '../templates/footer.php'; ?>