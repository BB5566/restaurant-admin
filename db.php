<?php
// db.php
require_once __DIR__ . '/env_loader.php';

// 優先從環境變數讀取資料庫類型，預設使用 SQLite
$dbType = EnvLoader::get('DB_TYPE', 'sqlite');

if ($dbType === 'sqlite') {
  // SQLite 連線設定
  $dbPath = EnvLoader::get('DB_PATH', __DIR__ . '/database/restaurant.sqlite');

  // 確保資料庫目錄存在
  $dbDir = dirname($dbPath);
  if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
  }

  // 如果資料庫不存在，建立並初始化
  $dbExists = file_exists($dbPath);

  try {
    $dsn = "sqlite:$dbPath";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 啟用外鍵約束（SQLite 預設關閉）
    $pdo->exec('PRAGMA foreign_keys = ON;');

    // 如果是新資料庫，執行初始化
    if (!$dbExists) {
      $schemaFile = __DIR__ . '/database/schema.sqlite.sql';
      if (file_exists($schemaFile)) {
        $sql = file_get_contents($schemaFile);
        $pdo->exec($sql);
      }
    }
  } catch (PDOException $e) {
    die('SQLite 資料庫連線失敗: ' . $e->getMessage());
  }

} else {
  // MySQL 連線設定（向下相容）
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
    die('MySQL 資料庫連線失敗: ' . $e->getMessage());
  }
}
