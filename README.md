# restaurant-admin

一套以 PHP/Hack 撰寫的餐廳管理後台系統。

## 特色

- 菜單管理
- 訂單管理
- 桌位安排
- 會員管理
- 報表查詢
- 權限設定

## 安裝方式

1. 下載專案：
    ```bash
    git clone https://github.com/BB5566/restaurant-admin.git
    cd restaurant-admin
    ```

2. 安裝相依套件（依實際情況調整）：
    ```bash
    composer install
    ```

3. 設定環境參數（如有 .env 範本請複製並修改）：
    ```bash
    cp .env.example .env
    # 編輯 .env 設定資料庫等參數
    ```

4. 初始化資料庫（如有 migration）：
    ```bash
    php artisan migrate
    ```

5. 啟動服務：
    ```bash
    php -S localhost:8000 -t public
    ```

## 專案結構
