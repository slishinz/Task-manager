<?php
if (isset($_GET['id'])) {
    $conn = new mysqli('localhost', 'root', '', 'projekt');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_GET['id'];
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: index.php');
    exit;
}