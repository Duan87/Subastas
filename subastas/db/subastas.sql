-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-08-2016 a las 07:37:56
-- Versión del servidor: 5.5.49-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `subastas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`, `descripcion`) VALUES
(1, 'Autos deportivos', 'Todos los autos de la gama de deportivos...'),
(2, 'Electronica', 'Todo sobre electronica.'),
(3, 'Linea Blanca', 'Todos los muebles que entran en la linea blanca.'),
(4, 'People', 'Vendo gente'),
(5, 'Ropa casual', 'Todo tipo de ropa casual'),
(6, 'Perfumeria', 'Todo tipo de perfumeria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

CREATE TABLE IF NOT EXISTS `cesta` (
  `id_cesta` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_subasta` int(11) NOT NULL,
  PRIMARY KEY (`id_cesta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE IF NOT EXISTS `oferta` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `oferta` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_subasta` int(11) NOT NULL,
  `comprador` int(11) NOT NULL,
  PRIMARY KEY (`id_oferta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `oferta`, `estado`, `fecha`, `id_subasta`, `comprador`) VALUES
(1, 500, 0, '2016-08-09 00:00:00', 1, 1),
(2, 700, 0, '2016-08-09 04:12:19', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `imagen`, `id_categoria`) VALUES
(1, 'Abanico', 'Es negro', 'default.jpg', 3),
(2, 'Ferrari', 'Ferrari color rojo', 'ferrari.jpg', 1),
(3, 'Persona', 'Trata de blanca', 'ALEJANDROZAVALA - WIN_20140713_173704.JPG', 4),
(4, 'Abanico', 'Ventilador color negro', 'abanico.jpg', 3),
(5, 'Playera polo', 'Color verde Color verde Color verde Color verde', 'default.jpg', 5),
(6, 'Bocinas', 'Bocinas color negras 2', 'bocinas.jpg', 2),
(7, 'Pantalones levis', 'Pantaloncillos marca levis talla 32 para caballero', 'pantalones.jpg', 5),
(8, 'Bentley Bentayga 2017', 'Compare 2 Bentayga trims and trim families below to see the differences in prices and features.', 'bently.jpg', 1),
(9, 'JF9 BLUE de Jafra', 'Perfume de Jafra JF9 color azul', 'jf9.jpg', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subasta`
--

CREATE TABLE IF NOT EXISTS `subasta` (
  `id_subasta` int(11) NOT NULL AUTO_INCREMENT,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL,
  `tiempo_ini` datetime NOT NULL,
  `tiempo_fin` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `comprador` int(11) DEFAULT NULL,
  `subastador` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_subasta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `subasta`
--

INSERT INTO `subasta` (`id_subasta`, `min`, `max`, `tiempo_ini`, `tiempo_fin`, `estado`, `comprador`, `subastador`, `id_producto`) VALUES
(1, 1000000, 3000000, '2016-08-09 10:25:44', '2016-08-16 13:10:00', 0, NULL, 1, 2),
(2, 100000, 1000000, '2016-08-09 17:18:12', '2016-08-16 12:00:00', 0, NULL, 6, 3),
(3, 300, 1500, '2016-08-10 05:24:36', '2016-08-31 00:00:00', 0, NULL, 1, 4),
(4, 100, 900, '2016-08-10 05:32:08', '2016-08-28 15:00:00', 0, NULL, 1, 5),
(5, 200, 3000, '2016-08-10 05:48:21', '2016-09-15 12:00:00', 0, NULL, 5, 6),
(6, 700, 1800, '2016-08-10 05:50:45', '2016-09-13 12:00:00', 0, NULL, 5, 7),
(7, 2000000, 7000000, '2016-08-10 06:04:28', '2016-10-27 00:00:00', 0, NULL, 3, 8),
(8, 100, 800, '2016-08-10 06:12:10', '2016-08-12 12:12:00', 0, NULL, 4, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `paterno` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `materno` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `edad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `foto` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `paterno`, `materno`, `edad`, `foto`, `correo`, `user`, `pass`) VALUES
(1, 'Alejandro', 'Zavala', 'Ortiz', '21', 'signup.png', 'zaoa95@gmail.com', '1330021', '1330021'),
(3, 'Angel Alejandro', 'Garcia', 'Rivera', '30', '', '1330469@upv.edu.mx', 'angel', 'angel'),
(4, 'Luis', 'Zavala', 'Ortiz', '70', 'ALEJANDROZAVALA - WIN_20140805_115508.JPG', 'luis@gmail.com', 'luis', 'luis'),
(5, 'Jose', 'Perales', 'Geronimo', '30', 'logo.png', 'pepe@gmail.com', 'pepe', 'pepe'),
(6, 'Christian', 'Hernandez', 'Hernandez', '21', 'ALEJANDROZAVALA - WIN_20140709_130308.JPG', 'pastor@gmail.com', 'pastor', 'pastor');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
