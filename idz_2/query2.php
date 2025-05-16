<?php
header('Content-Type: text/xml; charset=utf-8');
include 'db.php';
include 'log_db.php';

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<response>\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['department'])) {
        echo "  <error>Не вказаний відділ</error>\n";
        echo "</response>";
        exit;
    }
    
    $department = $_POST['department'];
    
    $requestParams = ['department' => $department];
    logRequest($pdo, 'query2_nurses', $requestParams);
} else {
    if (!isset($_GET['department'])) {
        echo "  <error>Не вказаний відділ</error>\n";
        echo "</response>";
        exit;
    }
    
    $department = $_GET['department'];
}

try {
    $sql = "SELECT id_nurse, name FROM nurse WHERE department = :department ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['department' => $department]);
    
    $results = $stmt->fetchAll();
    
    echo "  <department>" . htmlspecialchars($department) . "</department>\n";
    
    echo "  <nurses count='" . count($results) . "'>\n";
    
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo "    <nurse id='" . $row['id_nurse'] . "'>" . htmlspecialchars($row['name']) . "</nurse>\n";
        }
    }
    
    echo "  </nurses>\n";
    
} catch (PDOException $e) {
    echo "  <error>" . htmlspecialchars($e->getMessage()) . "</error>\n";
}

echo "</response>";
?>
