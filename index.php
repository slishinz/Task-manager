<?php
// Подключение к базе данных
$conn = new mysqli('localhost', 'root', '', 'projekt');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Получаем все задачи из БД
$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Task Manager</h1>
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <br><strong><?php echo htmlspecialchars($row['title']); ?></strong> -
            <em><?php echo $row['status'] === 'completed' ? 'complete' : 'Pending'; ?></em>
            <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="button_ed">Edit</a>
            <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="button_del">Delete</a>
            <?php if ($row['status'] === 'pending'): ?>
                <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="button_com">Complete</a>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
</ul>
<a href="add_task.php" class="button">Add task</a>
</body>
</html>
<?php $conn->close(); ?>
