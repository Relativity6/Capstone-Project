<?php

$type = 'mysql';
$server = 'localhost';
$db = 'practicemembership';
$port = '3306';
$charset = 'utf8mb4';

$username = 'user';
$password = 'Summer__2022';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password, $options);
}
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), $e->getCode());
}