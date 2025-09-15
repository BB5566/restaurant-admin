-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-06-05 03:40:42
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `store`
--

-- --------------------------------------------------------

--
-- 資料表結構 `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(16) NOT NULL,
  `cost` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL DEFAULT '未分類'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `items`
--

INSERT INTO `items` (`id`, `name`, `cost`, `stock`, `price`, `img`, `category`) VALUES
(1, '蛋餅', 20, 50, 20, '683f9fd15fae3.png', '其他'),
(2, '豆漿', 8, 100, 15, '683fa099b5bb2.jpg', '飲品'),
(3, '三明治', 10, 100, 25, '683fa062991d0.png', '吐司'),
(4, '漢堡', 20, 50, 30, '683fa21e7b727.png', '漢堡'),
(5, '蘿葡糕', 12, 100, 35, '683fa004a3e62.png', '其他'),
(7, '大冰奶', 5, 100, 20, '683f9b6c1da36.png', '飲品');

-- --------------------------------------------------------

--
-- 資料表結構 `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sales`
--

INSERT INTO `sales` (`id`, `item`, `quantity`, `no`) VALUES
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

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
