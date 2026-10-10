<?php
$host    = "localhost";
$db_name = "studenthub_db";
$user    = "root";
$pass    = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("<div style='color:red; font-family:sans-serif; padding:15px;'>Database Connection Failed: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>