<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $error = "Email must be a valid Gmail address";
    } elseif (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $username)) {
        $error = "Username must start with a letter and contain only letters and numbers";
    } else {
        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        mysqli_query($conn, $query);

        header('Location: login.php');
        exit();
    }
}
?>



<main>
    <div class="register-container">
        <div class="register-box">
            <h2>Register</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="register.php" onsubmit="return validateForm()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Register</button>
            </form>
            <button class="login-button" onclick="window.location.href='login.php';">Already have an account?</button>
        </div>
    </div>
</main>

<script>
function validateForm() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const usernamePattern = /^[a-zA-Z][a-zA-Z0-9]*$/;

    if (!usernamePattern.test(username)) {
        alert('Username must start with a letter and contain only letters and numbers');
        return false;
    }

    const emailPattern = /^[^\s@]+@gmail\.com$/;
    if (!emailPattern.test(email)) {
        alert('Email must be a valid Gmail address');
        return false;
    }

    return true;
}
</script>

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

.register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.register-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

.register-box h2 {
    margin-bottom: 20px;
    color: #333;
}

.register-box .error {
    color: red;
    margin-bottom: 10px;
}

.register-box form {
    display: flex;
    flex-direction: column;
}

.register-box label {
    margin-bottom: 5px;
    color: #333;
    text-align: left;
}

.register-box input {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.register-box button {
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.register-box button:hover {
    background-color: #0056b3;
}

.login-button {
    background-color: #28a745;
}

.login-button:hover {
    background-color: #218838;
}
</style>



