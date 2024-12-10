<?php
$conn = new mysqli('localhost', 'root', '', 'projekt');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение ID задачи из URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID задачи не указан.";
    exit;
}

// Если форма отправлена, обновляем данные
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $title, $description, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header('Location: index.php');
    exit;
}

// Получение текущих данных задачи
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Если задача не найдена
if (!$task) {
    echo "Задача не найдена.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Edit task</h1>
<form method="POST">
    <label for="title">Name of task:</label><br>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required><br>
    <br><label for="description">Description:</label><br>
    <textarea id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea><br>
    <button type="submit">Save changes</button>
</form>
<br><a href="index.php" class="button_back">Back</a>
</body>
</html>
