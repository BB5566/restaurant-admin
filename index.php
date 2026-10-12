<?php
// 在輸出任何 HTML 之前先啟動 session，否則 CSRF token 無法寫入 session
require_once __DIR__ . '/security.php';
ensureSessionStarted();
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>泰褲辣 早餐店 後臺系統</title>
    <style>
        :root {
            /* Colors */
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-active: #3730a3;
            --primary-light: #eef2ff;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --primary-gradient-hover: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);

            --danger: #b91c1c;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --danger-hover-bg: #fee2e2;

            --success: #15803d;
            --success-bg: #dcfce7;
            --success-border: #bbf7d0;

            --warning: #b45309;
            --warning-bg: #fef3c7;
            --warning-border: #fde68a;

            --info: #1d4ed8;
            --info-bg: #eff6ff;
            --info-border: #bfdbfe;
            --info-hover-bg: #dbeafe;

            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-inverse: #ffffff;

            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --bg-subtle: #f1f5f9;
            --bg-table-hover: #f8fafc;

            --border-color: #e2e8f0;
            --border-subtle: #f1f5f9;

            /* Spacing */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;

            /* Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-full: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.06), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.03);

            /* Focus & Transitions */
            --focus-ring: 0 0 0 3px rgba(99, 102, 241, 0.35);
            --transition-fast: 150ms ease;
            --transition-normal: 200ms ease;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans TC', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-secondary);
            line-height: 1.5;
            margin: 0;
            padding: var(--space-md);
            min-height: 100vh;
        }

        .container {
            max-width: 1080px;
            margin: 0 auto;
        }

        /* Header & Brand */
        .header {
            text-align: center;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: var(--space-lg) var(--space-md);
            margin-bottom: var(--space-xl);
            box-shadow: var(--shadow-sm);
        }

        .brand-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .header img {
            width: 72px;
            height: 72px;
            object-fit: contain;
            border-radius: var(--radius-md);
        }

        .brand-text {
            text-align: left;
        }

        h1 {
            color: var(--text-primary);
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .header-subtitle {
            color: var(--text-secondary);
            margin: 4px 0 0 0;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Page Head & Actions */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }

        h2 {
            color: var(--text-primary);
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .actions {
            margin: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 10px 22px;
            background: var(--primary-gradient);
            color: var(--text-inverse);
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: var(--shadow-sm);
            border: none;
            cursor: pointer;
            transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: var(--focus-ring);
        }

        /* Category Sections */
        .category-section {
            margin-bottom: var(--space-xl);
        }

        .category-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--primary-gradient);
            color: var(--text-inverse);
            padding: 12px 20px;
            border-radius: var(--radius-md);
            margin: 0 0 var(--space-sm) 0;
            box-shadow: var(--shadow-sm);
        }

        h3.category-title {
            color: var(--text-inverse);
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-badge {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-inverse);
            font-size: 0.8125rem;
            font-weight: 500;
            padding: 2px 10px;
            border-radius: var(--radius-full);
        }

        /* Table Design */
        .table-responsive {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: var(--space-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: var(--bg-subtle);
            padding: 14px 16px;
            text-align: center;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            border-bottom: 1px solid var(--border-color);
        }

        th.col-name, td.col-name {
            text-align: left;
        }

        td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background-color var(--transition-fast);
        }

        tbody tr:hover {
            background-color: var(--bg-table-hover);
        }

        .item-id {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .item-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .price {
            color: var(--danger);
            font-weight: 700;
            font-size: 1rem;
        }

        .sales {
            display: inline-flex;
            align-items: center;
            background: var(--success-bg);
            color: var(--success);
            padding: 3px 10px;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .item-img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            display: block;
            margin: 0 auto;
        }

        .no-img {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: var(--radius-md);
            background: var(--bg-subtle);
            border: 1px dashed var(--border-color);
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-cell {
            white-space: nowrap;
        }

        .action-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-form {
            display: inline;
            margin: 0;
        }

        .action-button {
            border: none;
            font: inherit;
            cursor: pointer;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            min-height: 38px;
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background var(--transition-fast), border-color var(--transition-fast), transform var(--transition-fast), box-shadow var(--transition-fast);
        }

        .action-link:hover {
            transform: translateY(-1px);
        }

        .action-link:active {
            transform: translateY(0);
        }

        .action-link:focus-visible {
            outline: none;
            box-shadow: var(--focus-ring);
        }

        .edit-link {
            background: var(--info-bg);
            color: var(--info);
            border-color: var(--info-border);
        }

        .edit-link:hover {
            background: var(--info-hover-bg);
            border-color: #93c5fd;
        }

        .delete-link {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: var(--danger-border);
        }

        .delete-link:hover {
            background: var(--danger-hover-bg);
            border-color: #fca5a5;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 2px dashed var(--border-color);
            margin: var(--space-xl) 0;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .empty-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 6px 0;
        }

        .empty-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0 0 20px 0;
        }

        /* Footer */
        .site-footer {
            text-align: center;
            padding: var(--space-xl) 0 var(--space-md);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .site-footer p {
            margin: 0;
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 48px;
            padding: 12px 20px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            font-size: 0.95rem;
            font-weight: 500;
            z-index: 1000;
            animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .toast-success {
            background: #065f46;
            color: #ffffff;
            border-left: 4px solid #34d399;
        }

        .toast-warning {
            background: #92400e;
            color: #ffffff;
            border-left: 4px solid #fbbf24;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            min-height: 32px;
        }

        .toast-close:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }

        .toast-close:focus-visible {
            outline: 2px solid #ffffff;
        }

        .toast-hiding {
            opacity: 0;
            transform: translateY(-8px);
        }

        @keyframes slideIn {
            from {
                transform: translateY(-16px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Mobile Layout (<= 720px) */
        @media (max-width: 720px) {
            body {
                padding: 12px;
            }

            .header {
                padding: var(--space-md);
                margin-bottom: var(--space-lg);
            }

            .brand-wrapper {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .brand-text {
                text-align: center;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .btn {
                width: 100%;
                min-height: 48px;
            }

            .table-responsive {
                background: transparent;
                border: none;
                box-shadow: none;
                overflow: visible;
            }

            table.responsive-table {
                display: block;
                width: 100%;
            }

            table.responsive-table thead {
                display: none;
            }

            table.responsive-table tbody {
                display: flex;
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }

            table.responsive-table tr {
                display: block;
                background: var(--bg-card);
                border-radius: var(--radius-lg);
                border: 1px solid var(--border-color);
                box-shadow: var(--shadow-sm);
                padding: 16px;
            }

            table.responsive-table tr:hover {
                background: var(--bg-card);
            }

            table.responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid var(--border-subtle);
                font-size: 0.95rem;
                text-align: right;
            }

            table.responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-muted);
                font-size: 0.875rem;
                text-align: left;
                flex-shrink: 0;
                margin-right: 12px;
            }

            table.responsive-table td.col-img {
                padding: 8px 0;
            }

            table.responsive-table td.col-img .item-img,
            table.responsive-table td.col-img .no-img {
                margin: 0;
            }

            table.responsive-table td.col-actions {
                border-bottom: none;
                padding-top: 14px;
                padding-bottom: 0;
                display: block;
            }

            table.responsive-table td.col-actions::before {
                display: none;
            }

            table.responsive-table .action-group {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                width: 100%;
            }

            table.responsive-table .action-form {
                display: block;
                width: 100%;
            }

            table.responsive-table .action-link {
                width: 100%;
                min-height: 44px;
                font-size: 0.95rem;
            }

            .toast {
                top: 16px;
                left: 16px;
                right: 16px;
                width: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="brand-wrapper">
                <img src="./img/泰褲辣LOGO.png" alt="泰褲辣早餐店商標">
                <div class="brand-text">
                    <h1>泰褲辣 早餐店</h1>
                    <p class="header-subtitle">後臺管理系統</p>
                </div>
            </div>
        </header>

        <main>
            <div class="page-header">
                <h2>📋 餐點項目管理</h2>
                <div class="actions">
                    <a href="add_item.php" class="btn">➕ 新增品項</a>
                </div>
            </div>

            <?php
            require_once __DIR__ . '/db.php';
            require_once __DIR__ . '/security.php';
            ensureSessionStarted();
            $csrfToken = getCsrfToken();

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
                <div class="empty-state">
                    <div class="empty-icon" aria-hidden="true">🍳</div>
                    <p class="empty-title">目前尚未建立任何品項</p>
                    <p class="empty-desc">請點擊上方「新增品項」按鈕開始建立餐點。</p>
                    <a href="add_item.php" class="btn">➕ 新增第一個品項</a>
                </div>
            <?php else:
                foreach ($grouped as $category => $items): ?>
                    <section class="category-section" aria-label="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?> 分類">
                        <div class="category-header">
                            <h3 class="category-title">📁 <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?></h3>
                            <span class="category-badge">共 <?= count($items) ?> 項</span>
                        </div>
                        <div class="table-responsive">
                            <table class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col" class="col-name">品項名稱</th>
                                        <th scope="col">價格</th>
                                        <th scope="col">銷售數量</th>
                                        <th scope="col">圖片</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td data-label="編號"><span class="item-id">#<?= (int) $item['id'] ?></span></td>
                                            <td data-label="品項名稱" class="col-name"><span class="item-name"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td data-label="價格" class="price">NT$ <?= number_format((float) $item['price']) ?></td>
                                            <td data-label="銷售數量"><span class="sales"><?= (int) $item['total_sales'] ?> 份</span></td>
                                            <td data-label="圖片" class="col-img">
                                                <?php if (!empty($item['img'])): ?>
                                                    <img src="uploads/<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>"
                                                         alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?> 餐點圖片"
                                                         class="item-img"
                                                         loading="lazy">
                                                <?php else: ?>
                                                    <span class="no-img">無圖片</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="操作" class="col-actions">
                                                <div class="action-group">
                                                    <a href="update_item.php?id=<?= (int) $item['id'] ?>" class="action-link edit-link" aria-label="編輯 <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>">✏️ 編輯</a>
                                                    <form action="./api/delete_item.php" method="post" class="action-form" onsubmit="return confirm('確定要刪除「<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>」嗎？此操作無法復原。')">
                                                        <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                                        <button type="submit" class="action-link delete-link action-button" aria-label="刪除 <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>">🗑️ 刪除</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                <?php endforeach;
            endif;
            ?>
        </main>

        <footer class="site-footer">
            <p>泰褲辣 早餐店 後臺管理系統 &copy; <?= date('Y') ?></p>
        </footer>
    </div>

    <?php
    // 顯示操作結果訊息
    $messages = [
        'added' => ['type' => 'success', 'text' => '✅ 品項新增成功！'],
        'updated' => ['type' => 'success', 'text' => '✅ 品項更新成功！'],
        'deleted' => ['type' => 'success', 'text' => '✅ 品項已刪除！'],
        'not_found' => ['type' => 'warning', 'text' => '⚠️ 找不到該品項或已被刪除！']
    ];
    $msgKey = $_GET['msg'] ?? '';
    if (isset($messages[$msgKey])):
        $msgInfo = $messages[$msgKey];
    ?>
        <div class="toast toast-<?= $msgInfo['type'] ?>" role="status" aria-live="polite">
            <span><?= $msgInfo['text'] ?></span>
            <button type="button" class="toast-close" onclick="this.parentElement.remove()" aria-label="關閉提示訊息">&times;</button>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.querySelector('.toast');
                if (toast) {
                    toast.classList.add('toast-hiding');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 3000);
        </script>
    <?php endif; ?>
</body>

</html>
