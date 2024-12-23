<?php



$conn = new mysqli("localhost", "root", "", "lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        header("Location: read.php");
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: read.php");
}

$conn->close();
?>
