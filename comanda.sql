-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2019 a las 00:51:17
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `sector` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `usuario_id`, `estado`, `sector`) VALUES
(6, 'usuario1', 5, 2, 2),
(7, 'usuario2', 6, 1, 3),
(8, 'cocinero', 7, 1, 2),
(9, 'mozo', 8, 1, 4),
(10, 'socio1', 9, 1, 5),
(11, 'socio2', 10, 1, 5),
(12, 'socio3', 11, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_estado`
--

CREATE TABLE `empleado_estado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empleado_estado`
--

INSERT INTO `empleado_estado` (`id`, `nombre`) VALUES
(1, 'activo'),
(2, 'suspendido'),
(3, 'borrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `pMesa` int(11) NOT NULL,
  `pRestaurante` int(11) NOT NULL,
  `pMozo` int(11) NOT NULL,
  `pCocinero` int(11) NOT NULL,
  `comentario` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id`, `pMesa`, `pRestaurante`, `pMozo`, `pCocinero`, `comentario`) VALUES
(1, 10, 10, 10, 10, 'Excelente'),
(2, 10, 10, 10, 10, 'Muy bueno todo'),
(3, 10, 10, 10, 10, 'Muy bueno todo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id`, `estado`) VALUES
('a90f5', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_estado`
--

CREATE TABLE `mesa_estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesa_estado`
--

INSERT INTO `mesa_estado` (`id`, `estado`) VALUES
(1, 'cerrada'),
(2, 'con cliente esperando pedido'),
(3, 'con clientes comiendo'),
(4, 'con clientes pagando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `mesa` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `total` float NOT NULL,
  `tiempo_inicial` datetime NOT NULL,
  `tiempo_final_estimado` datetime NOT NULL,
  `tiempo_entregado` datetime NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `mesa`, `total`, `tiempo_inicial`, `tiempo_final_estimado`, `tiempo_entregado`, `estado`) VALUES
('06497', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2019-07-01 01:01:19', 4),
('6f123', 'ASDFJ', 1000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
('', 'GADJJ', 2000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
('b1761', 'ASDFJ', 1000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
('6ea9f', 'ASDFJ', 1000, '0000-00-00 00:00:00', '2019-06-29 19:02:05', '0000-00-00 00:00:00', 1),
('8dc03', 'ASDFJ', 1000, '0000-00-00 00:00:00', '2019-06-29 19:04:19', '0000-00-00 00:00:00', 1),
('e3448', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 19:05:17', '0000-00-00 00:00:00', 1),
('0479b', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 19:04:17', '0000-00-00 00:00:00', 1),
('2021d', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 14:06:06', '0000-00-00 00:00:00', 1),
('53f81', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 14:33:56', '0000-00-00 00:00:00', 1),
('5583f', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 14:35:08', '0000-00-00 00:00:00', 1),
('1e681', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-29 14:35:50', '0000-00-00 00:00:00', 1),
('cdeb0', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-30 21:23:53', '0000-00-00 00:00:00', 1),
('57cfc', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-30 21:38:19', '0000-00-00 00:00:00', 1),
('2e63e', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-30 22:31:43', '0000-00-00 00:00:00', 1),
('8589c', 'ASDFJ', 500, '0000-00-00 00:00:00', '2019-06-30 22:32:52', '0000-00-00 00:00:00', 1),
('f6162', 'a90f5', 500, '0000-00-00 00:00:00', '2019-06-30 22:54:55', '0000-00-00 00:00:00', 1),
('26938', 'a90f5', 500, '0000-00-00 00:00:00', '2019-06-30 23:06:19', '0000-00-00 00:00:00', 1),
('25d20', 'a90f5', 390, '0000-00-00 00:00:00', '2019-07-01 00:36:06', '0000-00-00 00:00:00', 1),
('7f794', 'a90f5', 390, '0000-00-00 00:00:00', '2019-07-01 00:38:14', '0000-00-00 00:00:00', 1),
('0606d', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 00:31:52', '0000-00-00 00:00:00', 1),
('de4a1', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 00:54:53', '0000-00-00 00:00:00', 1),
('32876', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 00:55:49', '2019-07-01 01:02:16', 5),
('f929c', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 19:00:11', '0000-00-00 00:00:00', 1),
('28bcd', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 19:00:27', '0000-00-00 00:00:00', 1),
('a39c5', 'a90f5', 500, '0000-00-00 00:00:00', '2019-07-01 19:01:14', '0000-00-00 00:00:00', 1),
('b4072', 'a90f5', 500, '2019-07-01 19:18:40', '2019-07-01 19:20:40', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_estado`
--

CREATE TABLE `pedido_estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedido_estado`
--

INSERT INTO `pedido_estado` (`id`, `estado`) VALUES
(1, 'pendiente'),
(2, 'en preparación'),
(3, 'listo para servir'),
(4, 'entregado'),
(5, 'pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

CREATE TABLE `pedido_producto` (
  `id` int(11) NOT NULL,
  `pedido_id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`id`, `pedido_id`, `producto_id`, `cantidad`, `estado`) VALUES
(1, '06497', 1, 2, 3),
(2, '6f123', 1, 2, 1),
(3, 'b1761', 1, 2, 0),
(4, '6ea9f', 1, 2, 0),
(5, '8dc03', 1, 2, 0),
(6, 'e3448', 1, 1, 0),
(7, '0479b', 1, 1, 0),
(8, '2021d', 1, 1, 0),
(9, '53f81', 1, 1, 0),
(10, '5583f', 1, 1, 0),
(11, '1e681', 1, 1, 0),
(12, 'cdeb0', 1, 1, 0),
(13, '57cfc', 1, 1, 0),
(14, '2e63e', 1, 1, 0),
(15, '8589c', 1, 1, 0),
(16, 'f6162', 1, 1, 0),
(17, '26938', 1, 1, 0),
(18, '25d20', 2, 3, 0),
(19, '7f794', 2, 3, 1),
(20, '0606d', 2, 3, 1),
(21, '0606d', 1, 1, 1),
(22, 'de4a1', 2, 3, 1),
(23, 'de4a1', 1, 1, 1),
(24, '32876', 2, 3, 1),
(25, '32876', 1, 1, 1),
(26, 'f929c', 2, 3, 1),
(27, 'f929c', 1, 1, 1),
(28, '28bcd', 2, 3, 1),
(29, '28bcd', 1, 1, 1),
(30, 'a39c5', 2, 3, 1),
(31, 'a39c5', 1, 1, 1),
(32, 'b4072', 2, 3, 1),
(33, 'b4072', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `tiempo_estimado` int(11) NOT NULL,
  `sector_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `tiempo_estimado`, `sector_id`) VALUES
(1, 'Whiskey', '500.00', 2, 1),
(2, 'Canelones', '130.00', 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_login`
--

CREATE TABLE `registro_login` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_login`
--

INSERT INTO `registro_login` (`id`, `empleado_id`, `fecha`) VALUES
(1, 6, '2019-06-30 22:11:38'),
(2, 6, '2019-07-01 00:19:11'),
(3, 8, '2019-07-01 00:24:56'),
(4, 9, '2019-07-01 00:25:56'),
(5, 8, '2019-07-01 00:26:31'),
(6, 10, '2019-07-01 01:16:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_operacion`
--

CREATE TABLE `registro_operacion` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_operacion`
--

INSERT INTO `registro_operacion` (`id`, `empleado_id`, `fecha`) VALUES
(1, 6, '2019-06-30 22:30:52'),
(2, 6, '2019-06-30 22:52:55'),
(3, 7, '2019-06-30 23:04:19'),
(4, 9, '2019-07-01 00:26:06'),
(5, 9, '2019-07-01 00:28:14'),
(6, 9, '2019-07-01 00:29:52'),
(7, 9, '2019-07-01 00:53:49'),
(8, 9, '2019-07-01 01:01:19'),
(9, 9, '2019-07-01 01:02:16'),
(10, 9, '2019-07-01 01:10:05'),
(11, 9, '2019-07-01 18:56:37'),
(12, 9, '2019-07-01 18:57:29'),
(13, 9, '2019-07-01 18:58:12'),
(14, 9, '2019-07-01 18:58:27'),
(15, 9, '2019-07-01 18:59:14'),
(16, 9, '2019-07-01 19:00:47'),
(17, 9, '2019-07-01 19:00:51'),
(18, 9, '2019-07-01 19:01:28'),
(19, 9, '2019-07-01 19:03:06'),
(20, 9, '2019-07-01 19:18:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`id`, `nombre`) VALUES
(1, 'Bar'),
(2, 'Cocina'),
(3, 'Cervecería'),
(4, 'Atención a mesas'),
(5, 'Socios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`) VALUES
(5, 'usuario1', 'ef8180cb0cf0b9dc910e3466b7f998c28dabb54bae206c6b8e475c87796a40d277947049a8567ba5d2d4f4a057a502f39d912644357ec6c9d253a0b3b036da0b'),
(6, 'usuario2', '47cc3735e0915115b97c81cba68340cf33257be23bad223f7392d8c8aa1880c11310652f98e3eb9abe6644fcb025adb89ff0976b0a6fc9bb005ddee9cafc8bbc'),
(7, 'cocinero', '23f3f4262e61d10440f1a3fae9314504b42753eaeaad49ca7e4b3a08b79a87ca702c4c0e30b13206192b64e6bd0e392f5d63a4ddbff9528ee199978e344561c6'),
(8, 'mozo', '07b6e126fb040cd69b4480a418220e1a85adb85883a260d0c6d73bda975c570c0a54571a2805be47cd505f93c2c196244e6d16ac1975c5fadfb9e40540efab50'),
(9, 'socio1', '6e39e54075e842f3edcf93a442ef3f1f427160cdef9137bc571853c40c6aa128efe8e1674d5ff9183fe9d3d7961dea27709d2d65fa0e7fb6a185bd76c222af41'),
(10, 'socio2', 'bcd6c0950fec6e761aa18a0d6f841229d4288a07e2c580921876a868dd1dbc29bf13d603af4bbe68db34b43a706872b1f7fe4dd4340014a3442e9a8f59957efa'),
(11, 'socio3', '37bacbef3c9f6b7c5afbdb579b172198aaf04c6c208a4288c3de0c6cf497cc3f5fe5c1c34d8d4391de635f174afde973fd7d6a16a37795934349c6b596a85398');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_empleado_usuario` (`usuario_id`);

--
-- Indices de la tabla `empleado_estado`
--
ALTER TABLE `empleado_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesa_estado`
--
ALTER TABLE `mesa_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_estado`
--
ALTER TABLE `pedido_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_operacion`
--
ALTER TABLE `registro_operacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `empleado_estado`
--
ALTER TABLE `empleado_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesa_estado`
--
ALTER TABLE `mesa_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido_estado`
--
ALTER TABLE `pedido_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `registro_operacion`
--
ALTER TABLE `registro_operacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_empleado_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
