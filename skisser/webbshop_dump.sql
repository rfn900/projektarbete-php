-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 24, 2021 at 12:26 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `webbshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `shipped` tinyint(1) NOT NULL,
  `quantity` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `user_id`, `shipped`, `quantity`) VALUES
(1, 2, 4, 1, 2),
(1, 4, 4, 1, 1),
(1, 6, 4, 1, 1),
(2, 2, 4, 1, 1),
(3, 2, 4, 1, 1),
(4, 6, 4, 1, 1),
(5, 2, 4, 0, 1),
(5, 9, 4, 0, 1),
(6, 7, 4, 1, 1),
(7, 2, 6, 0, 1),
(8, 11, 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `description`, `price`) VALUES
(4, 'Dog hat', 'https://images-na.ssl-images-amazon.com/images/I/7174hEzc%2BYL._SL1500_.jpg', 'Cute and ugly dog hat at the same time', 239),
(6, 'Cat protective gear', 'img/cat-gear.png', 'It protects your cat during home renovation', 1990),
(7, 'Cat hammer and wrench', 'img/cat-hammer.png', 'Well it is a hammer and wrench for your cat', 599),
(11, 'Cat sport car', 'img/catbil.png', 'Your cat is going to want this', 20999),
(13, 'Dog socks', 'img/dog-sock.jpeg', 'Dog socks to keep your dog warm', 129);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `admin`) VALUES
(1, 'user1', 1),
(2, 'fadfadf', 0),
(3, 'user2', 0),
(4, 'rona2001', 1),
(5, 'rfn900@gmail.com', 0),
(6, 'rfn900', 0),
(7, 'Duck', 0),
(8, 'Donald', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

