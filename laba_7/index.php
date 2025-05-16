<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>  <meta charset="UTF-8">
  <title>AJAX + PDO</title>
  <link rel="stylesheet" href="styles.css">
  <script src="main.js" defer></script>
</head>
<body>
  <div class="header">
    <h1>AJAX Запити</h1>
  </div>
  
  <div class="container">
    <!-- (TEXT формат) -->
    <div class="card">
      <h2>Запит 1: Палати медсестри (TEXT)</h2>
      <div class="form-group">
        <label for="nurse-select">Виберіть медсестру:</label>
        <select id="nurse-select">
          <?php
          $stmt = $pdo->query("SELECT id_nurse, name FROM nurse");
          foreach ($stmt as $row) {
              echo "<option value='{$row['id_nurse']}'>{$row['name']}</option>";
          }
          ?>
        </select>
      </div>
      <button class="btn" onclick="loadWards()">Отримати палати</button>
      <div id="wards-result" class="result-body"></div>
    </div>

    <!-- (XML формат) -->
    <div class="card">
      <h2>Запит 2: Медсестри у відділенні (XML)</h2>
      <div class="form-group">
        <label for="department-select">Виберіть відділення:</label>
        <select id="department-select">
          <?php
          $stmt = $pdo->query("SELECT DISTINCT department FROM nurse");
          foreach ($stmt as $row) {
              echo "<option value='{$row['department']}'>{$row['department']}</option>";
          }
          ?>
        </select>
      </div>
      <button class="btn" onclick="loadNurses()">Отримати медсестер</button>
      <div id="nurses-result" class="result-body"></div>
    </div>

    <!-- (JSON формат з Fetch API) -->
    <div class="card">
      <h2>Запит 3: Чергування у зміну (JSON/Fetch API)</h2>
      <div class="form-group">
        <label for="shift-select">Виберіть зміну:</label>
        <select id="shift-select">
          <option value="1">Перша (First)</option>
          <option value="2">Друга (Second)</option>
          <option value="3">Третя (Third)</option>
        </select>
      </div>
      <button class="btn" onclick="loadShifts()">Отримати чергування</button>
      <div id="shifts-result" class="result-body"></div>
    </div>
  </div>
</body>
</html>
