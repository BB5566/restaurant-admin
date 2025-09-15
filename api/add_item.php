<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

// 圖片上傳處理
$imgName = '';
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $imgName = uniqid() . '.' . $ext;
    if (!is_dir('../uploads')) {
        mkdir('../uploads', 0777, true);
    }
    move_uploaded_file($_FILES['img']['tmp_name'], '../uploads/' . $imgName);
}

$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;
$sql = "INSERT INTO `items`(`name`, `category`, `price`, `cost`, `stock`, `img`)
                VALUES ('{$_POST['name']}','{$_POST['category']}','{$_POST['price']}','{$_POST['cost']}','{$_POST['stock']}','$imgName')";
$pdo->exec($sql);

header("Location: ../index.php");
