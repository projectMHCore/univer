<?php
$host = '89.35.130.223:3306';
$db = 's66_univer'; 
$user = 'u66_5hvSxccBHf'; 
$pass = 'kVMph1.!hemilMea013!3RVl';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Помилка підключення: " . $e->getMessage());
}
?>
