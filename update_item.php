<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯品項</title>
</head>
<body>
    <h1>編輯品項</h1>
    <?php
    require_once __DIR__ . '/db.php';
    $id = $_GET['id'] ?? 0;
    $item= $pdo->query("SELECT * FROM items WHERE id='$id'")->fetch(PDO::FETCH_ASSOC);
    if (!$item) {
        echo "<h2>品項不存在</h2>";
        exit;
    }
    ?>
    <form action="./api/update_item.php" method="post" enctype="multipart/form-data">
        <label for="name">品項名稱:</label>
        <input type="text" name="name" id="name" value="<?=$item['name'];?>" required>
        <br>
        <label for="category">分類:</label>
        <select name="category" id="category" required>
            <option value="飲品" <?=($item['category']==='飲品')?'selected':'';?>>飲品</option>
            <option value="吐司" <?=($item['category']==='吐司')?'selected':'';?>>吐司</option>
            <option value="漢堡" <?=($item['category']==='漢堡')?'selected':'';?>>漢堡</option>
            <option value="其他" <?=($item['category']==='其他')?'selected':'';?>>其他</option>
        </select>
        <br>
        <label for="price">價格:</label>
        <input type="number" name="price" id="price" value="<?=$item['price'];?>" required>
        <br>
        <label for="cost">成本:</label>
        <input type="text" name="cost" id="cost" value="<?=$item['cost'];?>" required>
        <br>
        <label for="stock">庫存:</label>
        <input type="number" name="stock" id="stock" value="<?=$item['stock'];?>" required>
        <br>
        <label for="img">更換圖片:</label>
        <input type="file" name="img" id="img" accept="image/*">
        <?php if (!empty($item['img'])): ?>
            <br><img src="uploads/<?=$item['img'];?>" alt="現有圖片" style="width:60px;height:60px;object-fit:cover;">
            <input type="hidden" name="old_img" value="<?=$item['img'];?>">
        <?php endif; ?>
        <br>
        <input type="hidden" name="id" value="<?=$item['id'];?>">
        <button type="submit">編輯</button>
    </form>
</body>
</html>