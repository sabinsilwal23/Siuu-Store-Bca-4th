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


$images_dir = '../images/';
if (!is_dir($images_dir)) {
    mkdir($images_dir, 0777, true);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $image = $_FILES['image']['name'];
    $target = $images_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
        if (mysqli_query($conn, $query)) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . mysqli_error($conn);
        }
    } else {
        $message = "Error uploading image.";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $query = "DELETE FROM products WHERE id='$product_id'";
    if (mysqli_query($conn, $query)) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product: " . mysqli_error($conn);
    }
}


$search_name = isset($_GET['search_name']) ? mysqli_real_escape_string($conn, $_GET['search_name']) : '';

$query = "SELECT * FROM products WHERE name LIKE '%$search_name%'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
        .search-form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .search-form input {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Products</h2>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form class="search-form" method="GET" action="admin_product.php">
            <input type="text" name="search_name" placeholder="Search by Product Name" value="<?php echo htmlspecialchars($search_name); ?>">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td>₨<?php echo $product['price']; ?></td>
                        <td><img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 50px; height: auto;"></td>
                        <td>
                            <form method="POST" action="admin_product.php" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete_product">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Add New Product</h3>
        <form method="POST" action="admin_product.php" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required>
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>
</body>
</html>

<?php include '../templates/footer.php'; ?>