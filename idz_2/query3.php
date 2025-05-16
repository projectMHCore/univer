<?php
header('Content-Type: application/json; charset=utf-8');
include 'db.php';
include 'log_db.php';

$response = [
    'success' => true,
    'data' => [],
    'error' => null
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['shift'])) {
        $response['success'] = false;
        $response['error'] = 'Не вказана зміна';
        echo json_encode($response);
        exit;
    }
    
    $shift = $_POST['shift'];
    
    $requestParams = ['shift' => $shift];
    logRequest($pdo, 'query3_shifts', $requestParams);
} else {
    if (!isset($_GET['shift'])) {
        $response['success'] = false;
        $response['error'] = 'Не вказана зміна';
        echo json_encode($response);
        exit;
    }
    
    $shift = $_GET['shift'];
}

$shiftMap = [
    '1' => 'First',
    '2' => 'Second',
    '3' => 'Third'
];

if (!isset($shiftMap[$shift])) {
    $response['success'] = false;
    $response['error'] = 'Недійсна зміна. Допустимі значення: 1, 2 або 3.';
    echo json_encode($response);
    exit;
}

$shiftText = $shiftMap[$shift];

try {
    $sql = "SELECT n.id_nurse as nurse_id, n.name as nurse_name, w.id_ward as ward_id, w.name as ward_name 
            FROM nurse n
            JOIN nurse_ward nw ON n.id_nurse = nw.fid_nurse
            JOIN ward w ON w.id_ward = nw.fid_ward
            WHERE n.shift = :shift
            ORDER BY n.name, w.name";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['shift' => $shiftText]);
    
    $results = $stmt->fetchAll();
    
    $response['total'] = count($results);
    $response['shift'] = $shiftText;
    $response['data'] = $results;
    
    if (count($results) === 0) {
        $response['message'] = 'Немає чергувань у цю зміну';
    }
    
} catch (PDOException $e) {
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
