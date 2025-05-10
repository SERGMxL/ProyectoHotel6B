-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2025 a las 20:46:56
-- Versión del servidor: 10.4.32-MariaDB-log
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contraseña_admin`
--

CREATE TABLE `contraseña_admin` (
  `id` int(11) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contraseña_admin`
--

INSERT INTO `contraseña_admin` (`id`, `clave`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) DEFAULT NULL COMMENT 'Subtotal antes de impuestos',
  `impuestos` decimal(10,2) DEFAULT NULL COMMENT 'Monto de impuestos (normalmente 16% del subtotal)',
  `total` decimal(10,2) DEFAULT NULL COMMENT 'Total a pagar (subtotal + impuestos)',
  `estado` enum('pendiente','pagada','cancelada') DEFAULT 'pendiente',
  `metodo_pago` varchar(50) DEFAULT NULL COMMENT 'Método de pago seleccionado por el cliente',
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de facturas del sistema de reservas del hotel';

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `reserva_id`, `fecha_emision`, `subtotal`, `impuestos`, `total`, `estado`, `metodo_pago`, `detalles`) VALUES
(1, 6, '2025-05-09 19:47:42', 200.00, 32.00, 232.00, 'pendiente', 'Tarjeta de Débito', 'se robo la tv'),
(2, 7, '2025-05-09 19:53:07', 1000.00, 160.00, 1160.00, 'pendiente', 'Tarjeta de Crédito', 'xd'),
(3, 8, '2025-05-09 19:53:49', 2800.00, 448.00, 3248.00, 'pendiente', 'Tarjeta de Débito', 'x'),
(4, 9, '2025-05-10 18:44:50', 1230.00, 196.80, 1426.80, 'pendiente', 'Tarjeta de Débito', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `tipo` enum('simple','doble','suite') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('disponible','ocupada','mantenimiento') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `habitacion` varchar(100) NOT NULL,
  `personas` int(11) NOT NULL,
  `noches` int(11) NOT NULL,
  `servicios` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `habitacion`, `personas`, `noches`, `servicios`, `fecha`) VALUES
(1, 'habitacion1', 2, 2, 'todo_incluido', '2025-05-09 01:48:15'),
(2, 'habitacion3', 7, 5, 'pedidos_ilimitados', '2025-05-09 02:00:16'),
(3, 'habitacion2', 2, 1, 'spa', '2025-05-09 19:36:39'),
(4, 'habitacion2', 4, 4, 'buffet', '2025-05-09 19:37:40'),
(5, 'habitacion2', 2, 2, '', '2025-05-09 19:40:37'),
(6, 'habitacion1', 2, 2, 'buffet,todo_incluido', '2025-05-09 19:47:21'),
(7, 'habitacion3', 1, 3, 'todo_incluido', '2025-05-09 19:51:12'),
(8, 'habitacion3', 4, 9, 'todo_incluido', '2025-05-09 19:53:39'),
(9, 'habitacion3', 8, 4, 'buffet', '2025-05-10 18:44:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','recepcionista') NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `contraseña_plana` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `contraseña`, `rol`, `nombre_completo`, `contraseña_plana`) VALUES
(1, 'sergmxl', '$2y$10$kb5jTRrzm2LSvJ7qbaBKOu7PwEoAByU/Dqwy5FV4rbdPKq4k2tJAq', 'recepcionista', 'Sergio Castañeda', NULL),
(2, 'pancracio', '$2y$10$6ZldOPXi6rgugZQ2E5D37.zEpjwvAlE5InLo1kJiFhdYkOIC8ZYGi', 'recepcionista', 'pepe toño', NULL),
(4, 'pepe1', '$2y$10$ajA8MZMeHx36AprQVf0UXOd505b5B.50uf8tRRa6S3U66TmYCyW.6', 'recepcionista', 'alberto', NULL),
(5, 'Luevanitolee', '$2y$10$XwOpknk6hNTi/vYYYPxwgO1yeYr/5MzmlgHUkvblm/9Is8ZBwWMaO', 'recepcionista', 'Brayan', NULL),
(6, 'juan', '$2y$10$xJlI2wY1zXsWHAWodcocT.E.u0gLXiFUcg6g/KWNzCA/ilEGoO/CK', 'recepcionista', 'juan', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `contraseña_admin`
--
ALTER TABLE `contraseña_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`),
  ADD KEY `fecha_emision` (`fecha_emision`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contraseña_admin`
--
ALTER TABLE `contraseña_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
