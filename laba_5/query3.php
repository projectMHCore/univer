<?php
include 'db.php';
$shift = $_GET['shift'];

$sql = "SELECT nurse.name, ward.name AS ward, nurse.department
        FROM nurse
        JOIN nurse_ward ON nurse.id_nurse = nurse_ward.fid_nurse
        JOIN ward ON ward.id_ward = nurse_ward.fid_ward
        WHERE nurse.shift = :shift";

$stmt = $pdo->prepare($sql);
$stmt->execute(['shift' => $shift]);
$data = $stmt->fetchAll();

$shift_names = [
    'First' => 'Перша',
    'Second' => 'Друга',
    'Third' => 'Третя'
];
$shift_name = isset($shift_names[$shift]) ? $shift_names[$shift] : $shift;
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чергування у зміну</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Система обліку чергувань медсестер</h1>
    </div>
    
    <div class="result-container">
        <h2 class="result-header">Чергування у <?php echo htmlspecialchars($shift_name); ?> зміну</h2>
        
        <div class="result-body">
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $row): ?>
                    <div class="result-item">
                        <p><strong>Медсестра:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                        <p><strong>Палата:</strong> <?php echo htmlspecialchars($row['ward']); ?></p>
                        <p><strong>Відділення:</strong> <?php echo htmlspecialchars($row['department']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="result-item">
                    <p>Для цієї зміни не знайдено чергувань</p>
                </div>
            <?php endif; ?>
            
            <a href="index.php" class="back-link">← Повернутися на головну</a>
        </div>
    </div>
</body>
</html>