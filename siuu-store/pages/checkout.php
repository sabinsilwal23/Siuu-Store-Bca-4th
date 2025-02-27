<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/auth.php';
check_login();
include '../templates/header.php';


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($_SESSION['cart'][$row['id']] as $size => $quantity) {
            $row['quantity'] = $quantity;
            $row['size'] = $size;
            $cart_items[] = $row;
        }
    }
}


$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $total = 0;

    
    foreach ($_SESSION['cart'] as $product_id => $sizes) {
        foreach ($sizes as $shoe_size => $quantity) {
            $query = "SELECT price FROM products WHERE id='$product_id'";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
            $total += $product['price'] * $quantity;
        }
    }

   
    $query = "INSERT INTO orders (user_id, total, created_at, status) VALUES ('$user_id', '$total', NOW(), 'Pending')";
    mysqli_query($conn, $query);
    $order_id = mysqli_insert_id($conn);


    foreach ($_SESSION['cart'] as $product_id => $sizes) {
        foreach ($sizes as $shoe_size => $quantity) {
            $query = "SELECT price FROM products WHERE id='$product_id'";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
            $price = $product['price'];
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price, shoe_size) VALUES ('$order_id', '$product_id', '$quantity', '$price', '$shoe_size')";
            mysqli_query($conn, $query);
        }
    }

  
    unset($_SESSION['cart']);

 
    header('Location: order_confirmation.php');
    exit();
}
?>

<main>
    <section id="content">
        <h2>Checkout</h2>
        <form method="POST" action="checkout.php">
            <button type="submit" name="checkout">Confirm Order</button>
        </form>

        <h3>Order Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['size']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₨<?php echo $item['price']; ?></td>
                        <td>₨<?php echo $item['price'] * $item['quantity']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong>₨<?php echo $total_price; ?></strong></td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<?php include '../templates/footer.php'; ?>