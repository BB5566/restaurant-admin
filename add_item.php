<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增品項</title>
</head>
<body>
    <h1>新增品項</h1>
    <form action="./api/add_item.php" method="post" enctype="multipart/form-data">
        <label for="name">品項名稱:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="category">分類:</label>
        <select name="category" id="category" required>
            <option value="飲品">飲品</option>
            <option value="吐司">吐司</option>
            <option value="漢堡">漢堡</option>
            <option value="其他">其他</option>
        </select>
        <br>
        <label for="price">價格:</label>
        <input type="number" name="price" id="price" required>
        <br>
        <label for="cost">成本:</label>
        <input type="text" name="cost" id="cost" required>
        <br>
        <label for="stock">庫存:</label>
        <input type="number" name="stock" id="stock" required>
        <br>
        <label for="img">圖片上傳:</label>
        <input type="file" name="img" id="img" accept="image/*">
        <br>
        <button type="submit">新增</button>
    </form>
</body>
</html>