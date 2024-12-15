<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Check if the entered credentials match the fixed ones
    if ($_POST['username'] == 'Simon Ngugi' && $_POST['password'] == '@ngugikagiri7209') {
        $_SESSION['admin'] = true;
        header('Location: add_product.php');
        exit();
    } else {
        echo "<p class='error'>Invalid credentials. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Tsavo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1 class="brand-name">Tsavo</h1>
        <h2 class="login-title">Admin Login</h2>

        <form action="admin_login.php" method="POST" class="login-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="submit" value="Login" name="submit">
        </form>
    </div>

</body>
</html>
