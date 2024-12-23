<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="register.php" method="post">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" id="matric" required><br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">Please select</option>
            <option value="lecturer">Lecturer</option>
            <option value="student">Student</option>
        </select><br>
        <input type="submit" name="submit" value="Register">
    </form>
    <p>Already registered? <a href="login.php">Login here</a></p>
</body>
</html>
