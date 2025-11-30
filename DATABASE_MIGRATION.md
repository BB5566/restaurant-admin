# Restaurant Admin - SQLite 遷移指南

## 🎉 改版說明

Restaurant Admin 已改用 **SQLite** 作為預設資料庫，簡化部署流程！

---

## 📦 優點

| 項目 | 說明 |
|------|------|
| ✅ **零配置部署** | 無需安裝 MySQL，上傳即可使用 |
| ✅ **單檔備份** | 整個資料庫就一個 `.sqlite` 檔案 |
| ✅ **輕量快速** | 適合小型餐廳單店使用 |
| ✅ **向下相容** | 仍支援 MySQL（透過環境變數切換）|

---

## 🚀 快速開始

### 1. 使用 SQLite（預設，推薦）

**無需任何設定**，直接使用即可！

系統會自動：
- 建立 `database/restaurant.sqlite` 資料庫檔案
- 初始化資料表結構
- 載入範例資料

### 2. 切換回 MySQL

如果需要使用 MySQL，建立 `.env` 檔案：

```env
DB_TYPE=mysql
DB_HOST=localhost
DB_NAME=store
DB_USER=root
DB_PASS=your_password
```

---

## 🔄 從 MySQL 遷移到 SQLite

### 方法 1: 手動匯出（推薦）

```bash
# 1. 匯出 MySQL 資料
mysqldump -u root -p store items sales > backup.sql

# 2. 手動編輯 backup.sql，移除 MySQL 特定語法
# 3. 匯入到 SQLite
sqlite3 database/restaurant.sqlite < database/schema.sqlite.sql
```

### 方法 2: 直接使用新資料庫

刪除舊的 `.env` 設定，系統會自動建立新的 SQLite 資料庫並載入範例資料。

---

## 📂 資料庫檔案位置

- **SQLite**: `database/restaurant.sqlite`
- **Schema**: `database/schema.sqlite.sql`

---

## 🔒 安全建議

### 1. 資料庫檔案權限

```bash
chmod 644 database/restaurant.sqlite
chmod 755 database/
```

### 2. 防止直接存取

在 `database/.htaccess` 加入：

```apache
Order Deny,Allow
Deny from all
```

或在 Nginx 配置中阻擋：

```nginx
location ~* \.sqlite$ {
    deny all;
}
```

---

## 📊 資料表結構

### items（品項表）
| 欄位 | 類型 | 說明 |
|------|------|------|
| id | INTEGER | 主鍵（自動遞增）|
| name | VARCHAR(16) | 品項名稱 |
| cost | INTEGER | 成本 |
| stock | INTEGER | 庫存 |
| price | INTEGER | 售價 |
| img | VARCHAR(255) | 圖片檔名 |
| category | VARCHAR(50) | 分類 |

### sales（銷售表）
| 欄位 | 類型 | 說明 |
|------|------|------|
| id | INTEGER | 主鍵（自動遞增）|
| item | INTEGER | 品項 ID |
| quantity | INTEGER | 數量 |
| no | INTEGER | 訂單編號 |

---

## 🛠️ 疑難排解

### Q: 資料庫連線失敗？

**檢查清單：**
1. `database/` 目錄是否存在？
2. PHP 是否有寫入權限？
3. PHP 是否啟用 PDO SQLite 擴充？

```bash
# 檢查 PDO SQLite 支援
php -m | grep pdo_sqlite
```

### Q: 如何備份資料？

```bash
# 備份 SQLite 資料庫
cp database/restaurant.sqlite database/restaurant_backup_$(date +%Y%m%d).sqlite
```

### Q: 如何查看資料庫內容？

使用 SQLite 命令列工具：

```bash
sqlite3 database/restaurant.sqlite
sqlite> .tables
sqlite> SELECT * FROM items;
sqlite> .exit
```

或使用圖形化工具：
- [DB Browser for SQLite](https://sqlitebrowser.org/)
- [DBeaver](https://dbeaver.io/)

---

## 📝 技術細節

### SQL 語法差異

| MySQL | SQLite |
|-------|--------|
| `AUTO_INCREMENT` | `AUTOINCREMENT` |
| `ENGINE=InnoDB` | (移除) |
| `UNSIGNED` | (移除，所有整數都是有號) |

### PDO 連線差異

```php
// MySQL
$dsn = "mysql:host=localhost;dbname=store;charset=utf8";
$pdo = new PDO($dsn, $user, $pass);

// SQLite
$dsn = "sqlite:/path/to/database.sqlite";
$pdo = new PDO($dsn);
```

---

## ✅ 完成！

現在您的 Restaurant Admin 已成功改用 SQLite，享受更簡單的部署體驗吧！

如有任何問題，請參考主專案文檔或提交 Issue。
