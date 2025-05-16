<?php
include_once 'db.php';
global $pdo;

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS request_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            query_type VARCHAR(50) NOT NULL,
            parameters TEXT NOT NULL,
            request_time DATETIME NOT NULL
        )
    ");
    
    $logPdo = $pdo;
} catch (\PDOException $e) {
    die("Ошибка подключения к базе данных логов: " . $e->getMessage());
}

function logRequest($queryType, $parameters) {
    global $logPdo;
    
    $stmt = $logPdo->prepare("
        INSERT INTO request_logs (query_type, parameters, request_time)
        VALUES (:query_type, :parameters, :request_time)
    ");
    
    $stmt->execute([
        'query_type' => $queryType,
        'parameters' => json_encode($parameters, JSON_UNESCAPED_UNICODE),
        'request_time' => date('Y-m-d H:i:s')
    ]);
}
?>
