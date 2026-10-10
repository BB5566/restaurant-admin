<?php
/**
 * 更新品項 API
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
$required = ['id', 'name', 'category', 'price', 'cost', 'stock'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        die('錯誤：缺少必要欄位 ' . $field);
    }
}

// 驗證數值欄位
if (!is_numeric($_POST['id']) || !is_numeric($_POST['price']) || !is_numeric($_POST['cost']) || !is_numeric($_POST['stock'])) {
    die('錯誤：ID、價格、成本、庫存必須是數字');
}

$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;

// 處理圖片上傳
$img = $_POST['old_img'] ?? '';
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads';
    try {
        $newName = saveUploadedImage($_FILES['img'], $uploadDir);
        // 刪除舊圖片
        if (!empty($img) && file_exists($uploadDir . '/' . $img)) {
            unlink($uploadDir . '/' . $img);
        }
        $img = $newName;
    } catch (RuntimeException $e) {
        die($e->getMessage());
    }
}

// 資料庫操作 - 使用 Prepared Statement
try {
    $stmt = $pdo->prepare("UPDATE items SET name = ?, category = ?, price = ?, cost = ?, stock = ?, img = ? WHERE id = ?");
    $stmt->execute([
        trim($_POST['name']),
        trim($_POST['category']),
        (float) $_POST['price'],
        (float) $_POST['cost'],
        (int) $_POST['stock'],
        $img,
        (int) $_POST['id']
    ]);

    header("Location: ../index.php?msg=updated");
    exit;
} catch (PDOException $e) {
    die('資料庫錯誤：' . $e->getMessage());
}
