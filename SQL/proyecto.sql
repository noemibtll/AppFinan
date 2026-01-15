-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2025 a las 20:53:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Id_usuario` int(11) NOT NULL,
  `Id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(120) DEFAULT NULL,
  `tipo_operacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Id_usuario`, `Id_categoria`, `nombre_categoria`, `tipo_operacion`) VALUES
(0, 1, 'Alimentacion', 2),
(0, 2, 'Transporte', 2),
(0, 3, 'Nomina', 1),
(0, 4, 'Ahorro', 1),
(0, 5, 'Hogar', 2),
(0, 6, 'Salud ', 2),
(0, 7, 'Entretenimiento', 2),
(0, 10, 'Tarjeta Credito', 2),
(1, 11, 'Tarjeta Credito', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

CREATE TABLE `objetivos` (
  `Id_usuario` int(11) NOT NULL,
  `Id_Transaccion` int(11) NOT NULL,
  `Id_objetivo` int(11) NOT NULL,
  `monto_objetivo` float DEFAULT NULL,
  `objetivo_tipo` int(11) DEFAULT NULL,
  `nombre_objetivo` varchar(60) DEFAULT NULL,
  `fecha_objetivo` date DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `objetivos`
--

INSERT INTO `objetivos` (`Id_usuario`, `Id_Transaccion`, `Id_objetivo`, `monto_objetivo`, `objetivo_tipo`, `nombre_objetivo`, `fecha_objetivo`, `activo`) VALUES
(1, 0, 1, 5000, 2, 'Vacaciones', '2025-09-24', 0),
(1, 0, 2, 1100000, 1, 'Operacion', '2025-07-28', 0),
(1, 0, 3, 11000, 1, 'Xbox ', '2025-07-28', 0),
(1, 0, 4, 1000, 0, 'CARRO', '2025-07-31', 0),
(1, 0, 5, 9999, 1, 'Regalo madre', '2025-07-28', 0),
(1, 0, 6, 10000, 1, 'Servicio Automovil', '2025-08-30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `Id_transacciones` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Id_categoria` int(11) NOT NULL,
  `tipo` int(60) NOT NULL,
  `monto` float NOT NULL,
  `fecha` date NOT NULL,
  `frecuencia` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`Id_transacciones`, `Id_usuario`, `Id_categoria`, `tipo`, `monto`, `fecha`, `frecuencia`, `descripcion`) VALUES
(2, 2, 3, 1, 2000, '2025-07-28', 2, 'Ingreso Quincenal'),
(3, 8, 9, 1, 10, '2025-07-30', 0, 'Test'),
(41, 1, 3, 1, 4000, '2025-10-01', 3, 'Pago quincena 1'),
(42, 1, 4, 1, 800, '2025-10-01', 3, 'Ahorro quincena 1'),
(43, 1, 3, 1, 4000, '2025-10-15', 3, 'Pago quincena 2'),
(44, 1, 4, 1, 800, '2025-10-15', 3, 'Ahorro quincena 2'),
(45, 1, 3, 1, 4000, '2025-11-01', 3, 'Pago quincena 3'),
(46, 1, 4, 1, 800, '2025-11-01', 3, 'Ahorro quincena 3'),
(47, 1, 5, 2, 2500, '2025-10-03', 3, 'Pago Renta Octubre'),
(48, 1, 10, 2, 1000, '2025-10-05', 3, 'Pago mensual Tarjeta Credito'),
(49, 1, 1, 2, 1200, '2025-10-06', 2, 'Supermercado semanal'),
(50, 1, 2, 2, 50, '2025-10-07', 1, 'Transporte Campus'),
(51, 1, 2, 2, 50, '2025-10-08', 1, 'Transporte Campus'),
(52, 1, 1, 2, 150, '2025-10-09', 0, 'Cafetería'),
(53, 1, 2, 2, 50, '2025-10-09', 1, 'Transporte Campus'),
(54, 1, 7, 2, 350, '2025-10-11', 0, 'Cine fin de semana'),
(55, 1, 1, 2, 1200, '2025-10-13', 2, 'Supermercado semanal'),
(56, 1, 2, 2, 50, '2025-10-14', 1, 'Transporte Campus'),
(57, 1, 2, 2, 50, '2025-10-16', 1, 'Transporte Campus'),
(58, 1, 1, 2, 150, '2025-10-17', 0, 'Cafetería'),
(59, 1, 6, 2, 450, '2025-10-18', 0, 'Medicinas'),
(60, 1, 1, 2, 1300, '2025-10-20', 2, 'Supermercado semanal'),
(61, 1, 2, 2, 50, '2025-10-21', 1, 'Transporte Campus'),
(62, 1, 2, 2, 50, '2025-10-23', 1, 'Transporte Campus'),
(63, 1, 7, 2, 600, '2025-10-25', 0, 'Salida con amigos'),
(64, 1, 1, 2, 1100, '2025-10-27', 2, 'Supermercado semanal'),
(65, 1, 2, 2, 50, '2025-10-28', 1, 'Transporte Campus'),
(66, 1, 2, 2, 50, '2025-10-30', 1, 'Transporte Campus'),
(67, 1, 5, 2, 2500, '2025-11-03', 3, 'Pago Renta Noviembre'),
(68, 1, 2, 2, 50, '2025-11-04', 1, 'Transporte Campus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_usuario` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellidos` varchar(128) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `correo` varchar(120) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `activo` int(11) DEFAULT 0,
  `codigo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_usuario`, `nombre`, `apellidos`, `edad`, `correo`, `password`, `activo`, `codigo`) VALUES
(1, 'Juan         ', 'Parada      ', NULL, 'juan@gmail.com', 'e4da3b7fbbce2345d7772b0674a318d5', 1, 0),
(2, 'jose   ', 'Becerra       ', NULL, 'jose@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0),
(3, 'Noemi ', 'Botello ', NULL, 'noemi@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 0, 0),
(5, '1', '1', NULL, '1@1', 'c4ca4238a0b923820dcc509a6f75849b', 0, 0),
(6, 'prueba', 'test', NULL, 'prueba@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0),
(7, 'test ', 'test ', NULL, 'test@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0),
(8, '1234  ', '5678  ', NULL, '1234@5678', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0),
(9, 'Carlos', 'Becerra', NULL, 'becerrapina1234@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_categoria`);

--
-- Indices de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  ADD PRIMARY KEY (`Id_objetivo`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`Id_transacciones`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `Id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  MODIFY `Id_objetivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `Id_transacciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
