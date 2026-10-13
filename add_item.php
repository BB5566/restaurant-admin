<?php
require_once __DIR__ . '/security.php';
ensureSessionStarted();
$csrfToken = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增品項 - 泰褲辣早餐店</title>
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

            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-inverse: #ffffff;

            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --bg-subtle: #f1f5f9;

            --border-color: #cbd5e1;
            --border-focus: #4f46e5;

            /* Spacing */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;

            /* Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.06), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);

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
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .container {
            max-width: 540px;
            width: 100%;
            margin: 0 auto;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: var(--space-xl);
        }

        .header {
            text-align: center;
            margin-bottom: var(--space-lg);
            position: relative;
        }

        .back-nav {
            margin-bottom: var(--space-md);
            text-align: left;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 44px;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            padding: 4px 8px;
            margin-left: -8px;
            transition: color var(--transition-fast), background var(--transition-fast);
        }

        .back-link:hover {
            color: var(--primary-hover);
            background: var(--primary-light);
            text-decoration: none;
        }

        .back-link:focus-visible {
            outline: none;
            box-shadow: var(--focus-ring);
        }

        h1 {
            color: var(--text-primary);
            margin: 0 0 6px 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .header-desc {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: var(--space-md);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-md);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.925rem;
        }

        .required-star {
            color: var(--danger);
            margin-left: 2px;
        }

        .optional-hint {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            min-height: 46px;
            padding: 10px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-primary);
            background-color: var(--bg-card);
            transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder {
            color: var(--text-muted);
            opacity: 0.8;
        }

        input:hover,
        select:hover {
            border-color: #94a3b8;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: var(--focus-ring);
        }

        input[type="file"] {
            width: 100%;
            min-height: 46px;
            padding: 10px 14px;
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-md);
            background: var(--bg-subtle);
            color: var(--text-secondary);
            font-family: inherit;
            font-size: 0.95rem;
            cursor: pointer;
            transition: border-color var(--transition-fast), background var(--transition-fast);
        }

        input[type="file"]:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        input[type="file"]:focus-visible {
            outline: none;
            box-shadow: var(--focus-ring);
            border-color: var(--primary);
        }

        .field-hint {
            display: block;
            margin-top: 6px;
            font-size: 0.8125rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .preview-area {
            margin-top: 14px;
            text-align: center;
            padding: 14px;
            background: var(--bg-subtle);
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }

        .preview-title {
            margin: 0 0 8px 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .preview-area img {
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            display: none;
            margin: 0 auto;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: var(--space-xl);
        }

        .btn {
            flex: 1;
            min-height: 48px;
            padding: 12px 20px;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform var(--transition-fast), box-shadow var(--transition-fast), background var(--transition-fast);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: var(--focus-ring);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: var(--text-inverse);
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: var(--bg-subtle);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: #94a3b8;
        }

        .site-footer {
            text-align: center;
            padding: var(--space-md) 0 0;
            color: var(--text-muted);
            font-size: 0.8125rem;
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .card {
                padding: var(--space-lg) var(--space-md);
                border-radius: var(--radius-md);
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .btn-group {
                flex-direction: column-reverse;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <main class="card">
            <header class="header">
                <nav class="back-nav" aria-label="導覽">
                    <a href="index.php" class="back-link"><span aria-hidden="true">←</span> 返回列表</a>
                </nav>
                <h1>➕ 新增品項</h1>
                <p class="header-desc">填寫品項資訊以新增至早餐店菜單</p>
            </header>

            <form action="./api/add_item.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                <div class="form-group">
                    <label for="name">品項名稱 <span class="required-star" aria-hidden="true">*</span></label>
                    <input type="text" name="name" id="name" placeholder="例如：原味蛋餅、招牌奶茶" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="category">分類 <span class="required-star" aria-hidden="true">*</span></label>
                    <select name="category" id="category" required>
                        <option value="">請選擇分類</option>
                        <option value="飲品">🥤 飲品</option>
                        <option value="吐司">🍞 吐司</option>
                        <option value="漢堡">🍔 漢堡</option>
                        <option value="其他">📦 其他</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">售價 (NT$) <span class="required-star" aria-hidden="true">*</span></label>
                        <input type="number" name="price" id="price" min="0" step="1" placeholder="例如：35" required>
                    </div>

                    <div class="form-group">
                        <label for="cost">成本 (NT$) <span class="required-star" aria-hidden="true">*</span></label>
                        <input type="number" name="cost" id="cost" min="0" step="0.1" placeholder="例如：15.0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stock">庫存數量 <span class="required-star" aria-hidden="true">*</span></label>
                    <input type="number" name="stock" id="stock" min="0" step="1" placeholder="例如：100" required>
                </div>

                <div class="form-group">
                    <label for="img">商品圖片 <span class="optional-hint">（選填）</span></label>
                    <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/gif,image/webp" aria-describedby="img-hint" onchange="previewImage(this)">
                    <small class="field-hint" id="img-hint">支援 JPG、PNG、WebP、GIF 格式，上傳後顯示於品項列表</small>
                    <div class="preview-area" id="previewContainer" style="display: none;">
                        <p class="preview-title">圖片預覽：</p>
                        <img id="preview" alt="即將上傳的商品圖片預覽">
                    </div>
                </div>

                <div class="btn-group">
                    <a href="index.php" class="btn btn-secondary">取消</a>
                    <button type="submit" class="btn btn-primary">新增品項</button>
                </div>
            </form>
        </main>

        <footer class="site-footer">
            <p>泰褲辣 早餐店 後臺管理系統 &copy; <?= date('Y') ?></p>
        </footer>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const container = document.getElementById('previewContainer');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.type && !file.type.startsWith('image/')) {
                    alert('請選擇有效的圖片檔案！');
                    input.value = '';
                    preview.style.display = 'none';
                    if (container) container.style.display = 'none';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (container) container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                if (container) container.style.display = 'none';
            }
        }
    </script>
</body>
</html>
