-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 22-04-2022 a las 17:03:00
-- Versión del servidor: 10.6.4-MariaDB-1:10.6.4+maria~focal
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autogest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busca_cliente`
--

CREATE TABLE `busca_cliente` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busca_pedido`
--

CREATE TABLE `busca_pedido` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busca_producto`
--

CREATE TABLE `busca_producto` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busca_usuario`
--

CREATE TABLE `busca_usuario` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_via` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_via` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_via` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puerta` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tfno` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cif` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_alta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre_departamento` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre_departamento`, `role`) VALUES
(1, 'Administración', 'ROLE_ADMIN'),
(2, 'Recambios', 'ROLE_RECAMBIOS'),
(3, 'Taller', 'ROLE_TALLER'),
(4, 'Comercial', 'ROLE_COMERCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `id` int(11) NOT NULL,
  `tipo_familia` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_familia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`id`, `tipo_familia`, `nombre_familia`) VALUES
(1, 'AC', 'Aceites'),
(2, 'CH', 'Chapa'),
(3, 'MC', 'Mecánica'),
(4, 'PN', 'Pintura'),
(5, 'ACC', 'Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_call_center`
--

CREATE TABLE `pedido_call_center` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cuenta_cliente` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `telefono1` int(11) DEFAULT NULL,
  `cif` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vin` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id` int(11) NOT NULL,
  `pedido_call_center_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `referencia` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` smallint(6) NOT NULL,
  `dto` decimal(6,2) NOT NULL,
  `neto` decimal(11,2) NOT NULL,
  `total_pvp` decimal(11,2) NOT NULL,
  `total_dto` decimal(11,2) NOT NULL,
  `total_neto` decimal(11,2) NOT NULL,
  `total_iva` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `referencia` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familia` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pvp` decimal(9,2) NOT NULL,
  `marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `almacen` smallint(6) NOT NULL,
  `marca` smallint(6) NOT NULL,
  `referencia` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(9,2) NOT NULL,
  `ubicacion` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estado`
--

CREATE TABLE `tipo_estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_estado`
--

INSERT INTO `tipo_estado` (`id`, `estado`) VALUES
(1, 'PENDIENTE'),
(2, 'PRESUPUESTO'),
(3, 'FINALIZADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `foto`, `departamento`, `confirm_password`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$qxmnNr6VM1GJ9Uz/l0W3YeoH5Ix3JYYMxlWUJdjJE47jozr7K.1PK', 'administrador', 'administrador', 'administrador', 'admin@admin.com', 'administrador-62097d27d1da0.jpg', 'Administración', '$2y$13$qxmnNr6VM1GJ9Uz/l0W3YeoH5Ix3JYYMxlWUJdjJE47jozr7K.1PK');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `busca_cliente`
--
ALTER TABLE `busca_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `busca_pedido`
--
ALTER TABLE `busca_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `busca_producto`
--
ALTER TABLE `busca_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `busca_usuario`
--
ALTER TABLE `busca_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F41C9B25A53EB8E8` (`cif`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ECB632C5DE734E51` (`cliente_id`);

--
-- Indices de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A56BD82B3E57D3BF` (`pedido_call_center_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A7BB0615C01213D8` (`referencia`),
  ADD UNIQUE KEY `UNIQ_A7BB0615DCD6110` (`stock_id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4B365660C01213D8` (`referencia`);

--
-- Indices de la tabla `tipo_estado`
--
ALTER TABLE `tipo_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `busca_cliente`
--
ALTER TABLE `busca_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `busca_pedido`
--
ALTER TABLE `busca_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `busca_producto`
--
ALTER TABLE `busca_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `busca_usuario`
--
ALTER TABLE `busca_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `familia`
--
ALTER TABLE `familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_estado`
--
ALTER TABLE `tipo_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  ADD CONSTRAINT `FK_ECB632C5DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Filtros para la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `FK_A56BD82B3E57D3BF` FOREIGN KEY (`pedido_call_center_id`) REFERENCES `pedido_call_center` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB0615DCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
