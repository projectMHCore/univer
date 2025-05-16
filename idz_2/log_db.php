<?php
function logRequest($pdo, $requestType, $requestParams = []) {
    try {        $stmt = $pdo->prepare("INSERT INTO request_logs_idz 
                              (request_time, browser, latitude, longitude, request_type, request_params) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        
        $requestTime = isset($_POST['request_time']) ? $_POST['request_time'] : date('Y-m-d H:i:s');
        $browser = isset($_POST['browser']) ? $_POST['browser'] : $_SERVER['HTTP_USER_AGENT'];
        $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
        $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;
        
        $requestParamsJson = json_encode($requestParams);
        
        return $stmt->execute([
            $requestTime,
            $browser,
            $latitude, 
            $longitude,
            $requestType,
            $requestParamsJson
        ]);
    } catch (PDOException $e) {
        error_log("Ошибка логирования: " . $e->getMessage());
        return false;
    }
}
?>
