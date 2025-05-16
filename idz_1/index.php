<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Медсестри та чергування</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>    <div class="header">
        <h1>Система обліку чергувань медсестер</h1>
        <div style="text-align: right; margin-top: -30px;">
            <a href="logs.php" style="color: white; text-decoration: underline;">Журнал запитів</a>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <h2>Оберіть тип запиту</h2>

            <form action="query1.php" method="get">
                <div class="form-group">
                    <label for="nurse">Оберіть медсестру для перегляду палат:</label>
                    <select name="nurse_id" id="nurse">
                        <?php
                        $stmt = $pdo->query("SELECT id_nurse as id, name FROM nurse");
                        foreach ($stmt as $row) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn">Показати палати</button>
            </form>
        </div>
        
        <div class="card">
            <form action="query2.php" method="get">
                <div class="form-group">
                    <label for="department">Оберіть відділення для перегляду медсестер:</label>
                    <select name="department" id="department">
                        <?php
                        $stmt = $pdo->query("SELECT DISTINCT department FROM nurse");
                        foreach ($stmt as $row) {
                            echo "<option value='{$row['department']}'>{$row['department']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn">Показати медсестер</button>
            </form>
        </div>
        
        <div class="card">
            <form action="query3.php" method="get">
                <div class="form-group">
                    <label for="shift">Оберіть зміну для перегляду чергувань:</label>
                    <select name="shift" id="shift">
                        <option value="First">Перша</option>
                        <option value="Second">Друга</option>
                        <option value="Third">Третя</option>
                    </select>
                </div>
                <button type="submit" class="btn">Показати чергування</button>            </form>
        </div>
    </div>
</body>
</html>

</body>
</html>
