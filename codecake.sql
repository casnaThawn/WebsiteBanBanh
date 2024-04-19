-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2024 lúc 09:12 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `codecake`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `email` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`email`, `name`, `password`, `role`) VALUES
('admin', 'admin', '$2y$12$zmgMt5dItVnhUqD/FJkC0ejL8xTU5IuqxDhsALMO81eWzWgEh8noO', 'admin'),
('thang', 'thang', '$2y$12$S4.8EdpSDOHRH.wwsyxH3O5HuWUoHisrX6ANoqyzAxntQgtOBVV82', 'user'),
('thai@gmail.com', 'thai@gmail.com', '$2y$12$GeVvo5P4y/cuDDZaHmGnxOXoJbDDholFo1Yx09qoGxYcOW4NfN93G', 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_slug` int(250) NOT NULL,
  `is_homepage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `is_homepage`) VALUES
(1, 'Maccaron', 0, 0),
(2, 'Tiramisu', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_address` varchar(200) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_address`, `customer_phone`, `total_price`) VALUES
(8, 'Thai', 'hotphne@gmail.com', 'ádfasd', '0333131801', 85000),
(9, 'Vuss', 'yolobosit@gmail.com', 'nb n b', '0333131801', 50000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(6, 8, 1, 1, 25000),
(7, 8, 6, 2, 30000),
(8, 9, 1, 2, 25000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_slug` varchar(250) NOT NULL,
  `product_size` varchar(20) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` varchar(250) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `product_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_slug`, `product_size`, `is_special`, `product_price`, `product_description`, `product_image`, `product_category`) VALUES
(1, 'Maccaron Matcha', 'Maccaron-Matcha', '10 cm', 0, 25000, 'Maccaron Trà Xanh', 'uploads/MAC-Matcha.png', 1),
(3, 'Maccaron Strawberry', 'Maccaron-Strawberry', '10 cm', 0, 26000, 'Maccaron Dâu', 'uploads/MAC-Strawberry.png', 1),
(5, 'Tiramisu Strawberry', 'Tiramisu-Strawberry', '12 cm', 0, 32000, 'Tiramisu Dâu', 'uploads/TRMS-Strawberry.png', 2),
(6, 'Macaroon Chocolate', '', '', 0, 30000, 'Macaroon Socola', 'uploads/MAC-Chocolate.png', 1),
(7, 'Tiramisu Matcha', '', '', 0, 35000, 'Tiramisu Trà Xanh', 'uploads/TRMS-Matcha.png', 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
