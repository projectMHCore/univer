<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Логи запросов</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .log-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    .log-table th, .log-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .log-table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    .log-table tr:hover {
      background-color: #f5f5f5;
    }
    .header-with-button {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .back-btn {
      padding: 8px 16px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-with-button">
      <h1>Логи запросов</h1>
      <a href="index.php" class="back-btn">Вернуться к запросам</a>
    </div>
  </div>
  
  <div class="container">
    <div class="card">
      <h2>Информация о запросах</h2>
      
      <div class="log-content">
        <?php
        try {
            $sql = "SELECT * FROM request_logs_idz ORDER BY created_at DESC LIMIT 100";
            $result = $pdo->query($sql);
            
            if ($result->rowCount() > 0) {
                echo '<table class="log-table">';
                echo '<tr>
                        <th>ID</th>
                        <th>Время запроса</th>
                        <th>Тип запроса</th>
                        <th>Браузер</th>
                        <th>Широта</th>
                        <th>Долгота</th>
                        <th>Параметры</th>
                        <th>Создан</th>
                      </tr>';
                
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['request_time'] . '</td>';
                    echo '<td>' . $row['request_type'] . '</td>';
                    echo '<td>' . substr($row['browser'], 0, 50) . '...</td>';
                    echo '<td>' . ($row['latitude'] ? $row['latitude'] : 'Н/Д') . '</td>';
                    echo '<td>' . ($row['longitude'] ? $row['longitude'] : 'Н/Д') . '</td>';
                    echo '<td>' . $row['request_params'] . '</td>';
                    echo '<td>' . $row['created_at'] . '</td>';
                    echo '</tr>';
                }
                
                echo '</table>';
            } else {
                echo '<p>Логи запросов отсутствуют.</p>';
            }
        } catch(PDOException $e) {
            echo "Ошибка при получении логов: " . $e->getMessage();
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
