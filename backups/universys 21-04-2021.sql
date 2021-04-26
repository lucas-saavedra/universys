-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2021 a las 14:42:27
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `universys`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hora_inicio` time NOT NULL,
  `hola_fin` time NOT NULL,
  `dia_id` enum('l','m','x','j','v','s','d') NOT NULL,
  `estado_asistencia` enum('presente','falta','tarde','') NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `docente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `nombre`, `docente_id`) VALUES
(1, 'Docente BD', 3),
(2, 'Auxiliar Inf', 3),
(3, 'Docente Prog. Avanzada', 3);

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
-- Estructura de tabla para la tabla `detalle_jornada`
--

CREATE TABLE `detalle_jornada` (
  `id` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `dia` enum('l','m','x','j','v','s','d') NOT NULL,
  `id_jornada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_jornada`
--

INSERT INTO `detalle_jornada` (`id`, `hora_inicio`, `hora_fin`, `dia`, `id_jornada`) VALUES
(3, '10:00:00', '11:00:00', 'm', 1),
(4, '14:00:00', '17:00:00', 'j', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `dni` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `nombre`, `dni`, `usuario_id`) VALUES
(2, 'Gomez Ramiro', 1234567, 0),
(3, 'Omar Panozzo', 99999999, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id` int(11) NOT NULL,
  `tipo` enum('mañana','tarde','noche') NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada`
--

INSERT INTO `jornada` (`id`, `tipo`, `fecha_inicio`, `fecha_fin`, `id_cargo`) VALUES
(1, 'mañana', '2021-04-20', '2021-04-20', 1),
(2, 'tarde', '2021-04-20', '2021-04-20', 1),
(3, 'tarde', '2021-04-20', '2021-05-20', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcacion`
--

CREATE TABLE `marcacion` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hola_fin` time NOT NULL,
  `dia_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marcacion`
--

INSERT INTO `marcacion` (`id`, `fecha`, `hora_inicio`, `hola_fin`, `dia_id`, `docente_id`) VALUES
(10, '2021-04-20', '11:10:12', '11:30:00', 1, 3),
(11, '2021-04-20', '11:14:05', '11:14:05', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `dni` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `sexo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasenia`, `email`) VALUES
(1, 'omar', '1234', 'omar@mail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `catedras`
--
ALTER TABLE `catedras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jornada` (`id_jornada`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Indices de la tabla `marcacion`
--
ALTER TABLE `marcacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `catedras`
--
ALTER TABLE `catedras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marcacion`
--
ALTER TABLE `marcacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `cargo_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);

--
-- Filtros para la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  ADD CONSTRAINT `detalle_jornada_ibfk_1` FOREIGN KEY (`id_jornada`) REFERENCES `jornada` (`id`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`);

--
-- Filtros para la tabla `marcacion`
--
ALTER TABLE `marcacion`
  ADD CONSTRAINT `marcacion_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
