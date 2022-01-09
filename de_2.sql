-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 01 2021 г., 15:11
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `de`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

CREATE TABLE `cats` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`c_id`, `c_name`) VALUES
(1, 'Косметический ремонт'),
(2, 'Капитальный ремонт'),
(3, 'Ремонт электрики');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `o_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `o_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_cat` int(11) NOT NULL,
  `o_price1` int(11) NOT NULL,
  `o_price2` int(11) DEFAULT NULL,
  `o_status` enum('Новая','Ремонтируется','Отремонтировано') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Новая',
  `o_img1` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_img2` varchar(550) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `o_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`o_id`, `o_timestamp`, `o_address`, `o_desc`, `o_cat`, `o_price1`, `o_price2`, `o_status`, `o_img1`, `o_img2`, `o_user`) VALUES
(8, '2021-10-01 15:10:28', 'г. Уфа, ул. Генерала Горбатова, 11', 'Lorem ipsum dolor sit, amet consectetur adipisicing, elit. Quo temporibus, a nesciunt modi laudantium animi architecto, qui id omnis non, in? Dolor, sunt, voluptatem. Aperiam quidem in, numquam doloribus suscipit!', 1, 1000, NULL, 'Новая', 'fdeaa02f30fd7a2033a73443fd0ab265.jpg', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_fio` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_login` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_email` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_pass` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`u_id`, `u_fio`, `u_login`, `u_email`, `u_pass`, `u_is_admin`) VALUES
(1, 'Сафаров Владислав Маратович', 'admin', 'admin@vladsafarov.ru', '925000c815f042fa0cdf840d14d32bb9', 1),
(2, 'Сафаров Владислав Маратович', 'safarov', 'admin@vladsafarov.ru', '41d2719c9e51140ac190699374a3a38a', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`c_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `o_cat` (`o_cat`),
  ADD KEY `o_user` (`o_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_login` (`u_login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cats`
--
ALTER TABLE `cats`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`o_cat`) REFERENCES `cats` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`o_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
