-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2018 at 12:49 AM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.9-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hellbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `compra_credito`
--

CREATE TABLE `compra_credito` (
  `id` int(11) NOT NULL,
  `cuotas_restantes` int(11) DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP,
  `numero_cuotas` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `compra_credito`
--

INSERT INTO `compra_credito` (`id`, `cuotas_restantes`, `id_producto`, `monto`, `fecha_realizado`, `numero_cuotas`) VALUES
(1, NULL, 1, 10, '2018-09-03 00:46:03', 4),
(2, NULL, 1, 10, '2018-09-03 00:47:22', 4),
(3, NULL, 1, 5, '2018-09-03 21:19:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `consignacion_credito`
--

CREATE TABLE `consignacion_credito` (
  `id` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `tipo_t` enum('cliente','vis') DEFAULT 'cliente',
  `id_origen` int(11) DEFAULT NULL,
  `monto` float NOT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `consignacion_credito`
--

INSERT INTO `consignacion_credito` (`id`, `id_destino`, `tipo_t`, `id_origen`, `monto`, `fecha_realizado`) VALUES
(1, 1, 'cliente', 2, 2, '2018-09-03 04:15:06'),
(2, 1, 'cliente', 2, 2, '2018-09-03 04:15:11');

-- --------------------------------------------------------

--
-- Table structure for table `consignacion_debito`
--

CREATE TABLE `consignacion_debito` (
  `id` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `tipo_t` enum('cliente','vis') DEFAULT 'cliente',
  `id_origen` int(11) DEFAULT NULL,
  `monto` float NOT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `consignacion_debito`
--

INSERT INTO `consignacion_debito` (`id`, `id_destino`, `tipo_t`, `id_origen`, `monto`, `fecha_realizado`) VALUES
(1, 1, 'cliente', 3, 100, '2018-09-02 23:43:55'),
(2, 1, 'cliente', 3, 100, '2018-09-02 23:46:20'),
(3, 1, 'cliente', 3, 100, '2018-09-02 23:46:28'),
(4, 1, 'cliente', 3, 100, '2018-09-02 23:47:42'),
(5, 6, 'cliente', 7, 10, '2018-09-03 17:43:52'),
(6, 1, 'cliente', 3, 100, '2018-09-03 21:28:17'),
(7, 1, 'cliente', 3, 100, '2018-09-03 21:43:11'),
(8, 1, 'cliente', 5, 10, '2018-09-03 21:48:51'),
(9, 1, 'cliente', 8, 10, '2018-09-03 22:26:56'),
(10, 11, 'cliente', 8, 10, '2018-09-03 22:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `credito`
--

CREATE TABLE `credito` (
  `id` int(11) NOT NULL,
  `estado` enum('APROBADO','NO_APROBADO','EN_ESPERA') DEFAULT 'EN_ESPERA',
  `tasa_interes` float NOT NULL,
  `interes_mora` float NOT NULL,
  `monto` float NOT NULL,
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_dueno` int(11) DEFAULT NULL,
  `email_vis` varchar(244) DEFAULT NULL,
  `ultimo_pago` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credito`
--

INSERT INTO `credito` (`id`, `estado`, `tasa_interes`, `interes_mora`, `monto`, `fecha_creado`, `id_dueno`, `email_vis`, `ultimo_pago`) VALUES
(1, 'NO_APROBADO', 1.7, 2.7, 3, '2018-09-03 01:22:18', 1, 'N/A', '2018-09-03 17:14:08'),
(2, 'NO_APROBADO', 1, 0, 10, '2018-09-03 01:22:27', 1, 'N/A', '2018-09-04 02:52:15'),
(3, 'NO_APROBADO', 0, 0, 100, '2018-09-03 04:36:13', NULL, 'email@vis.com', '2018-09-04 04:26:03'),
(4, 'APROBADO', 2.5, 0, 100, '2018-09-03 04:36:14', NULL, 'email@vis.com', '2018-09-03 09:37:01'),
(5, 'EN_ESPERA', 2.5, 0, 100, '2018-09-03 04:36:15', NULL, 'email@vis.com', '2018-09-03 09:36:15'),
(6, 'NO_APROBADO', 6, 0, 10, '2018-09-03 12:59:23', 4, 'N/A', '2018-09-04 04:18:50'),
(7, 'EN_ESPERA', 9, 0, 10, '2018-09-03 21:24:36', NULL, 'santiago@chaustre.pw', '2018-09-04 02:24:36'),
(8, 'EN_ESPERA', 6, 0, 18, '2018-09-03 22:26:21', 7, 'N/A', '2018-09-04 03:26:21'),
(9, 'EN_ESPERA', 6, 0, 18, '2018-09-03 22:26:24', 7, 'N/A', '2018-09-04 03:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `cuenta_ahorros`
--

CREATE TABLE `cuenta_ahorros` (
  `id` int(11) NOT NULL,
  `estado` enum('APROBADO','NO_APROBADO','EN_ESPERA') DEFAULT 'EN_ESPERA',
  `tasa_interes` float NOT NULL,
  `saldo` float NOT NULL,
  `cuota_manejo` float DEFAULT NULL,
  `id_dueno` int(11) NOT NULL,
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuenta_ahorros`
--

INSERT INTO `cuenta_ahorros` (`id`, `estado`, `tasa_interes`, `saldo`, `cuota_manejo`, `id_dueno`, `fecha_creado`) VALUES
(1, 'EN_ESPERA', 0, 700, 0, 1, '2018-09-02 23:29:30'),
(2, 'EN_ESPERA', 0, 49, 0, 1, '2018-09-02 23:29:42'),
(3, 'EN_ESPERA', 0, 10, 0, 4, '2018-09-03 12:58:55'),
(4, 'EN_ESPERA', 0, 10, 0, 1, '2018-09-03 13:36:39'),
(5, 'EN_ESPERA', 0, 1, 0, 6, '2018-09-03 17:17:24'),
(6, 'EN_ESPERA', 0, 13, 0, 6, '2018-09-03 17:17:27'),
(7, 'EN_ESPERA', 0, 45, 0, 6, '2018-09-03 17:17:31'),
(8, 'EN_ESPERA', 0, 70, 0, 7, '2018-09-03 22:26:07'),
(9, 'EN_ESPERA', 0, 99, 0, 7, '2018-09-03 22:26:11'),
(10, 'EN_ESPERA', 0, 99, 0, 7, '2018-09-03 22:26:13'),
(11, 'EN_ESPERA', 0, 109, 0, 7, '2018-09-03 22:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `id_origen` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`id`, `contenido`, `id_origen`, `id_destino`) VALUES
(1, 'Se ha hecho una consignación por 100', 3, 1),
(2, 'Se ha hecho una consignación por 100', 3, 1),
(3, 'Se ha hecho una consignación por 100', 3, 1),
(4, 'Se ha hecho una consignación por 100', 3, 1),
(5, 'Se ha hecho una compra por 10', 1, 1),
(6, 'Se ha hecho una compra por 10', 1, 1),
(7, 'Se ha hecho un retiro por 4', 1, 1),
(8, 'Se ha hecho un retiro por 4', 1, 1),
(9, 'Se ha hecho una consignación por 2', 1, 1),
(10, 'Se ha hecho una consignación por 2', 1, 1),
(11, 'Se ha hecho un retiro por 2', 6, 6),
(12, 'Se ha hecho un retiro por 10', 6, 6),
(13, 'Se ha hecho una consignación por 10', 6, 6),
(14, 'Se ha hecho una compra por 5', 1, 1),
(15, 'Se ha hecho una consignación por 100', 3, 1),
(16, 'Se ha hecho una consignación por 100', 3, 1),
(17, 'Se ha hecho una consignación por 10', 5, 1),
(18, 'Se ha hecho un retiro por 10', 7, 7),
(19, 'Se ha hecho una consignación por 10', 7, 1),
(20, 'Se ha hecho una consignación por 10', 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `movimientos_admin`
--

CREATE TABLE `movimientos_admin` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_operacion` int(11) NOT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operaciones_admin`
--

CREATE TABLE `operaciones_admin` (
  `id` int(11) NOT NULL,
  `nombre_operacion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operaciones_admin`
--

INSERT INTO `operaciones_admin` (`id`, `nombre_operacion`) VALUES
(1, 'aprobar_credito'),
(2, 'aprobar_ahorros'),
(3, 'aprobar_tarjeta_credito'),
(4, 'aprueba_cupo'),
(5, 'fin_mes'),
(6, 'aprueba_sobrecupo');

-- --------------------------------------------------------

--
-- Table structure for table `producto_compra`
--

CREATE TABLE `producto_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `restante` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `retiro`
--

CREATE TABLE `retiro` (
  `id` int(11) NOT NULL,
  `id_ahorros` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `retiro`
--

INSERT INTO `retiro` (`id`, `id_ahorros`, `monto`, `fecha_realizado`) VALUES
(1, 1, 4, '2018-09-03 03:18:06'),
(2, 1, 4, '2018-09-03 03:18:09'),
(3, 5, 2, '2018-09-03 17:21:26'),
(4, 7, 10, '2018-09-03 17:42:51'),
(5, 8, 10, '2018-09-03 22:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `sistema`
--

CREATE TABLE `sistema` (
  `id` int(11) NOT NULL,
  `interes_aumento` float DEFAULT NULL,
  `interes_inter_banco` float DEFAULT NULL,
  `cuota_manejo_default` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sistema`
--

INSERT INTO `sistema` (`id`, `interes_aumento`, `interes_inter_banco`, `cuota_manejo_default`) VALUES
(1, 6, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tarjeta_credito`
--

CREATE TABLE `tarjeta_credito` (
  `id` int(11) NOT NULL,
  `estado` enum('APROBADO','NO_APROBADO','EN_ESPERA') DEFAULT 'EN_ESPERA',
  `id_dueno` int(11) NOT NULL,
  `id_ahorros` int(11) NOT NULL,
  `cupo_maximo` float NOT NULL,
  `gastado` float NOT NULL,
  `sobre_cupo` float NOT NULL,
  `tasa_interes` float NOT NULL,
  `mora` float DEFAULT NULL,
  `cuota_manejo` float NOT NULL,
  `ultimo_pago` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tarjeta_credito`
--

INSERT INTO `tarjeta_credito` (`id`, `estado`, `id_dueno`, `id_ahorros`, `cupo_maximo`, `gastado`, `sobre_cupo`, `tasa_interes`, `mora`, `cuota_manejo`, `ultimo_pago`, `fecha_creado`) VALUES
(1, 'EN_ESPERA', 1, 1, 100, 25, 100, 200, 0, 2, '2018-09-04 02:52:50', '2018-09-03 04:29:49'),
(2, 'APROBADO', 4, 3, 0, 0, 0, 0, 0, 0, '2018-09-04 03:30:49', '2018-09-03 17:59:08'),
(3, 'APROBADO', 1, 2, 0, 0, 0, 0, 0, 0, '2018-09-04 03:31:00', '2018-09-03 18:37:03'),
(4, 'EN_ESPERA', 7, 9, 0, 0, 0, 0, 0, 0, '2018-09-04 03:26:29', '2018-09-04 03:26:29'),
(5, 'APROBADO', 7, 8, 100, 0, 100, 100, 0, 100, '2018-09-04 04:01:01', '2018-09-04 03:26:32'),
(6, 'APROBADO', 7, 11, 0, 0, 0, 0, 0, 0, '2018-09-04 03:30:56', '2018-09-04 03:26:34'),
(7, 'NO_APROBADO', 7, 8, 100, 0, 100, 100, 0, 100, '2018-09-04 04:01:48', '2018-09-04 03:30:28'),
(8, 'APROBADO', 7, 8, 0, 0, 0, 0, 0, 0, '2018-09-04 03:31:11', '2018-09-04 03:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `transferencias_externas`
--

CREATE TABLE `transferencias_externas` (
  `id` int(11) NOT NULL,
  `banco_origen` varchar(50) NOT NULL,
  `banco_destino` varchar(50) NOT NULL,
  `id_origen` int(11) DEFAULT NULL,
  `monto` float NOT NULL,
  `id_destino` int(11) DEFAULT NULL,
  `fecha_realizado` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipo_trans` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(512) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `emailadd` varchar(255) NOT NULL,
  `rol` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `user_name`, `password`, `nombre`, `apellido`, `emailadd`, `rol`) VALUES
(1, 'nikmend', '$1$WVpYa27b$Fp/YOsrZxCnJi/RZhpnsD0', 'Nicolas', 'Mendez', 'nicolas@mendez.com', 'admin'),
(2, 'amodelaweb2', '$1$t03TO8Cw$JM/L.EfaXemttNZNkm.TZ/', 'Santiago', 'Chaustre', 'amodelaweb@chaustre.pw', 'admin'),
(3, 'essoca', '$1$98TCzWOy$w.f.P64b26fvflAW8ft0N/', 'Pablo', 'Ariza', 'essoca@essoca.com', 'admin'),
(4, 'ailinr', '$1$pdraxELV$MCcfbnRvCoupFf6vpne0w/', 'Ailin', 'Rojas', 'ailin@ailin.com', 'admin'),
(5, 'imrock', '$1$CYhfbyPZ$YyZSWbx2hlbIGA3ls1l/i/', 'Andres', 'marino', 'zero@chaustre.pw', 'admin'),
(6, 'doe', '$1$WpN8a6Vk$3vIpImjeoIMgJx5dP7bvQ.', 'jhon', 'doe', 'jhon@doe.com', 'user'),
(7, 'user', '$1$Ip1KUyQH$AThxg9Kl7eiTS2J1VHpDJ.', 'user', 'user', 'user@user.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `visitante`
--

CREATE TABLE `visitante` (
  `id` int(11) NOT NULL,
  `emailadd` varchar(255) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitante`
--

INSERT INTO `visitante` (`id`, `emailadd`, `cedula`, `nombre`, `apellido`) VALUES
(1, 'rpez@javeriana.edu.co', '1234567890', 'Rafael', 'Paez'),
(3, 'email@vis.com', '845217546', 'tarea', 'gerencia'),
(4, '', '3', NULL, NULL),
(5, 'santiago@chaustre.pw', '1105792535', 'Santiago', 'Chaustre');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compra_credito`
--
ALTER TABLE `compra_credito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `consignacion_credito`
--
ALTER TABLE `consignacion_credito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Indexes for table `consignacion_debito`
--
ALTER TABLE `consignacion_debito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Indexes for table `credito`
--
ALTER TABLE `credito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_dueno` (`id_dueno`);

--
-- Indexes for table `cuenta_ahorros`
--
ALTER TABLE `cuenta_ahorros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_dueno` (`id_dueno`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Indexes for table `movimientos_admin`
--
ALTER TABLE `movimientos_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_operacion` (`id_operacion`);

--
-- Indexes for table `operaciones_admin`
--
ALTER TABLE `operaciones_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `producto_compra`
--
ALTER TABLE `producto_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_compra` (`id_compra`);

--
-- Indexes for table `retiro`
--
ALTER TABLE `retiro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_ahorros` (`id_ahorros`);

--
-- Indexes for table `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_dueno` (`id_dueno`),
  ADD KEY `id_ahorros` (`id_ahorros`);

--
-- Indexes for table `transferencias_externas`
--
ALTER TABLE `transferencias_externas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `emailadd` (`emailadd`);

--
-- Indexes for table `visitante`
--
ALTER TABLE `visitante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `emailadd` (`emailadd`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compra_credito`
--
ALTER TABLE `compra_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `consignacion_credito`
--
ALTER TABLE `consignacion_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `consignacion_debito`
--
ALTER TABLE `consignacion_debito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `credito`
--
ALTER TABLE `credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cuenta_ahorros`
--
ALTER TABLE `cuenta_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `movimientos_admin`
--
ALTER TABLE `movimientos_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `operaciones_admin`
--
ALTER TABLE `operaciones_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `producto_compra`
--
ALTER TABLE `producto_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `retiro`
--
ALTER TABLE `retiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `transferencias_externas`
--
ALTER TABLE `transferencias_externas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `visitante`
--
ALTER TABLE `visitante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `compra_credito`
--
ALTER TABLE `compra_credito`
  ADD CONSTRAINT `compra_credito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tarjeta_credito` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `consignacion_credito`
--
ALTER TABLE `consignacion_credito`
  ADD CONSTRAINT `consignacion_credito_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `credito` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `consignacion_debito`
--
ALTER TABLE `consignacion_debito`
  ADD CONSTRAINT `consignacion_debito_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `cuenta_ahorros` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `credito`
--
ALTER TABLE `credito`
  ADD CONSTRAINT `credito_ibfk_1` FOREIGN KEY (`id_dueno`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `cuenta_ahorros`
--
ALTER TABLE `cuenta_ahorros`
  ADD CONSTRAINT `cuenta_ahorros_ibfk_1` FOREIGN KEY (`id_dueno`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `movimientos_admin`
--
ALTER TABLE `movimientos_admin`
  ADD CONSTRAINT `movimientos_admin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_admin_ibfk_2` FOREIGN KEY (`id_operacion`) REFERENCES `operaciones_admin` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `producto_compra`
--
ALTER TABLE `producto_compra`
  ADD CONSTRAINT `producto_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra_credito` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `retiro`
--
ALTER TABLE `retiro`
  ADD CONSTRAINT `retiro_ibfk_1` FOREIGN KEY (`id_ahorros`) REFERENCES `cuenta_ahorros` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  ADD CONSTRAINT `tarjeta_credito_ibfk_1` FOREIGN KEY (`id_dueno`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tarjeta_credito_ibfk_2` FOREIGN KEY (`id_ahorros`) REFERENCES `cuenta_ahorros` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
