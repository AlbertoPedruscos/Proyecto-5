-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2024 a las 19:11:08
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pr05_aparcacoches`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_04_23_174915_create_tbl_empresas_table', 1),
(2, '2024_04_23_174915_create_tbl_roles_table', 1),
(3, '2024_04_23_174915_create_tbl_usuarios_table', 1),
(4, '2024_04_23_174916_create_tbl_estados_table', 1),
(5, '2024_04_23_174916_create_tbl_parking_table', 1),
(6, '2024_04_23_174916_create_tbl_plazas_table', 1),
(7, '2024_04_23_174916_create_tbl_reservas_table', 1),
(8, '2024_04_24_160624_create_tbl_chat_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mensaje` longtext DEFAULT NULL,
  `emisor` bigint(20) UNSIGNED DEFAULT NULL,
  `receptor` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_chat`
--

INSERT INTO `tbl_chat` (`id`, `mensaje`, `emisor`, `receptor`, `created_at`, `updated_at`) VALUES
(1, '¡Hola! ¿Cómo estás?', 1, 2, '2024-04-30 11:43:02', '2024-04-30 11:43:02'),
(2, '¡Bien, gracias! ¿Y tú?', 2, 1, '2024-04-30 11:43:02', '2024-04-30 11:43:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empresas`
--

CREATE TABLE `tbl_empresas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_empresas`
--

INSERT INTO `tbl_empresas` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Nnparkings', '2024-05-07 13:38:09', '2024-05-07 13:38:09'),
(2, 'Interparking Hispania', '2024-05-07 13:38:09', '2024-05-07 13:38:09'),
(3, 'Saba Sede', '2024-05-07 13:38:09', '2024-05-07 13:38:09'),
(4, 'Continental Parking SL', '2024-05-07 13:38:09', '2024-05-07 13:38:09'),
(5, 'Pàrking PRATSA Self Storage', '2024-05-07 13:38:09', '2024-05-07 13:38:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estados`
--

CREATE TABLE `tbl_estados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_estados`
--

INSERT INTO `tbl_estados` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Ocupado', '2024-04-30 11:42:57', '2024-04-30 11:42:57'),
(2, 'Libre', '2024-04-30 11:42:57', '2024-04-30 11:42:57'),
(3, 'Reservado', '2024-04-30 11:42:57', '2024-04-30 11:42:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_parking`
--

CREATE TABLE `tbl_parking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `latitud` longtext DEFAULT NULL,
  `longitud` longtext DEFAULT NULL,
  `id_empresa` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_parking`
--

INSERT INTO `tbl_parking` (`id`, `nombre`, `latitud`, `longitud`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 'Parking 1', '41.349536354143744', '2.106697003108879', 1, '2024-05-07 13:38:10', '2024-05-07 13:38:10'),
(2, 'Parking 2', '41.35010355977579', '2.106182758240472', 2, '2024-05-07 13:38:10', '2024-05-07 13:38:10'),
(3, 'Parking 3', '41.34915063858738', '2.105719090230854', 1, '2024-05-07 13:38:10', '2024-05-07 13:38:10'),
(4, 'Parking 4', '41.34780760150584', '2.1074169285400246', 2, '2024-05-07 13:38:10', '2024-05-07 13:38:10'),
(5, 'Parking 5', '41.34659114964164', '2.1098135735856767', 2, '2024-05-07 13:38:10', '2024-05-07 13:38:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_plazas`
--

CREATE TABLE `tbl_plazas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `planta` decimal(8,2) DEFAULT NULL,
  `id_estado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_parking` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_plazas`
--

INSERT INTO `tbl_plazas` (`id`, `nombre`, `planta`, `id_estado`, `id_parking`, `created_at`, `updated_at`) VALUES
(1, 'A1', '1.00', 1, 1, '2024-04-30 11:43:00', '2024-04-30 11:43:00'),
(2, 'A2', '1.00', 2, 1, '2024-04-30 11:43:00', '2024-04-30 11:43:00'),
(3, 'A3', '1.00', 1, 2, '2024-04-30 11:43:00', '2024-04-30 11:43:00'),
(4, 'A4', '1.00', 2, 2, '2024-04-30 11:43:00', '2024-04-30 11:43:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_registros`
--

CREATE TABLE `tbl_registros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accion` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `id_usuario` bigint(20) UNSIGNED DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `id_reserva` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reservas`
--

CREATE TABLE `tbl_reservas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_trabajador` bigint(20) UNSIGNED DEFAULT NULL,
  `id_plaza` bigint(20) UNSIGNED DEFAULT NULL,
  `nom_cliente` varchar(45) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `marca` varchar(15) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `color` varchar(15) DEFAULT NULL,
  `num_telf` varchar(9) NOT NULL,
  `email` varchar(45) NOT NULL,
  `ubicacion_entrada` varchar(20) NOT NULL,
  `ubicacion_salida` varchar(20) NOT NULL,
  `fecha_entrada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_salida` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `firma_entrada` varchar(75) DEFAULT NULL,
  `firma_salida` varchar(75) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_reservas`
--

INSERT INTO `tbl_reservas` (`id`, `id_trabajador`, `id_plaza`, `nom_cliente`, `matricula`, `marca`, `modelo`, `color`, `num_telf`, `email`, `ubicacion_entrada`, `ubicacion_salida`, `fecha_entrada`, `fecha_salida`, `firma_entrada`, `firma_salida`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Alberto', '1234 ABC', 'Volkswagen', 'Golf', 'Azul', '654321987', 'alberto@gmail.com', '1', '1', '2024-04-30 11:43:01', '2024-04-30 11:43:01', NULL, NULL, '2024-04-30 11:43:01', '2024-04-30 11:43:01'),
(2, NULL, 2, 'Julio', '5678 DEF', 'Audi', 'A3', 'Rojo', '654321987', 'julio@gmail.com', '1', '1', '2024-04-30 11:43:01', '2024-04-30 11:43:01', NULL, NULL, '2024-04-30 11:43:01', '2024-04-30 11:43:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2024-04-30 11:42:57', '2024-04-30 11:42:57'),
(2, 'Empresa', '2024-04-30 11:42:57', '2024-04-30 11:42:57'),
(3, 'Usuario', '2024-04-30 11:42:57', '2024-04-30 11:42:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `id_rol` bigint(20) UNSIGNED DEFAULT NULL,
  `id_empresa` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id`, `nombre`, `apellidos`, `email`, `contrasena`, `id_rol`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 'Julio', 'Cesar', 'julio@gmail.com', '$2y$12$uYlfYYnIRobpSI8IpS9jgufs8/qDXfC/rvcdL6jiyxwA4nmM07HCW', 1, 1, '2024-04-30 11:42:58', '2024-04-30 11:42:58'),
(2, 'Iker', 'Catala', 'iker@gmail.com', '$2y$12$0kf7KrSEuVN68P6dOtCw3OjxIHlH6kY04Wu.lz6xkFnUT/HBoTrpa', 1, 1, '2024-04-30 11:42:58', '2024-04-30 11:42:58'),
(3, 'Alberto', 'Bermejo', 'alberto@gmail.com', '$2y$12$sXIwDK42q9L/UPQPaguuzeDUrJ4wnIvWnWuazMXZTnU6mRn7XTsbK', 1, 1, '2024-04-30 11:42:59', '2024-04-30 11:42:59'),
(4, 'Oscar', 'Lopez', 'oscar@gmail.com', '$2y$12$ohJ5ocG5kltX2jQmrJCWYe.IRcPF.vckoL/9/TlYY3Q/F9ETfSD9C', 3, 1, '2024-04-30 11:43:00', '2024-04-30 11:43:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chat_emisor` (`emisor`),
  ADD KEY `fk_chat_receptor` (`receptor`);

--
-- Indices de la tabla `tbl_empresas`
--
ALTER TABLE `tbl_empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_estados`
--
ALTER TABLE `tbl_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_parking`
--
ALTER TABLE `tbl_parking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parking_empresa` (`id_empresa`);

--
-- Indices de la tabla `tbl_plazas`
--
ALTER TABLE `tbl_plazas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_plazas_parking` (`id_parking`),
  ADD KEY `fk_plazas_estado` (`id_estado`);

--
-- Indices de la tabla `tbl_registros`
--
ALTER TABLE `tbl_registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_registros_usuario` (`id_usuario`),
  ADD KEY `tbl_registros_reserva` (`id_reserva`);

--
-- Indices de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservas_plazas` (`id_plaza`),
  ADD KEY `fk_reservas_usuarios` (`id_trabajador`);

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_usuarios_id_rol_foreign` (`id_rol`),
  ADD KEY `tbl_usuarios_id_empresa_foreign` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_chat`
--
ALTER TABLE `tbl_chat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_empresas`
--
ALTER TABLE `tbl_empresas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_estados`
--
ALTER TABLE `tbl_estados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_parking`
--
ALTER TABLE `tbl_parking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_plazas`
--
ALTER TABLE `tbl_plazas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_registros`
--
ALTER TABLE `tbl_registros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD CONSTRAINT `fk_chat_emisor` FOREIGN KEY (`emisor`) REFERENCES `tbl_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat_receptor` FOREIGN KEY (`receptor`) REFERENCES `tbl_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_parking`
--
ALTER TABLE `tbl_parking`
  ADD CONSTRAINT `fk_parking_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `tbl_empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_plazas`
--
ALTER TABLE `tbl_plazas`
  ADD CONSTRAINT `fk_plazas_estado` FOREIGN KEY (`id_estado`) REFERENCES `tbl_estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plazas_parking` FOREIGN KEY (`id_parking`) REFERENCES `tbl_parking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_registros`
--
ALTER TABLE `tbl_registros`
  ADD CONSTRAINT `tbl_registros_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `tbl_reservas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_registros_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD CONSTRAINT `fk_reservas_plazas` FOREIGN KEY (`id_plaza`) REFERENCES `tbl_plazas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservas_usuarios` FOREIGN KEY (`id_trabajador`) REFERENCES `tbl_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`id_rol`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_usuarios_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `tbl_empresas` (`id`),
  ADD CONSTRAINT `tbl_usuarios_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `tbl_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
