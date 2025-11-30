# Restaurant Admin 資料庫設定指南

## 📋 資料庫概述

早餐店後台管理系統使用 MySQL 資料庫來儲存商品資訊和銷售記錄。

### 技術規格
- **資料庫類型:** MySQL / MariaDB
- **字元集:** UTF-8 (utf8mb4)
- **連線方式:** PDO
- **預設資料庫名稱:** `store`

---

## 🚀 快速開始

### 方法一：使用 MySQL CLI

```bash
# 1. 登入 MySQL
mysql -u root -p

# 2. 匯入資料庫
source /path/to/restaurant-admin/restaurant-admin.sql

# 3. 驗證
USE store;
SHOW TABLES;
```

### 方法二：使用 phpMyAdmin

1. 開啟 phpMyAdmin
2. 點選「匯入」
3. 選擇 `restaurant-admin.sql` 檔案
4. 點擊「執行」

---

## ⚙️ 環境設定

### 步驟 1: 建立 .env 檔案

```bash
cp .env.example .env
```

### 步驟 2: 編輯 .env 檔案

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=store
DB_USER=your_username
DB_PASS=your_password
```

### 步驟 3: 執行資料庫 Schema

```bash
mysql -u your_username -p < restaurant-admin.sql
```

---

## 📊 資料表結構

### 1. items 資料表

儲存商品資訊。

| 欄位 | 類型 | 說明 | 約束 |
|------|------|------|------|
| id | INT UNSIGNED | 商品ID | 主鍵, 自動遞增 |
| name | VARCHAR(16) | 商品名稱 | 非空 |
| cost | INT | 成本 | 非空 |
| stock | INT | 庫存數量 | 非空 |
| price | INT UNSIGNED | 售價 | 非空 |
| img | VARCHAR(255) | 商品圖片 | 可空 |
| category | VARCHAR(50) | 分類 | 預設'未分類' |

**範例資料:**
```sql
INSERT INTO items (name, cost, stock, price, img, category) VALUES
('蛋餅', 20, 50, 20, '683f9fd15fae3.png', '其他'),
('豆漿', 8, 100, 15, '683fa099b5bb2.jpg', '飲品');
```

---

### 2. sales 資料表

儲存銷售記錄。

| 欄位 | 類型 | 說明 | 約束 |
|------|------|------|------|
| id | INT | 記錄ID | 主鍵, 自動遞增 |
| item | INT | 商品ID | 關聯 items.id |
| quantity | INT | 銷售數量 | 非空 |
| no | INT | 訂單編號 | 非空 |

**範例資料:**
```sql
INSERT INTO sales (item, quantity, no) VALUES
(1, 1, 1001),
(2, 2, 1001);
```

---

## 🔍 常用查詢

### 查詢銷售統計

```sql
SELECT
    i.id,
    i.name,
    i.price,
    i.img,
    i.category,
    COALESCE(SUM(s.quantity), 0) AS total_sales
FROM items i
LEFT JOIN sales s ON i.id = s.item
GROUP BY i.id
ORDER BY total_sales DESC;
```

### 查詢特定訂單

```sql
SELECT
    s.no AS order_number,
    i.name,
    s.quantity,
    i.price,
    (s.quantity * i.price) AS subtotal
FROM sales s
JOIN items i ON s.item = i.id
WHERE s.no = 1001;
```

### 查詢庫存不足商品

```sql
SELECT * FROM items
WHERE stock < 10
ORDER BY stock ASC;
```

---

## 🛠️ 維護建議

### 定期備份

```bash
# 完整備份
mysqldump -u root -p store > backup_$(date +%Y%m%d).sql

# 僅備份結構
mysqldump -u root -p --no-data store > schema.sql
```

### 清理舊訂單

```sql
-- 刪除 30 天前的訂單記錄
DELETE FROM sales
WHERE no IN (
    SELECT DISTINCT no FROM sales
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
);
```

---

## ❓ 常見問題

### Q1: 如何重置資料庫?

```sql
DROP DATABASE IF EXISTS store;
```

然後重新匯入 `restaurant-admin.sql`。

### Q2: 如何新增新的商品分類?

分類儲存在 `items.category` 欄位，直接新增商品時指定即可:

```sql
INSERT INTO items (name, cost, stock, price, category)
VALUES ('咖啡', 15, 100, 40, '飲品');
```

### Q3: 圖片檔案儲存在哪裡?

圖片儲存在 `uploads/` 目錄，資料庫僅儲存檔案名稱。

---

**文件版本:** 1.0.0
**最後更新:** 2025-11-03
