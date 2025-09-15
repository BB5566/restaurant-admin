<?php
// db.php
require_once __DIR__ . '/env_loader.php';

$host = EnvLoader::get('DB_HOST', 'localhost');
$dbname = EnvLoader::get('DB_NAME', 'restaurant-admin');
$user = EnvLoader::get('DB_USER', 'root');
$pass = EnvLoader::get('DB_PASS', '');

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
try {
  $pdo = new PDO($dsn, $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('資料庫連線失敗: ' . $e->getMessage());
}
