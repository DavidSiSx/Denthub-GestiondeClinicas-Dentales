-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2024 a las 06:38:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `denthub`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarAdministrador` (IN `p_id` INT, IN `p_nombre` VARCHAR(50), IN `p_apellido_paterno` VARCHAR(50), IN `p_apellido_materno` VARCHAR(50), IN `p_correo` VARCHAR(100), IN `p_contrasena` VARCHAR(255))   BEGIN
    UPDATE administradores
    SET nombre = p_nombre,
        apellido_paterno = p_apellido_paterno,
        apellido_materno = p_apellido_materno,
        correo = p_correo,
        contrasena = p_contrasena
    WHERE id_administrador = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarUsuario` (IN `p_id` INT, IN `p_nombre` VARCHAR(50), IN `p_apellido_paterno` VARCHAR(50), IN `p_apellido_materno` VARCHAR(50), IN `p_usuario` VARCHAR(50), IN `p_correo` VARCHAR(100), IN `p_telefono` VARCHAR(15), IN `p_contrasena` VARCHAR(255), IN `p_fecha_nacimiento` DATE, IN `p_estado` ENUM('Activo','Inactivo'))   BEGIN
    UPDATE pacientes
    SET nombre = p_nombre,
        apellido_paterno = p_apellido_paterno,
        apellido_materno = p_apellido_materno,
        usuario = p_usuario,
        correo = p_correo,
        telefono = p_telefono,
        contrasena = p_contrasena,
        fecha_nacimiento = p_fecha_nacimiento,
        estado = p_estado
    WHERE id_paciente = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearAdministrador` (IN `p_nombre` VARCHAR(50), IN `p_apellido_paterno` VARCHAR(50), IN `p_apellido_materno` VARCHAR(50), IN `p_correo` VARCHAR(100), IN `p_contrasena` VARCHAR(255))   BEGIN
    INSERT INTO administradores (nombre, apellido_paterno, apellido_materno, correo, contrasena)
    VALUES (p_nombre, p_apellido_paterno, p_apellido_materno, p_correo, p_contrasena);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CrearUsuario` (IN `p_nombre` VARCHAR(50), IN `p_apellido_paterno` VARCHAR(50), IN `p_apellido_materno` VARCHAR(50), IN `p_usuario` VARCHAR(50), IN `p_correo` VARCHAR(100), IN `p_telefono` VARCHAR(15), IN `p_contrasena` VARCHAR(255), IN `p_fecha_nacimiento` DATE)   BEGIN
    INSERT INTO pacientes (nombre, apellido_paterno, apellido_materno, usuario, correo, telefono, contrasena, fecha_nacimiento, estado)
    VALUES (p_nombre, p_apellido_paterno, p_apellido_materno, p_usuario, p_correo, p_telefono, p_contrasena, p_fecha_nacimiento, 'Inactivo');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarAdministrador` (IN `p_id` INT)   BEGIN
    DELETE FROM administradores WHERE id_administrador = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `p_id` INT)   BEGIN
    DELETE FROM pacientes WHERE id_paciente = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LeerAdministradores` ()   BEGIN
    SELECT * FROM administradores;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LeerUsuarios` ()   BEGIN
    SELECT * FROM pacientes;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_administrador` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) DEFAULT NULL,
  `apellido_materno` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_administrador`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `contrasena`, `telefono`) VALUES
(1, 'Maria', 'Delgado', 'Martinez', 'marigado@gmail.com', '7890', '098765432112345'),
(2, 'hiro', 'zavala', 'pele', 'hiro@gmail.com', '$2y$10$cytPwK.xAmIRkGOhZ8Q2suvkreJb/KytUmHu.Qk4.j4', '123456789012345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `estado` enum('Confirmada','Pendiente') DEFAULT 'Pendiente',
  `precio` int(200) NOT NULL,
  `monto_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_paciente`, `fecha_hora`, `motivo`, `comentarios`, `estado`, `precio`, `monto_total`) VALUES
(1, 1, '2024-07-18 21:20:48', 'Malestar dental', 'yiyi', 'Pendiente', 0, NULL),
(6, 4, '2024-07-11 22:41:00', 'duele', 'mucho', 'Pendiente', 0, NULL),
(8, 3, '2024-07-24 20:35:00', 'duele', 'muucho', 'Pendiente', 0, NULL),
(9, 3, '2024-07-31 14:31:00', 'ortodoncia', 'hola', 'Pendiente', 0, NULL),
(10, 4, '2024-07-12 21:50:00', 'wefwefwe', 'wefwef', 'Pendiente', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `id_expediente` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_user`
--

CREATE TABLE `expediente_user` (
  `id_expediente_user` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `expediente_user`
--

INSERT INTO `expediente_user` (`id_expediente_user`, `id_paciente`, `descripcion`, `fecha`) VALUES
(1, 1, 'Cancer de pulmon', '0000-00-00'),
(2, 1, 'Cancer de pulmon', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) DEFAULT NULL,
  `apellido_materno` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Inactivo',
  `telefono` varchar(15) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `contrasena`, `fecha_nacimiento`, `estado`, `telefono`, `usuario`) VALUES
(1, 'Romel', 'Cruz', 'Sierra', 'romel@gmail.com', '123', '2018-07-06', 'Inactivo', '9875334567', ''),
(2, 'Angel', 'Perez', 'Mora', 'Angel@gmail.com', '12345', '2014-10-08', 'Inactivo', '9987675436', ''),
(3, 'Soki', 'Amir', 'Perez', 'soki@gmail.com', '0987', '2014-07-09', 'Inactivo', '9983482765', 'soki '),
(4, 'Romel', 'Cruz', 'Medina', 'sebastiamedina2311@gmail.com', '123', '2000-02-08', 'Inactivo', '9984108750', '123'),
(7, 'Romel', 'Cruz', 'Medina', 'rcm@gmail.com', '$2y$10$OnocWanV.N0lKGEOqFyFIea2ZNsMBsJoaAHZ3osOgcJ', '2000-02-08', 'Inactivo', '9984108750', '123'),
(8, 'Romel', 'Cruz', 'Medina', 'soki@gmail.com', '$2y$10$rOEddebmYI6jseZdEc0Ow.r9j7MaVCNCFHy1dHFTgk7', '1986-01-28', 'Inactivo', '9984108750', '12334242'),
(9, 'Romel', 'Cruz', 'Medina', 'soki@gmail.com', '$2y$10$/paeL4i6QE4zxN/Etze6.OvsCGDVZpLX5C8xAZz51j9', '1986-01-28', 'Inactivo', '9984108750', '12334242'),
(11, 'Romel', 'Cruz', 'Medina', 'fdaf@gmail.com', '$2y$10$lBmC3hp8LKm6vwMfNJZMyuK48svulFYbFPHKHAPEWE4', '2024-07-22', 'Inactivo', '9984108750', '964534'),
(13, 'Romel', 'Cruz', 'Medina', 'esotilin@gmail.com', '$2y$10$EkuqEfYwDR6wM1oGn8ybN.91FTCUFohJ1AwRlwWST/e', '2004-03-17', 'Inactivo', '9984108750', '98765'),
(14, 'Alex', 'Marin', 'Mia', 'mia@gmail.com', '$2y$10$ysjA0rW1/yQ4W7RxHq8mJeTjGFb/yeUOeqv88IazD5/', '2012-03-16', 'Inactivo', '9981472323', 'Marin'),
(15, 'mia', 'khalifa', '1234', 'mia@gmail.com', '$2y$10$q11dVdvdYvnnH8/Rhuar0uTYt/jXXNCSvdIvqWmuKui', '2022-03-22', 'Inactivo', '324242', '2354325'),
(16, 'Alex', 'Marin', '1234', 'mia@gmail.com', '$2y$10$SmpJnKTseHB4IOrQltHjx.4oVbLMZtdLLBRQPGqihnZ', '2024-07-04', 'Inactivo', '9981472323', '2354325'),
(17, 'romel', 'sierra', 'sosa', 'ih43100@gmail.com', '$2y$10$s.yzA5JMicoHzw2AgfS/qe0U536Cn6KoF9j61mUjh8/', '2024-07-23', 'Inactivo', '9984661276', 'david222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto_total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `concepto` varchar(100) NOT NULL,
  `id_cita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_paciente`, `fecha_pago`, `monto_total`, `estado`, `concepto`, `id_cita`) VALUES
(1, 1, '2024-07-24', 1000.00, NULL, 'ya no duele', NULL),
(2, 3, '2024-07-24', 500.00, NULL, 'dfgth', NULL),
(3, 1, '2024-07-24', 2100.00, 'Pendiente', 'dsfsdf', 1),
(4, 3, '2024-07-24', 4000.00, 'Pendiente', 'rewe', 8),
(5, 4, '2024-07-24', 1200.00, 'Pendiente', 'si', 6),
(6, 4, '2024-07-24', 2000.00, 'Pendiente', 'dffbdf', 10),
(7, 1, '2024-07-24', 231231.00, 'Pendiente', '21312', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`id_expediente`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `expediente_user`
--
ALTER TABLE `expediente_user`
  ADD PRIMARY KEY (`id_expediente_user`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `fk_pagos_citas` (`id_cita`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `id_expediente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_user`
--
ALTER TABLE `expediente_user`
  MODIFY `id_expediente_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `expedientes_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Filtros para la tabla `expediente_user`
--
ALTER TABLE `expediente_user`
  ADD CONSTRAINT `expediente_user_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_id_cita` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`),
  ADD CONSTRAINT `fk_pagos_citas` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
