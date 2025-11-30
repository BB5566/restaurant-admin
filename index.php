<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>泰褲辣 早餐店 後臺系統</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        h1 {
            color: #e74c3c;
            margin: 10px 0;
            font-size: 1.8rem;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin: 20px 0;
        }

        h3.category-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 30px 0 15px 0;
            font-size: 1.1rem;
        }

        .actions {
            text-align: center;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        th {
            background: #f1f3f4;
            padding: 14px 12px;
            text-align: center;
            font-weight: 600;
            color: #5f6368;
            font-size: 0.9rem;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .item-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .no-img {
            color: #aaa;
            font-size: 0.85rem;
        }

        .action-link {
            display: inline-block;
            padding: 6px 12px;
            margin: 2px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background 0.2s;
        }

        .edit-link {
            background: #e3f2fd;
            color: #1976d2;
        }

        .edit-link:hover {
            background: #bbdefb;
        }

        .delete-link {
            background: #ffebee;
            color: #c62828;
        }

        .delete-link:hover {
            background: #ffcdd2;
        }

        .price {
            color: #e74c3c;
            font-weight: 600;
        }

        .sales {
            color: #27ae60;
            font-weight: 500;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #4caf50;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s;
            z-index: 1000;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 8px 6px;
            }

            .item-img {
                width: 40px;
                height: 40px;
            }

            .action-link {
                display: block;
                margin: 4px 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="./img/泰褲辣LOGO.png" alt="泰褲辣 Logo">
            <h1>泰褲辣 早餐店</h1>
            <p style="color: #666; margin: 0;">後臺管理系統</p>
        </div>

        <h2>📋 餐點項目管理</h2>

        <div class="actions">
            <a href="add_item.php" class="btn">➕ 新增品項</a>
        </div>

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

        if (empty($grouped)): ?>
            <p style="text-align: center; color: #666;">目前沒有任何品項，請點擊上方按鈕新增。</p>
        <?php else:
            foreach ($grouped as $category => $items): ?>
                <h3 class="category-title">📁 <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>品項名稱</th>
                            <th>價格</th>
                            <th>銷售數量</th>
                            <th>圖片</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= (int) $item['id'] ?></td>
                                <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="price">$<?= number_format((float) $item['price']) ?></td>
                                <td class="sales"><?= (int) $item['total_sales'] ?></td>
                                <td>
                                    <?php if (!empty($item['img'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>"
                                             alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                                             class="item-img">
                                    <?php else: ?>
                                        <span class="no-img">無圖片</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="update_item.php?id=<?= (int) $item['id'] ?>" class="action-link edit-link">✏️ 編輯</a>
                                    <a href="./api/delete_item.php?id=<?= (int) $item['id'] ?>"
                                       class="action-link delete-link"
                                       onclick="return confirm('確定要刪除「<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>」嗎？此操作無法復原。')">🗑️ 刪除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach;
        endif;
        ?>
    </div>

    <?php
    // 顯示操作結果訊息
    $messages = [
        'added' => '✅ 品項新增成功！',
        'updated' => '✅ 品項更新成功！',
        'deleted' => '✅ 品項已刪除！'
    ];
    if (isset($_GET['msg']) && isset($messages[$_GET['msg']])): ?>
        <div class="toast"><?= $messages[$_GET['msg']] ?></div>
        <script>setTimeout(() => document.querySelector('.toast')?.remove(), 3000);</script>
    <?php endif; ?>
</body>

</html>
