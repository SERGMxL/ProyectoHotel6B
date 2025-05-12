-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2025 a las 04:05:56
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
  `subtotal` decimal(10,2) DEFAULT NULL,
  `impuestos` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','pagada','cancelada') DEFAULT 'pendiente',
  `metodo_pago` varchar(50) DEFAULT NULL,
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(0, 'habitacion2', 2, 4, 'todo_incluido', '2025-05-12 01:26:03'),
(0, 'habitacion2', 2, 3, 'todo_incluido', '2025-05-12 02:00:12'),
(0, 'habitacion3', 4, 5, 'todo_incluido', '2025-05-12 02:01:12');

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
(0, 'pancracio', '$2y$10$ykGW2O1ihNBYq..ZNvQqDeEhxPZBrFrhyd.G1HahhwOIzo0K9/ytG', 'recepcionista', 'pepe toño', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
