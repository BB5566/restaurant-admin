<?php

/* echo "<pre>";
print_r($_POST);
echo "</pre>";
 */
$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;

// 處理圖片上傳
$img = $_POST['old_img'] ?? '';
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $newName = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['img']['tmp_name'], '../uploads/' . $newName);
    $img = $newName;
}

$sql = "UPDATE `items`
         SET `name`='{$_POST['name']}',
             `category`='{$_POST['category']}',
             `price`='{$_POST['price']}',
             `cost`='{$_POST['cost']}',
             `stock`='{$_POST['stock']}',
             `img`='{$img}'
         WHERE `id`='{$_POST['id']}'";
$pdo->exec($sql);

header("Location: ../index.php");
