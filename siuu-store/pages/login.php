<?php
require '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<main>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <button class="register-button" onclick="window.location.href='register.php';">Create an Account</button>
        </div>
    </div>
</main>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.login-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

.login-box h2 {
    margin-bottom: 20px;
    color: #333;
}

.login-box .error {
    color: red;
    margin-bottom: 10px;
}

.login-box form {
    display: flex;
    flex-direction: column;
}

.login-box label {
    margin-bottom: 5px;
    color: #333;
    text-align: left;
}

.login-box input {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login-box button {
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.login-box button:hover {
    background-color: #0056b3;
}

.register-button {
    background-color: #28a745;
}

.register-button:hover {
    background-color: #218838;
}
</style>

