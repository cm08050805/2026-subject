<?php
session_start();

$host = 'localhost';
$dbname = '2017D';
$user = 'root';
$password = '';
$charset = "utf8mb4";
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];

try {
    $db = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e){
    die("접속 실패" . $e->getMessage());
}