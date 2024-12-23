<?php


$conn = new mysqli("localhost", "root", "", "lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        header("Location: read.php");
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
