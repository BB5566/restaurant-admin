<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>早餐店系統</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <img src="./img/泰褲辣LOGO.png" style="width:100px;">
    </div>
    <h1>泰褲辣 早餐店 後臺系統</h1>
    <h2>餐點項目</h2>
    <?php
    require_once __DIR__ . '/db.php';
    // 查詢每個品項的銷售數量，並包含分類
    $sql = "SELECT i.id, i.name, i.price, IFNULL(SUM(s.quantity),0) AS total_sales, i.img, i.category
             FROM items i
             LEFT JOIN sales s ON i.id = s.item
             GROUP BY i.id, i.name, i.price, i.img, i.category
             ORDER BY i.category, i.id";
    $items = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    // 依分類分組
    $grouped = [];
    foreach ($items as $item) {
        $grouped[$item['category']][] = $item;
    }
    ?>
    <style>
        #items,
        .btns {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        #items td,
        #items th {
            border: 1px solid #ddd;
            padding: 5px 12px;
            text-align: center;
        }
    </style>
    <div class='btns'>
        <button><a href='add_item.php'>新增品項</a></button>
        <button><a href='add_item.php'>新增品項</a></button>

    </div>
    <?php foreach ($grouped as $category => $items): ?>
        <h3 style="width:50%;margin:30px auto 10px auto;">分類：<?= htmlspecialchars($category) ?></h3>
        <table id='items'>
            <tr>
                <td>編號</td>
                <td>品項</td>
                <td>價格</td>
                <td>銷售數量</td>
                <td>圖片</td>
                <td>操作</td>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= $item['name']; ?></td>
                    <td>$<?= $item['price']; ?></td>
                    <td><?= $item['total_sales']; ?></td>
                    <td>
                        <?php if (!empty($item['img'])): ?>
                            <img src="uploads/<?= $item['img']; ?>" alt="<?= $item['name']; ?>" style="width:60px;height:60px;object-fit:cover;">
                        <?php else: ?>
                            <span style="color:#aaa;">無圖片</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href='update_item.php?id=<?= $item['id']; ?>'>編輯</a>
                        <a href='./api/delete_item.php?id=<?= $item['id']; ?>'>刪除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</body>

</html>
