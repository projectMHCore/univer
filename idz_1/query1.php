<?php
include 'log_db.php';
$nurse_id = $_GET['nurse_id'];

// Логирование запроса
logRequest('query1', ['nurse_id' => $nurse_id]);

$sql_nurse = "SELECT name FROM nurse WHERE id_nurse = :nurse_id";
$stmt_nurse = $pdo->prepare($sql_nurse);
$stmt_nurse->execute(['nurse_id' => $nurse_id]);
$nurse = $stmt_nurse->fetch();

$sql = "SELECT ward.name AS ward_name
        FROM nurse_ward
        JOIN ward ON nurse_ward.fid_ward = ward.id_ward
        WHERE nurse_ward.fid_nurse = :nurse_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['nurse_id' => $nurse_id]);
$wards = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Палати медсестри</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Система обліку чергувань медсестер</h1>
    </div>
    
    <div class="result-container">
        <h2 class="result-header">Палати, де чергує медсестра <?php echo htmlspecialchars($nurse['name']); ?></h2>
        
        <div class="result-body">
            <?php if (count($wards) > 0): ?>
                <?php foreach ($wards as $ward): ?>
                    <div class="result-item">
                        <p><strong>Палата:</strong> <?php echo htmlspecialchars($ward['ward_name']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="result-item">
                    <p>Для цієї медсестри не знайдено палат</p>
                </div>
            <?php endif; ?>
            
            <a href="index.php" class="back-link">← Повернутися на головну</a>
        </div>
    </div>
</body>
</html>