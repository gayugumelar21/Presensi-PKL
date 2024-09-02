-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 31 Agu 2024 pada 19.20
-- Versi server: 10.11.4-MariaDB-1:10.11.4+maria~ubu2204
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absenpkl_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('Datang','Pulang') DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `created_at`) VALUES
(1, 'Nabila Irma Luthvia', '2024-08-31 12:18:45'),
(2, 'Ni Putu Keisya', '2024-08-31 12:18:45'),
(3, 'Salsa Zahra Sabilla', '2024-08-31 12:18:45'),
(4, 'Alea Putri Marta', '2024-08-31 12:18:45'),
(5, 'Rehan Nugraha', '2024-08-31 12:18:45'),
(6, 'Muhammad Reza Raditya', '2024-08-31 12:18:45'),
(7, 'Desi Santika', '2024-08-31 12:18:45'),
(8, 'Yulis Afria', '2024-08-31 12:18:45'),
(9, 'Nabila', '2024-08-31 12:18:45'),
(10, 'Anggun Ramania', '2024-08-31 12:18:45'),
(11, 'Febiola Nadia Putri', '2024-08-31 12:18:45'),
(12, 'Tiara Saputri', '2024-08-31 12:18:45'),
(13, 'Muhammad Akmal Millatudin', '2024-08-31 12:18:45'),
(14, 'Zahra Amelia', '2024-08-31 12:18:45'),
(15, 'Cahaya Rhamadhani', '2024-08-31 12:18:45'),
(16, 'Farell Sudarmawan', '2024-08-31 12:18:45'),
(17, 'Selpi Mandari', '2024-08-31 12:18:45'),
(18, 'Tri Juni Nabila Sari', '2024-08-31 12:18:45'),
(19, 'Nurmala Sari', '2024-08-31 12:18:45'),
(20, 'Airin Indah Dian Pratiwi', '2024-08-31 12:18:45'),
(21, 'Uswatun Hasanah', '2024-08-31 12:18:45'),
(22, 'Rohayda Wati', '2024-08-31 12:18:45'),
(23, 'Permata Salsabila', '2024-08-31 12:18:45'),
(24, 'Riska Damaranti', '2024-08-31 12:18:45'),
(25, 'Tamara Putri Pricilia', '2024-08-31 12:18:45'),
(26, 'Ria Septiana', '2024-08-31 12:18:45'),
(27, 'Anggun Permata Sari', '2024-08-31 12:18:45'),
(28, 'Sania Sintia Noviyani', '2024-08-31 12:18:45'),
(29, 'Mutiara Bunga Rindia', '2024-08-31 12:18:45'),
(30, 'Oca Aprillia', '2024-08-31 12:18:45'),
(31, 'Fika Absari', '2024-08-31 12:18:45'),
(32, 'Iyan Alfarizi', '2024-08-31 12:18:45'),
(33, 'Rifki Mardiansyah Pratama', '2024-08-31 12:18:45'),
(34, 'Dian Novita', '2024-08-31 12:18:45'),
(35, 'Evita Sari', '2024-08-31 12:18:45'),
(36, 'Fornia Kempila Sari', '2024-08-31 12:18:45'),
(37, 'Dwi Safitri', '2024-08-31 12:18:45'),
(38, 'Ike Fatimatu Zahra', '2024-08-31 12:18:45'),
(39, 'Rasya Mayang Pertiwi', '2024-08-31 12:18:45'),
(40, 'Epa Pitri Yani', '2024-08-31 12:18:45'),
(41, 'Rangga Febriyansyah', '2024-08-31 12:18:45'),
(42, 'Kleren Ramadani', '2024-08-31 12:18:45'),
(43, 'Dian Melan Sisca', '2024-08-31 12:18:45'),
(44, 'Raissa Aulia Saputri Z', '2024-08-31 12:18:45'),
(45, 'Famela Renata Andini', '2024-08-31 12:18:45'),
(46, 'Nova Tri Indri Yani', '2024-08-31 12:18:45'),
(47, 'Marsa Nurul Zakia', '2024-08-31 12:18:45'),
(48, 'Amelia', '2024-08-31 12:18:45'),
(49, 'Marsika Gustira', '2024-08-31 12:18:45'),
(50, 'Sopiya', '2024-08-31 12:18:45'),
(51, 'Panji Adi Nata', '2024-08-31 12:18:45'),
(52, 'Pahrurizal', '2024-08-31 12:18:45'),
(53, 'Winda Ani Sailyna', '2024-08-31 12:18:45'),
(54, 'Asha Damarifa', '2024-08-31 12:18:45'),
(55, 'Asyifa Imelda', '2024-08-31 12:18:45'),
(56, 'Resa Ramadhani', '2024-08-31 12:18:45'),
(57, 'Resfina Putri', '2024-08-31 12:18:45'),
(58, 'Vharel Christyaristu', '2024-08-31 12:18:45'),
(59, 'Fazri Raditya Ardana', '2024-08-31 12:18:45'),
(60, 'Farid Faturohman', '2024-08-31 12:18:45'),
(61, 'Henggar Dirgantara', '2024-08-31 12:18:45'),
(62, 'Fari Adi', '2024-08-31 12:18:45'),
(63, 'Dio Setiawan', '2024-08-31 12:18:45'),
(64, 'Rosmiyati', '2024-08-31 12:18:45'),
(65, 'Nursabila', '2024-08-31 12:18:45'),
(66, 'Resti Amalia', '2024-08-31 12:18:45'),
(67, 'Syarah Agustin', '2024-08-31 12:18:45'),
(68, 'Rahmat Zidan S', '2024-08-31 12:18:45'),
(69, 'Muhamad Fathir Alwi', '2024-08-31 12:18:45'),
(70, 'M. Nadzwa Pratama', '2024-08-31 12:18:45'),
(71, 'M. Fajar Apriyansyah', '2024-08-31 12:18:45'),
(72, 'Nabila Aprilia', '2024-08-31 12:18:45'),
(73, 'Ratu Bilbina Saharani', '2024-08-31 12:18:45'),
(74, 'Shinta', '2024-08-31 12:18:45'),
(75, 'Ussy Nazwa Pratiwi', '2024-08-31 12:18:45'),
(76, 'Nadia Saputri', '2024-08-31 12:18:45'),
(77, 'Nur Azizah', '2024-08-31 12:18:45'),
(78, 'Novita Ayu Amelia', '2024-08-31 12:18:45'),
(79, 'Nafita Cahyati', '2024-08-31 12:18:45'),
(80, 'Arum Andayani', '2024-08-31 12:18:45'),
(81, 'Kezia Ananda Saputri', '2024-08-31 12:18:45'),
(82, 'Arif Fernando', '2024-08-31 12:18:45'),
(83, 'Muhammad Aldi', '2024-08-31 12:18:45'),
(84, 'Yati Oktapiya', '2024-08-31 12:18:45'),
(85, 'Titian Nayla Septia Mozza', '2024-08-31 12:18:45'),
(86, 'Risma Safitri', '2024-08-31 12:18:45'),
(87, 'Ali Rozi Ansor', '2024-08-31 12:18:45'),
(88, 'Ahmad Afrizal', '2024-08-31 12:18:45'),
(89, 'Chelsi Elisa Putri', '2024-08-31 12:18:45'),
(90, 'Rista Asiska Dewi', '2024-08-31 12:18:45'),
(91, 'Mutya Refa Liana', '2024-08-31 12:18:45'),
(92, 'Widia Nabila Sari', '2024-08-31 12:18:45'),
(93, 'Desti Ariyani', '2024-08-31 12:18:45'),
(94, 'Reva Afrelia', '2024-08-31 12:18:45'),
(95, 'Finanda Azkia', '2024-08-31 12:18:45'),
(96, 'Kleren Ramadani', '2024-08-31 12:18:45'),
(97, 'Dewi Novita Sari', '2024-08-31 12:18:45'),
(98, 'Anggun Permata Sari', '2024-08-31 12:18:45'),
(99, 'Sania Sintia Noviyani', '2024-08-31 12:18:45'),
(100, 'Fadilah', '2024-08-31 12:18:45'),
(101, 'Septi Afriyani', '2024-08-31 12:18:45'),
(102, 'Muhammad Rizky Romadhon', '2024-08-31 12:18:45'),
(103, 'Farisah Amelia', '2024-08-31 12:18:45'),
(104, 'Tasya Olivia', '2024-08-31 12:18:45'),
(105, 'Reniya Hesti Apriyani', '2024-08-31 12:18:45'),
(106, 'Anggun Wulan Dari', '2024-08-31 12:18:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
