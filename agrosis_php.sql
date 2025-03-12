-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-03-2025 a las 16:20:49
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agrosis_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int NOT NULL,
  `nombre_actividad` varchar(50) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_actividad`
--

CREATE TABLE `asignacion_actividad` (
  `id_asignacion_actividad` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `fk_id_actividad` int DEFAULT NULL,
  `fk_identificacion` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_lunar`
--

CREATE TABLE `calendario_lunar` (
  `id_calendario_lunar` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion_evento` text,
  `evento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_fitosanitario`
--

CREATE TABLE `control_fitosanitario` (
  `id_control_fitosanitario` int NOT NULL,
  `fecha_control` date DEFAULT NULL,
  `descripcion` text,
  `fk_id_desarrollan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_usa_insumo`
--

CREATE TABLE `control_usa_insumo` (
  `id_control_usa_insumo` int NOT NULL,
  `fk_id_insumo` int DEFAULT NULL,
  `fk_id_control_fitosanitario` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivo`
--

CREATE TABLE `cultivo` (
  `id_cultivo` int NOT NULL,
  `fecha_plantacion` date NOT NULL,
  `nombre_cultivo` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `fk_id_especie` int DEFAULT NULL,
  `fk_id_semillero` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desarrollan`
--

CREATE TABLE `desarrollan` (
  `id_desarrollan` int NOT NULL,
  `fk_id_cultivo` int DEFAULT NULL,
  `fk_id_pea` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eras`
--

CREATE TABLE `eras` (
  `id_eras` int NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `fk_id_lote` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie`
--

CREATE TABLE `especie` (
  `id_especie` int NOT NULL,
  `nombre_comun` varchar(50) DEFAULT NULL,
  `nombre_cientifico` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `fk_id_tipo_cultivo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genera`
--

CREATE TABLE `genera` (
  `id_genera` int NOT NULL,
  `fk_id_cultivo` int DEFAULT NULL,
  `fk_id_produccion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `id_herramienta` int NOT NULL,
  `nombre_h` varchar(50) DEFAULT NULL,
  `fecha_prestamo` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id_insumo` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `precio_unidad` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `unidad_medida` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_lote` int NOT NULL,
  `dimension` int DEFAULT NULL,
  `nombre_lote` varchar(50) DEFAULT NULL,
  `fk_id_ubicacion` int DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_lote`, `dimension`, `nombre_lote`, `fk_id_ubicacion`, `estado`) VALUES
(5, 10, 'lote 1', 1, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mide`
--

CREATE TABLE `mide` (
  `id_mide` int NOT NULL,
  `fk_id_sensor` int DEFAULT NULL,
  `fk_id_era` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `mensaje` varchar(50) DEFAULT NULL,
  `fk_id_programacion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pea`
--

CREATE TABLE `pea` (
  `id_pea` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantacion`
--

CREATE TABLE `plantacion` (
  `id_plantacion` int NOT NULL,
  `fk_id_cultivo` int DEFAULT NULL,
  `fk_id_era` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `id_produccion` int NOT NULL,
  `fk_id_cultivo` int DEFAULT NULL,
  `cantidad_producida` int NOT NULL,
  `fecha_produccion` date NOT NULL,
  `fk_id_lote` int DEFAULT NULL,
  `descripcion_produccion` text,
  `estado` enum('En proceso','Finalizado','Cancelado') DEFAULT NULL,
  `fecha_cosecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programacion`
--

CREATE TABLE `programacion` (
  `id_programacion` int NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_programada` date DEFAULT NULL,
  `duracion` int DEFAULT NULL,
  `fk_id_asignacion_actividad` int DEFAULT NULL,
  `fk_id_calendario_lunar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `realiza`
--

CREATE TABLE `realiza` (
  `id_realiza` int NOT NULL,
  `fk_id_cultivo` int DEFAULT NULL,
  `fk_id_actividad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requiere`
--

CREATE TABLE `requiere` (
  `id_requiere` int NOT NULL,
  `fk_id_herramienta` int DEFAULT NULL,
  `fk_id_asignacion_actividad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residuos`
--

CREATE TABLE `residuos` (
  `id_residuo` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text,
  `fk_id_tipo_residuo` int DEFAULT NULL,
  `fk_id_cultivo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int NOT NULL,
  `nombre_rol` enum('aprendiz','pasante','instructor') NOT NULL,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `fecha_creacion`) VALUES
(1, 'aprendiz', '2025-02-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semilleros`
--

CREATE TABLE `semilleros` (
  `id_semillero` int NOT NULL,
  `nombre_semilla` varchar(50) DEFAULT NULL,
  `fecha_siembra` date DEFAULT NULL,
  `fecha_estimada` date DEFAULT NULL,
  `cantidad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sensores`
--

CREATE TABLE `sensores` (
  `id_sensor` int NOT NULL,
  `nombre_sensor` varchar(50) DEFAULT NULL,
  `tipo_sensor` varchar(50) DEFAULT NULL,
  `unidad_medida` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `medida_minima` float DEFAULT NULL,
  `medida_maxima` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cultivo`
--

CREATE TABLE `tipo_cultivo` (
  `id_tipo_cultivo` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_residuos`
--

CREATE TABLE `tipo_residuos` (
  `id_tipo_residuo` int NOT NULL,
  `nombre_residuo` varchar(50) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int NOT NULL,
  `latitud` decimal(9,6) DEFAULT NULL,
  `longitud` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `latitud`, `longitud`) VALUES
(1, 10.500000, 12.500000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `identificacion` bigint NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fk_id_rol` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`identificacion`, `nombre`, `contrasena`, `email`, `fk_id_rol`) VALUES
(541212424, 'pacho Pérez', '$2y$10$bDi3rnKH0z97p4uQlIh3/ukeWdb0AFV6vSZzMq6ZSRAEWDazj/k0.', 'pachoz@gmail.com', 1),
(1004268551, 'Dilson Pérez', '$2y$10$./kAb9TNhyMO7cV9V6XFNe6ZupVH/xITYoIiNwjCN0EhrMAkJP6hy', 'dilsonperez@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utiliza`
--

CREATE TABLE `utiliza` (
  `id_utiliza` int NOT NULL,
  `fk_id_insumo` int DEFAULT NULL,
  `fk_id_asignacion_actividad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int NOT NULL,
  `fk_id_produccion` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` int NOT NULL,
  `total_venta` int DEFAULT NULL,
  `fecha_venta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `asignacion_actividad`
--
ALTER TABLE `asignacion_actividad`
  ADD PRIMARY KEY (`id_asignacion_actividad`),
  ADD KEY `fk_id_actividad` (`fk_id_actividad`),
  ADD KEY `fk_identificacion` (`fk_identificacion`);

--
-- Indices de la tabla `calendario_lunar`
--
ALTER TABLE `calendario_lunar`
  ADD PRIMARY KEY (`id_calendario_lunar`);

--
-- Indices de la tabla `control_fitosanitario`
--
ALTER TABLE `control_fitosanitario`
  ADD PRIMARY KEY (`id_control_fitosanitario`),
  ADD KEY `desarrollan_control_fitosanitario` (`fk_id_desarrollan`);

--
-- Indices de la tabla `control_usa_insumo`
--
ALTER TABLE `control_usa_insumo`
  ADD PRIMARY KEY (`id_control_usa_insumo`),
  ADD KEY `fk_id_insumo` (`fk_id_insumo`),
  ADD KEY `control_fitosanitario_usa_insumo` (`fk_id_control_fitosanitario`);

--
-- Indices de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD PRIMARY KEY (`id_cultivo`),
  ADD KEY `especie_cultivo` (`fk_id_especie`),
  ADD KEY `semillero_cultivo` (`fk_id_semillero`);

--
-- Indices de la tabla `desarrollan`
--
ALTER TABLE `desarrollan`
  ADD PRIMARY KEY (`id_desarrollan`),
  ADD KEY `fk_id_cultivo` (`fk_id_cultivo`),
  ADD KEY `pea_desarrollan` (`fk_id_pea`);

--
-- Indices de la tabla `eras`
--
ALTER TABLE `eras`
  ADD PRIMARY KEY (`id_eras`),
  ADD KEY `lote_era` (`fk_id_lote`);

--
-- Indices de la tabla `especie`
--
ALTER TABLE `especie`
  ADD PRIMARY KEY (`id_especie`),
  ADD KEY `tipo_especie` (`fk_id_tipo_cultivo`);

--
-- Indices de la tabla `genera`
--
ALTER TABLE `genera`
  ADD PRIMARY KEY (`id_genera`),
  ADD KEY `cultivo_gen` (`fk_id_cultivo`),
  ADD KEY `produ_gen` (`fk_id_produccion`);

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`id_herramienta`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id_insumo`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `ubicacion_lote` (`fk_id_ubicacion`);

--
-- Indices de la tabla `mide`
--
ALTER TABLE `mide`
  ADD PRIMARY KEY (`id_mide`),
  ADD KEY `fk_id_sensor` (`fk_id_sensor`),
  ADD KEY `era_mide` (`fk_id_era`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_id_programacion` (`fk_id_programacion`);

--
-- Indices de la tabla `pea`
--
ALTER TABLE `pea`
  ADD PRIMARY KEY (`id_pea`);

--
-- Indices de la tabla `plantacion`
--
ALTER TABLE `plantacion`
  ADD PRIMARY KEY (`id_plantacion`),
  ADD KEY `fk_id_cultivo` (`fk_id_cultivo`),
  ADD KEY `era_plantacion` (`fk_id_era`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `fk_cultivo_prod` (`fk_id_cultivo`),
  ADD KEY `fk_lote_prod` (`fk_id_lote`);

--
-- Indices de la tabla `programacion`
--
ALTER TABLE `programacion`
  ADD PRIMARY KEY (`id_programacion`),
  ADD KEY `fk_id_asignacion_actividad` (`fk_id_asignacion_actividad`),
  ADD KEY `fk_id_calendario_lunar` (`fk_id_calendario_lunar`);

--
-- Indices de la tabla `realiza`
--
ALTER TABLE `realiza`
  ADD PRIMARY KEY (`id_realiza`),
  ADD KEY `fk_id_cultivo` (`fk_id_cultivo`),
  ADD KEY `actividad_realiza` (`fk_id_actividad`);

--
-- Indices de la tabla `requiere`
--
ALTER TABLE `requiere`
  ADD PRIMARY KEY (`id_requiere`),
  ADD KEY `fk_id_herramienta` (`fk_id_herramienta`),
  ADD KEY `fk_id_asignacion_actividad` (`fk_id_asignacion_actividad`);

--
-- Indices de la tabla `residuos`
--
ALTER TABLE `residuos`
  ADD PRIMARY KEY (`id_residuo`),
  ADD KEY `tipo_residuo_residuo` (`fk_id_tipo_residuo`),
  ADD KEY `cultivo_residuo` (`fk_id_cultivo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `semilleros`
--
ALTER TABLE `semilleros`
  ADD PRIMARY KEY (`id_semillero`);

--
-- Indices de la tabla `sensores`
--
ALTER TABLE `sensores`
  ADD PRIMARY KEY (`id_sensor`);

--
-- Indices de la tabla `tipo_cultivo`
--
ALTER TABLE `tipo_cultivo`
  ADD PRIMARY KEY (`id_tipo_cultivo`);

--
-- Indices de la tabla `tipo_residuos`
--
ALTER TABLE `tipo_residuos`
  ADD PRIMARY KEY (`id_tipo_residuo`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `fk_id_rol` (`fk_id_rol`);

--
-- Indices de la tabla `utiliza`
--
ALTER TABLE `utiliza`
  ADD PRIMARY KEY (`id_utiliza`),
  ADD KEY `fk_id_insumo` (`fk_id_insumo`),
  ADD KEY `fk_id_asignacion_actividad` (`fk_id_asignacion_actividad`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_produccion_venta` (`fk_id_produccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacion_actividad`
--
ALTER TABLE `asignacion_actividad`
  MODIFY `id_asignacion_actividad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendario_lunar`
--
ALTER TABLE `calendario_lunar`
  MODIFY `id_calendario_lunar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `control_fitosanitario`
--
ALTER TABLE `control_fitosanitario`
  MODIFY `id_control_fitosanitario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `control_usa_insumo`
--
ALTER TABLE `control_usa_insumo`
  MODIFY `id_control_usa_insumo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cultivo`
--
ALTER TABLE `cultivo`
  MODIFY `id_cultivo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desarrollan`
--
ALTER TABLE `desarrollan`
  MODIFY `id_desarrollan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eras`
--
ALTER TABLE `eras`
  MODIFY `id_eras` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especie`
--
ALTER TABLE `especie`
  MODIFY `id_especie` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genera`
--
ALTER TABLE `genera`
  MODIFY `id_genera` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `id_herramienta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id_insumo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id_lote` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mide`
--
ALTER TABLE `mide`
  MODIFY `id_mide` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pea`
--
ALTER TABLE `pea`
  MODIFY `id_pea` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plantacion`
--
ALTER TABLE `plantacion`
  MODIFY `id_plantacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `id_produccion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programacion`
--
ALTER TABLE `programacion`
  MODIFY `id_programacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `realiza`
--
ALTER TABLE `realiza`
  MODIFY `id_realiza` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `requiere`
--
ALTER TABLE `requiere`
  MODIFY `id_requiere` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `residuos`
--
ALTER TABLE `residuos`
  MODIFY `id_residuo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `semilleros`
--
ALTER TABLE `semilleros`
  MODIFY `id_semillero` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sensores`
--
ALTER TABLE `sensores`
  MODIFY `id_sensor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_cultivo`
--
ALTER TABLE `tipo_cultivo`
  MODIFY `id_tipo_cultivo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_residuos`
--
ALTER TABLE `tipo_residuos`
  MODIFY `id_tipo_residuo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `utiliza`
--
ALTER TABLE `utiliza`
  MODIFY `id_utiliza` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_actividad`
--
ALTER TABLE `asignacion_actividad`
  ADD CONSTRAINT `asignacion_actividad_ibfk_1` FOREIGN KEY (`fk_id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `asignacion_actividad_ibfk_2` FOREIGN KEY (`fk_identificacion`) REFERENCES `usuarios` (`identificacion`);

--
-- Filtros para la tabla `control_fitosanitario`
--
ALTER TABLE `control_fitosanitario`
  ADD CONSTRAINT `desarrollan_control_fitosanitario` FOREIGN KEY (`fk_id_desarrollan`) REFERENCES `desarrollan` (`id_desarrollan`);

--
-- Filtros para la tabla `control_usa_insumo`
--
ALTER TABLE `control_usa_insumo`
  ADD CONSTRAINT `control_fitosanitario_usa_insumo` FOREIGN KEY (`fk_id_control_fitosanitario`) REFERENCES `control_fitosanitario` (`id_control_fitosanitario`),
  ADD CONSTRAINT `control_usa_insumo_ibfk_1` FOREIGN KEY (`fk_id_insumo`) REFERENCES `insumos` (`id_insumo`);

--
-- Filtros para la tabla `cultivo`
--
ALTER TABLE `cultivo`
  ADD CONSTRAINT `especie_cultivo` FOREIGN KEY (`fk_id_especie`) REFERENCES `especie` (`id_especie`),
  ADD CONSTRAINT `semillero_cultivo` FOREIGN KEY (`fk_id_semillero`) REFERENCES `semilleros` (`id_semillero`);

--
-- Filtros para la tabla `desarrollan`
--
ALTER TABLE `desarrollan`
  ADD CONSTRAINT `desarrollan_ibfk_1` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `pea_desarrollan` FOREIGN KEY (`fk_id_pea`) REFERENCES `pea` (`id_pea`);

--
-- Filtros para la tabla `eras`
--
ALTER TABLE `eras`
  ADD CONSTRAINT `lote_era` FOREIGN KEY (`fk_id_lote`) REFERENCES `lote` (`id_lote`);

--
-- Filtros para la tabla `especie`
--
ALTER TABLE `especie`
  ADD CONSTRAINT `tipo_especie` FOREIGN KEY (`fk_id_tipo_cultivo`) REFERENCES `tipo_cultivo` (`id_tipo_cultivo`);

--
-- Filtros para la tabla `genera`
--
ALTER TABLE `genera`
  ADD CONSTRAINT `cultivo_gen` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `produ_gen` FOREIGN KEY (`fk_id_produccion`) REFERENCES `produccion` (`id_produccion`);

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `ubicacion_lote` FOREIGN KEY (`fk_id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`);

--
-- Filtros para la tabla `mide`
--
ALTER TABLE `mide`
  ADD CONSTRAINT `era_mide` FOREIGN KEY (`fk_id_era`) REFERENCES `eras` (`id_eras`),
  ADD CONSTRAINT `mide_ibfk_1` FOREIGN KEY (`fk_id_sensor`) REFERENCES `sensores` (`id_sensor`);

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`fk_id_programacion`) REFERENCES `programacion` (`id_programacion`);

--
-- Filtros para la tabla `plantacion`
--
ALTER TABLE `plantacion`
  ADD CONSTRAINT `era_plantacion` FOREIGN KEY (`fk_id_era`) REFERENCES `eras` (`id_eras`),
  ADD CONSTRAINT `plantacion_ibfk_1` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`);

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `fk_cultivo_prod` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `fk_lote_prod` FOREIGN KEY (`fk_id_lote`) REFERENCES `lote` (`id_lote`);

--
-- Filtros para la tabla `programacion`
--
ALTER TABLE `programacion`
  ADD CONSTRAINT `programacion_ibfk_1` FOREIGN KEY (`fk_id_asignacion_actividad`) REFERENCES `asignacion_actividad` (`id_asignacion_actividad`),
  ADD CONSTRAINT `programacion_ibfk_2` FOREIGN KEY (`fk_id_calendario_lunar`) REFERENCES `calendario_lunar` (`id_calendario_lunar`);

--
-- Filtros para la tabla `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `actividad_realiza` FOREIGN KEY (`fk_id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `realiza_ibfk_1` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`);

--
-- Filtros para la tabla `requiere`
--
ALTER TABLE `requiere`
  ADD CONSTRAINT `requiere_ibfk_1` FOREIGN KEY (`fk_id_herramienta`) REFERENCES `herramientas` (`id_herramienta`),
  ADD CONSTRAINT `requiere_ibfk_2` FOREIGN KEY (`fk_id_asignacion_actividad`) REFERENCES `asignacion_actividad` (`id_asignacion_actividad`);

--
-- Filtros para la tabla `residuos`
--
ALTER TABLE `residuos`
  ADD CONSTRAINT `cultivo_residuo` FOREIGN KEY (`fk_id_cultivo`) REFERENCES `cultivo` (`id_cultivo`),
  ADD CONSTRAINT `tipo_residuo_residuo` FOREIGN KEY (`fk_id_tipo_residuo`) REFERENCES `tipo_residuos` (`id_tipo_residuo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`fk_id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `utiliza`
--
ALTER TABLE `utiliza`
  ADD CONSTRAINT `utiliza_ibfk_1` FOREIGN KEY (`fk_id_insumo`) REFERENCES `insumos` (`id_insumo`),
  ADD CONSTRAINT `utiliza_ibfk_2` FOREIGN KEY (`fk_id_asignacion_actividad`) REFERENCES `asignacion_actividad` (`id_asignacion_actividad`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_produccion_venta` FOREIGN KEY (`fk_id_produccion`) REFERENCES `produccion` (`id_produccion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
