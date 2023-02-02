-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2021 a las 17:26:56
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repartos`
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
(1, 6, 2, '2021-11-22', '17:01:32', 2700, '');

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
(1, 1, 4, '2021-11-22', '17:03:39', 10000, NULL, 'Recepcion recaudo del usuario 4'),
(2, 1, 4, '2021-11-22', '17:05:30', NULL, 3000, 'Pago comision al usuario 4'),
(4, 1, 4, '2021-11-22', '17:07:41', 2000, NULL, 'Recepcion recaudo del usuario 4'),
(5, 1, 4, '2021-11-22', '17:09:59', NULL, 3000, 'Pago comision al usuario 4'),
(6, 1, 4, '2021-11-22', '17:15:34', 3000, NULL, 'Devolucion registro de comision'),
(7, 1, 4, '2021-11-22', '17:16:25', 700, NULL, 'Recepcion recaudo del usuario 4'),
(9, 1, 4, '2021-11-22', '17:18:31', 700, NULL, 'Recepcion recaudo del usuario 4'),
(10, 1, 4, '2021-11-22', '17:19:38', 0, 700, 'Eliminacion de recaudo'),
(11, 1, 4, '2021-11-22', '17:22:27', 10000, 0, 'Eliminacion de recaudo');

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
  `estado` int(1) DEFAULT NULL COMMENT '1=No enviado 2= Enviado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_registro`, `idPedido`, `idCliente`, `id_usuario`, `idProducto`, `fecha`, `invitado`, `cantidad`, `precio_costo`, `porcentaje`, `estado`) VALUES
(1, 1, 1, 1, 1, '2021-10-01', 'c6OeYnQIJGQm6nIeVIz', 10, 1200, 480, 0),
(2, 1, 1, 1, 3, '2021-10-01', 'c6OeYnQIJGQm6nIeVIz', 5, 3000, 1500, 0),
(3, 1, 1, 1, 6, '2021-10-01', 'c6OeYnQIJGQm6nIeVIz', 8, 750, 540, 0),
(4, 1, 1, 1, 2, '2021-10-01', 'c6OeYnQIJGQm6nIeVIz', 4, 1500, 180, 0),
(5, 1, 1, 1, 4, '2021-10-01', 'c6OeYnQIJGQm6nIeVIz', 3, 2000, 300, 0),
(6, 2, 2, 1, 1, '2021-10-01', 'ojPMzkqDLbCpdBGvd2U', 10, 1200, 480, 0),
(7, 2, 2, 1, 3, '2021-10-01', 'ojPMzkqDLbCpdBGvd2U', 20, 3000, 6000, 0),
(8, 2, 2, 1, 6, '2021-10-01', 'ojPMzkqDLbCpdBGvd2U', 30, 750, 2025, 0),
(9, 3, 1, 1, 6, '2021-10-09', 'Od9JPtIV5jBxlEdVOnp', 10, 750, 675, 0),
(10, 3, 1, 1, 7, '2021-10-09', 'Od9JPtIV5jBxlEdVOnp', 6, 1500, 900, 0),
(11, 3, 1, 1, 2, '2021-10-09', 'Od9JPtIV5jBxlEdVOnp', 8, 1500, 360, 0),
(16, 5, 2, 1, 1, '2021-10-09', 'NB8oNnewf9EDmLspn0', 3, 1200, 144, 0),
(17, 5, 2, 1, 6, '2021-10-09', 'NB8oNnewf9EDmLspn0', 9, 750, 607.5, 0),
(18, 5, 2, 1, 4, '2021-10-09', 'NB8oNnewf9EDmLspn0', 4, 2000, 400, 0),
(19, 6, 2, 4, 1, '2021-10-17', 'YH4yo0yJ4ShASDCmieA', 36, 1200, 1728, 0),
(20, 6, 2, 4, 3, '2021-10-17', 'YH4yo0yJ4ShASDCmieA', 5, 3000, 1500, 0),
(21, 6, 2, 4, 6, '2021-10-17', 'YH4yo0yJ4ShASDCmieA', 6, 750, 405, 0),
(22, 7, 3, 1, 2, '2021-10-20', 'a3bFlTq5sS5uMrQQvsz', 4, 1500, 180, 0),
(23, 7, 3, 1, 5, '2021-10-20', 'a3bFlTq5sS5uMrQQvsz', 3, 1350, 324, 0),
(24, 7, 3, 1, 4, '2021-10-20', 'a3bFlTq5sS5uMrQQvsz', 1, 2000, 100, 0),
(25, 8, 4, 1, 7, '2021-10-20', 'akpelnBiBX9yXR4hmBi', 10, 1500, 1500, 0),
(26, 8, 4, 1, 3, '2021-10-20', 'akpelnBiBX9yXR4hmBi', 3, 3000, 900, 0),
(27, 9, 3, 1, 4, '2021-10-20', '9GhyNJe0iPNETpzOU79', 3, 2000, 300, 0),
(28, 9, 3, 1, 2, '2021-10-20', '9GhyNJe0iPNETpzOU79', 10, 1500, 450, 0),
(29, 9, 3, 1, 5, '2021-10-20', '9GhyNJe0iPNETpzOU79', 8, 1350, 864, 0),
(30, 9, 3, 1, 3, '2021-10-20', '9GhyNJe0iPNETpzOU79', 4, 3000, 1200, 0),
(31, 9, 3, 1, 1, '2021-10-20', '9GhyNJe0iPNETpzOU79', 6, 1200, 288, 0),
(32, 9, 3, 1, 6, '2021-10-20', '9GhyNJe0iPNETpzOU79', 1, 750, 67.5, 0),
(33, 10, 4, 1, 1, '2021-10-20', 'sS2r1zHT5DwlQSYZxt3', 5, 1200, 240, 0),
(34, 10, 4, 1, 3, '2021-10-20', 'sS2r1zHT5DwlQSYZxt3', 3, 3000, 900, 0),
(35, 10, 4, 1, 6, '2021-10-20', 'sS2r1zHT5DwlQSYZxt3', 4, 750, 270, 0),
(36, 10, 4, 1, 2, '2021-10-20', 'sS2r1zHT5DwlQSYZxt3', 4, 1500, 180, 0);

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
(1, NULL, '1027884154', 'Carlos Mario Moncada', '3117778850', 'Vegachi'),
(2, NULL, '785296325', 'Eider Sanchez', '32385646', 'Junto a arepas Angela'),
(3, NULL, '3378451', 'Jorge Eliecer Moncada', '3147417810', 'La esperanza san Bartolo'),
(4, NULL, '10278841544', 'Francy Milena Sanchez', '54546325', 'S.Bartolo');

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
(1, 'Fruver', NULL),
(2, 'Arepas', NULL);

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
  `observacion` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `id_usuario`, `idCliente`, `invitado`, `fecha`, `estado`, `observacion`) VALUES
(1, 1, 1, 'c6OeYnQIJGQm6nIeVIz', '2021-10-01', 1, 'Enviar a Vegach&iacute; Antioquia barrio el departamento'),
(2, 1, 2, 'ojPMzkqDLbCpdBGvd2U', '2021-10-01', 0, 'Arepas Angela una cuadra mas abajo'),
(3, 1, 1, 'Od9JPtIV5jBxlEdVOnp', '2021-10-09', 1, 'Vegachi'),
(5, 1, 2, 'NB8oNnewf9EDmLspn0', '2021-10-09', 0, 'Ensayando nuevamente otro pedido'),
(6, 4, 2, 'YH4yo0yJ4ShASDCmieA', '2021-10-17', 1, 'Junto a arepas Angela'),
(7, 1, 3, 'a3bFlTq5sS5uMrQQvsz', '2021-10-20', 0, 'La monta&ntilde;ita San Bartolo'),
(8, 1, 4, 'akpelnBiBX9yXR4hmBi', '2021-10-20', 0, 'En la finca de Kiko En san bartolo'),
(9, 1, 3, '9GhyNJe0iPNETpzOU79', '2021-10-20', 0, 'La esperanza san Bartolo'),
(10, 1, 4, 'sS2r1zHT5DwlQSYZxt3', '2021-10-20', 0, 'S.Bartolo');

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
(1, 1, 1, 'Papaya', 1200, 'kilo', 4, 'Ensayando la carga de productos nuevos', 'kVITVKBLD6DeFrUKZvfdTIBPnTmfG-papaya.jpg', 1, NULL, 1),
(2, 1, 2, 'Tomate', 1500, 'Libra', 3, 'Tomate chonto bien bonito', 'n51JUswRZxkr8EkGiCAzbeF4I7lXlR-tomates.jpg', 1, NULL, 0),
(3, 1, 1, 'Uvas', 3000, 'Libra', 10, 'Uvas chilenas', 'HUjp3JZFLcCrAvFRqVU4uOpw5Pq7o-uvas.jpg', 1, NULL, 0),
(4, 1, 2, 'Lechuga', 2000, 'libra', 5, 'Lechuga redonda', 'UbTHkNZifWOldpgMEhpjTMK95T30B-lechuga.jpg', 1, NULL, 0),
(5, 1, 2, 'Rrepollo', 1350, 'Libra', 8, 'Repollo blanco, no morado', 'VgnF1O4J5BAUJ6hWzj1IAuA5Nifpb-repollo.jpg', 1, NULL, 1),
(6, 1, 1, 'Manzana roja', 750, 'Libra', 9, 'Manzanas rojas muy muy bonitas', 'S69nx8IjddiGh6gDocFO6CEHybcb5-manzana_roja.jpg', 1, NULL, 1),
(7, 2, 3, 'Arepas blancas redondas', 1500, 'paquete', 10, 'Arepas blancas x 6 unidades', '1wLPOfQAIXYvP90Ko7gpUTHbaQHck-arepas.jpg', 1, NULL, 0);

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
(1, 1, 4, 2, 6, '2021-11-22', '17:01:32', 2700, NULL, NULL),
(3, NULL, 4, NULL, NULL, '2021-11-22', '17:03:39', NULL, 10000, ''),
(4, NULL, 4, NULL, NULL, '2021-11-22', '17:07:41', NULL, 2000, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id_sector` int(11) NOT NULL,
  `nombre_sector` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id_sector`, `nombre_sector`, `observacion`) VALUES
(4, 'Andes', 'Otro ensayo');

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
(1, 1, 'Frutas', NULL),
(2, 1, 'Verduras', NULL),
(3, 2, 'Arepas blancas redondas', NULL);

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
  `clave_admin` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo_usuario`, `nombre_usuario`, `clave`, `nivel`, `intentos`, `estado`, `clave_admin`) VALUES
(1, 'jelmo29@hotmail.com', 'Jorge Eliecer Moncada', '$2y$10$A3HTB2m3pweaVkJad54ah.9otECqkhGRg/tBDDIK.y/2HAJT87UxW', 3, 0, 0, '963852741'),
(4, 'frami19@hotmail.com', 'Francy Sanchez', '$2y$10$vXgHs.9xfaqfn6jt/H46iOthgz0d8jAFWGeUJlS1CXqCC4kw3WMzW', 2, 0, 1, NULL);

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
  ADD KEY `id_usuario` (`id_usuario`);

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
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD UNIQUE KEY `invitado` (`invitado`) USING BTREE,
  ADD KEY `cedula_cliente` (`idCliente`),
  ADD KEY `fecha` (`fecha`);

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
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id_sector`),
  ADD UNIQUE KEY `nombre_sector` (`nombre_sector`);

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
  ADD KEY `estado` (`estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abono_comision`
--
ALTER TABLE `abono_comision`
  MODIFY `id_abono_comision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `abono_pedidos`
--
ALTER TABLE `abono_pedidos`
  MODIFY `id_abono_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_registro_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  MODIFY `id_recaudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id_sector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `subdepartamento`
--
ALTER TABLE `subdepartamento`
  MODIFY `idSubdepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
