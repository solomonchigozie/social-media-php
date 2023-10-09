-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 29, 2023 at 03:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpour`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `post` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `weather` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userid`, `post`, `location`, `weather`, `image`, `date_added`, `date_updated`) VALUES
(1, 1, 'For the great doesn&#039;t happen through impulse alone, and is a succession of little things that are brought together.', 'London', '19', 'ca832a6feafc6e5ea8eb2b23b5c6cffc.jpg', '2023-08-29 13:19:15', '2023-08-29 13:19:15'),
(2, 1, 'When everything seems to be going against you, remember that the airplane takes off against the wind, not with it.', 'Stoke-on-Trent', '15', 'fd960d63380605c37fe925e08e56103djpeg', '2023-08-29 14:19:20', '2023-08-29 14:19:20'),
(3, 1, '&quot;Twenty years from now, you will be more disappointed by the things you didn&#039;t do than by the ones you did. So, throw off the bowlines, sail away from safe harbor, catch the trade winds in your sails. Explore. Dream. Discover.&quot; — Mark Twain', 'Newcastle', '18', NULL, '2023-08-29 14:20:53', '2023-08-29 14:20:53'),
(4, 2, '&quot;If you look at what you have in life, you&#039;ll always have more. If you look at what you don&#039;t have in life, you&#039;ll never have enough.&quot; — Oprah Winfrey', 'Manchester', '21', '8790a4141c918b86543bd176125f7701jpeg', '2023-08-29 14:36:15', '2023-08-29 14:36:15'),
(5, 2, 'Everyday is another chance to do great things.', 'Oxford', '19', 'ff9fffa6c5ec4ee6a4fc4e11335c6d1a.jpg', '2023-08-29 14:37:41', '2023-08-29 14:37:41'),
(6, 2, 'Its a bright and sunny day.', 'Liverpool', '27', '3704ab2b1fbe5702c683df3f8ec81157.jpg', '2023-08-29 14:39:06', '2023-08-29 14:39:06'),
(7, 1, '&quot;Don&#039;t be distracted by criticism. Remember—the only taste of success some people get is to take a bite out of you.&quot; — Zig Ziglar', 'Crewe', '16', NULL, '2023-08-29 14:40:20', '2023-08-29 14:40:20'),
(8, 1, 'Successful people do what unsuccessful people are not willing to do. Don&#039;t wish it were easier; wish you were better', 'Leek', '20', 'd43a04b01668b6937fc186f1359714b1jpeg', '2023-08-29 14:41:04', '2023-08-29 14:41:04'),
(9, 2, '&quot;You only live once, but if you do it right, once is enough.&quot; — Mae West', 'Burnley', '21', 'beb0563cecb9977e4158fb85a863745djpeg', '2023-08-29 14:43:37', '2023-08-29 14:43:37'),
(10, 2, '&quot;Never let the fear of striking out keep you from playing the game.&quot;– Babe Ruth', 'Blackpool', '18', '49c56ba6597bbd8a6abc1e168313436ajpeg', '2023-08-29 14:45:33', '2023-08-29 14:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `biography` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'u11.png',
  `location` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `username`, `biography`, `phone`, `profile_picture`, `location`, `password`, `date_joined`, `last_updated`) VALUES
(1, 'john', 'doe', 'test@test.com', 'phpour', NULL, NULL, 'u1.png', NULL, '6f4e174df159f2b4cc9a2e622d689c8965536c0e9de47e238ea9847f307da5c1', '2023-08-29 11:28:07', '2023-08-29 11:28:07'),
(2, 'Anne', 'Mercy', 'testuser@test.com', 'annemercy', NULL, NULL, 'u2.png', NULL, 'cb24e51461b03ad18ceb24744a31eb01f3d30fb5a04e2ea34a38b794fa8ec611', '2023-08-29 14:33:20', '2023-08-29 14:33:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
