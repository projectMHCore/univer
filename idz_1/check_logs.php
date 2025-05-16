<?php
include 'log_db.php';

try {
    $stmt = $logPdo->query("SELECT COUNT(*) FROM request_logs");
    $count = $stmt->fetchColumn();
    echo "База данных логов работает корректно. Количество записей: " . $count;
} catch (PDOException $e) {
    echo "Ошибка при доступе к базе данных логов: " . $e->getMessage();
}
?>
