-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Трв 08 2026 р., 17:25
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `shelter`
--

-- --------------------------------------------------------

--
-- Структура таблиці `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `announcements`
--

INSERT INTO `announcements` (`id`, `type`, `title`, `description`, `image`, `phone`, `user_id`, `created_at`) VALUES
(1, 'Я загубив тваринку', 'Загубився рудий кіт', 'Загубився в районі центру (поблизу стадіону). Коті 3 роки, відгукується на кличку Рудик. Має білу пляму на грудях та дуже пухнастий хвіст. Був без нашийника. Будемо вдячні за будь-яку інформацію!', '1778253611_rudyk.jpg', '+380991333432', 1, '2026-05-04 08:12:57'),
(2, 'Я знайшов тваринку', 'Знайшлася киця', 'Знайдена маленька киця, забарвлення - триколірна. Дуже ласкава, явно домашня. Знаходиться в районі школи. Шукаємо старих або нових господарів.', '1778253390_kitten.jpg', '+380971384836', 2, '2026-05-04 08:12:57'),
(3, 'Я знайшов тваринку', 'Знайшовся маленький песик', 'У районі центру знайдено молодого песика - дворняжку. Пес дуже розумний, заглядає людям в очі, шукає старого господаря. Був без нашийника. Якщо впізнали свого друга - телефонуйте!', '1778253085_puppy.jpg', '+380991333432', 1, '2026-05-04 11:51:12');

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Собаки'),
(2, 'Коти'),
(3, 'Гризуни'),
(4, 'Птахи'),
(5, 'Інші');

-- --------------------------------------------------------

--
-- Структура таблиці `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `parent_id`) VALUES
(1, 'Головна', 'index.php', 0),
(2, 'Тварини', '#', 0),
(3, '📢Загублені/Знайдені', 'lost-found.php', 0),
(4, 'Про проєкт', 'about.php', 0),
(5, '❤️Допомога', 'donate.php', 0),
(6, 'Всі тварини', 'index.php?view=all', 2),
(7, 'Собаки', 'category.php?category_id=1', 2),
(8, 'Коти', 'category.php?category_id=2', 2),
(9, 'Гризуни', 'category.php?category_id=3', 2),
(10, 'Птахи', 'category.php?category_id=4', 2),
(11, 'Інші', 'category.php?category_id=5', 2),
(12, 'Контакти', 'contacts.php', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `gender` varchar(20) DEFAULT 'Не вказано',
  `status` varchar(50) DEFAULT 'Шукає дім',
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `pets`
--

INSERT INTO `pets` (`id`, `name`, `image`, `description`, `age`, `gender`, `status`, `category_id`, `created_at`) VALUES
(1, 'Бровко', 'pet_69fcdbb549ad7.jpg', 'Дуже добрий та вірний пес. Любить гратися з дітьми. Він стане чудовим другом для вашої родини.', '3 роки', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 17:16:55'),
(2, 'Мурзик', 'pet_69fcdbd0432d5.jpg', 'Спокійний котик, полюбляє спати на сонці. Ласкавий і привчений до лотка.', '5 років', 'Хлопчик', 'Шукає дім', 2, '2026-05-04 20:37:04'),
(3, 'Рекс', 'pet_69fcdbe3350e1.jpg', 'Енергійний собака, відмінний охоронець. Потребує регулярних прогулянок.', '2 роки', 'Хлопчик', 'Зарезервовано', 1, '2026-05-04 20:37:23'),
(4, 'Сніжок', 'pet_69fcdbede4fca.jpg', 'Білосніжний кіт з блакитними очима, дуже лагідний.', '1 рік', 'Хлопчик', 'Шукає дім', 2, '2026-05-04 20:37:33'),
(5, 'Хомка', 'pet_69fcdbf8c4234.jpg', 'Кумедний хом\'як, любить бігати в колесі.', '6 місяців', 'Дівчинка', 'Шукає дім', 3, '2026-05-04 20:37:44'),
(6, 'Кеша', 'pet_69fcdc24ddac0.jpg', 'Папуга, що вміє розмовляти. Знає декілька слів.', '4 роки', 'Хлопчик', 'Шукає дім', 4, '2026-05-04 20:38:28'),
(7, 'Барон', 'pet_69fcdc35a0192.jpg', 'Статний і спокійний собака породи німецька вівчарка. Знає базові команди та стане надійним другом для активної сім\'ї.', '4 роки', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 20:38:45'),
(8, 'Лея', 'pet_69fcdc47f1263.jpg', 'Справжня леді з густою сірою шерстю. Вибаглива до їжі, але за порцію уваги віддячить гучним мурчанням.', '1,5 роки', 'Дівчинка', 'Зарезервовано', 2, '2026-05-04 20:39:03'),
(9, 'Сімба', 'pet_69fcdc53b8a06.jpg', 'Рудий бешкетник, який вважає себе господарем джунглів (або вашої вітальні). Любить полювати на сонячних зайчиків.', '4 місяці', 'Хлопчик', 'Зарезервовано', 2, '2026-05-04 20:39:15'),
(10, 'Ріо', 'pet_69fdf8e463707.jpg', 'Яскравий хвилястий папужка. Любить дивитися на себе у дзеркало і намагається повторювати звуки сповіщень на телефоні.', '1 рік', 'Хлопчик', 'Шукає дім', 4, '2026-05-04 16:53:24'),
(11, 'Коко', 'pet_69fdf8f113192.jpg', 'Корела з кумедним чубчиком. Дуже товариська пташка, яка любить сідати на плече до господарів.', '2 роки', 'Дівчинка', 'Шукає дім', 4, '2026-05-04 16:53:37'),
(12, 'Буся', 'pet_69fdf8ff64232.jpg', 'Морська свинка породи тедді (схожа на ведмежа). Дуже спокійна і любить овочі.', '9 місяців', 'Дівчинка', 'Шукає дім', 3, '2026-05-04 16:53:51'),
(13, 'Борис', 'pet_69fdf9102a990.jpg', 'Сухопутна середньоазіатська черепаха. Борис повільний, мудрий і дуже любить листя кульбаби та сонячне світло.', '2 роки', 'Хлопчик', 'Шукає дім', 5, '2026-05-04 16:54:08'),
(14, 'Гаррі', 'pet_69fdf91fd83ec.jpg', 'Маленький декоративний кролик. Схожий на пухнасту хмаринку, дуже любить, коли йому чешуть за вушком.', '1,5 роки', 'Хлопчик', 'Шукає дім', 5, '2026-05-04 16:54:23'),
(15, 'Джессі', 'pet_69fdf93a1ac17.jpg', 'Золотистий ретривер, неймовірно добра, обожнює воду та ігри з м\'ячем.', '2 роки', 'Дівчинка', 'Зарезервовано', 1, '2026-05-04 16:54:50'),
(16, 'Тобі', 'pet_69fdf94ba4722.jpg', 'Маленький йоркширський тер\'єр, справжній енерджайзер, не дасть вам сумувати ні хвилини.', '10 місяців', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 16:55:07'),
(17, 'Шустрик', 'pet_69fdf95a2b5b4.jpg', 'Шиншила сріблястого кольору. Обожнює купатися в спеціальному піску та стрибати по полицях', '6 місяців', 'Хлопчик', 'Зарезервовано', 3, '2026-05-04 16:55:22'),
(18, 'Дейзі', 'pet_69fdf9709575c.jpg', 'Життєрадісний кокер-спанієль. Ні хвилини не сидить на місці, обожнює довгі прогулянки в лісі та приносити палицю.', '2 роки', 'Хлопчик', 'Зарезервовано', 1, '2026-05-04 16:55:44'),
(19, 'Граф', 'pet_69fdf97ebdc57.jpg', 'Статний доберман, дуже дисциплінований, ідеальний для охорони приватного будинку.', '3 роки', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 16:55:58'),
(20, 'Тедді', 'pet_69fdf988f383e.jpg', 'Пухнастий пудель, схожий на плюшевого ведмедика. Не линяє, дуже легко вчиться новим трюкам і любить бути в центрі уваги.', '6 місяців', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 16:56:08'),
(21, 'Сплінтер', 'pet_69fdf992f394e.jpg', 'Декоративний щур дамбо з великими вушками. Дуже розумний, легко вчиться простим трюкам за винагороду.', '1 рік', 'Хлопчик', 'Шукає дім', 3, '2026-05-04 16:56:18'),
(22, 'Майя', 'pet_69fdf9a0e6d11.jpg', 'Білосніжна самоїдська лайка, дуже пухнаста, любить обійми та зимові прогулянки.', '3 роки', 'Дівчинка', 'Зарезервовано', 1, '2026-05-04 16:56:32'),
(23, 'Бруно', 'pet_69fdf9b8c08bc.jpg', 'Хаскі з блакитними очима. Дуже вокальний пес — він не просто гавкає, а буквально \"розмовляє\" зі своїм господарем.', '2 роки', 'Хлопчик', 'Шукає дім', 1, '2026-05-04 16:56:56'),
(24, 'Лулу', 'pet_69fdf9c543aac.jpg', 'Величний мейн-кун. Велика киця з пензликами на вухах. Попри розміри, має дуже ніжний голос і спокійний характер.', '1 рік', 'Дівчинка', 'Шукає дім', 2, '2026-05-04 16:57:09'),
(25, 'Колючка', 'pet_69fdf9d370db4.jpg', 'Африканський карликовий їжачок. Веде нічний спосіб життя, дуже кумедно фиркає, коли знаходить щось смачне.', '8 місяців', 'Дівчинка', 'Шукає дім', 5, '2026-05-04 16:57:23');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Вікторія Кучерява', 'kviktoria1710@gmail.com', '$2y$10$odKPaE8AwRHY23A6/YGMtePf3.6bSGgZ9Ua6u.JfutXCMwVO6Htgu', '2026-05-04 08:12:57'),
(2, 'Руслана Шимчишин', 'ruslanavol05@gmail.com', '$2y$10$Na6qnxpSjzj1hx09mOCA0.CPZAyhyDKxK.IB2TGzGJVwG2HtzkRDS', '2026-05-04 08:12:57'),
(3, 'Соломія Шимчишин', 'solomiia2604@gmail.com', '$2y$10$tYWbG3hNOK5qpaiW9YXf7OOH/pZb/DKmm03Iw.76AMKWSb9RvbxT.', '2026-05-06 09:14:45');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблиці `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
