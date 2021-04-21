-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-04-2021 a las 14:33:12
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tablas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catedras`
--

CREATE TABLE `catedras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `catedras`
--

INSERT INTO `catedras` (`id`, `nombre`) VALUES
(1, 'Base de Datos'),
(2, 'Ingenieria en software 2'),
(3, 'Programacion avanzada'),
(4, 'Ingenieria en software 1'),
(5, 'Sistemas y Organizaciones'),
(6, 'Logica y Algebra'),
(7, 'Fundamentos de Programacion'),
(8, 'Calculo Diferencia e Integral'),
(9, 'Lecto Comprension en Ingles'),
(10, 'Fundamento de Computacion'),
(11, 'Programacion Orientada a Objetos'),
(12, 'Matematicas Discretas'),
(13, 'Algoritmos y Estructura de datos'),
(14, 'Informatica Aplicada al Diseño'),
(15, 'Arquitectura de computadoras'),
(16, 'Taller de Integracion'),
(17, 'Sistemas Operativos'),
(18, 'Probabilidad y Estadisticas'),
(19, 'Ingenieria en Software 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

CREATE TABLE `dias` (
  `id` int(11) NOT NULL,
  `dia` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `dia`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miercoles'),
(4, 'Jueves'),
(5, 'Viernes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `nombre`, `dni`) VALUES
(1, 'Panozzo Omar', 12345678),
(2, 'Gomez Ramiro', 1234567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `id` int(11) NOT NULL,
  `hora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`id`, `hora`) VALUES
(1, 14),
(2, 15),
(3, 16),
(4, 17),
(5, 18),
(6, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas`
--

CREATE TABLE `tablas` (
  `id` int(11) NOT NULL,
  `id_hora` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_catedra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablas`
--

INSERT INTO `tablas` (`id`, `id_hora`, `id_dia`, `id_docente`, `id_catedra`) VALUES
(1, 1, 1, 1, 9),
(2, 2, 1, 2, 1),
(3, 3, 1, 2, 4),
(4, 4, 1, 2, 4),
(5, 5, 1, NULL, NULL),
(6, 6, 1, NULL, NULL),
(25, 1, 2, 1, 2),
(26, 2, 2, 2, 2),
(27, 3, 2, NULL, 2),
(28, 4, 2, NULL, 1),
(29, 5, 2, NULL, 2),
(30, 6, 2, NULL, NULL),
(31, 1, 3, 2, 2),
(32, 2, 3, NULL, NULL),
(33, 3, 3, NULL, NULL),
(34, 4, 3, NULL, NULL),
(35, 5, 3, NULL, NULL),
(36, 6, 3, NULL, NULL),
(37, 1, 4, NULL, NULL),
(38, 2, 4, NULL, NULL),
(39, 3, 4, 1, 1),
(40, 4, 4, NULL, NULL),
(41, 5, 4, NULL, NULL),
(42, 6, 4, 2, 4),
(43, 1, 5, 1, 1),
(44, 2, 5, NULL, NULL),
(45, 3, 5, NULL, NULL),
(46, 4, 5, NULL, NULL),
(47, 5, 5, 2, 2),
(48, 6, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_sistemas`
--

CREATE TABLE `tablas_sistemas` (
  `id` int(11) NOT NULL,
  `id_hora` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_catedra` int(11) DEFAULT NULL,
  `anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablas_sistemas`
--

INSERT INTO `tablas_sistemas` (`id`, `id_hora`, `id_dia`, `id_docente`, `id_catedra`, `anio`) VALUES
(1, 1, 1, NULL, NULL, 1),
(2, 2, 1, NULL, 5, 1),
(3, 3, 1, NULL, 6, 1),
(4, 4, 1, NULL, 6, 1),
(5, 5, 1, NULL, 8, 1),
(6, 6, 1, NULL, 8, 1),
(13, 1, 2, NULL, NULL, 1),
(14, 2, 2, NULL, NULL, 1),
(15, 3, 2, NULL, 7, 1),
(16, 4, 2, NULL, 7, 1),
(17, 5, 2, NULL, 8, 1),
(18, 6, 2, NULL, 8, 1),
(19, 1, 3, NULL, 7, 1),
(20, 2, 3, NULL, 7, 1),
(21, 3, 3, NULL, 7, 1),
(22, 4, 3, NULL, 9, 1),
(23, 5, 3, NULL, 9, 1),
(24, 6, 3, NULL, NULL, 1),
(25, 1, 4, NULL, NULL, 1),
(26, 2, 4, NULL, NULL, 1),
(27, 3, 4, NULL, NULL, 1),
(28, 4, 4, NULL, 5, 1),
(29, 5, 4, NULL, 5, 1),
(30, 6, 4, NULL, 5, 1),
(31, 1, 5, NULL, NULL, 1),
(32, 2, 5, NULL, 10, 1),
(33, 3, 5, NULL, 10, 1),
(34, 4, 5, NULL, 10, 1),
(35, 5, 5, NULL, 6, 1),
(36, 6, 5, NULL, 6, 1),
(37, 1, 1, NULL, NULL, 2),
(38, 2, 1, NULL, NULL, 2),
(39, 3, 1, NULL, NULL, 2),
(40, 4, 1, NULL, NULL, 2),
(41, 5, 1, NULL, 4, 2),
(42, 6, 1, NULL, 4, 2),
(43, 1, 2, NULL, NULL, 2),
(44, 2, 2, NULL, 12, 2),
(45, 3, 2, NULL, 12, 2),
(46, 4, 2, NULL, 13, 2),
(47, 5, 2, NULL, 13, 2),
(48, 6, 2, NULL, 13, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catedras`
--
ALTER TABLE `catedras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias`
--
ALTER TABLE `dias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tablas`
--
ALTER TABLE `tablas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hora` (`id_hora`),
  ADD KEY `id_dia` (`id_dia`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_catedra` (`id_catedra`);

--
-- Indices de la tabla `tablas_sistemas`
--
ALTER TABLE `tablas_sistemas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hora` (`id_hora`),
  ADD KEY `id_dia` (`id_dia`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_catedra` (`id_catedra`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catedras`
--
ALTER TABLE `catedras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `dias`
--
ALTER TABLE `dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tablas`
--
ALTER TABLE `tablas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `tablas_sistemas`
--
ALTER TABLE `tablas_sistemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tablas`
--
ALTER TABLE `tablas`
  ADD CONSTRAINT `tablas_ibfk_1` FOREIGN KEY (`id_hora`) REFERENCES `horas` (`id`),
  ADD CONSTRAINT `tablas_ibfk_2` FOREIGN KEY (`id_dia`) REFERENCES `dias` (`id`),
  ADD CONSTRAINT `tablas_ibfk_3` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `tablas_ibfk_4` FOREIGN KEY (`id_catedra`) REFERENCES `catedras` (`id`);

--
-- Filtros para la tabla `tablas_sistemas`
--
ALTER TABLE `tablas_sistemas`
  ADD CONSTRAINT `tablas_sistemas_ibfk_1` FOREIGN KEY (`id_hora`) REFERENCES `horas` (`id`),
  ADD CONSTRAINT `tablas_sistemas_ibfk_2` FOREIGN KEY (`id_dia`) REFERENCES `dias` (`id`),
  ADD CONSTRAINT `tablas_sistemas_ibfk_3` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `tablas_sistemas_ibfk_4` FOREIGN KEY (`id_catedra`) REFERENCES `catedras` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
