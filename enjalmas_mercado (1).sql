-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-08-2022 a las 19:21:52
-- Versión del servidor: 10.3.35-MariaDB-cll-lve
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `enjalmas_mercado`
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
(1, 2, '2022-08-15', '09:05:35', 3000, 'redimio puntos, regalo');

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
(1, 1, 1, '2022-08-01', '16:30:09', 32400, ''),
(2, 3, 3, '2022-08-02', '16:02:57', 3600, ''),
(3, 2, 2, '2022-08-03', '15:59:49', 3600, ''),
(4, 7, 3, '2022-08-05', '14:50:00', 9000, ''),
(5, 4, 4, '2022-08-05', '15:17:37', 3600, ''),
(6, 5, 5, '2022-08-05', '15:17:57', 1800, ''),
(7, 6, 6, '2022-08-05', '15:18:20', 1800, '');

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
(1, 1, 2, '2022-08-15', '09:05:35', NULL, 3000, 'Pago comision al usuario 2');

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
(4, 1, 1, 2, 1, '2022-08-01', 'LepSaSPwPvLxOPEA6Dg', 18, 1800, 3564, 0),
(5, 2, 2, NULL, 1, '2022-08-02', 'f3p1zoke0MLlSCUQ9M', 2, 1800, 396, 0),
(6, 3, 3, 2, 1, '2022-08-02', 'WWGfYF49BASmjIlnYiW', 2, 1800, 396, 0),
(8, 4, 4, 4, 1, '2022-08-03', 'JxMm5GJbOqKUuMmcBb', 2, 1800, 396, 0),
(9, 5, 5, 4, 1, '2022-08-03', 'mM3By7x81QazjvSEbzv', 1, 1800, 198, 0),
(10, 6, 6, 4, 1, '2022-08-03', 'XbofbOml8Rsdn0jSkw', 1, 1800, 198, 0),
(11, 7, 3, 1, 1, '2022-08-05', 'DwBMiTTx1YvW9P6D90J', 5, 1800, 990, 0),
(12, NULL, NULL, 1, 1, '2022-08-15', 'NWnjg3Kzs3CcGxLSmJf', 3, 1800, 594, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id_ciudad` int(11) NOT NULL,
  `nombre_ciudad` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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
(1, NULL, '43287926', 'Sandra Patricia Cuadros', '3116630357', 'Corregimiento Santa Rita\r\nDespachar en la escalera San Pedro Santa Rita a las 5pm'),
(2, NULL, '1036668467', 'BRAYAN VALLE ', '3007444471', 'Carrera 50 # 51 - 22. Edificio Colombia. Apartamento 201. Reja negra, al Lado del colegio San Juan de los Andes.'),
(3, NULL, '1027891999', 'Darwin', '123', 'oficina'),
(4, NULL, '43283610', 'Luz Dary Villada ', '3222270922', 'Barrio Nuevo de Aguada (Berta Martinez)\r\n3 bloque segundo piso '),
(5, NULL, '1078636182', 'Monica Andrea Okendo', '3207404668', 'Barrio Nuevo de la Aguada (Berta Martinez) 1 mer bloque entrando cuarta casa '),
(6, NULL, '43284703', 'Beatriz Elena Gutierrez ', '3127777102', 'Barrio Nuevo de la Aguada (Berta Martinez )\r\n1 mer bloque segundo piso apartamento 207');

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
(1, 'Producto terminado', NULL);

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
(1, 2, 1, 'LepSaSPwPvLxOPEA6Dg', '2022-08-01', 1, 0, 'Corregimiento Santa Rita\r\nDespachar en la escalera San Pedro Santa Rita a las 5pm'),
(2, NULL, 2, 'f3p1zoke0MLlSCUQ9M', '2022-08-02', 1, 0, 'Carrera 50 # 51 - 22. Edificio Colombia. Apartamento 201. Reja negra, al Lado del colegio San Juan de los Andes.'),
(3, 2, 3, 'WWGfYF49BASmjIlnYiW', '2022-08-02', 1, 0, 'oficina'),
(4, 4, 4, 'JxMm5GJbOqKUuMmcBb', '2022-08-03', 1, 0, 'Barrio Nuevo de Aguada (Berta Martinez)\r\n3 bloque segundo piso '),
(5, 4, 5, 'mM3By7x81QazjvSEbzv', '2022-08-03', 1, 0, 'Barrio Nuevo de la Aguada (Berta Martinez) 1 mer bloque entrando cuarta casa '),
(6, 4, 6, 'XbofbOml8Rsdn0jSkw', '2022-08-03', 1, 0, 'Barrio Nuevo de la Aguada (Berta Martinez )\r\n1 mer bloque segundo piso apartamento 207'),
(7, 1, 3, 'DwBMiTTx1YvW9P6D90J', '2022-08-05', 1, 0, 'oficina');

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
(1, 1, 1, 'Arepa tipo tela', 1800, 'Paquete x5 unidades', 11, 'Arepa campesina tipo tela, en presentacion de paquete por 5 unidades', 'p1LH17rm45ZnEAmj7lkA2ncKIE0R-Imagen1.jpg', 1, NULL, 0);

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
(1, 1, 2, 1, 1, '2022-08-01', '16:30:09', 32400, NULL, NULL),
(2, 2, 2, 3, 3, '2022-08-02', '16:02:57', 3600, NULL, NULL),
(3, 3, 1, 2, 2, '2022-08-03', '15:59:49', 3600, NULL, NULL),
(4, 4, 1, 3, 7, '2022-08-05', '14:50:00', 9000, NULL, NULL),
(5, 5, 1, 4, 4, '2022-08-05', '15:17:37', 3600, NULL, NULL),
(6, 6, 1, 5, 5, '2022-08-05', '15:17:57', 1800, NULL, NULL),
(7, 7, 1, 6, 6, '2022-08-05', '15:18:20', 1800, NULL, NULL);

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
(1, 1, 'Arepas', NULL);

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
  `id_ciudad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo_usuario`, `nombre_usuario`, `clave`, `nivel`, `intentos`, `estado`, `clave_admin`, `id_ciudad`) VALUES
(1, 'frutosdelcampoandes@gmail.com', 'Administrador', '$2y$10$XxTXvxVKBKOe8DgFMbpPvuJi9TRCOswHcj66/oOcAzu7dhxJFORM6', 3, 0, 1, NULL, NULL),
(2, 'neyibias@gmail.com', 'Nayibia Serna Velez', '$2y$10$hgCoj6p.7PIbjqGdmoLiNuFRpfYnZQTAj4wTk1wY3mPdIPT8SQdsm', 2, 0, 1, NULL, NULL),
(3, 'alba16607@gmail.com', 'Alba Nelly Zapata', '$2y$10$VDF2k7YcFBCOK7VTQES0GOftMjh5VF4HKz183nxy2jd7XIONLR4tG', 2, 0, 1, NULL, NULL),
(4, 'anvefi23@hotmail.com', 'Angela Patricia Figueroa', '$2y$10$mjAEEq8/K1FcR93/51JfA..6TWABN75mog3xbXeWDyAfgwEm3sfGW', 2, 0, 1, NULL, NULL);

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
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD UNIQUE KEY `invitado` (`invitado`) USING BTREE,
  ADD KEY `cedula_cliente` (`idCliente`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `id_sector` (`id_sector`);

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
  ADD KEY `id_ciudad` (`id_ciudad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abono_comision`
--
ALTER TABLE `abono_comision`
  MODIFY `id_abono_comision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `abono_pedidos`
--
ALTER TABLE `abono_pedidos`
  MODIFY `id_abono_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_registro_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  MODIFY `id_recaudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id_sector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subdepartamento`
--
ALTER TABLE `subdepartamento`
  MODIFY `idSubdepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
