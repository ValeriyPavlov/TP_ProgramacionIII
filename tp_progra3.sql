-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2023 a las 01:28:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_progra3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `clave` text NOT NULL,
  `rol` text NOT NULL,
  `fechaAlta` date NOT NULL,
  `fechaBaja` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `clave`, `rol`, `fechaAlta`, `fechaBaja`) VALUES
(10, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Socio', '2023-06-17', '0000-00-00'),
(11, 'mozo', '126f8d4532191178216b1be0d199af87', 'Mozo', '2023-06-17', '0000-00-00'),
(12, 'cocinero', '209398364a16235aa9df0f44569f8feb', 'Cocinero', '2023-06-17', '0000-00-00'),
(13, 'cervecero', '60bdaa45be0668753a35da130ba1824a', 'Cervecero', '2023-06-26', '0000-00-00'),
(14, 'bartender', '7bb0b63fe7ca769b3e05fc6200931b82', 'Bartender', '2023-06-26', '0000-00-00'),
(15, 'test1', '5a105e8b9d40e1329780d62ea2265d8a', 'Cocinero', '2023-06-26', '0000-00-00'),
(16, 'test2', 'ad0234829205b9033196ba818f7a872b', 'Pastelero', '2023-06-26', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `codigoPedido` text NOT NULL,
  `puntuacionMesa` int(11) NOT NULL,
  `puntuacionRestaurante` int(11) NOT NULL,
  `puntuacionMozo` int(11) NOT NULL,
  `puntuacionCocinero` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`codigoPedido`, `puntuacionMesa`, `puntuacionRestaurante`, `puntuacionMozo`, `puntuacionCocinero`, `comentario`, `fecha`) VALUES
('AWP77', 7, 7, 10, 8, 'Muy rico todo.', '2023-06-25'),
('TEST1', 6, 6, 7, 7, 'Bastante bien.', '2023-06-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `codigoPedido` text NOT NULL,
  `montoTotal` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `pagada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`codigoPedido`, `montoTotal`, `fecha`, `pagada`) VALUES
('AWP77', 0, '2023-06-18', 0),
('AWP77', 14400, '2023-06-18', 0),
('TEST1', 6450, '2023-06-26', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `estado` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `estado`) VALUES
(10000, 'con cliente comiendo'),
(10001, 'con cliente esperando pedido'),
(10002, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidadProductos` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `estado` text NOT NULL,
  `codigoPedido` text NOT NULL,
  `fotoMesa` text NOT NULL,
  `tiempoPreparacion` int(11) NOT NULL,
  `horaCreacion` time NOT NULL,
  `horaFinalizacion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idEmpleado`, `idProducto`, `cantidadProductos`, `idMesa`, `estado`, `codigoPedido`, `fotoMesa`, `tiempoPreparacion`, `horaCreacion`, `horaFinalizacion`) VALUES
(1, 1, 1, 2, 10000, 'En preparacion', 'AW123', '', 40, '00:00:00', '00:00:00'),
(2, 0, 2, 3, 10000, 'Pendiente', 'AWP77', '', 0, '00:00:00', '00:00:00'),
(3, 12, 1, 5, 10001, 'En preparacion', 'QWE55', '', 34, '00:00:00', '00:00:00'),
(4, 12, 2, 3, 10000, 'Listo para servir!', 'AWP77', '.\\img\\\\fotoMesa-.jpg', 36, '00:00:00', '22:41:51'),
(5, 0, 2, 3, 10000, 'Pendiente', 'AWP77', '.\\img\\\\fotoMesa-AWP77.jpg', 0, '00:00:00', '00:00:00'),
(6, 0, 2, 3, 10000, 'Pendiente', 'AWP77', '.\\img\\\\fotoMesa-AWP77.jpg', 0, '00:00:00', '00:00:00'),
(7, 0, 2, 3, 10000, 'Pendiente', '123TT', '.\\img\\\\fotoMesa-123TT.jpg', 0, '00:00:00', '00:00:00'),
(8, 12, 3, 2, 10000, 'En preparacion', 'QTW23', '.\\img\\\\fotoMesa-QTW23.jpg', 40, '02:24:33', '00:00:00'),
(9, 12, 3, 2, 10000, 'En preparacion', '123RE', '.\\img\\\\fotoMesa-123RE.jpg', 35, '21:33:11', '00:00:00'),
(10, 12, 8, 1, 10002, 'Listo para servir!', 'TEST1', '.\\img\\\\fotoMesa-TEST1.jpg', 35, '19:03:42', '19:28:59'),
(11, 12, 9, 2, 10002, 'Listo para servir!', 'TEST1', '.\\img\\\\fotoMesa-TEST1.jpg', 33, '19:03:59', '19:29:03'),
(12, 13, 10, 1, 10002, 'Listo para servir!', 'TEST1', '.\\img\\\\fotoMesa-TEST1.jpg', 10, '19:04:09', '19:38:53'),
(13, 14, 11, 1, 10002, 'Listo para servir!', 'TEST1', '.\\img\\\\fotoMesa-TEST1.jpg', 15, '19:04:13', '19:29:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` float NOT NULL,
  `sector` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `descripcion`, `precio`, `sector`) VALUES
(1, 'Patagonia Weiss', 520, 'Cerveceria'),
(2, 'Cheeseburger', 1200, 'Cocina'),
(3, 'Muzza Gigante', 2200, 'Cocina'),
(7, 'Daikiri', 1000, 'Vinoteca'),
(8, 'Milanesa a Caballo', 1800, 'Cocina'),
(9, 'Hamburguesa de Garbanzo', 1400, 'Cocina'),
(10, 'Corona', 500, 'Cerveceria'),
(11, 'Daikiri', 1350, 'Vinoteca');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10003;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
