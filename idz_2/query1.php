<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';
include 'log_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['nurse_id'])) {
        echo "<p class='error'>Помилка: не вказаний ідентифікатор медсестри.</p>";
        exit;
    }
    
    $nurse_id = $_POST['nurse_id'];
    $requestParams = ['nurse_id' => $nurse_id];
    logRequest($pdo, 'query1_wards', $requestParams);
} else {
    if (!isset($_GET['nurse_id'])) {
        echo "<p class='error'>Помилка: не вказаний ідентифікатор медсестри.</p>";
        exit;
    }
    
    $nurse_id = $_GET['nurse_id'];
}

$nurse_name_sql = "SELECT name FROM nurse WHERE id_nurse = :nurse_id";
$nurse_stmt = $pdo->prepare($nurse_name_sql);
$nurse_stmt->execute(['nurse_id' => $nurse_id]);
$nurse_name = $nurse_stmt->fetchColumn();

if (!$nurse_name) {
    echo "<p class='error'>Медсестру з таким ідентифікатором не знайдено.</p>";
    exit;
}

$sql = "SELECT w.name FROM nurse_ward nw
        JOIN ward w ON w.id_ward = nw.fid_ward
        WHERE nw.fid_nurse = :nurse_id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nurse_id' => $nurse_id]);
    
    $results = $stmt->fetchAll();
    
    if (count($results) > 0) {
        echo "<h3>Палати медсестри: " . htmlspecialchars($nurse_name) . "</h3>";
        echo "<ul class='results-list'>";
        foreach ($results as $row) {
            echo "<li class='result-item'>" . htmlspecialchars($row['name']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Для медсестри " . htmlspecialchars($nurse_name) . " не знайдено палат.</p>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>Помилка запиту: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
