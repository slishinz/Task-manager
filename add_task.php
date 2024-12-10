<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'projekt');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO tasks (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $title, $description);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Add task</h1>
<form method="POST">
    <label for="title">Name of task:</label><br>
    <br><input type="text" id="title" name="title" required><br>
    <label for="description">Description:</label><br>
    <br><textarea id="description" name="description"></textarea><br>
    <button  ="submit">Add </button>
</form>
<br><a href="index.php" class="button_back">Back</a>
</body>
</html>
