-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2022 a las 02:30:49
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mercado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abono_comision`
--

CREATE TABLE `abono_comision` (
  `id_abono_comision` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` text DEFAULT NULL,
  `total` double NOT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `abono_comision`
--

INSERT INTO `abono_comision` (`id_abono_comision`, `id_usuario`, `fecha`, `hora`, `total`, `observacion`) VALUES
(1, 1, '2022-09-02', '20:04:50', 57, 'hjg'),
(2, 1, '2022-09-24', '02:20:42', 151954, 'Ensayo abono'),
(4, 2, '2022-09-25', '00:51:42', 200000, 'Enviando a Francy y descontando 200000 puntos'),
(5, 1, '2022-09-25', '01:01:15', 900000, 'fgjhfhmndgnh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abono_pedidos`
--

CREATE TABLE `abono_pedidos` (
  `id_abono_pedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `total` double NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `abono_pedidos`
--

INSERT INTO `abono_pedidos` (`id_abono_pedido`, `idPedido`, `idCliente`, `fecha`, `hora`, `total`, `observacion`) VALUES
(1, 1, 1, '2022-09-02', '20:03:40', 10600, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_registro_caja` int(11) NOT NULL,
  `id_usuario_receptor` int(11) NOT NULL COMMENT 'id del usuario que recibe el dinero',
  `id_usuario_emisor` int(11) NOT NULL COMMENT 'id del usuario que entrega el dinero al administrador',
  `fecha` date NOT NULL,
  `hora` text DEFAULT NULL,
  `debito` double DEFAULT NULL COMMENT 'Total que ingresa',
  `credito` double DEFAULT NULL COMMENT 'Total que sale',
  `observacion_caja` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_registro_caja`, `id_usuario_receptor`, `id_usuario_emisor`, `fecha`, `hora`, `debito`, `credito`, `observacion_caja`) VALUES
(1, 1, 1, '2022-09-02', '20:04:50', NULL, 57, 'Pago comision al usuario 1'),
(2, 1, 1, '2022-09-24', '02:20:42', NULL, 151954, 'Pago comision al usuario 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_registro` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `idProducto` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `invitado` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `cantidad` double NOT NULL,
  `precio_costo` double DEFAULT NULL,
  `porcentaje` float DEFAULT NULL,
  `estado` int(1) DEFAULT 0 COMMENT '0=No enviado 1= Enviado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_registro`, `idPedido`, `idCliente`, `id_usuario`, `idProducto`, `fecha`, `invitado`, `cantidad`, `precio_costo`, `porcentaje`, `estado`) VALUES
(1, 1, 2, 2, 1, '2022-09-06', 'kv6DgK8EWGsdJHwHaq5', 6, 1800, 324, 1),
(2, 1, 2, 2, 2, '2022-09-06', 'kv6DgK8EWGsdJHwHaq5', 7, 1500, 315, 1),
(3, 1, 2, 2, 3, '2022-09-06', 'kv6DgK8EWGsdJHwHaq5', 8, 1300, 416, 1),
(4, 2, 1, 1, 3, '2022-09-06', 'eFolfO5wBpVFQFIUJET', 7, 1300, 364, 1),
(5, 3, 2, 2, 2, '2022-09-06', 'MlQ7tCHiIS9YoWxqs3I', 10, 1500, 450, 1),
(6, 3, 2, 2, 1, '2022-09-06', 'MlQ7tCHiIS9YoWxqs3I', 15, 1800, 810, 1),
(7, 3, 2, 2, 3, '2022-09-06', 'MlQ7tCHiIS9YoWxqs3I', 30, 1300, 1560, 1),
(11, NULL, NULL, 1, 1, '2022-09-10', 'jB55YDJ1bkc9SVVitBD', 6, 1800, 324, 1),
(12, 5, 1, 1, 1, '2022-09-14', '4bdRa4gR1mcwjFN4G9', 10000, 1800, 540000, 1),
(13, 5, 1, 1, 2, '2022-09-14', '4bdRa4gR1mcwjFN4G9', 30000, 1500, 1350000, 1),
(14, 5, 1, 1, 3, '2022-09-14', '4bdRa4gR1mcwjFN4G9', 5000, 1300, 260000, 1),
(15, 6, 2, 2, 1, '2022-09-17', 'vwimzrjy5JalIHWw3Ro', 10, 1800, 540, 1),
(16, 6, 2, 2, 2, '2022-09-17', 'vwimzrjy5JalIHWw3Ro', 15, 1500, 675, 1),
(17, 6, 2, 2, 3, '2022-09-17', 'vwimzrjy5JalIHWw3Ro', 20, 1300, 1040, 1),
(18, 7, 1, 1, 1, '2022-09-17', 'h1Mgu2A017DapR6NLlu', 10, 1800, 540, 1),
(19, 7, 1, 1, 2, '2022-09-17', 'h1Mgu2A017DapR6NLlu', 7, 1500, 315, 1),
(20, 7, 1, 1, 3, '2022-09-17', 'h1Mgu2A017DapR6NLlu', 9, 1300, 468, 1),
(21, 8, 2, 2, 1, '2022-09-24', 'WtvkItCqEGt7wGpFZQF', 500, 1800, 27000, 1),
(22, 8, 2, 2, 2, '2022-09-24', 'WtvkItCqEGt7wGpFZQF', 200, 1500, 9000, 1),
(23, 8, 2, 2, 3, '2022-09-24', 'WtvkItCqEGt7wGpFZQF', 250, 1300, 13000, 1),
(24, 9, 2, 2, 4, '2022-09-24', 'S6AWvmbLZFYvhC3dWs', 1300, 1200, 31200, 1),
(25, 9, 2, 2, 1, '2022-09-24', 'S6AWvmbLZFYvhC3dWs', 600, 1800, 32400, 1),
(26, 9, 2, 2, 2, '2022-09-24', 'S6AWvmbLZFYvhC3dWs', 800, 1500, 36000, 1),
(27, 9, 2, 2, 3, '2022-09-24', 'S6AWvmbLZFYvhC3dWs', 6000, 1300, 312000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id_ciudad` int(11) NOT NULL,
  `nombre_ciudad` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id_ciudad`, `nombre_ciudad`) VALUES
(1, 'Andes'),
(2, 'Ciuudad Bolivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `correo` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `cedula` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `observacion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `correo`, `cedula`, `nombre`, `telefono`, `observacion`) VALUES
(1, NULL, '3378451', 'Jorge Moncada', '3147417810', 'Altos de la circunvalar &uacute;ltimo bloque tercer piso ? Emmanuel'),
(2, NULL, '1027884154', 'Francy Sanchez', '3128449783', 'Altos de la circunvalar tercer piso ultimo bloque');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `idDepartamento` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`idDepartamento`, `nombre`, `descripcion`) VALUES
(1, 'Maiz', NULL),
(2, 'Fruver', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `titulo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `noticia` text COLLATE latin1_spanish_ci NOT NULL,
  `imagen` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `id_usuario`, `fecha_publicacion`, `titulo`, `noticia`, `imagen`) VALUES
(1, 1, '2022-08-19', 'Ensayo noticia', 'Aca ensayando que se publique la noticia', NULL),
(2, 1, '2022-08-19', 'Compra bananos', 'Se hizo convenio para comprar 500 kg de banano semanalmente con comsab', 'Ni6MnzL2uCYjawtIr8PbWY5BCYLrs-bananos.jpg'),
(3, 2, '2022-09-17', 'Entrando sin permiso', 'afsjklasslfdjkapsfmkasdf', 'MEeNXYb6I15I6VHjX4VVY7BcdSHmbD-licuadora.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL COMMENT 'Se llena si el pedido pertenece a un vendedor',
  `idCliente` int(11) NOT NULL,
  `invitado` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(1) DEFAULT 0 COMMENT '1 = Despachado',
  `id_sector` int(11) NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `id_usuario`, `idCliente`, `invitado`, `fecha`, `estado`, `id_sector`, `observacion`) VALUES
(1, 2, 2, 'kv6DgK8EWGsdJHwHaq5', '2022-09-06', 1, 1, 'Altos de la circunvalar tercer piso ultimo bloque'),
(2, 1, 1, 'eFolfO5wBpVFQFIUJET', '2022-09-06', 1, 1, 'Altos de la circunvalar &uacute;ltimo bloque tercer piso ? Emmanuel'),
(3, 2, 2, 'MlQ7tCHiIS9YoWxqs3I', '2022-09-06', 1, 1, 'Altos de la circunvalar tercer piso ultimo bloque'),
(5, 1, 1, '4bdRa4gR1mcwjFN4G9', '2022-09-14', 1, 1, 'Altos de la circunvalar &uacute;ltimo bloque tercer piso ? Emmanuel'),
(6, 2, 2, 'vwimzrjy5JalIHWw3Ro', '2022-09-17', 1, 1, 'Altos de la circunvalar tercer piso ultimo bloque'),
(7, 1, 1, 'h1Mgu2A017DapR6NLlu', '2022-09-17', 1, 1, 'Altos de la circunvalar &uacute;ltimo bloque tercer piso ? Emmanuel'),
(8, 2, 2, 'WtvkItCqEGt7wGpFZQF', '2022-09-24', 1, 1, 'Altos de la circunvalar tercer piso ultimo bloque'),
(9, 2, 2, 'S6AWvmbLZFYvhC3dWs', '2022-09-24', 1, 1, 'Altos de la circunvalar tercer piso ultimo bloque');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premios`
--

CREATE TABLE `premios` (
  `id_premio` int(11) NOT NULL,
  `nombre_premio` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `puntos` int(11) NOT NULL,
  `imagen` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `premios`
--

INSERT INTO `premios` (`id_premio`, `nombre_premio`, `puntos`, `imagen`) VALUES
(1, 'Licuadora Oster', 75000, 'zEStSnMpc3CvJd6VzCEUyJo0c25QYr-licuadora.png'),
(4, 'Olla arrocera', 125000, 'qhke50vdrhXpYuyEBNVx7JDZWEJG1-ARROCERA.png'),
(5, 'Olla a presion', 200000, 'uR1LNmmV9MBxaqUjBGmg8l659BBGN-olla a presion.png'),
(6, 'Lavadora', 900000, 'IAPWp1kfMhl1nDMWKeGAgp3gw4mih-lavadora.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `idDepartamento` int(11) DEFAULT NULL,
  `idSubdepartamento` int(11) DEFAULT NULL,
  `nombre_producto` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `unidad` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `porcentaje` double DEFAULT NULL,
  `descripcion` varchar(300) COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `estado` int(1) DEFAULT NULL COMMENT '0 = No disponible, 1 = Disponible',
  `cantidad` double DEFAULT NULL,
  `promocion` int(1) DEFAULT 0 COMMENT '0 = no, 1 = si'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `idDepartamento`, `idSubdepartamento`, `nombre_producto`, `precio`, `unidad`, `porcentaje`, `descripcion`, `imagen`, `estado`, `cantidad`, `promocion`) VALUES
(1, 1, 1, 'Arepas de queso', 1800, 'paquete por 5', 3, 'Paquete de arepas de queso por 5 unidades', 'PqX9vaXTERL4hUJZePrtliirzTczVN-arepas de queso.jpg', 1, NULL, 0),
(2, 1, 1, 'Arepas Sonsone&ntilde;as', 1500, 'paquete por 5', 3, 'Paquete arepas blancas por 5 unidades', 'DYYXs4mli6Qln7FkfQQVbFizbOD-sonsoneñas.jpg', 1, NULL, 0),
(3, 1, 1, 'Arepas tipo tela', 1300, 'Paquete por 15 unidades', 4, 'Paquete arepas por 15 unidades', 'xPnw3xbfale4mNLhIhoa2S56IpybhX-arepas de tela.jpg', 1, NULL, 1),
(4, 2, 2, 'Banano', 1200, 'kilo', 2, 'Bananos verdes o maduros', 'BJCmjIGtFZMYXgchdo4g5OurxnbX2-bananos.jpg', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recaudos`
--

CREATE TABLE `recaudos` (
  `id_recaudo` int(11) NOT NULL,
  `id_abono_pedido` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `fecha_recaudo` date NOT NULL,
  `hora_recaudo` text NOT NULL,
  `total_recaudo` double DEFAULT NULL,
  `abono_recaudo` double DEFAULT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recaudos`
--

INSERT INTO `recaudos` (`id_recaudo`, `id_abono_pedido`, `id_usuario`, `idCliente`, `idPedido`, `fecha_recaudo`, `hora_recaudo`, `total_recaudo`, `abono_recaudo`, `observacion`) VALUES
(1, 1, 1, 1, 1, '2022-09-02', '20:03:40', 10600, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redenciones`
--

CREATE TABLE `redenciones` (
  `id_redencion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time DEFAULT NULL,
  `total` float NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No redimido, 1 = Redimido',
  `observacion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `redenciones`
--

INSERT INTO `redenciones` (`id_redencion`, `id_usuario`, `id_producto`, `fecha`, `hora`, `total`, `estado`, `observacion`) VALUES
(2, 1, 6, '2022-09-15', '02:18:15', 900000, 0, 'fgjhfhmndgnh'),
(3, 2, 1, '2022-09-24', '23:32:44', 75000, 0, 'ESTOY ENSAYANDO PARA VER QUE SI DESPACHE'),
(4, 2, 5, '2022-09-24', '23:38:05', 200000, 1, 'Enviando a Francy y descontando 200000 puntos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id_sector` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `nombre_sector` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id_sector`, `id_ciudad`, `nombre_sector`, `observacion`) VALUES
(1, 1, 'Zona urbana', 'Probando lo del sector'),
(2, 2, 'Ciudad bolivar urbana', 'Zona urbana de ciudad bolivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subdepartamento`
--

CREATE TABLE `subdepartamento` (
  `idSubdepartamento` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `subdepartamento`
--

INSERT INTO `subdepartamento` (`idSubdepartamento`, `idDepartamento`, `nombre`, `descripcion`) VALUES
(1, 1, 'Arepas', NULL),
(2, 2, 'Frutas', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `correo_usuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_usuario` text COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nivel` int(11) DEFAULT NULL COMMENT '3=Super admin, 2=Vendedores, 1=repartidores',
  `intentos` int(1) DEFAULT NULL,
  `estado` int(11) DEFAULT 1 COMMENT '0 = inactivo, 1 = Activo\r\n',
  `clave_admin` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `id_sector` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo_usuario`, `nombre_usuario`, `clave`, `nivel`, `intentos`, `estado`, `clave_admin`, `id_ciudad`, `fecha_registro`, `id_sector`) VALUES
(1, '3378451', 'Jorge Moncada', '$2y$10$XWyIpsLY7RetX6nS9T4TPecI5xZDlN5Ie14mn5uvyGigahDHOZxlq', 3, 0, 1, NULL, NULL, NULL, 0),
(2, '1027884154', 'Francy Sanchez', '$2y$10$XWyIpsLY7RetX6nS9T4TPecI5xZDlN5Ie14mn5uvyGigahDHOZxlq', 2, 0, 1, NULL, NULL, NULL, 0),
(3, '562222', 'Pepito', '$2y$10$PVJLYkpjpk825/p7cX9fmuaRxlm5V30wRl/.6u4pZKs2Q3GFbZzkq', 2, NULL, 1, NULL, NULL, '2022-08-26', 0),
(4, '565656', 'ruperto', '$2y$10$xmaXfr0lopr9XoPQI2cekOztmsqP/AFvSNXAYy1Kibgsi6D/gm5Lu', 2, NULL, 1, NULL, NULL, '2022-08-28', 0),
(5, '123456', '123456', '$2y$10$42SG72qA0SxBN5ENJZ.8D.8p1.WwtfBnYgI4FKmUhJMSsohcGE/DO', 2, NULL, 1, NULL, NULL, '2022-08-28', 0),
(6, '9875', '9875', '$2y$10$BDpcCw.RVmbyIQR.FjfTi.flcrxCXOJ3ApWL9GoPXbPGWiLu4vvhW', 2, NULL, 1, NULL, NULL, '2022-08-28', 1),
(7, '7777777', 'PAblo Perez', '$2y$10$EAv35w8kyM7Y8kEiXgPbpu/nPIejP.GFx8cvyUqzHMIhGdRG4aqA.', 2, NULL, 1, NULL, NULL, '2022-08-30', 2),
(8, '9632547852', 'Maria', '$2y$10$2VHgLal06lqspgMhclQ9OeJ29lLeKgzKrR68yjKOJ5LF4865L3Xc.', 2, NULL, 1, NULL, NULL, '2022-09-03', 1),
(9, '7777777777', 'poiuyyt', '$2y$10$p99xkeWy9gsU3ERekd0EU.2Flt6NPqJEcx81C0Uoy8PTtCnBwouEC', 2, NULL, 1, NULL, NULL, '2022-09-15', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abono_comision`
--
ALTER TABLE `abono_comision`
  ADD PRIMARY KEY (`id_abono_comision`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `abono_pedidos`
--
ALTER TABLE `abono_pedidos`
  ADD PRIMARY KEY (`id_abono_pedido`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_registro_caja`),
  ADD KEY `id_usuario_receptor` (`id_usuario_receptor`),
  ADD KEY `id_usuario_emisor` (`id_usuario_emisor`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `invitado` (`invitado`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `cedula_cliente` (`idCliente`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `cedula` (`cedula`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD UNIQUE KEY `invitado` (`invitado`) USING BTREE,
  ADD KEY `cedula_cliente` (`idCliente`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `id_sector` (`id_sector`);

--
-- Indices de la tabla `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`id_premio`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idDepartamento` (`idDepartamento`),
  ADD KEY `idSubdepartamento` (`idSubdepartamento`),
  ADD KEY `promocion` (`promocion`),
  ADD KEY `cantidad` (`cantidad`),
  ADD KEY `nombre_producto` (`nombre_producto`);

--
-- Indices de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  ADD PRIMARY KEY (`id_recaudo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fecha_recaudo` (`fecha_recaudo`),
  ADD KEY `id_abono_pedido` (`id_abono_pedido`);

--
-- Indices de la tabla `redenciones`
--
ALTER TABLE `redenciones`
  ADD PRIMARY KEY (`id_redencion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id_sector`),
  ADD UNIQUE KEY `nombre_sector` (`nombre_sector`),
  ADD UNIQUE KEY `id_ciudad` (`id_ciudad`,`nombre_sector`);

--
-- Indices de la tabla `subdepartamento`
--
ALTER TABLE `subdepartamento`
  ADD PRIMARY KEY (`idSubdepartamento`),
  ADD KEY `idDepartamento` (`idDepartamento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`),
  ADD KEY `estado` (`estado`),
  ADD KEY `id_ciudad` (`id_ciudad`),
  ADD KEY `fecha_registro` (`fecha_registro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abono_comision`
--
ALTER TABLE `abono_comision`
  MODIFY `id_abono_comision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `abono_pedidos`
--
ALTER TABLE `abono_pedidos`
  MODIFY `id_abono_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_registro_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `premios`
--
ALTER TABLE `premios`
  MODIFY `id_premio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  MODIFY `id_recaudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `redenciones`
--
ALTER TABLE `redenciones`
  MODIFY `id_redencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id_sector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `subdepartamento`
--
ALTER TABLE `subdepartamento`
  MODIFY `idSubdepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
