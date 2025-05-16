<?php
include 'db.php';
$department = $_GET['department'];

$sql = "SELECT name, shift, date FROM nurse WHERE department = :department";
$stmt = $pdo->prepare($sql);
$stmt->execute(['department' => $department]);
$nurses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Медсестри відділення</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Система обліку чергувань медсестер</h1>
    </div>
    
    <div class="result-container">
        <h2 class="result-header">Медсестри з відділення №<?php echo htmlspecialchars($department); ?></h2>
        
        <div class="result-body">
            <?php if (count($nurses) > 0): ?>
                <?php foreach ($nurses as $nurse): ?>
                    <div class="result-item">
                        <p><strong>Ім'я:</strong> <?php echo htmlspecialchars($nurse['name']); ?></p>
                        <p><strong>Зміна:</strong> <?php echo htmlspecialchars($nurse['shift']); ?></p>
                        <p><strong>Дата:</strong> <?php echo htmlspecialchars($nurse['date']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="result-item">
                    <p>У цьому відділенні не знайдено медсестер</p>
                </div>
            <?php endif; ?>
            
            <a href="index.php" class="back-link">← Повернутися на головну</a>
        </div>
    </div>
</body>
</html>
