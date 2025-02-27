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

include '../templates/header1.php';

$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);

    if ($action == 'delete') {
        
        $delete_order_items_query = "DELETE FROM order_items WHERE order_id='$order_id'";
        mysqli_query($conn, $delete_order_items_query);

       
        $query = "DELETE FROM orders WHERE id='$order_id'";
    } else {
        $status = ($action == 'cancel') ? 'Cancelled' : 'Successful';
        $query = "UPDATE orders SET status='$status' WHERE id='$order_id'";
    }

    if (mysqli_query($conn, $query)) {
        $message = "Order updated successfully";
    } else {
        $message = "Error updating order: " . mysqli_error($conn);
    }
}


$query = "SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching orders: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 0.5rem;
            text-align: left;
        }
        button {
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <main>
            <section id="content">
                <h2>Manage Orders</h2>
                <?php if ($message): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['username']; ?></td>
                                <td>₨<?php echo $order['total']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                                <td><?php echo $order['created_at']; ?></td>
                                <td>
                                    <?php
                                    $order_id = $order['id'];
                                    $order_items_query = "SELECT products.name, products.image, order_items.quantity, order_items.shoe_size FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = '$order_id'";
                                    $order_items_result = mysqli_query($conn, $order_items_query);
                                    if (!$order_items_result) {
                                        echo "Error fetching order items: " . mysqli_error($conn);
                                    } else {
                                        while ($item = mysqli_fetch_assoc($order_items_result)): ?>
                                            <div>
                                                <img src="../images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px; height: auto;">
                                                <span><?php echo $item['name']; ?> (Size: <?php echo $item['shoe_size']; ?>, x<?php echo $item['quantity']; ?>)</span>
                                            </div>
                                        <?php endwhile;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <form method="POST" action="admin_order_manage.php" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" name="action" value="cancel">Cancel</button>
                                        <button type="submit" name="action" value="complete">Complete</button>
                                        <button type="submit" name="action" value="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

<?php include '../templates/footer.php'; ?>
