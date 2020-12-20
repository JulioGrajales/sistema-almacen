-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2019 a las 09:57:37
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa_almacenes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id_almacen` int(2) NOT NULL,
  `nombre_almacen` varchar(50) DEFAULT NULL,
  `estado_almacen` varchar(50) DEFAULT NULL,
  `ciudad_almacen` varchar(50) DEFAULT NULL,
  `cp_almacen` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id_almacen`, `nombre_almacen`, `estado_almacen`, `ciudad_almacen`, `cp_almacen`) VALUES
(1, 'Almacen Cancun', 'Quintana Roo', 'Cancun', '77500'),
(2, 'Almacen Puebla', 'Puebla', 'Puebla', '7200');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_entrada` int(3) NOT NULL,
  `id_almacen` int(2) NOT NULL,
  `id_producto` int(3) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_entrada`, `id_almacen`, `id_producto`, `cantidad`, `costo`, `fecha`, `hora`) VALUES
(1, 1, 1, 5, '2.30', '2019-11-29', '03:48:42'),
(2, 2, 1, 10, '4.43', '2019-11-29', '03:50:31'),
(3, 1, 2, 15, '7.70', '2019-11-29', '03:51:11'),
(4, 2, 3, 20, '14.60', '2019-11-29', '03:51:49'),
(5, 1, 1, 1, '4.43', '2019-11-29', '03:54:18'),
(6, 1, 3, 3, '14.60', '2019-11-29', '03:54:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(3) NOT NULL,
  `nombre_producto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`) VALUES
(1, 'Lapiz'),
(2, 'Balon'),
(3, 'Mochila');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_almacen`
--

CREATE TABLE `productos_almacen` (
  `id_almacen` int(2) NOT NULL,
  `Lugar` int(3) NOT NULL,
  `id_producto` int(3) NOT NULL,
  `cantidad_producto` int(3) NOT NULL,
  `costoP_producto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos_almacen`
--

INSERT INTO `productos_almacen` (`id_almacen`, `Lugar`, `id_producto`, `cantidad_producto`, `costoP_producto`) VALUES
(1, 1, 1, 6, '2.66'),
(2, 1, 1, 9, '4.43'),
(1, 2, 2, 14, '7.70'),
(2, 2, 3, 15, '14.60'),
(1, 3, 3, 3, '14.60');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int(3) NOT NULL,
  `id_almacen` int(2) NOT NULL,
  `id_producto` int(3) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`id_salida`, `id_almacen`, `id_producto`, `cantidad`, `fecha`, `hora`) VALUES
(1, 1, 2, 1, '2019-11-29', '03:52:57'),
(2, 2, 3, 2, '2019-11-29', '03:53:14'),
(3, 2, 1, 1, '2019-11-29', '03:54:18'),
(4, 2, 3, 3, '2019-11-29', '03:54:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traspasos`
--

CREATE TABLE `traspasos` (
  `id_traspaso` int(3) NOT NULL,
  `id_almacen_salida` int(2) NOT NULL,
  `id_almacen_entrada` int(2) NOT NULL,
  `id_producto` int(3) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `traspasos`
--

INSERT INTO `traspasos` (`id_traspaso`, `id_almacen_salida`, `id_almacen_entrada`, `id_producto`, `cantidad`, `costo`, `fecha`, `hora`) VALUES
(1, 2, 1, 1, 1, '4.43', '2019-11-29', '03:54:18'),
(2, 2, 1, 3, 3, '14.60', '2019-11-29', '03:54:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(3) NOT NULL,
  `nombre_user` varchar(50) NOT NULL,
  `password_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `nombre_user`, `password_user`) VALUES
(1, 'admin', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `id_almacen` (`id_almacen`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productos_almacen`
--
ALTER TABLE `productos_almacen`
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_almacen` (`id_almacen`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_almacen` (`id_almacen`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `traspasos`
--
ALTER TABLE `traspasos`
  ADD PRIMARY KEY (`id_traspaso`),
  ADD KEY `id_almacen_salida` (`id_almacen_salida`),
  ADD KEY `id_almacen_entrada` (`id_almacen_entrada`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id_almacen` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_entrada` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `traspasos`
--
ALTER TABLE `traspasos`
  MODIFY `id_traspaso` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos_almacen`
--
ALTER TABLE `productos_almacen`
  ADD CONSTRAINT `productos_almacen_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `productos_almacen_ibfk_2` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`);

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_ibfk_1` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `salidas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `traspasos`
--
ALTER TABLE `traspasos`
  ADD CONSTRAINT `traspasos_ibfk_1` FOREIGN KEY (`id_almacen_salida`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `traspasos_ibfk_2` FOREIGN KEY (`id_almacen_entrada`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `traspasos_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
