<?php
include 'db.php';
$sql = file_get_contents('create_logs_table.sql');

try {
    $pdo->exec($sql);
    echo "Таблица для логирования успешно создана!";
    echo "<br><br><a href='index.php'>Вернуться на главную страницу</a>";
} catch (PDOException $e) {
    echo "Ошибка при создании таблицы: " . $e->getMessage();
    echo "<br><br><a href='index.php'>Вернуться на главную страницу</a>";
}
?>
