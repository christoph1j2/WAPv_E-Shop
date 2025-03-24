-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 11:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Pánské formální boty', 'Elegantní pánské boty pro společenské události.'),
(2, 'Dámské lodičky', 'Klasické dámské lodičky s různými výškami podpatku.'),
(3, 'Dětské tenisky', 'Pohodlné a odolné tenisky pro aktivní děti.'),
(4, 'Pánské běžecké boty', 'Lehké a prodyšné boty pro běh a trénink.'),
(5, 'Dámské zimní boty', 'Teplé a stylové boty pro chladné zimní dny.'),
(6, 'Pánské trekové boty', 'Odolné boty pro turistiku a outdoorové aktivity.'),
(7, 'Dámské baleríny', 'Pohodlné a elegantní boty pro každodenní nošení.'),
(8, 'Dětské sandály', 'Letní sandály s nastavitelnými pásky pro pohodlí.'),
(9, 'Pánské kopačky', 'Profesionální kopačky pro fotbalové hráče všech úrovní.'),
(10, 'Dámské kotníkové boty', 'Stylové kotníkové boty pro různé outfity.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `note`) VALUES
(1, 1, 6546.00, 'cancelled', '2025-03-24 19:36:15', NULL),
(2, 4, 7500.00, 'pending', '2025-03-24 21:11:36', ''),
(3, 4, 2500.00, 'pending', '2025-03-24 21:12:28', ''),
(4, 4, 2500.00, 'pending', '2025-03-24 21:15:57', ''),
(5, 4, 1800.00, 'pending', '2025-03-24 21:16:21', ''),
(6, 4, 2500.00, 'pending', '2025-03-24 21:16:56', ''),
(7, 4, 2500.00, 'pending', '2025-03-24 21:17:27', ''),
(8, 4, 2500.00, 'pending', '2025-03-24 21:18:02', ''),
(9, 4, 900.00, 'pending', '2025-03-24 21:18:13', ''),
(10, 4, 2800.00, 'pending', '2025-03-24 21:18:37', ''),
(11, 4, 1500.00, 'pending', '2025-03-24 21:20:33', ''),
(12, 4, 800.00, 'pending', '2025-03-24 21:20:59', ''),
(13, 4, 1800.00, 'delivered', '2025-03-24 21:21:29', ''),
(14, 4, 2500.00, 'pending', '2025-03-24 21:49:14', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 2, 15, 3, 2500.00),
(2, 3, 15, 1, 2500.00),
(3, 4, 15, 1, 2500.00),
(4, 5, 16, 1, 1800.00),
(5, 6, 15, 1, 2500.00),
(6, 7, 15, 1, 2500.00),
(7, 8, 15, 1, 2500.00),
(8, 9, 17, 1, 900.00),
(9, 10, 19, 1, 2800.00),
(10, 11, 21, 1, 1500.00),
(11, 12, 22, 1, 800.00),
(12, 13, 16, 1, 1800.00),
(13, 14, 15, 1, 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `stock_quantity`, `category_id`, `created_at`) VALUES
(15, 'Oxfordky', 'Klasické černé kožené polobotky pro formální příležitosti.', 2500.00, 'images/example.webp', 21, 1, '2025-03-24 18:05:09'),
(16, 'Lodičky', 'Černé lodičky s pohodlným nízkým podpatkem.', 1800.00, 'images/example.webp', 48, 2, '2025-03-24 18:05:09'),
(17, 'Tenisky', 'Modré tenisky s obrázkem Spidermana pro chlapce.', 900.00, 'images/example.webp', 79, 3, '2025-03-24 18:05:09'),
(18, 'Air Maxy', 'Bílé běžecké boty s odpružením Air Max pro maximální pohodlí.', 3200.00, 'images/example.webp', 20, 4, '2025-03-24 18:05:09'),
(19, 'Kožíškem', 'Hnědé zimní boty s teplým kožíškem uvnitř.', 2800.00, 'images/example.webp', 24, 5, '2025-03-24 18:05:09'),
(20, 'Questy', 'Šedé trekové boty s Gore-Tex membránou pro voděodolnost.', 3500.00, 'images/example.webp', 15, 6, '2025-03-24 18:05:09'),
(21, 'Mašlí', 'Černé baleríny s ozdobnou mašlí.', 1500.00, 'images/example.webp', 59, 7, '2025-03-24 18:05:09'),
(22, 'Pásky', 'Modré sandály s nastavitelnými pásky pro pohodlí a stabilitu.', 800.00, 'images/example.webp', 99, 8, '2025-03-24 18:05:09'),
(23, 'Predátory', 'Černé kopačky s technologií Predator pro maximální kontrolu míče.', 4000.00, 'images/example.webp', 10, 9, '2025-03-24 18:05:09'),
(24, 'Podpatku', 'Hnědé kotníkové boty na podpatku s koženým vzhledem.', 2200.00, 'images/example.webp', 35, 10, '2025-03-24 18:05:09'),
(25, 'Reeboky', 'Černé pánské sportovní boty Reebok, pro každodenní nošení', 1799.00, 'images/example.webp', 40, 4, '2025-03-24 18:05:09'),
(26, 'Mokasíny', 'Hnědé dámské kožené mokasíny, vhodné pro každodenní nošení.', 1999.00, 'images/example.webp', 25, 7, '2025-03-24 18:05:09'),
(27, 'Vody', 'Modré dětské boty do vody, vhodné na pláž i k bazénu.', 599.00, 'images/example.webp', 50, 8, '2025-03-24 18:05:09'),
(28, 'Hanwagy', 'Hnědé pánské trekové boty Hanwag vhodné do náročného terénu', 4500.00, 'images/example.webp', 12, 6, '2025-03-24 18:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_editor` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `address`, `phone`, `is_admin`, `is_editor`, `created_at`, `active`) VALUES
(1, 'asdfasdf', 'asdfasdf@asdfasdf.asdf', 'asdfasdfasdfasdf', NULL, NULL, 0, 0, '2025-03-24 16:38:44', 0),
(2, 'leschkae', 'leschkae@spseplzen.cz', '$2y$10$qS7HG44RQL9uE2/XJx8FZOoKeblw.Wr5alinkTfQYgW6LzoJyzXym', 'asdfasdffffdfdfdfqqasdfasdf', 'dfdfssqq', 1, 0, '2025-03-24 16:46:12', 1),
(3, 'asdfasdf', 'leschka@spseplzen.cz', '$2y$10$tQ/nkeBNLS3phtzkh78mrepg4VopxsQabTfN99H3jRC41Bp04jdo6', '', '', 0, 1, '2025-03-24 19:01:34', 1),
(4, 'test', 'test@test.com', '$2y$10$kIueIpL3LUd3Qf4VPniRcuLO6B/x.fKPIVabvAtnrM//jWNlQ6Zq.', 'f', 'f', 0, 0, '2025-03-24 20:20:24', 1),
(5, 'qqqqqq', 'tessst@test.com', '$2y$10$Pmo1zh2yevyFMYTTFEZAJuriwCb5UFSaRojXJ7x0jtR31V3gGuB8i', NULL, NULL, 0, 0, '2025-03-24 20:22:55', 1),
(6, 'q', 'q@q.q', '$2y$10$fIYNpjCpkcNI5f4IjhBGReNE6O4DIxkyZnvHJlzZMUlSsOTWnlPXO', NULL, NULL, 0, 0, '2025-03-24 21:00:05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_items_order` (`order_id`),
  ADD KEY `idx_order_items_product` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_password_resets_token` (`token`),
  ADD KEY `idx_password_resets_user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
