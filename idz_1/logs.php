<?php
include 'log_db.php';

$stmt = $logPdo->query("SELECT * FROM request_logs ORDER BY request_time DESC");
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Журнал запросов</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .logs-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .empty-logs {
            text-align: center;
            padding: 30px;
            color: #888;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Система обліку чергувань медсестер</h1>
    </div>
    
    <div class="logs-container">
        <a href="index.php" class="back-link">Повернутися на головну</a>
        <h2>Журнал запитів</h2>
        
        <?php if (count($logs) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Тип запиту</th>
                        <th>Параметри</th>
                        <th>Час запиту</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['id']) ?></td>
                            <td><?= htmlspecialchars($log['query_type']) ?></td>
                            <td><?= htmlspecialchars($log['parameters']) ?></td>
                            <td><?= htmlspecialchars($log['request_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-logs">Журнал запитів порожній</p>
        <?php endif; ?>
    </div>
</body>
</html>
