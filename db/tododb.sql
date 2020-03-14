-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 14 2020 г., 23:51
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tododb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `tasks_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `atCreate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `tasks_id`, `comment`, `atCreate`) VALUES
(2, 1, '{\"content\":\"ext comment 21312312312\",\"id\":\"2\",\"lastUpdate\":\"2020-03-13 00:00:00\"}', '2020-03-13 00:00:00'),
(4, 1, '{\"content\":\"ext comment 213\",\"id\":\"4\",\"lastUpdate\":\"2020-03-13 00:00:00\"}', '2020-03-13 00:00:00'),
(5, 1, '{\"content\":\"ext comment 21312312312\",\"id\":\"5\",\"lastUpdate\":\"2020-03-13 00:00:00\"}', '2020-03-13 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `task`, `description`, `status`) VALUES
(1, 'test1', 'twetsdfsf', 1),
(5, 'test2', '', 2),
(8, 'asdasdasd', 'asdasdas', 1),
(10, 'test3 task', 'qweqweqweqwe', 3),
(11, 'qweqwqw', 'qweqwe', 3),
(12, 'qweqwqw', 'qweqwe', 2),
(13, 'rewrwe', 'erwrwerew', 3),
(14, 'qweqwe', '123123', 3),
(15, 'qweqwe', 'qweqweqw', 3),
(17, 'TestTask', '2 stauts', 2),
(18, 'qweqweqweqwasczxczxczx', 'zxczxczxc', 2),
(20, 'qweqweqw', '234324', 2),
(21, 'СупертудуЛист', 'Нужно сделать туду лист', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tasks_id` (`tasks_id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
