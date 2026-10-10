<?php
/**
 * 新增品項 API
 * 使用 Prepared Statements 防止 SQL 注入
 */

require_once __DIR__ . '/../security.php';
require_once __DIR__ . '/../upload_helper.php';
ensureSessionStarted();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('錯誤：無效的請求方式');
}

if (!validateCsrfToken($_POST['csrf_token'] ?? null)) {
    die('錯誤：CSRF 驗證失敗');
}

// 驗證必要欄位
$required = ['name', 'category', 'price', 'cost', 'stock'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        die('錯誤：缺少必要欄位 ' . $field);
    }
}

// 驗證數值欄位
if (!is_numeric($_POST['price']) || !is_numeric($_POST['cost']) || !is_numeric($_POST['stock'])) {
    die('錯誤：價格、成本、庫存必須是數字');
}

// 圖片上傳處理
$imgName = '';
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads';
    try {
        $imgName = saveUploadedImage($_FILES['img'], $uploadDir);
    } catch (RuntimeException $e) {
        die($e->getMessage());
    }
}

// 資料庫操作 - 使用 Prepared Statement
$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;

try {
    $stmt = $pdo->prepare("INSERT INTO items (name, category, price, cost, stock, img) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        trim($_POST['name']),
        trim($_POST['category']),
        (float) $_POST['price'],
        (float) $_POST['cost'],
        (int) $_POST['stock'],
        $imgName
    ]);

    header("Location: ../index.php?msg=added");
    exit;
} catch (PDOException $e) {
    die('資料庫錯誤：' . $e->getMessage());
}
