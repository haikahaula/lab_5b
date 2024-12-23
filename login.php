<?php
include 'authenticate.php'; // This handles session management and authentication logic
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <h2>Login Form</h2>

    <form action="login.php" method="post">
        <div class="container">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" id="matric" value="<?= htmlspecialchars($_POST['matric'] ?? '') ?>" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" name="submit" value="Login">

            <label>
                <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>> Remember me
            </label>
        </div>

        <!-- Display the error message dynamically -->
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <div class="register-message">
            <a href="register_form.php">Register</a> if you don't have an account.
        </div>
    </form>
</body>
</html>
