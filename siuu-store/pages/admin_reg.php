<?php
include '../config/db.php';
include '../includes/auth.php';
check_login();
include '../templates/header1.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'admin')";
    if (mysqli_query($conn, $query)) {
        echo "Admin registered successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<main>
    <section id="content">
        <h2>Admin Registration</h2>
        <form method="POST" action="admin_reg.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </section>
</main>

<?php include '../templates/footer.php'; ?>