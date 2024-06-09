-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jun 2024 pada 00.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokokue`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `categorieId` int(11) NOT NULL,
  `categorieName` varchar(255) NOT NULL,
  `categorieDesc` text NOT NULL,
  `categorieCreateDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`categorieId`, `categorieName`, `categorieDesc`, `categorieCreateDate`) VALUES
(1, 'Kue Basah', 'Kue basah adalah camilan lembut dan kadar air tinggi dengan bahan utama tepung, santan, dan gula. Cocok untuk berbagai acara, sebaiknya segera dikonsumsi karena tidak tahan lama.', '2024-05-26 20:52:02'),
(2, 'Aneka Gorengan', 'Aneka gorengan adalah camilan gurih dan renyah, digoreng hingga keemasan. Terbuat dari berbagai bahan seperti tahu, tempe, dan pisang, cocok dinikmati kapan saja sebagai camilan atau pelengkap makanan.', '2024-05-26 21:04:49'),
(3, 'Paket Hantaran/Seserahan', 'Paket hantaran/seserahan berisi aneka barang sebagai simbol penghormatan atau hadiah dalam tradisi pernikahan atau acara spesial. Dikemas menarik, melambangkan rasa hormat dan cinta kepada penerima.', '2024-05-26 21:43:48'),
(4, 'Paket Snack Box', 'Paket snack box berisi aneka camilan lezat dalam kemasan praktis, cocok untuk acara atau rapat. Menyediakan berbagai pilihan rasa, memastikan semua tamu menikmati hidangan yang disajikan.', '2024-05-26 21:58:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact`
--

CREATE TABLE `contact` (
  `contactId` int(21) NOT NULL,
  `userId` int(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phoneNo` bigint(21) NOT NULL,
  `orderId` int(21) NOT NULL DEFAULT 0 COMMENT 'If problem is not related to the order then order id = 0',
  `message` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `contactreply`
--

CREATE TABLE `contactreply` (
  `id` int(21) NOT NULL,
  `contactId` int(21) NOT NULL,
  `userId` int(23) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `deliverydetails`
--

CREATE TABLE `deliverydetails` (
  `id` int(21) NOT NULL,
  `orderId` int(21) NOT NULL,
  `deliveryBoyName` varchar(35) NOT NULL,
  `deliveryBoyPhoneNo` bigint(25) NOT NULL,
  `deliveryTime` int(200) NOT NULL COMMENT 'Time in minutes',
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(21) NOT NULL,
  `orderId` int(21) NOT NULL,
  `pizzaId` int(21) NOT NULL,
  `itemQuantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderId`, `pizzaId`, `itemQuantity`) VALUES
(1, 1, 69, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `orderId` int(21) NOT NULL,
  `userId` int(21) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipCode` int(21) NOT NULL,
  `phoneNo` bigint(21) NOT NULL,
  `amount` int(200) NOT NULL,
  `paymentMode` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=cash on delivery, \r\n1=online ',
  `orderStatus` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0' COMMENT '0=Order Placed.\r\n1=Order Confirmed.\r\n2=Preparing your Order.\r\n3=Your order is on the way!\r\n4=Order Delivered.\r\n5=Order Denied.\r\n6=Order Cancelled.',
  `orderDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `address`, `zipCode`, `phoneNo`, `amount`, `paymentMode`, `orderStatus`, `orderDate`) VALUES
(1, 5, 'Jl Serpong, Dekat Ps.Serpong', 123123, 1238962222, 3000, '0', '4', '2024-06-08 20:48:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pizza`
--

CREATE TABLE `pizza` (
  `pizzaId` int(12) NOT NULL,
  `pizzaName` varchar(255) NOT NULL,
  `pizzaPrice` int(12) NOT NULL,
  `pizzaDesc` text NOT NULL,
  `pizzaCategorieId` int(12) NOT NULL,
  `pizzaPubDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pizza`
--

INSERT INTO `pizza` (`pizzaId`, `pizzaName`, `pizzaPrice`, `pizzaDesc`, `pizzaCategorieId`, `pizzaPubDate`) VALUES
(69, 'Dadar Gulung', 1500, 'Dadar gulung adalah kue tradisional Indonesia dengan kulit hijau dari tepung dan santan, diisi parutan kelapa dan gula merah, lalu digulung. Rasanya manis dan lembut.', 1, '2024-06-08 20:44:22'),
(70, 'Talam Ketan Pandan', 2500, 'Talam ketan pandan adalah kue tradisional Indonesia yang terdiri dari lapisan ketan kukus dan lapisan pandan santan yang lembut. Rasanya manis dan gurih dengan aroma pandan yang khas.', 1, '2024-06-08 20:55:35'),
(71, 'Lontong Isi Oncom', 1500, 'Lontong isi oncom adalah makanan tradisional Indonesia yang terdiri dari lontong (nasi yang dikukus dalam daun pisang) yang diisi dengan oncom berbumbu. Rasanya gurih dan sedikit pedas.', 1, '2024-06-08 21:02:57'),
(72, 'Lontong Isi Sayur', 1500, 'Lontong isi sayur adalah makanan tradisional Indonesia yang terdiri dari lontong (nasi yang dikukus dalam daun pisang) yang diisi dengan sayuran berbumbu. Rasanya gurih dan nikmat, sering disajikan dengan tambahan sambal.', 1, '2024-06-08 21:05:33'),
(73, 'Pastel', 1500, 'Pastel adalah kue goreng berbentuk setengah lingkaran dengan kulit renyah yang diisi dengan campuran sayuran, dan bihun. Rasanya gurih dan biasanya disajikan sebagai camilan atau hidangan pembuka.', 2, '2024-06-08 21:16:42'),
(74, 'Risoles Segitiga', 1500, 'Risoles segitiga adalah camilan goreng berbentuk segitiga dengan kulit tepung yang renyah dan diisi dengan campuran sayuran. Rasanya gurih dan lembut di dalam, menjadikannya populer sebagai makanan ringan atau hidangan pembuka.', 2, '2024-06-08 21:21:09'),
(75, 'Lemper', 2000, 'Lemper abon adalah camilan tradisional Indonesia yang terbuat dari ketan yang diisi dengan abon (daging sapi atau ayam suwir kering berbumbu). Ketan ini kemudian dibungkus dengan daun pisang dan dibakar, menghasilkan rasa gurih dan tekstur kenyal yang khas.', 1, '2024-06-08 21:30:55'),
(76, 'Onde-Onde', 1500, 'Onde-onde adalah camilan tradisional Indonesia berupa bola-bola kecil dari tepung ketan yang digoreng dan dilapisi dengan biji wijen. Di dalamnya terdapat isian  kacang hijau manis yang sudah di tumbuk . Teksturnya kenyal di luar dan lembut di dalam, dengan rasa manis dan gurih yang khas.', 2, '2024-06-08 21:35:36'),
(77, 'Tahu Isi', 1500, 'Tahu isi sayur adalah camilan goreng khas Indonesia yang terdiri dari tahu yang diisi dengan campuran sayuran berbumbu, seperti wortel, kubis, dan tauge. Rasanya gurih dan renyah, sering disajikan dengan sambal atau saus kacang sebagai pelengkap.', 2, '2024-06-08 21:39:17'),
(78, 'Paket Hantaran Gorengan', 50000, 'Paket Hantaran yang bisa dipesan untuk acara acara besar seperti, acara besanan, lamaran. DLL. yang berisi berbagai macam gorengan.', 3, '2024-06-08 21:55:35'),
(79, 'Paket Hantaran Kue Basah', 50000, 'Paket Hantaran yang bisa di pesan untuk acara - acara besar seperti besanan, lamaran, Dll. yang berisi berbagai macam kue basah', 3, '2024-06-08 22:07:30'),
(80, 'Paket Box 1 ', 7000, 'Paket Box 1 ( Risoles segitiga,Lontong isi sayur,Onde-onde)', 4, '2024-06-08 22:18:21'),
(81, 'Paket Box 2', 10000, 'Paket Box 2 ( Pastel, Lemper, Talam Ketan Pandan,)', 4, '2024-06-08 22:20:04'),
(82, 'Paket Box 3', 8000, 'Paket Box 3 ( Tahu isi, dadar gulung, onde-ondel)', 4, '2024-06-08 22:21:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sitedetail`
--

CREATE TABLE `sitedetail` (
  `tempId` int(11) NOT NULL,
  `systemName` varchar(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `contact1` bigint(21) NOT NULL,
  `contact2` bigint(21) DEFAULT NULL COMMENT 'Optional',
  `address` text NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sitedetail`
--

INSERT INTO `sitedetail` (`tempId`, `systemName`, `email`, `contact1`, `contact2`, `address`, `dateTime`) VALUES
(1, 'Kedai Kanzoe', 'mukti@gmail.com', 8080808080, 8123123123, 'Pancoran Mas no 123,Depok', '2021-03-23 19:56:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(21) NOT NULL,
  `username` varchar(21) NOT NULL,
  `firstName` varchar(21) NOT NULL,
  `lastName` varchar(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `userType` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=user\r\n1=admin',
  `password` varchar(255) NOT NULL,
  `joinDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `phone`, `userType`, `password`, `joinDate`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@gmail.com', 1111111111, '1', '$2y$10$AAfxRFOYbl7FdN17rN3fgeiPu/xQrx6MnvRGzqjVHlGqHAM4d9T1i', '2021-04-11 11:40:58'),
(3, 'mukti', 'mukti', 'andrianto', 'mukti@gmail.com', 1234567890, '0', '$2y$10$enK5Qq7cQUR.G7fzpIPg/eTwDYUtiFn2J4/tVtnCwWDJQ.yiisYIa', '2024-05-27 01:55:20'),
(4, 'rezka', 'muhamad', 'rezka', 'rezkamuhamad212@gmail.com', 1238962222, '0', '$2y$10$t1QepHHWHsdPZa8JxNHgJ.1PA7FL7d6y/HbLpTQXx2zv4siPSmuTq', '2024-06-08 04:29:56'),
(5, 'Rulay', 'gorlay', 'yuhuu', 'demo@gmail.com', 1238962222, '0', '$2y$10$2c6wfmBuyvwFsatSoFysuezxjAqBqgRlCRIL0Vh1Em1nyY7wZSH/e', '2024-06-08 20:34:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `viewcart`
--

CREATE TABLE `viewcart` (
  `cartItemId` int(11) NOT NULL,
  `pizzaId` int(11) NOT NULL,
  `itemQuantity` int(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `addedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categorieId`);
ALTER TABLE `categories` ADD FULLTEXT KEY `categorieName` (`categorieName`,`categorieDesc`);

--
-- Indeks untuk tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactId`);

--
-- Indeks untuk tabel `contactreply`
--
ALTER TABLE `contactreply`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deliverydetails`
--
ALTER TABLE `deliverydetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orderId` (`orderId`);

--
-- Indeks untuk tabel `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indeks untuk tabel `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`pizzaId`);
ALTER TABLE `pizza` ADD FULLTEXT KEY `pizzaName` (`pizzaName`,`pizzaDesc`);

--
-- Indeks untuk tabel `sitedetail`
--
ALTER TABLE `sitedetail`
  ADD PRIMARY KEY (`tempId`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `viewcart`
--
ALTER TABLE `viewcart`
  ADD PRIMARY KEY (`cartItemId`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `categorieId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `contactId` int(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `contactreply`
--
ALTER TABLE `contactreply`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `deliverydetails`
--
ALTER TABLE `deliverydetails`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pizza`
--
ALTER TABLE `pizza`
  MODIFY `pizzaId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `sitedetail`
--
ALTER TABLE `sitedetail`
  MODIFY `tempId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `viewcart`
--
ALTER TABLE `viewcart`
  MODIFY `cartItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
