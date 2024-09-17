<?php
$host = 'mysql';  // Docker-compose ile aynı network'te olduğumuz için, service name olan 'mysql' kullanılmalı
$db = 'mydatabase'; // docker-compose'daki MYSQL_DATABASE değeri
$user = 'myuser'; // docker-compose'daki MYSQL_USER değeri
$pass = 'mypassword'; // docker-compose'daki MYSQL_PASSWORD değeri
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
