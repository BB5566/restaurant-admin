<?php
/**
 * 新增品項 API
 * 使用 Prepared Statements 防止 SQL 注入
 */

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
    // 驗證檔案類型
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['img']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        die('錯誤：不支援的圖片格式');
    }

    // 驗證副檔名
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowedExt)) {
        die('錯誤：不支援的圖片副檔名');
    }

    $imgName = uniqid() . '.' . $ext;
    $uploadDir = __DIR__ . '/../uploads';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadDir . '/' . $imgName)) {
        die('錯誤：圖片上傳失敗');
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
