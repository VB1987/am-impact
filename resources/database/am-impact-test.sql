-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 apr 2020 om 11:13
-- Serverversie: 10.1.38-MariaDB
-- PHP-versie: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `am-impact-test`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `communities`
--

CREATE TABLE `communities` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `image` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `communities`
--

INSERT INTO `communities` (`id`, `name`, `image`) VALUES
(1, 'Community 1', NULL),
(2, 'Community 2', NULL),
(3, 'Community 3', NULL),
(4, 'Community 4', NULL),
(5, 'Community 5', NULL),
(6, 'Community 6', NULL),
(7, 'Community 7', NULL),
(8, 'Community 8', '{\"name\":\"18_LEGO_Logo_1972.png\",\"type\":\"image\\/png\",\"tmp_name\":\"C:\\\\xampp\\\\tmp\\\\phpDE70.tmp\",\"error\":0,\"size\":45642}');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(128) NOT NULL,
  `post_content` varchar(256) NOT NULL,
  `post_date` varchar(128) NOT NULL,
  `post_time` varchar(128) NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `community_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_title`, `post_content`, `post_date`, `post_time`, `likes`, `community_id`) VALUES
(1, 1, 'Post 1', 'Dit is test post 1', '25-03-2020', '09:16:07', 1, 1),
(2, 1, 'Post 2', 'Dit is test post 2', '25-03-2020', '10:16:07', NULL, 1),
(13, 6, 'Post 3', 'Deze post is geplaatst door Third user', '03-04-2020', '09:16:02', 18, 3),
(14, 6, 'Post 3', 'Deze post is geplaatst door Third user', '03-04-2020', '09:16:07', 7, 3),
(16, 6, 'Post 4', 'Dit is een test post voor community 2', '04-04-2020', '14:14:18', NULL, 2),
(17, 6, 'Post 5', 'Dit is een test post voor community 1', '04-04-2020', '14:14:45', 1, 1),
(18, 6, 'Post 6', 'Dit is een test post ', '04-04-2020', '19:47:14', 1, 1),
(19, 6, 'Post 7', 'Dit is nog een test post', '04-04-2020', '19:47:56', 1, 2),
(20, 7, 'Post 8', 'Fourth user\r\nCommunity 3', '04-04-2020', '19:51:27', 3, 3),
(21, 7, 'Post 9', 'Fourth user \r\nCommunity 3', '04-04-2020', '19:58:38', NULL, 3),
(22, 6, 'Post 10', 'Dit is een post voor community 1 om de email functie te testen ', '05-04-2020', '14:42:06', NULL, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `blocked` int(11) NOT NULL DEFAULT '0',
  `community_id` varchar(512) DEFAULT NULL,
  `liked_post_ids` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `pass`, `email`, `admin`, `blocked`, `community_id`, `liked_post_ids`) VALUES
(1, 'Vincent', 'Braamburg', '281ff8a6813d0eab69b165aa7417d811', 'vincent.braamburg@live.nl', 1, 0, '1', NULL),
(2, 'First', 'Subscriber', '8adcda2e97e82910bac9b80f35fea0cb', 'first.subscriber@example.com', 0, 0, '1,2', NULL),
(5, 'Second', 'Subscriber', '8adcda2e97e82910bac9b80f35fea0cb', 'second.subscriber@example.nl', 0, 1, '1,3', ',1,20'),
(6, 'Third', 'Subscriber', '8adcda2e97e82910bac9b80f35fea0cb', 'third.subscriber@example.nl', 0, 0, '1,2,4,5', ',13,14,17,18'),
(7, 'Fourth', 'Subscriber', '8adcda2e97e82910bac9b80f35fea0cb', 'fourth.subscriber@example.nl', 0, 0, '1,2,3', ',19,20'),
(8, 'admin', 'root', '281ff8a6813d0eab69b165aa7417d811', 'admin@example.nl', 1, 0, NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `community_id` (`community_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `communities`
--
ALTER TABLE `communities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_community_id` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
