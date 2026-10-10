<?php
/**
 * 刪除品項 API
 * 使用 Prepared Statements 防止 SQL 注入
 */

require_once __DIR__ . '/../security.php';
ensureSessionStarted();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('錯誤：無效的請求方式');
}

if (!validateCsrfToken($_POST['csrf_token'] ?? null)) {
    die('錯誤：CSRF 驗證失敗');
}

// 驗證 ID
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die('錯誤：無效的品項 ID');
}

$id = (int) $_POST['id'];

$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;

try {
    // 先查詢圖片路徑
    $stmt = $pdo->prepare("SELECT img FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // 刪除圖片檔案
        if (!empty($item['img'])) {
            $imgPath = __DIR__ . '/../uploads/' . basename($item['img']);
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // 刪除資料庫記錄
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: ../index.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    die('資料庫錯誤：' . $e->getMessage());
}
