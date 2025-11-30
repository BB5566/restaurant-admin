-- Restaurant Admin SQLite Schema
-- 轉換自 MySQL schema
-- 建立時間: 2025-11-20

-- ====================================================================
-- 品項資料表
-- ====================================================================

CREATE TABLE IF NOT EXISTS items (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(16) NOT NULL,
  cost INTEGER NOT NULL,
  stock INTEGER NOT NULL,
  price INTEGER NOT NULL,
  img VARCHAR(255) DEFAULT NULL,
  category VARCHAR(50) NOT NULL DEFAULT '未分類'
);

-- ====================================================================
-- 銷售資料表
-- ====================================================================

CREATE TABLE IF NOT EXISTS sales (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  item INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  no INTEGER NOT NULL
);

-- ====================================================================
-- 插入範例資料
-- ====================================================================

INSERT INTO items (id, name, cost, stock, price, img, category) VALUES
(1, '蛋餅', 20, 50, 20, '683f9fd15fae3.png', '其他'),
(2, '豆漿', 8, 100, 15, '683fa099b5bb2.jpg', '飲品'),
(3, '三明治', 10, 100, 25, '683fa062991d0.png', '吐司'),
(4, '漢堡', 20, 50, 30, '683fa21e7b727.png', '漢堡'),
(5, '蘿葡糕', 12, 100, 35, '683fa004a3e62.png', '其他'),
(7, '大冰奶', 5, 100, 20, '683f9b6c1da36.png', '飲品');

INSERT INTO sales (id, item, quantity, no) VALUES
(1, 1, 1, 1001),
(2, 2, 1, 1001),
(3, 3, 1, 1002),
(4, 2, 2, 1003),
(5, 4, 1, 1004),
(6, 2, 1, 1004),
(7, 5, 1, 1005),
(8, 1, 2, 1006),
(9, 3, 1, 1007),
(10, 2, 1, 1007),
(11, 4, 1, 1008),
(12, 1, 1, 1009),
(13, 5, 1, 1009),
(14, 3, 1, 1010),
(15, 2, 1, 1011),
(16, 5, 1, 1012),
(17, 2, 1, 1012),
(18, 4, 2, 1013),
(19, 1, 1, 1014),
(20, 3, 1, 1014);
