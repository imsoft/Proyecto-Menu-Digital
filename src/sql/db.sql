-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-05-2024 a las 06:24:22
-- Versión del servidor: 8.0.34-26
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbaucwkxjvtpaq`
--
CREATE DATABASE IF NOT EXISTS `dbaucwkxjvtpaq` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `dbaucwkxjvtpaq`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `branches`
--

CREATE TABLE `branches` (
  `id` int NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_manager` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` char(5) NOT NULL,
  `cellphone` char(10) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_manager`, `address`, `postal_code`, `cellphone`, `website`, `company_id`) VALUES
(3, 'Gourmet Centro', 'Juan Martínez', 'Centro Comercial Plaza Norte, Ciudad A', '01002', '1234509876', 'www.gourmetcentro.com', 1),
(4, 'Gourmet Sur', 'Laura Gómez', 'Avenida del Río, Ciudad A', '01003', '1234509877', 'www.gourmetsur.com', 1),
(5, 'Café Central Park', 'Carlos López', 'Parque Central, Ciudad B', '02001', '2345612345', 'www.cafecentralpark.com', 2),
(8, 'sucursal', 'sucursal', 'sucursal', '44869', '3311670593', 'https://www.imsoft.io/', 9),
(9, 'Legacy Cafe', 'Vanessa Flores', 'Santa Maria 12', '44440', '3311670593', 'https://legacyroasters.com.mx/', 9),
(10, 'Cafe San Pedro', 'Vanessa Flores', 'Santa Maria 12', '44440', '3311670593', 'https://legacyroasters.com.mx/', 9),
(11, 'Panaderia Vane', 'Elizabeth Juarez', 'Oblatos Presa Laurel', '44440', '3311648958', 'https://www.facebook.com/RoussPastelerias', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carts`
--

INSERT INTO `carts` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 6, '2024-04-25 12:15:14', '2024-04-25 12:15:14'),
(2, 9, '2024-05-07 13:48:22', '2024-05-07 13:48:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `menu_item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `folio` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `menu_item_id`, `quantity`, `folio`) VALUES
(2, 1, 3, 1, 4),
(6, 2, 9, 2, 931573),
(7, 2, 10, 1, 726869),
(8, 2, 15, 1, 447719),
(9, 2, 35, 1, 367889),
(10, 2, 36, 1, 540261);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_item_ingredients`
--

CREATE TABLE `cart_item_ingredients` (
  `id` int NOT NULL,
  `cart_item_id` int DEFAULT NULL,
  `ingredient` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cart_item_ingredients`
--

INSERT INTO `cart_item_ingredients` (`id`, `cart_item_id`, `ingredient`) VALUES
(1, 8, 'Lechuga'),
(2, 2, 'Papa'),
(3, 6, 'Pan'),
(4, 7, 'Pollo'),
(5, 9, 'Extra Cheese'),
(6, 9, 'Avocado'),
(7, 10, 'Avocado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('masculino','femenino','otro') NOT NULL,
  `password` varchar(255) NOT NULL,
  `table_number` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `firstName`, `lastName`, `surname`, `email`, `phone`, `birthdate`, `gender`, `password`, `table_number`) VALUES
(6, 'Brandon Uriel', 'García', 'Ramos', 'a@a.com', '3325365558', '2024-04-09', 'femenino', '$2y$10$OSPeKfCBeEDNdJ/0XBbXue/enwSjK/p6UtIIb0i.F0Wwe3aFwOyM.', 98),
(8, 'Brandon Uriel', 'García', 'Ramos', 'b@b.com', '3325365558', '2024-04-12', 'masculino', '$2y$10$lvOVKEZhpPDkg9BhLuszEuoqj0NQgzV/.DWWNo1TeQz5tRc7rKmVq', 36),
(9, 'cliente', 'cliente', 'cliente', 'cliente@cliente.com', '3311670593', '2024-04-11', 'femenino', '$2y$10$De7KfGq0A/hJuAqW/PTOg.FUPbEeGDJQ/sE33IuieqtpVm.2yihj.', 92);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `branch_id` int NOT NULL,
  `rating` enum('bueno','regular','malo') NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `client_id`, `branch_id`, `rating`, `comment`, `created_at`, `company_id`) VALUES
(4, 9, 8, 'bueno', 'Buen restaurante :)', '2024-05-02 20:04:41', 9),
(8, 9, 8, 'bueno', 'Bueno', '2024-05-15 04:33:06', NULL),
(9, 9, 8, 'regular', 'regular', '2024-05-15 04:33:16', NULL),
(11, 9, 8, 'bueno', 'Muy bueno!', '2024-05-15 04:33:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` int NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `associated_name` varchar(255) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `cellphone` char(10) NOT NULL,
  `food_type` enum('restaurante','cafe','panaderia','otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `has_rfc` tinyint(1) NOT NULL,
  `consistent_menu` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'negocio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `logo_path`, `associated_name`, `business_name`, `address`, `email`, `cellphone`, `food_type`, `has_rfc`, `consistent_menu`, `password`, `user_type`) VALUES
(1, '/path/to/logo1.png', 'Asociado 1', 'Restaurante Gourmet', '123 Calle Principal, Ciudad A', 'contacto@gourmet.com', '1234567890', '', 1, 1, 'passwordHashed1', 'negocio'),
(2, '/path/to/logo2.png', 'Asociado 2', 'Café Central', '456 Calle Secundaria, Ciudad B', 'contacto@cafecentral.com', '2345678901', 'cafe', 0, 1, 'passwordHashed2', 'negocio'),
(3, '/path/to/logo3.png', 'Asociado 3', 'Comida Rápida Express', '789 Calle Terciaria, Ciudad C', 'contacto@fastfoodexpress.com', '3456789012', '', 1, 0, 'passwordHashed3', 'negocio'),
(9, '../../../public/images/uploaded_images/4ad7737fc5d40dab0d983eabcb0c6c0a.jpg', 'negocio', 'negocio', 'negocio', 'negocio@negocio.com', '3311670593', 'restaurante', 0, 0, '$2y$10$LmmjkuyWr5o1mt.h7fO04OOjIp6YyPUHJbEOvnTIU3p0Nom4yTMCO', 'negocio'),
(10, '../../../public/images/uploaded_images/707bdfe1b9098b849b17b4758ede5ad0.webp', 'vanessa flores', 'Snackes', 'Santa Maria 250', 'vanessa_flores@hotmail.com', '3311674892', 'cafe', 1, 1, '$2y$10$PgGqgYORe80AFaVAxYgdmeszATyoyrhsEs1y2fnXcg5gJZ.neBgtK', 'negocio'),
(12, '../../../public/images/uploaded_images/e5a312fc84f4f180466b0e5e6e27c7fc.webp', 'vanessa flores', 'Snackes', 'Santa Maria 250', 'vanessa_flores1@hotmail.com', '3311674892', 'cafe', 1, 1, '$2y$10$t/umdalqzT7xYOgvEMGPE.EXw1tdPkPpZPSfMIQhiOstB6zqdnvRq', 'negocio'),
(13, '../../../public/images/uploaded_images/cf85c1dc904146a23dbe226d9a101d1f.png', 'Elizabeth Juarez', 'Deli Eli', 'Oblatos', 'ElizabethJuarez@hotmail.com', '3311670593', 'panaderia', 0, 1, '$2y$10$NUo0DDVhbjsofpY/XEpvIeK47MbFEM8ICp15qIp8nnzOmFqT6UAJ2', 'negocio'),
(14, '../../../public/images/uploaded_images/f7e825547942ba76b96d33df52d3ee36.png', 'Elizabeth Juarez', 'Deli Eli', 'presa osorio', 'Elizabeth@jabil.com', '3311672548', 'panaderia', 0, 1, '$2y$10$VvtoGgUyF9zqWfN90UWJXePAxbwLzb.Aqxa07DtNtbxui3zRE83Sy', 'negocio'),
(16, '../../../public/images/uploaded_images/90ce87091ae7b4dd1c3e111e9118c9d9.png', 'Elizabeth Juarez', 'Deli Eli', 'sta rosalia 314', 'Elizabether@jabil.com', '3311670593', 'panaderia', 0, 1, '$2y$10$D2225YRYC3g07.m3FkGF5egfmb.VatgDOnFMUlISCAqy4O0JP5tGS', 'negocio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('masculino','femenino','otro') NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'empleado',
  `company_id` int DEFAULT NULL,
  `branch_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `firstName`, `lastName`, `surname`, `email`, `phone`, `birthdate`, `gender`, `password`, `user_type`, `company_id`, `branch_id`) VALUES
(18, 'v', 'v', 'z', 'z@z.com', '3334109866', '2024-04-16', 'masculino', 'a', 'empleado', NULL, NULL),
(20, 'd', 'd', 'd', 'd@d.com', '3325365558', '2024-04-19', 'femenino', '$2y$10$53Q5fPTUBFPFhc.JuKMIbesyyA/c/h.3oyOTTzVlMCxhzauGdj.bC', 'empleado', NULL, NULL),
(21, 'Brandon Uriel', 'García', 'Ramos', 'contacto@imsoft.io', '3325365558', '2024-04-17', 'masculino', '$2y$10$ZzDLybQsLD12L4Oqy4BHguqIEpwxiDW2w1GZ12tvbrO/o7MC8beyu', 'empleado', NULL, NULL),
(27, 'empleado', 'empleado', 'empleado', 'empleado@empleado.com', '3311670593', '2024-04-11', 'masculino', '$2y$10$h.vq.J8yUvwv4UNRhuktbu8GFZhEhjWV60W1ymMwP8W8gFtatw.8i', 'empleado', 9, 8),
(28, 'vanessa', 'macias', 'macias', 'negocion@negocio.com', '3311670593', '2024-05-09', 'femenino', '$2y$10$lcxjtf8EWyI5UHuQS.3zXuTze.YaFdqKjyzFv3RWX0L4nwLmDrEge', 'empleado', 9, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `price`, `company_id`) VALUES
(1, 'Extra Cheese', '0.50', 9),
(2, 'Bacon', '1.00', 9),
(3, 'Avocado', '1.50', 9),
(4, 'Tomato', '0.30', 9),
(5, 'Lettuce', '0.20', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_name` enum('comida','bebida','extras') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `menu_items`
--

INSERT INTO `menu_items` (`id`, `product_image`, `product_name`, `description`, `category_name`, `price`, `company_id`) VALUES
(3, '../../../public/images/uploaded_images/6567de4cdf8aac472c3eb8e76cb279fa.jpg', 'Hamburguesa', 'Hamburguesa Sencilla', 'comida', '60.00', 9),
(9, '../../../public/images/uploaded_images/fd16845b881d88101041c28d3a0775c8.jpg', 'Dogo Sencillo', 'Dogo Sencillo', 'comida', '30.00', 9),
(10, '../../../public/images/uploaded_images/4d9ddf9238b0aa3a743860c4bf958214.png', 'Hot Dog Tocino', 'Hot Dog Tocino', 'comida', '35.00', 9),
(11, '../../../public/images/uploaded_images/b31c030109cdba55ce67124ab5aa7093.png', 'Hot Dog Gratinado', 'Hot Dog Gratinado', 'comida', '35.00', 9),
(12, '../../../public/images/uploaded_images/3a109473ee27c9a52223c0fca9b81168.jpg', 'Hamburguesa De tocino', 'Hamburguesa De tocino\r\nJitomate\r\ncebolla\r\nqueso', 'comida', '65.00', 9),
(13, '../../../public/images/uploaded_images/1620a9b14e4f6f86db39f85613b92d91.png', 'Hamburguesa Peperoni', 'Hamburguesa Peperoni y Queso', 'comida', '65.00', 9),
(14, '../../../public/images/uploaded_images/185e416d83d174b90c855df07aa671dc.jpg', 'Hamburguesa Peperoni', 'Hamburguesa Peperoni\r\nJitomate\r\nCebolla\r\n', 'comida', '65.00', 9),
(15, '../../../public/images/uploaded_images/a6783726abca4b6f723cdbb677662fe4.jpg', 'Hamburguesa Hawayana', 'Hamburguesa Hawayana\r\nJitomate\r\nCebolla\r\njamon', 'comida', '75.00', 9),
(16, '../../../public/images/uploaded_images/e61ba3877b4975591d804a562caaa8c8.jpg', 'Hamburguesa Champinon', 'Hamburguesa Champinon\r\nJitomate\r\nCebolla\r\nTocino', 'comida', '75.00', 9),
(17, '../../../public/images/uploaded_images/79aaafbb8b55cc4e43150e7259f10d15.jpg', 'Hamburguesa Pierna', 'Hamburguesa Pierna\r\nJitomate\r\nCebolla', 'comida', '75.00', 9),
(18, '../../../public/images/uploaded_images/02bd45fa7b3f9801a90ba97eec097a4e.png', 'Hamburguesa Chistorra', 'Hamburguesa Chistorra\r\nJitomate\r\nCebolla', 'comida', '80.00', 9),
(19, '../../../public/images/uploaded_images/c181e16799188cd5ab7eac92447de0e2.jpg', 'Agua Fresca Chica', 'Agua Fresca Chica\r\nLimon ', 'bebida', '20.00', 9),
(20, '../../../public/images/uploaded_images/bbf66ae0cf2c11eec8712a28ca9e35c9.jpg', 'Agua Fresca Grande', 'Agua Fresca Grande\r\nLimon ', 'bebida', '35.00', 9),
(21, '../../../public/images/uploaded_images/050f5c2508b6235c1d5c17b8034e14b4.jpg', 'Refresco', 'Refresco Coca cola', 'bebida', '20.00', 9),
(22, '../../../public/images/uploaded_images/ccb4574dc9761d4b7520f03c98beeb5f.jpg', 'Queso', 'Rico Queso Para Fundir', 'extras', '10.00', 9),
(23, '../../../public/images/uploaded_images/961a5c19ce43f1363ca3d105ec86d79b.jpg', 'Champinon', 'Rico Champinon', 'extras', '10.00', 9),
(24, '../../../public/images/uploaded_images/7500ccfb7c72c8da544a21ec1fffa6a2.jpg', 'Piña', 'Rico Piña', 'extras', '10.00', 9),
(25, '../../../public/images/uploaded_images/94116c5a0600494843150f2003d68be7.jpg', 'Salchicha', 'Salchicha', 'extras', '10.00', 9),
(26, '../../../public/images/uploaded_images/39919517dfb12d959d4c52cd944aa48a.jpg', 'Tocino', 'Tocino', 'extras', '10.00', 9),
(27, '../../../public/images/uploaded_images/8ccf8ebea0f00dc35e906a1626718f52.jpg', 'Peperoni', 'Peperoni', 'extras', '10.00', 9),
(28, '../../../public/images/uploaded_images/8789f7eb15007e182630984e2de640c8.jpg', 'Jamon', 'Jamon', 'extras', '10.00', 9),
(29, '../../../public/images/uploaded_images/fd0db1d535e536b7db9c5f8bc3ffda03.jpg', 'Aguacate', 'Aguacate', 'extras', '15.00', 9),
(30, '../../../public/images/uploaded_images/ce305ed35a9eb7349a19e455ba282ecd.jpg', 'Chistorra', 'Chistorra', 'extras', '20.00', 9),
(31, '../../../public/images/uploaded_images/63f46906c28c71769655b3ae57419800.jpg', 'Pierna', 'Pierna', 'extras', '20.00', 9),
(32, '../../../public/images/uploaded_images/936eb784a7284724154784f05e59853d.jpg', 'Carne', 'Carne', 'extras', '25.00', 9),
(33, '../../../public/images/uploaded_images/78927b3f0a9cf4c2a7c0d7fa493e4c8c.jpg', 'Camaron', 'Camaron', 'extras', '40.00', 9),
(34, '../../../public/images/uploaded_images/d02bf7d3df7134badcc314104c5cea66.jpg', 'Torta de Pierna', 'Torta de Pierna\r\nqueso y aguacate', 'comida', '75.00', 9),
(35, '../../../public/images/uploaded_images/b09e5c41fa53c93b67d42a817dfb14c4.jpg', 'Torta Cubana', 'Torta de Cubana\r\nSalchicha\r\nJamon\r\nTocino\r\nQueso', 'comida', '85.00', 9),
(36, '../../../public/images/uploaded_images/c8c24801c106b09707e13b6660693722.jpg', 'Torta de Camaron', 'Torta de Camaron\r\nAguacate \r\nCamaron\r\nQueso', 'comida', '100.00', 9),
(37, '../../../public/images/uploaded_images/bf216381b42260c585f701a1d15186cf.jpg', 'Papas a la Francesa', 'Snack\r\n\r\nPapas a la Francesa', 'comida', '40.00', 9),
(38, '../../../public/images/uploaded_images/f72c7eaab007eb3913b846fe910bf414.jpg', 'Papas Gajo', 'Snack\r\n\r\nPapas Gajo', 'comida', '45.00', 9),
(39, '../../../public/images/uploaded_images/153f5b672f2c72c17da81f7b872b575f.jpg', 'Salchipulpos', 'Snack\r\n\r\nSalchipulpos', 'comida', '45.00', 9),
(40, '../../../public/images/uploaded_images/980df7ca0fd60ff3132105abc57b529d.png', 'Aros de Cebolla', 'Snack\r\n\r\nAros de Cebolla', 'comida', '50.00', 9),
(41, '../../../public/images/uploaded_images/8f937437d1379d56a8bf0cba01e94347.jpg', 'Dedos de Queso', 'Snack\r\n\r\nDedos de Queso', 'comida', '60.00', 9),
(42, '../../../public/images/uploaded_images/ff3de2487ea5c06e295b2bb327eb8560.png', 'Pastel Oreo', 'Pastel Oreo', 'comida', '100.00', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `client_id` int NOT NULL,
  `company_id` int NOT NULL,
  `branch_id` int NOT NULL,
  `state` enum('esperando','preparando','lista','entregada') NOT NULL DEFAULT 'esperando',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `cart_id`, `client_id`, `company_id`, `branch_id`, `state`, `created_at`) VALUES
(2, 2, 6, 2, 5, 'entregada', '2024-05-08 02:54:41'),
(3, 2, 8, 9, 3, 'esperando', '2024-05-14 04:37:28'),
(4, 2, 9, 2, 5, 'esperando', '2024-05-14 04:42:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tax_data`
--

CREATE TABLE `tax_data` (
  `id` int NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `rfc` char(13) NOT NULL,
  `socialName` varchar(255) NOT NULL,
  `tradeName` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `curp` char(18) NOT NULL,
  `company_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tax_data`
--

INSERT INTO `tax_data` (`id`, `firstName`, `lastName`, `surname`, `rfc`, `socialName`, `tradeName`, `address`, `curp`, `company_id`) VALUES
(2, 'b', 'b', 'b', 'GARB9703155ZA', 'a', 'a', 'a', 'GARB970315HJCRMR01', NULL),
(4, 'Vanessa Esmeralda', 'flores', 'cervantes', 'GARC840512HDF', 'Restaurante Emilio, S.A. de C.V.', 'Comida Mexicana', 'sta rosalia 314', 'GARC840512HMNLRL09', 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_branches_companies` (`company_id`);

--
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indices de la tabla `cart_item_ingredients`
--
ALTER TABLE `cart_item_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_item_id` (`cart_item_id`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `fk_comments_company` (`company_id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indices de la tabla `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_items_company_id` (`company_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indices de la tabla `tax_data`
--
ALTER TABLE `tax_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_id` (`company_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cart_item_ingredients`
--
ALTER TABLE `cart_item_ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tax_data`
--
ALTER TABLE `tax_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_branches_companies` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);

--
-- Filtros para la tabla `cart_item_ingredients`
--
ALTER TABLE `cart_item_ingredients`
  ADD CONSTRAINT `cart_item_ingredients_ibfk_1` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `fk_comments_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu_items_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Filtros para la tabla `tax_data`
--
ALTER TABLE `tax_data`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
