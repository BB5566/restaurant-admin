<?php

$requirePath = file_exists(__DIR__ . '/../db.php') ? __DIR__ . '/../db.php' : __DIR__ . '/db.php';
require_once $requirePath;

$sql = "DELETE FROM `items` WHERE `id`='{$_GET['id']}'";
$pdo->exec($sql);

header("Location: ../index.php");
