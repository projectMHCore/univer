<?php
require_once __DIR__ . '/vendor/autoload.php';
$client = new MongoDB\Client;
$collection = $client->schedule->lessons;

$auditorium = $_GET['auditorium'];
$cursor = $collection->find(['auditorium' => $auditorium]);

// Формирование результатов запроса
$results = [];
foreach ($cursor as $doc) {
  $results[] = "{$doc['date']} — {$doc['subject']} ({$doc['type']})";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Заняття в аудиторії <?php echo htmlspecialchars($auditorium); ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .results, .stored-results {
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .results {
      background-color: #f9f9f9;
    }
    .stored-results {
      background-color: #f0f8ff;
    }
    h2 {
      color: #333;
    }
    p {
      margin: 5px 0;
    }
    .back-link {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h1>Заняття в аудиторії <?php echo htmlspecialchars($auditorium); ?></h1>
  
  <div class="results">
    <h2>Поточні результати:</h2>
    <?php if (count($results) > 0): ?>
      <?php foreach ($results as $result): ?>
        <p><?php echo htmlspecialchars($result); ?></p>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Розклад для аудиторії <?php echo htmlspecialchars($auditorium); ?> не знайдено.</p>
    <?php endif; ?>
  </div>
  
  <div class="stored-results">
    <h2>Раніше збережені результати:</h2>
    <div id="previous-results">
      <p>Завантаження збережених результатів...</p>
    </div>
  </div>
  
  <div class="back-link">
    <a href="index.php">Повернутися на головну</a>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Получение текущих результатов для сохранения
      const currentResults = <?php echo json_encode($results); ?>;
      const auditorium = <?php echo json_encode($auditorium); ?>;
      
      // Ключ для хранения в localStorage
      const storageKey = 'auditorium_' + auditorium;
      
      // Сохранение текущих результатов в localStorage
      if (currentResults.length > 0) {
        const savedData = {
          timestamp: new Date().toLocaleString(),
          results: currentResults
        };
        
        try {
          // Проверяем, есть ли уже сохраненные данные
          const existingDataJSON = localStorage.getItem(storageKey);
          let existingData = existingDataJSON ? JSON.parse(existingDataJSON) : [];
          
          // Если данные не являются массивом, создаем новый массив
          if (!Array.isArray(existingData)) {
            existingData = [];
          }
          
          // Добавляем новые данные и сохраняем
          existingData.push(savedData);
          localStorage.setItem(storageKey, JSON.stringify(existingData));
        } catch (e) {
          console.error("Ошибка при работе с localStorage:", e);
        }
      }
      
      // Отображение сохраненных результатов
      const previousResultsElement = document.getElementById('previous-results');
      
      try {
        const savedDataJSON = localStorage.getItem(storageKey);
        const savedData = savedDataJSON ? JSON.parse(savedDataJSON) : [];
        
        if (Array.isArray(savedData) && savedData.length > 0) {
          let html = '';
          
          // Отображаем последние 3 сохраненных результата (или меньше, если их меньше)
          const displayCount = Math.min(savedData.length, 3);
          
          for (let i = savedData.length - displayCount; i < savedData.length; i++) {
            const item = savedData[i];
            html += `<div>
              <h3>Запит від ${item.timestamp}</h3>
              ${item.results.map(result => `<p>${result}</p>`).join('')}
            </div>`;
          }
          
          previousResultsElement.innerHTML = html;
        } else {
          previousResultsElement.innerHTML = "<p>Немає збережених результатів для цієї аудиторії.</p>";
        }
      } catch (e) {
        previousResultsElement.innerHTML = "<p>Помилка при завантаженні збережених даних.</p>";
        console.error("Ошибка при чтении из localStorage:", e);
      }
    });
  </script>
</body>
</html>
