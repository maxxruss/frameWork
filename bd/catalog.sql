-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 05 2018 г., 19:26
-- Версия сервера: 5.7.24-0ubuntu0.18.04.1
-- Версия PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `catalog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

DROP TABLE IF EXISTS `basket`;
CREATE TABLE `basket` (
  `id` int(11) NOT NULL,
  `order_id` int(10) NOT NULL,
  `good_id` int(10) NOT NULL,
  `count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `token`, `date`, `name`, `email`, `comment`) VALUES
(1, '8f14e45fceea167a5a36dedd4bea2543', '2018-11-16 22:30:46', 'max', 'ig_max@mail.ru', 'Привет'),
(2, '8f14e45fceea167a5a36dedd4bea2543', '2018-11-16 22:31:47', 'max2', 'ig._max@mail.ru', 'Классные магазин!'),
(3, '8f14e45fceea167a5a36dedd4bea2543', '2018-11-18 17:53:51', 'admin', 'ig_max@mail.ru', 'Я ЗДЕСЬ!!!');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `nameShort` varchar(50) NOT NULL,
  `nameFull` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `param` varchar(250) NOT NULL,
  `bigPhoto` varchar(100) NOT NULL,
  `miniPhoto` varchar(100) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `stickerFit` int(1) NOT NULL,
  `stickerHit` int(1) NOT NULL,
  `discount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `nameShort`, `nameFull`, `price`, `param`, `bigPhoto`, `miniPhoto`, `weight`, `stickerFit`, `stickerHit`, `discount`) VALUES
(365, 'arizona', 'Аризона', 350, '0', 'img/arizona.jpeg', 'imgMini/arizona.jpeg', '0', 0, 0, 5),
(366, 'asahi', 'Асахи', 450, '0', 'img/asahi.jpeg', 'imgMini/asahi.jpeg', '0', 0, 0, 0),
(367, 'bangkok', 'Бангкок', 300, '0', 'img/bangkok.jpeg', 'imgMini/bangkok.jpeg', '0', 0, 0, 0),
(368, 'batakon', 'Батакон', 0, '0', 'img/batakon.jpeg', 'imgMini/batakon.jpeg', '0', 0, 0, 0),
(369, 'bonito_syaki', 'Бонито сяки', 0, '0', 'img/bonito_syaki.jpeg', 'imgMini/bonito_syaki.jpeg', '0', 0, 0, 0),
(370, 'bonito_unagi', 'Бонито унаги', 0, '0', 'img/bonito_unagi.jpeg', 'imgMini/bonito_unagi.jpeg', '0', 0, 0, 0),
(371, 'boston', 'Бостон', 0, '0', 'img/boston.jpeg', 'imgMini/boston.jpeg', '0', 0, 0, 0),
(372, 'cezar', 'Цезар', 0, '0', 'img/cezar.jpeg', 'imgMini/cezar.jpeg', '0', 0, 0, 0),
(373, 'dakota', 'Дакота', 0, '0', 'img/dakota.jpeg', 'imgMini/dakota.jpeg', '0', 0, 0, 0),
(374, 'drakon', 'Дракон', 0, '0', 'img/drakon.jpeg', 'imgMini/drakon.jpeg', '0', 0, 0, 0),
(375, 'filadelfiya_lyuks', 'Филаделфия луукс', 0, '0', 'img/filadelfiya_lyuks.jpeg', 'imgMini/filadelfiya_lyuks.jpeg', '0', 0, 0, 0),
(376, 'filadelfiya_s_lososem', 'Филаделфия с лососем', 0, '0', 'img/filadelfiya_s_lososem.jpeg', 'imgMini/filadelfiya_s_lososem.jpeg', '0', 0, 0, 0),
(377, 'filadelfiya_s_tuncom', 'Филаделфия с тунцом', 0, '0', 'img/filadelfiya_s_tuncom.jpeg', 'imgMini/filadelfiya_s_tuncom.jpeg', '0', 0, 0, 0),
(378, 'filadelfiya_s_zapechennym_percem', 'Филаделфия с запеченнум перцем', 0, '0', 'img/filadelfiya_s_zapechennym_percem.jpeg', 'imgMini/filadelfiya_s_zapechennym_percem.jpeg', '0', 0, 0, 0),
(379, 'fukusima', 'Фукусима', 0, '0', 'img/fukusima.jpeg', 'imgMini/fukusima.jpeg', '0', 0, 0, 0),
(380, 'gejsha', 'Гежша', 0, '0', 'img/gejsha.jpeg', 'imgMini/gejsha.jpeg', '0', 0, 0, 0),
(381, 'hirosima', 'Хиросима', 0, '0', 'img/hirosima.jpeg', 'imgMini/hirosima.jpeg', '0', 0, 0, 0),
(382, 'joko', 'Жоко', 0, '0', 'img/joko.jpeg', 'imgMini/joko.jpeg', '0', 0, 0, 0),
(383, 'kaliforniya', 'Калифорния', 0, '0', 'img/kaliforniya.jpeg', 'imgMini/kaliforniya.jpeg', '0', 0, 0, 0),
(384, 'kaliforniya_s_krevetkoj', 'Калифорния с креветкож', 0, '0', 'img/kaliforniya_s_krevetkoj.jpeg', 'imgMini/kaliforniya_s_krevetkoj.jpeg', '0', 0, 0, 0),
(385, 'kaliforniya_s_lososem', 'Калифорния с лососем', 0, '0', 'img/kaliforniya_s_lososem.jpeg', 'imgMini/kaliforniya_s_lososem.jpeg', '0', 0, 0, 0),
(386, 'kanada', 'Канада', 0, '0', 'img/kanada.jpeg', 'imgMini/kanada.jpeg', '0', 0, 0, 0),
(387, 'kimono', 'Кимоно', 0, '0', 'img/kimono.jpeg', 'imgMini/kimono.jpeg', '0', 0, 0, 0),
(389, 'krab-krevetka', 'Краб-креветка', 0, '0', 'img/krab-krevetka.jpeg', 'imgMini/krab-krevetka.jpeg', '0', 0, 0, 0),
(390, 'kunsej', 'Кунсеж', 0, '0', 'img/kunsej.jpeg', 'imgMini/kunsej.jpeg', '0', 0, 0, 0),
(391, 'kurasiku_s_lososem', 'Курасику с лососем', 0, '0', 'img/kurasiku_s_lososem.jpeg', 'imgMini/kurasiku_s_lososem.jpeg', '0', 0, 0, 0),
(392, 'kurasiku_s_tuncom', 'Курасику с тунцом', 0, '0', 'img/kurasiku_s_tuncom.jpeg', 'imgMini/kurasiku_s_tuncom.jpeg', '0', 0, 0, 0),
(393, 'lava', 'Лава', 0, '0', 'img/lava.jpeg', 'imgMini/lava.jpeg', '0', 0, 0, 0),
(394, 'lava_ehbi', 'Лава ехби', 0, '0', 'img/lava_ehbi.jpeg', 'imgMini/lava_ehbi.jpeg', '0', 0, 0, 0),
(395, 'lava_unagi', 'Лава унаги', 0, '0', 'img/lava_unagi.jpeg', 'imgMini/lava_unagi.jpeg', '0', 0, 0, 0),
(396, 'logotip', 'Логотип', 0, '0', 'img/logotip.png', 'imgMini/logotip.png', '0', 0, 0, 0),
(397, 'maguro', 'Магуро', 0, '0', 'img/maguro.jpeg', 'imgMini/maguro.jpeg', '0', 0, 0, 0),
(398, 'mehiko', 'Мехико', 0, '0', 'img/mehiko.jpeg', 'imgMini/mehiko.jpeg', '0', 0, 0, 0),
(399, 'nagano', 'Нагано', 0, '0', 'img/nagano.jpeg', 'imgMini/nagano.jpeg', '0', 0, 0, 0),
(400, 'nidzi', 'Нидзи', 0, '0', 'img/nidzi.jpeg', 'imgMini/nidzi.jpeg', '0', 0, 0, 0),
(401, 'raduga', 'Радуга', 0, '0', 'img/raduga.jpeg', 'imgMini/raduga.jpeg', '0', 0, 0, 0),
(402, 'roll-bekon', 'Ролл-бекон', 0, '0', 'img/roll-bekon.jpeg', 'imgMini/roll-bekon.jpeg', '0', 0, 0, 0),
(403, 'roll_s_syrom_parmezan', 'Ролл с суром пармезан', 0, '0', 'img/roll_s_syrom_parmezan.jpeg', 'imgMini/roll_s_syrom_parmezan.jpeg', '0', 0, 0, 0),
(405, 'samuraj', 'Самураж', 0, '0', 'img/samuraj.jpeg', 'imgMini/samuraj.jpeg', '0', 0, 0, 0),
(406, 'sensej', 'Сенсеж', 0, '0', 'img/sensej.jpeg', 'imgMini/sensej.jpeg', '0', 0, 0, 0),
(407, 'shahmaty', 'Шахмату', 0, '0', 'img/shahmaty.jpeg', 'imgMini/shahmaty.jpeg', '0', 0, 0, 0),
(408, 'spring_roll_s_krevetkoj', 'Спринг ролл с креветкож', 0, '0', 'img/spring_roll_s_krevetkoj.jpeg', 'imgMini/spring_roll_s_krevetkoj.jpeg', '0', 0, 0, 0),
(409, 'spring_roll_s_lososem', 'Спринг ролл с лососем', 0, '0', 'img/spring_roll_s_lososem.jpeg', 'imgMini/spring_roll_s_lososem.jpeg', '0', 0, 0, 0),
(410, 'tajfun', 'Тажфун', 0, '0', 'img/tajfun.jpeg', 'imgMini/tajfun.jpeg', '0', 0, 0, 0),
(411, 'tempura', 'Темпура', 0, '0', 'img/tempura.jpeg', 'imgMini/tempura.jpeg', '0', 0, 0, 0),
(412, 'tokio', 'Токио', 0, '0', 'img/tokio.jpeg', 'imgMini/tokio.jpeg', '0', 0, 0, 0),
(413, 'tomago_chiken', 'Томаго чикен', 0, '0', 'img/tomago_chiken.jpeg', 'imgMini/tomago_chiken.jpeg', '0', 0, 0, 0),
(414, 'tomago_ehbi', 'Томаго ехби', 0, '0', 'img/tomago_ehbi.jpeg', 'imgMini/tomago_ehbi.jpeg', '0', 0, 0, 0),
(415, 'tomago_kani', 'Томаго кани', 0, '0', 'img/tomago_kani.jpeg', 'imgMini/tomago_kani.jpeg', '0', 0, 0, 0),
(416, 'tomago_syaki', 'Томаго сяки', 0, '0', 'img/tomago_syaki.jpeg', 'imgMini/tomago_syaki.jpeg', '0', 0, 0, 0),
(417, 'tomago_unagi', 'Томаго унаги', 0, '0', 'img/tomago_unagi.jpeg', 'imgMini/tomago_unagi.jpeg', '0', 0, 0, 0),
(418, 'tono', 'Тоно', 0, '0', 'img/tono.jpeg', 'imgMini/tono.jpeg', '0', 0, 0, 0),
(419, 'tortilya_ovoschnaya', 'Тортиля овосчная', 0, '0', 'img/tortilya_ovoschnaya.jpeg', 'imgMini/tortilya_ovoschnaya.jpeg', '0', 0, 0, 0),
(420, 'tortilya_s_kuricej', 'Тортиля с курицеж', 0, '0', 'img/tortilya_s_kuricej.jpeg', 'imgMini/tortilya_s_kuricej.jpeg', '0', 0, 0, 0),
(421, 'tortilya_s_lososem', 'Тортиля с лососем', 0, '0', 'img/tortilya_s_lososem.jpeg', 'imgMini/tortilya_s_lososem.jpeg', '0', 0, 0, 0),
(422, 'unagi_filadelfiya', 'Унаги филаделфия', 0, '0', 'img/unagi_filadelfiya.jpeg', 'imgMini/unagi_filadelfiya.jpeg', '0', 0, 0, 0),
(423, 'vulkan', 'Вулкан', 0, '0', 'img/vulkan.jpeg', 'imgMini/vulkan.jpeg', '0', 0, 0, 0),
(424, 'yaho', 'Яхо', 0, '0', 'img/yaho.jpeg', 'imgMini/yaho.jpeg', '0', 0, 0, 0),
(425, 'yamajka', 'Ямажка', 0, '0', 'img/yamajka.jpeg', 'imgMini/yamajka.jpeg', '0', 0, 0, 0),
(426, 'zapechennyj_s_krevetkoj', 'Запеченнуж с креветкож', 0, '0', 'img/zapechennyj_s_krevetkoj.jpeg', 'imgMini/zapechennyj_s_krevetkoj.jpeg', '0', 0, 0, 0),
(427, 'zapechennyj_s_lososem', 'Запеченнуж с лососем', 0, '0', 'img/zapechennyj_s_lososem.jpeg', 'imgMini/zapechennyj_s_lososem.jpeg', '0', 0, 0, 0),
(429, 'zelenyj_roll', 'Зеленуж ролл', 0, '0', 'img/zelenyj_roll.jpeg', 'imgMini/zelenyj_roll.jpeg', '0', 0, 0, 0),
(434, 'kiota', 'Киота', 0, '0', 'img/kiota.jpeg', 'imgMini/kiota.jpeg', '0', 0, 0, 0),
(437, '', '1', 1, '1', 'img/kiota.jpeg', 'imgMini/kiota.jpeg', '1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orderInfo`
--

DROP TABLE IF EXISTS `orderInfo`;
CREATE TABLE `orderInfo` (
  `id` int(11) NOT NULL,
  `user_id` varchar(32) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `discountCard` varchar(50) DEFAULT NULL,
  `persons` varchar(50) DEFAULT NULL,
  `pay` int(1) NOT NULL DEFAULT '0',
  `money` varchar(50) DEFAULT NULL,
  `address` text,
  `comment` text,
  `delivery` int(1) DEFAULT '0',
  `desiredTime` varchar(50) DEFAULT NULL,
  `timeOrder` varchar(15) DEFAULT NULL,
  `order_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orderInfo`
--

INSERT INTO `orderInfo` (`id`, `user_id`, `phone`, `discountCard`, `persons`, `pay`, `money`, `address`, `comment`, `delivery`, `desiredTime`, `timeOrder`, `order_status`) VALUES
(59, '8f14e45fceea167a5a36dedd4bea2543', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0),
(60, '4945b361c53cd922e7b60321afca636c', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0),
(61, '86b1fed00a95fd36a00928b535ec0657', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login`, `pass`, `token`) VALUES
(1, 'admin', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', '8f14e45fceea167a5a36dedd4bea2543'),
(3, 'max', 'ig_max@mail.ru', 'max', '2ffe4e77325d9a7152f7086ea7aa5114', '288e64627365f262240dd20d6775b09d'),
(4, 'max1', 'ig_max@mail.ru', 'max1', '21225dccb5d0c174f1bcacf72cd4dcb2', '2b71c36b930edafa634a7fe7387c5bb8'),
(5, 'max2', 'ig_max@mail.ru', 'max2', '1c6268cd0d39f7aba33b053f84d3c310', 'd1b82fd1c4cf752e3738bf7e3648f38d'),
(6, 'max9', 'ig_max@mail.ru', 'max9', '566b939162a345a70e2ddd1469d14482', 'b56840654d187b36187cc8c25c4ac287');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orderInfo`
--
ALTER TABLE `orderInfo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;
--
-- AUTO_INCREMENT для таблицы `orderInfo`
--
ALTER TABLE `orderInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
