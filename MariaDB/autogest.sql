-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 11, 2025 at 06:48 PM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autogest`
--

-- --------------------------------------------------------

--
-- Table structure for table `busca_cliente`
--

CREATE TABLE `busca_cliente` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) DEFAULT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `busca_pedido`
--

CREATE TABLE `busca_pedido` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) DEFAULT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `busca_producto`
--

CREATE TABLE `busca_producto` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) NOT NULL,
  `valor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `busca_usuario`
--

CREATE TABLE `busca_usuario` (
  `id` int(11) NOT NULL,
  `selecciona` varchar(50) DEFAULT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(60) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido1` varchar(20) DEFAULT NULL,
  `apellido2` varchar(20) DEFAULT NULL,
  `tipo_via` varchar(4) NOT NULL,
  `nombre_via` varchar(60) NOT NULL,
  `codigo_postal` varchar(5) NOT NULL,
  `num_via` varchar(5) DEFAULT NULL,
  `puerta` varchar(3) DEFAULT NULL,
  `localidad` varchar(60) NOT NULL,
  `provincia` varchar(60) NOT NULL,
  `tfno` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cif` varchar(10) NOT NULL,
  `fecha_alta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre_departamento` varchar(30) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre_departamento`, `role`) VALUES
(1, 'Administración', 'ROLE_ADMIN'),
(2, 'Recambios', 'ROLE_RECAMBIOS'),
(3, 'Taller', 'ROLE_TALLER'),
(4, 'Comercial', 'ROLE_COMERCIAL');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `familia`
--

CREATE TABLE `familia` (
  `id` int(11) NOT NULL,
  `tipo_familia` varchar(3) NOT NULL,
  `nombre_familia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `familia`
--

INSERT INTO `familia` (`id`, `tipo_familia`, `nombre_familia`) VALUES
(1, 'AC', 'Aceites'),
(2, 'CH', 'Chapa'),
(3, 'MC', 'Mecánica'),
(4, 'PN', 'Pintura'),
(5, 'ACC', 'Accesorios');

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido_call_center`
--

CREATE TABLE `pedido_call_center` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cuenta_cliente` varchar(10) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `contacto` varchar(30) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `telefono1` int(11) DEFAULT NULL,
  `cif` varchar(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `localidad` varchar(60) NOT NULL,
  `comentario` longtext DEFAULT NULL,
  `vin` varchar(30) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id` int(11) NOT NULL,
  `pedido_call_center_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `referencia` varchar(13) DEFAULT NULL,
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
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `familia` varchar(20) NOT NULL,
  `pvp` decimal(9,2) NOT NULL,
  `marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `almacen` smallint(6) NOT NULL,
  `marca` smallint(6) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `cantidad` decimal(9,2) NOT NULL,
  `ubicacion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_estado`
--

CREATE TABLE `tipo_estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipo_estado`
--

INSERT INTO `tipo_estado` (`id`, `estado`) VALUES
(1, 'PENDIENTE'),
(2, 'PRESUPUESTO'),
(3, 'FINALIZADO');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `departamento` varchar(30) DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `foto`, `departamento`, `confirm_password`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$2asESJlO74KAJhnRE0bjHeXX4EUnT0sVn3wVkJj8ZThOJFjqwhp1q', 'administrador', 'administrador', 'administrador', 'admin@admin.com', 'administrador-62097d27d1da0.jpg', 'Administración', '$2y$13$2asESJlO74KAJhnRE0bjHeXX4EUnT0sVn3wVkJj8ZThOJFjqwhp1q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `busca_cliente`
--
ALTER TABLE `busca_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `busca_pedido`
--
ALTER TABLE `busca_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `busca_producto`
--
ALTER TABLE `busca_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `busca_usuario`
--
ALTER TABLE `busca_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F41C9B25A53EB8E8` (`cif`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ECB632C5DE734E51` (`cliente_id`);

--
-- Indexes for table `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A56BD82B3E57D3BF` (`pedido_call_center_id`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A7BB0615C01213D8` (`referencia`),
  ADD UNIQUE KEY `UNIQ_A7BB0615DCD6110` (`stock_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4B365660C01213D8` (`referencia`);

--
-- Indexes for table `tipo_estado`
--
ALTER TABLE `tipo_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `busca_cliente`
--
ALTER TABLE `busca_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `busca_pedido`
--
ALTER TABLE `busca_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `busca_producto`
--
ALTER TABLE `busca_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `busca_usuario`
--
ALTER TABLE `busca_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `familia`
--
ALTER TABLE `familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipo_estado`
--
ALTER TABLE `tipo_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pedido_call_center`
--
ALTER TABLE `pedido_call_center`
  ADD CONSTRAINT `FK_ECB632C5DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Constraints for table `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `FK_A56BD82B3E57D3BF` FOREIGN KEY (`pedido_call_center_id`) REFERENCES `pedido_call_center` (`id`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB0615DCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
