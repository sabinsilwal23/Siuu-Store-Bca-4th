<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
check_login();
require_once '../templates/header.php';


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $shoe_size = $_POST['shoe_size'];

  
    if (isset($_SESSION['cart'][$product_id][$shoe_size])) {
       
        $_SESSION['cart'][$product_id][$shoe_size] += $quantity;
    } else {
        
        $_SESSION['cart'][$product_id][$shoe_size] = $quantity;
    }

    
    header('Location: cart.php');
    exit();
}


$search_name = isset($_GET['search_name']) ? mysqli_real_escape_string($conn, $_GET['search_name']) : '';


$query = "SELECT * FROM products WHERE name LIKE '%$search_name%'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<main>
    <section id="content">
        <h2>Products</h2>
        <div id="message" style="display: none;"></div>
        <form class="search-form" method="GET" action="products.php">
            <input type="text" name="search_name" placeholder="Search by Product Name" value="<?php echo htmlspecialchars($search_name); ?>">
            <button type="submit">Search</button>
        </form>
        <div class="products-container">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <div class="product">
                    <img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <p class="price">Price: ₨<?php echo $product['price']; ?></p>
                    <form class="add-to-cart-form" method="POST" action="products.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="shoe_size">Shoe Size:</label>
                        <select name="shoe_size" required>
                            <?php for ($i = 35; $i <= 44; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" required>
                        <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

#content {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.search-form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.search-form input[type="text"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-form button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 10px;
}

.search-form button:hover {
    background-color: #0056b3;
}

.products-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.product {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: calc(25% - 20px);
    box-sizing: border-box;
    text-align: center;
    transition: transform 0.2s;
}

.product:hover {
    transform: translateY(-10px);
}

.product-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.product h3 {
    color: #007bff;
    margin: 10px 0;
}

.product p {
    color: #555;
}

.price {
    color: #28a745;
    font-weight: bold;
}

.add-to-cart-form {
    margin-top: 10px;
}

.add-to-cart-form label {
    display: block;
    margin: 10px 0 5px;
    color: #333;
}

.add-to-cart-form select,
.add-to-cart-form input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.add-to-cart-button {
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #28a745;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.add-to-cart-button:hover {
    background-color: #218838;
}
</style>

<?php include '../templates/footer.php'; ?>