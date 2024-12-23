<?php
// Include authentication and start session
include 'authenticate.php';

// Establish database connection
$conn = new mysqli("localhost", "root", "", "lab_5b");

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (!validateSession($conn, $_SESSION['matric'])) {
        session_destroy(); // Clear session if user no longer exists
        header('Location: login.php?error=account_deleted');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

// Fetch users from database
$result = $conn->query("SELECT matric, name, role FROM users");

echo "<h2>Users List</h2>";
echo "<table border='1'>
<tr>
<th>Matric</th>
<th>Name</th>
<th>Role</th>
<th>Actions</th>
</tr>";

// Display users in table rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['matric']}</td>
    <td>{$row['name']}</td>
    <td>{$row['role']}</td>
    <td>
        <a href='edit.php?matric=" . htmlspecialchars($row['matric']) . "'><button>Update</button></a>
        <a href='delete.php?matric=" . htmlspecialchars($row['matric']) . "' onclick='return confirm(\"Are you sure?\")'><button>Delete</button></a>
    </td>
    </tr>";
}

echo "</table>";
$conn->close();

// Validate user session
function validateSession($conn, $matric) {
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Logout handling form
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');  // Redirect to login page after logout
    exit;
}
?>

<!-- Logout button displayed if the user is logged in -->
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    <form method="POST" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
<?php endif; ?>

</body>
</html>
