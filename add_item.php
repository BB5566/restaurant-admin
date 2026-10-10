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
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 32px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        h1 {
            color: #2c3e50;
            margin: 0 0 8px 0;
            font-size: 1.5rem;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e1e5eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #e1e5eb;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        input[type="file"]:hover {
            border-color: #667eea;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f1f3f4;
            color: #5f6368;
            text-decoration: none;
            text-align: center;
            line-height: 1.2;
        }

        .btn-secondary:hover {
            background: #e8eaed;
        }

        .preview-area {
            margin-top: 10px;
            text-align: center;
        }

        .preview-area img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            display: none;
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>➕ 新增品項</h1>
                <a href="index.php" class="back-link">← 返回列表</a>
            </div>

            <form action="./api/add_item.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                <div class="form-group">
                    <label for="name">品項名稱</label>
                    <input type="text" name="name" id="name" placeholder="輸入品項名稱" required>
                </div>

                <div class="form-group">
                    <label for="category">分類</label>
                    <select name="category" id="category" required>
                        <option value="">請選擇分類</option>
                        <option value="飲品">🥤 飲品</option>
                        <option value="吐司">🍞 吐司</option>
                        <option value="漢堡">🍔 漢堡</option>
                        <option value="其他">📦 其他</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">售價 (NT$)</label>
                    <input type="number" name="price" id="price" min="0" step="1" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label for="cost">成本 (NT$)</label>
                    <input type="number" name="cost" id="cost" min="0" step="0.1" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label for="stock">庫存數量</label>
                    <input type="number" name="stock" id="stock" min="0" step="1" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label for="img">商品圖片</label>
                    <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewImage(this)">
                    <div class="preview-area">
                        <img id="preview" alt="圖片預覽">
                    </div>
                </div>

                <div class="btn-group">
                    <a href="index.php" class="btn btn-secondary">取消</a>
                    <button type="submit" class="btn btn-primary">新增品項</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
