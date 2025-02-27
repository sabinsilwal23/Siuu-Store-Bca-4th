<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
check_login();
require_once '../templates/header.php';


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $shoe_size = $_POST['shoe_size'];

    
    unset($_SESSION['cart'][$product_id][$shoe_size]);
    if (empty($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

  
    header('Location: cart.php');
    exit();
}


$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($_SESSION['cart'][$row['id']] as $shoe_size => $quantity) {
            $row['quantity'] = $quantity;
            $row['shoe_size'] = $shoe_size;
            $cart_items[] = $row;
        }
    }
}


$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<main>
    <section id="content">
        <h2>Your Cart</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Shoe Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><img src="../images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px; height: auto;"></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['shoe_size']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₨<?php echo $item['price']; ?></td>
                            <td>₨<?php echo $item['price'] * $item['quantity']; ?></td>
                            <td>
                                <form method="POST" action="cart.php" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="shoe_size" value="<?php echo $item['shoe_size']; ?>">
                                    <button type="submit" name="remove_from_cart">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>₨<?php echo $total_price; ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" action="checkout.php">
                <button type="submit" name="checkout">Proceed to Checkout</button>
            </form>
        <?php endif; ?>
    </section>
</main>

<?php include '../templates/footer.php'; ?>