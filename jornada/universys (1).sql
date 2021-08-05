-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2021 a las 16:52:46
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
-- Estructura Stand-in para la vista `agente_nombre`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `agente_nombre` (
`id` int(11)
,`nombre` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_plan`
--

CREATE TABLE `anio_plan` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `anio_plan`
--

INSERT INTO `anio_plan` (`id`, `nombre`) VALUES
(1, '1ro'),
(2, '2do'),
(3, '3ro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `nombre`) VALUES
(1, 'Personal'),
(2, 'Coordinacion'),
(3, 'Alumnado'),
(4, 'Extension'),
(5, 'Ordenanza'),
(6, 'Prensa'),
(7, 'Mesa Entrada'),
(8, 'Biblioteca'),
(9, 'Informatica'),
(10, 'Director Carrera'),
(11, 'Mesa Envios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_docente`
--

CREATE TABLE `asistencia_docente` (
  `id` int(11) NOT NULL,
  `detalle_jornada_id` int(11) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `estado_asistencia` enum('presente','falta','tarde') DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_no_docente`
--

CREATE TABLE `asistencia_no_docente` (
  `id` int(11) NOT NULL,
  `detalle_jornada_id` int(11) DEFAULT NULL,
  `no_docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `estado_asistencia` enum('presente','falta','tarde') DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE `aviso` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `validez` tinyint(1) DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id`, `nombre`) VALUES
(1, 'Analisis de Sistemas'),
(2, 'Prod. Agropecuaria'),
(3, 'Gestion Ambiental');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catedra`
--

CREATE TABLE `catedra` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `carrera_id` int(11) DEFAULT NULL,
  `anio_plan_id` int(11) DEFAULT NULL,
  `periodo_id` int(11) DEFAULT NULL,
  `total_horas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `catedra`
--

INSERT INTO `catedra` (`id`, `nombre`, `carrera_id`, `anio_plan_id`, `periodo_id`, `total_horas`) VALUES
(1, 'Lógica y Álgebra', 1, 1, 3, NULL),
(2, 'Cálculo Diferencial e Integral', 1, 1, 3, NULL),
(3, 'Sistemas y Organizaciones', 1, 1, 3, NULL),
(4, 'Derechos Humanos y Tecnología', 1, 1, 1, NULL),
(5, 'Fundamentos De Computación', 1, 1, 1, NULL),
(6, 'Matemática Discreta', 1, 2, 3, NULL),
(7, 'Ec. Diferenciales y Calc. Multivariado', 1, 2, 2, NULL),
(8, 'Arquitectura De Computadoras', 1, 2, 1, NULL),
(9, 'Probabilidad y Estadística', 1, 3, 3, NULL),
(10, 'Paradigmas y Lenguajes', 1, 3, 2, NULL),
(11, 'Ética Profesional', 1, 3, 1, NULL),
(12, 'Inglés Técnico I', 3, 1, 3, NULL),
(13, 'Química General', 3, 1, 1, NULL),
(14, 'Biología', 3, 1, 2, NULL),
(15, 'Inglés Técnico II', 3, 2, 3, NULL),
(16, 'Derecho Ambiental', 3, 2, 2, NULL),
(17, 'Informática II', 3, 2, 1, NULL),
(18, 'Tratamiento de Residuos Sólidos', 3, 3, 3, NULL),
(19, 'Efluentes Líquidos', 3, 3, 2, NULL),
(20, 'Gestión Recurso Suelo', 3, 3, 1, NULL),
(21, 'Inglés Técnico I', 2, 1, 3, NULL),
(22, 'Administración Agropecuaria I', 2, 1, 1, NULL),
(23, 'Anatomía Animal', 2, 1, 2, NULL),
(24, 'Inglés Técnico II', 2, 2, 3, NULL),
(25, 'Microbiología', 2, 2, 2, NULL),
(26, 'Fisiología Vegetal', 2, 2, 1, NULL),
(27, 'Práctica Profesional', 2, 3, 3, NULL),
(28, 'Ética y Deontología Profesional', 2, 3, 2, NULL),
(29, 'Cultivo Extensivo', 2, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo`
--

CREATE TABLE `codigo` (
  `id` int(11) NOT NULL,
  `nombre` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `es_docente` tinyint(1) DEFAULT NULL,
  `es_no_docente` tinyint(1) DEFAULT NULL,
  `tipo_inasistencia_id` int(11) DEFAULT NULL,
  `con_descuento` tinyint(1) DEFAULT NULL,
  `requiere_aviso` tinyint(1) DEFAULT NULL,
  `requiere_doc` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupo`
--

CREATE TABLE `cupo` (
  `id` int(11) NOT NULL,
  `codigo_id` int(11) DEFAULT NULL,
  `cantidad_max_dias` int(11) DEFAULT NULL,
  `rango` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_jornada`
--

CREATE TABLE `detalle_jornada` (
  `id` int(11) NOT NULL,
  `jornada_id` int(11) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_jornada`
--

INSERT INTO `detalle_jornada` (`id`, `jornada_id`, `hora_inicio`, `hora_fin`, `dia`, `descripcion`) VALUES
(31, 164, '19:30:00', '20:30:00', 4, 'ewr'),
(32, 165, '20:00:00', '18:00:00', 0, 'hgg'),
(93, 225, '15:00:00', '19:00:00', 0, NULL),
(94, 225, '16:00:00', '19:00:00', 1, NULL),
(95, 225, '16:00:00', '19:00:00', 2, NULL),
(96, 225, '20:00:00', '22:00:00', 3, NULL),
(97, 225, '16:00:00', '19:00:00', 4, NULL),
(98, 225, '18:00:00', '19:00:00', 5, NULL),
(99, 225, '17:00:00', '19:00:00', 6, NULL),
(132, 177, '10:30:00', '11:30:00', 3, 'test'),
(175, 164, '20:00:00', '21:00:00', 3, '123'),
(240, 259, '11:00:00', '13:00:00', 2, 'test_hor_no_modal_hide'),
(241, 258, '10:00:00', '12:00:00', 2, 'test_5'),
(243, 259, '22:30:00', '03:30:00', 1, 'tests_upd_hor'),
(246, 257, '11:00:00', '12:00:00', 1, 'tesrt'),
(285, 271, '10:00:00', '11:00:00', 4, 'test'),
(286, 272, '20:00:00', '23:00:00', 0, NULL),
(287, 272, '16:00:00', '19:00:00', 1, NULL),
(288, 272, '16:00:00', '19:00:00', 2, NULL),
(289, 272, '16:00:00', '19:00:00', 3, NULL),
(290, 272, '16:00:00', '19:00:00', 4, NULL),
(291, 272, '16:00:00', '19:00:00', 5, NULL),
(292, 272, '16:00:00', '19:00:00', 6, NULL),
(293, 177, '14:30:00', '15:30:00', 3, 'test'),
(294, 177, '11:00:00', '12:00:00', 1, 'test'),
(295, 274, '21:00:00', '23:00:00', 0, NULL),
(296, 274, '16:00:00', '19:00:00', 1, NULL),
(297, 274, '16:00:00', '19:00:00', 2, NULL),
(298, 274, '16:00:00', '19:00:00', 3, NULL),
(299, 274, '16:00:00', '19:00:00', 4, NULL),
(300, 274, '16:00:00', '19:00:00', 5, NULL),
(301, 274, '16:00:00', '19:00:00', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia`
--

CREATE TABLE `dia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dia`
--

INSERT INTO `dia` (`id`, `nombre`) VALUES
(0, 'Lunes'),
(1, 'Martes'),
(2, 'Miércoles'),
(3, 'Jueves'),
(4, 'Viernes'),
(5, 'Sábado'),
(6, 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `antiguedad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `persona_id`, `antiguedad`) VALUES
(1, 1, NULL),
(2, 2, NULL),
(3, 3, NULL),
(4, 6, NULL),
(5, 7, NULL),
(6, 12, NULL),
(8, 13, NULL),
(9, 10, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `docente_nombre`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `docente_nombre` (
`id` int(11)
,`nombre` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion_justificada`
--

CREATE TABLE `documentacion_justificada` (
  `id` int(11) NOT NULL,
  `tipo_justificacion_id` int(11) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `entrega_en_termino` tinyint(1) DEFAULT NULL,
  `fecha_recepcion` datetime DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente`
--

CREATE TABLE `expediente` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `cupo_superado` tinyint(1) DEFAULT NULL,
  `doc_justificada_id` int(11) DEFAULT NULL,
  `aviso_id` int(11) DEFAULT NULL,
  `codigo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_detalle`
--

CREATE TABLE `expediente_detalle` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) DEFAULT NULL,
  `det_jornada_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_docente`
--

CREATE TABLE `expediente_docente` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_no_docente`
--

CREATE TABLE `expediente_no_docente` (
  `id` int(11) NOT NULL,
  `expediente_id` int(11) DEFAULT NULL,
  `no_docente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_planilla_docente`
--

CREATE TABLE `expediente_planilla_docente` (
  `id` int(11) NOT NULL,
  `planilla_productividad_docente_id` int(11) DEFAULT NULL,
  `expediente_docente_id` int(11) DEFAULT NULL,
  `hs_descontadas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_planilla_no_docente`
--

CREATE TABLE `expediente_planilla_no_docente` (
  `id` int(11) NOT NULL,
  `planilla_productividad_no_docente_id` int(11) DEFAULT NULL,
  `expediente_no_docente_id` int(11) DEFAULT NULL,
  `hs_descontadas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencia_sin_aviso_docente`
--

CREATE TABLE `inasistencia_sin_aviso_docente` (
  `id` int(11) NOT NULL,
  `expediente_docente_id` int(11) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencia_sin_aviso_no_docente`
--

CREATE TABLE `inasistencia_sin_aviso_no_docente` (
  `id` int(11) NOT NULL,
  `expediente_no_docente_id` int(11) DEFAULT NULL,
  `no_docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `tipo_jornada_id` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada`
--

INSERT INTO `jornada` (`id`, `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) VALUES
(96, '2021-07-30', '2021-07-10', 5, 'dfgg'),
(101, '2021-07-10', '2021-07-04', 5, 'ddd'),
(102, '2021-07-10', '2021-07-04', 5, 'ddd'),
(131, '2021-07-22', '2021-07-14', 5, 'hfghfghfg'),
(135, '2021-09-07', '2021-08-29', 5, 'ftyhdy'),
(145, '2021-07-17', '2021-07-08', 6, 'werwer'),
(164, '2021-07-01', '2021-07-01', 3, 'sss'),
(165, '2021-07-01', '2021-07-11', 2, 'dd'),
(177, '2022-12-29', '2022-01-01', 3, 'test gente'),
(225, '2021-07-19', '2022-07-19', 4, 'test delete'),
(254, '2021-07-11', '2021-07-09', 6, 'te'),
(256, '2021-08-06', '2021-08-18', 6, 'test'),
(257, '2021-08-12', '2021-08-28', 5, 'test1'),
(258, '2021-08-12', '2021-08-31', 5, 'test_2'),
(259, '2021-08-10', '2021-08-20', 7, 'test_3'),
(271, '2021-08-07', '2021-08-28', 6, 'test'),
(272, '2021-07-01', '2021-07-30', 4, 'test'),
(274, '2021-07-01', '2021-07-30', 4, 'test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada_docente`
--

CREATE TABLE `jornada_docente` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `jornada_id` int(11) DEFAULT NULL,
  `catedra_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada_docente`
--

INSERT INTO `jornada_docente` (`id`, `docente_id`, `jornada_id`, `catedra_id`) VALUES
(104, 2, 164, 16),
(105, 3, 165, 13),
(109, 4, 177, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada_docente_mesa`
--

CREATE TABLE `jornada_docente_mesa` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `det_jornada_id` int(11) DEFAULT NULL,
  `mesa_examen_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada_docente_mesa`
--

INSERT INTO `jornada_docente_mesa` (`id`, `docente_id`, `det_jornada_id`, `mesa_examen_id`) VALUES
(165, 1, 286, 64),
(166, 2, 286, 64),
(167, 3, 286, 64),
(168, 4, 286, 64),
(169, 5, 286, 64),
(172, 4, 287, 64),
(173, 5, 287, 64),
(174, 8, 288, 64);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada_no_docente`
--

CREATE TABLE `jornada_no_docente` (
  `id` int(11) NOT NULL,
  `no_docente_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `jornada_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jornada_no_docente`
--

INSERT INTO `jornada_no_docente` (`id`, `no_docente_id`, `area_id`, `jornada_id`) VALUES
(29, 4, 1, 257),
(30, 3, 2, 258),
(31, 1, 8, 259),
(34, 3, 1, 271);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamado`
--

CREATE TABLE `llamado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `llamado`
--

INSERT INTO `llamado` (`id`, `nombre`) VALUES
(1, '1er Llamado'),
(2, '2do Llamado'),
(3, '3er Llamado'),
(4, '4to Llamado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcacion_docente`
--

CREATE TABLE `marcacion_docente` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_registro` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `estado` enum('entrada','salida') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcacion_no_docente`
--

CREATE TABLE `marcacion_no_docente` (
  `id` int(11) NOT NULL,
  `no_docente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_registro` time DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `estado` enum('entrada','salida') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes`
--

CREATE TABLE `mes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id` int(11) NOT NULL,
  `carrera_id` int(11) DEFAULT NULL,
  `llamado_id` int(11) DEFAULT NULL,
  `jornada_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesa_examen`
--

INSERT INTO `mesa_examen` (`id`, `carrera_id`, `llamado_id`, `jornada_id`) VALUES
(64, 2, 1, 272),
(65, 1, 1, 274);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `mesa_examen_jornada`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `mesa_examen_jornada` (
`id` int(11)
,`jornada_id` int(11)
,`carrera_nombre` varchar(100)
,`carreraId` int(11)
,`llamadoId` int(11)
,`llamado_nombre` varchar(50)
,`fecha_inicio` date
,`fecha_fin` date
,`descripcion` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `no_docente`
--

CREATE TABLE `no_docente` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `antiguedad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `no_docente`
--

INSERT INTO `no_docente` (`id`, `persona_id`, `antiguedad`) VALUES
(1, 4, NULL),
(2, 5, NULL),
(3, 6, NULL),
(4, 7, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id`, `nombre`) VALUES
(1, '1er Cuatrimestre'),
(2, '2do Cuatrimestre'),
(3, 'Anual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contrasenia` varchar(20) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `direccion` varchar(30) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `email`, `contrasenia`, `dni`, `direccion`, `telefono`) VALUES
(1, 'Nayra Asensio', 'nayra@gmail.com', '1234', NULL, NULL, NULL),
(2, 'Roman Morano', 'roman@gmail.com', '1234', NULL, NULL, NULL),
(3, 'Ion Machado', 'ion@gmail.com', '1234', NULL, NULL, NULL),
(4, 'Andoni Roig', 'andoni@gmail.com', '1234', NULL, NULL, NULL),
(5, 'Samuel Vicente', 'samuel@gmail.com', '1234', NULL, NULL, NULL),
(6, 'Enriqueta Galan', 'enriqueta@gmail.com', '1234', NULL, NULL, NULL),
(7, 'Pilar Fernandez', 'pilar@gmail.com', '1234', NULL, NULL, NULL),
(8, 'Jean Ubeda', 'jean@gmail.com', '1234', NULL, NULL, NULL),
(9, 'Gerard Carballo', 'roman@gmail.com', '1234', NULL, NULL, NULL),
(10, 'Laura Salvador', 'lu@gmail.com', '1234', NULL, NULL, NULL),
(11, 'Josep Lobato', 'jojo@gmail.com', '1234', NULL, NULL, NULL),
(12, 'Jan Gimeno', 'jan@gmail.com', '1234', NULL, NULL, NULL),
(13, 'Teofilo del Rio', 'teo@gmail.com', '1234', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla_productividad_docente`
--

CREATE TABLE `planilla_productividad_docente` (
  `id` int(11) NOT NULL,
  `mes_id` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `observaciones` varchar(50) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla_productividad_no_docente`
--

CREATE TABLE `planilla_productividad_no_docente` (
  `id` int(11) NOT NULL,
  `mes_id` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `observaciones` varchar(50) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_inasistencia`
--

CREATE TABLE `tipo_inasistencia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_jornada`
--

CREATE TABLE `tipo_jornada` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `pertenece` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_jornada`
--

INSERT INTO `tipo_jornada` (`id`, `nombre`, `pertenece`) VALUES
(1, '1er Cuatrimestre', 'docente'),
(2, '2do Cuatrimestre', 'docente'),
(3, 'Anual', 'docente'),
(4, 'Mesa de Examen', 'mesa'),
(5, 'Mañana', 'no_docente'),
(6, 'Tarde', 'no_docente'),
(7, 'Noche', 'no_docente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_justificacion`
--

CREATE TABLE `tipo_justificacion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_jornada`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_jornada` (
`id` int(11)
,`tipo_jornada_id` int(11)
,`fecha_inicio` date
,`fecha_fin` date
,`nombre` varchar(50)
,`descripcion` varchar(100)
,`pertenece` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `agente_nombre`
--
DROP TABLE IF EXISTS `agente_nombre`;

CREATE ALGORITHM=UNDEFINED /* DEFINER=`root`@`localhost` */ SQL SECURITY DEFINER VIEW `agente_nombre`  AS SELECT `no_docente`.`id` AS `id`, `persona`.`nombre` AS `nombre` FROM (`no_docente` left join `persona` on(`no_docente`.`persona_id` = `persona`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `docente_nombre`
--
DROP TABLE IF EXISTS `docente_nombre`;

CREATE ALGORITHM=UNDEFINED /* DEFINER=`root`@`localhost` */ SQL SECURITY DEFINER VIEW `docente_nombre`  AS SELECT `docente`.`id` AS `id`, `persona`.`nombre` AS `nombre` FROM (`docente` left join `persona` on(`docente`.`persona_id` = `persona`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `mesa_examen_jornada`
--
DROP TABLE IF EXISTS `mesa_examen_jornada`;

CREATE ALGORITHM=UNDEFINED /* DEFINER=`root`@`localhost` */ SQL SECURITY DEFINER VIEW `mesa_examen_jornada`  AS SELECT `mesa_examen`.`id` AS `id`, `mesa_examen`.`jornada_id` AS `jornada_id`, `carrera`.`nombre` AS `carrera_nombre`, `carrera`.`id` AS `carreraId`, `llamado`.`id` AS `llamadoId`, `llamado`.`nombre` AS `llamado_nombre`, `v_jornada`.`fecha_inicio` AS `fecha_inicio`, `v_jornada`.`fecha_fin` AS `fecha_fin`, `v_jornada`.`descripcion` AS `descripcion` FROM (((`mesa_examen` left join `carrera` on(`mesa_examen`.`carrera_id` = `carrera`.`id`)) left join `llamado` on(`mesa_examen`.`llamado_id` = `llamado`.`id`)) left join `v_jornada` on(`mesa_examen`.`jornada_id` = `v_jornada`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_jornada`
--
DROP TABLE IF EXISTS `v_jornada`;

CREATE ALGORITHM=UNDEFINED /* DEFINER=`root`@`localhost` */ SQL SECURITY DEFINER VIEW `v_jornada`  AS SELECT `jornada`.`id` AS `id`, `tipo_jornada`.`id` AS `tipo_jornada_id`, `jornada`.`fecha_inicio` AS `fecha_inicio`, `jornada`.`fecha_fin` AS `fecha_fin`, `tipo_jornada`.`nombre` AS `nombre`, `jornada`.`descripcion` AS `descripcion`, `tipo_jornada`.`pertenece` AS `pertenece` FROM (`jornada` left join `tipo_jornada` on(`jornada`.`tipo_jornada_id` = `tipo_jornada`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anio_plan`
--
ALTER TABLE `anio_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencia_docente`
--
ALTER TABLE `asistencia_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `detalle_jornada_id` (`detalle_jornada_id`);

--
-- Indices de la tabla `asistencia_no_docente`
--
ALTER TABLE `asistencia_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_docente_id` (`no_docente_id`),
  ADD KEY `detalle_jornada_id` (`detalle_jornada_id`);

--
-- Indices de la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catedra`
--
ALTER TABLE `catedra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrera_id` (`carrera_id`),
  ADD KEY `anio_plan_id` (`anio_plan_id`),
  ADD KEY `periodo_id` (`periodo_id`);

--
-- Indices de la tabla `codigo`
--
ALTER TABLE `codigo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_inasistencia_id` (`tipo_inasistencia_id`);

--
-- Indices de la tabla `cupo`
--
ALTER TABLE `cupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_id` (`codigo_id`);

--
-- Indices de la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jornada_id` (`jornada_id`);

--
-- Indices de la tabla `dia`
--
ALTER TABLE `dia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `documentacion_justificada`
--
ALTER TABLE `documentacion_justificada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_justificacion_id` (`tipo_justificacion_id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_justificada_id` (`doc_justificada_id`),
  ADD KEY `aviso_id` (`aviso_id`),
  ADD KEY `codigo_id` (`codigo_id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `expediente_detalle`
--
ALTER TABLE `expediente_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `det_jornada_id` (`det_jornada_id`);

--
-- Indices de la tabla `expediente_docente`
--
ALTER TABLE `expediente_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `expediente_no_docente`
--
ALTER TABLE `expediente_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `no_docente_id` (`no_docente_id`);

--
-- Indices de la tabla `expediente_planilla_docente`
--
ALTER TABLE `expediente_planilla_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planilla_productividad_docente_id` (`planilla_productividad_docente_id`),
  ADD KEY `expediente_docente_id` (`expediente_docente_id`);

--
-- Indices de la tabla `expediente_planilla_no_docente`
--
ALTER TABLE `expediente_planilla_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planilla_productividad_no_docente_id` (`planilla_productividad_no_docente_id`),
  ADD KEY `expediente_no_docente_id` (`expediente_no_docente_id`);

--
-- Indices de la tabla `inasistencia_sin_aviso_docente`
--
ALTER TABLE `inasistencia_sin_aviso_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_docente_id` (`expediente_docente_id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `inasistencia_sin_aviso_no_docente`
--
ALTER TABLE `inasistencia_sin_aviso_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expediente_no_docente_id` (`expediente_no_docente_id`),
  ADD KEY `no_docente_id` (`no_docente_id`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_jornada_id` (`tipo_jornada_id`);

--
-- Indices de la tabla `jornada_docente`
--
ALTER TABLE `jornada_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `jornada_id` (`jornada_id`),
  ADD KEY `catedra_id` (`catedra_id`);

--
-- Indices de la tabla `jornada_docente_mesa`
--
ALTER TABLE `jornada_docente_mesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `mesa_examen_id` (`mesa_examen_id`),
  ADD KEY `det_jornada_id` (`det_jornada_id`);

--
-- Indices de la tabla `jornada_no_docente`
--
ALTER TABLE `jornada_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `no_docente_id` (`no_docente_id`),
  ADD KEY `jornada_id` (`jornada_id`);

--
-- Indices de la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcacion_docente`
--
ALTER TABLE `marcacion_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `marcacion_no_docente`
--
ALTER TABLE `marcacion_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_docente_id` (`no_docente_id`);

--
-- Indices de la tabla `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrera_id` (`carrera_id`),
  ADD KEY `jornada_id` (`jornada_id`),
  ADD KEY `llamado_id` (`llamado_id`);

--
-- Indices de la tabla `no_docente`
--
ALTER TABLE `no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planilla_productividad_docente`
--
ALTER TABLE `planilla_productividad_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mes_id` (`mes_id`);

--
-- Indices de la tabla `planilla_productividad_no_docente`
--
ALTER TABLE `planilla_productividad_no_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mes_id` (`mes_id`);

--
-- Indices de la tabla `tipo_inasistencia`
--
ALTER TABLE `tipo_inasistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_jornada`
--
ALTER TABLE `tipo_jornada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_justificacion`
--
ALTER TABLE `tipo_justificacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anio_plan`
--
ALTER TABLE `anio_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `asistencia_docente`
--
ALTER TABLE `asistencia_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_no_docente`
--
ALTER TABLE `asistencia_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aviso`
--
ALTER TABLE `aviso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `catedra`
--
ALTER TABLE `catedra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `codigo`
--
ALTER TABLE `codigo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cupo`
--
ALTER TABLE `cupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `documentacion_justificada`
--
ALTER TABLE `documentacion_justificada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_detalle`
--
ALTER TABLE `expediente_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_docente`
--
ALTER TABLE `expediente_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_no_docente`
--
ALTER TABLE `expediente_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_planilla_docente`
--
ALTER TABLE `expediente_planilla_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expediente_planilla_no_docente`
--
ALTER TABLE `expediente_planilla_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inasistencia_sin_aviso_docente`
--
ALTER TABLE `inasistencia_sin_aviso_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inasistencia_sin_aviso_no_docente`
--
ALTER TABLE `inasistencia_sin_aviso_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT de la tabla `jornada_docente`
--
ALTER TABLE `jornada_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT de la tabla `jornada_docente_mesa`
--
ALTER TABLE `jornada_docente_mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de la tabla `jornada_no_docente`
--
ALTER TABLE `jornada_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `llamado`
--
ALTER TABLE `llamado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marcacion_docente`
--
ALTER TABLE `marcacion_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcacion_no_docente`
--
ALTER TABLE `marcacion_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mes`
--
ALTER TABLE `mes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `no_docente`
--
ALTER TABLE `no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `planilla_productividad_docente`
--
ALTER TABLE `planilla_productividad_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planilla_productividad_no_docente`
--
ALTER TABLE `planilla_productividad_no_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_inasistencia`
--
ALTER TABLE `tipo_inasistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_jornada`
--
ALTER TABLE `tipo_jornada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_justificacion`
--
ALTER TABLE `tipo_justificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia_docente`
--
ALTER TABLE `asistencia_docente`
  ADD CONSTRAINT `asistencia_docente_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `asistencia_docente_ibfk_2` FOREIGN KEY (`detalle_jornada_id`) REFERENCES `detalle_jornada` (`id`);

--
-- Filtros para la tabla `asistencia_no_docente`
--
ALTER TABLE `asistencia_no_docente`
  ADD CONSTRAINT `asistencia_no_docente_ibfk_1` FOREIGN KEY (`no_docente_id`) REFERENCES `no_docente` (`id`),
  ADD CONSTRAINT `asistencia_no_docente_ibfk_2` FOREIGN KEY (`detalle_jornada_id`) REFERENCES `detalle_jornada` (`id`);

--
-- Filtros para la tabla `catedra`
--
ALTER TABLE `catedra`
  ADD CONSTRAINT `catedra_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carrera` (`id`),
  ADD CONSTRAINT `catedra_ibfk_2` FOREIGN KEY (`anio_plan_id`) REFERENCES `anio_plan` (`id`),
  ADD CONSTRAINT `catedra_ibfk_3` FOREIGN KEY (`periodo_id`) REFERENCES `periodo` (`id`);

--
-- Filtros para la tabla `codigo`
--
ALTER TABLE `codigo`
  ADD CONSTRAINT `codigo_ibfk_1` FOREIGN KEY (`tipo_inasistencia_id`) REFERENCES `tipo_inasistencia` (`id`);

--
-- Filtros para la tabla `cupo`
--
ALTER TABLE `cupo`
  ADD CONSTRAINT `cupo_ibfk_1` FOREIGN KEY (`codigo_id`) REFERENCES `codigo` (`id`);

--
-- Filtros para la tabla `detalle_jornada`
--
ALTER TABLE `detalle_jornada`
  ADD CONSTRAINT `detalle_jornada_ibfk_1` FOREIGN KEY (`jornada_id`) REFERENCES `jornada` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `documentacion_justificada`
--
ALTER TABLE `documentacion_justificada`
  ADD CONSTRAINT `documentacion_justificada_ibfk_1` FOREIGN KEY (`tipo_justificacion_id`) REFERENCES `tipo_justificacion` (`id`),
  ADD CONSTRAINT `documentacion_justificada_ibfk_2` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD CONSTRAINT `expediente_ibfk_1` FOREIGN KEY (`doc_justificada_id`) REFERENCES `documentacion_justificada` (`id`),
  ADD CONSTRAINT `expediente_ibfk_2` FOREIGN KEY (`aviso_id`) REFERENCES `aviso` (`id`),
  ADD CONSTRAINT `expediente_ibfk_3` FOREIGN KEY (`codigo_id`) REFERENCES `codigo` (`id`),
  ADD CONSTRAINT `expediente_ibfk_4` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `expediente_detalle`
--
ALTER TABLE `expediente_detalle`
  ADD CONSTRAINT `expediente_detalle_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `expediente_detalle_ibfk_2` FOREIGN KEY (`det_jornada_id`) REFERENCES `detalle_jornada` (`id`);

--
-- Filtros para la tabla `expediente_docente`
--
ALTER TABLE `expediente_docente`
  ADD CONSTRAINT `expediente_docente_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `expediente_docente_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`);

--
-- Filtros para la tabla `expediente_no_docente`
--
ALTER TABLE `expediente_no_docente`
  ADD CONSTRAINT `expediente_no_docente_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expediente` (`id`),
  ADD CONSTRAINT `expediente_no_docente_ibfk_2` FOREIGN KEY (`no_docente_id`) REFERENCES `no_docente` (`id`);

--
-- Filtros para la tabla `expediente_planilla_docente`
--
ALTER TABLE `expediente_planilla_docente`
  ADD CONSTRAINT `expediente_planilla_docente_ibfk_1` FOREIGN KEY (`planilla_productividad_docente_id`) REFERENCES `planilla_productividad_docente` (`id`),
  ADD CONSTRAINT `expediente_planilla_docente_ibfk_2` FOREIGN KEY (`expediente_docente_id`) REFERENCES `expediente_docente` (`id`);

--
-- Filtros para la tabla `expediente_planilla_no_docente`
--
ALTER TABLE `expediente_planilla_no_docente`
  ADD CONSTRAINT `expediente_planilla_no_docente_ibfk_1` FOREIGN KEY (`planilla_productividad_no_docente_id`) REFERENCES `planilla_productividad_no_docente` (`id`),
  ADD CONSTRAINT `expediente_planilla_no_docente_ibfk_2` FOREIGN KEY (`expediente_no_docente_id`) REFERENCES `expediente_no_docente` (`id`);

--
-- Filtros para la tabla `inasistencia_sin_aviso_docente`
--
ALTER TABLE `inasistencia_sin_aviso_docente`
  ADD CONSTRAINT `inasistencia_sin_aviso_docente_ibfk_1` FOREIGN KEY (`expediente_docente_id`) REFERENCES `expediente_docente` (`id`),
  ADD CONSTRAINT `inasistencia_sin_aviso_docente_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`);

--
-- Filtros para la tabla `inasistencia_sin_aviso_no_docente`
--
ALTER TABLE `inasistencia_sin_aviso_no_docente`
  ADD CONSTRAINT `inasistencia_sin_aviso_no_docente_ibfk_1` FOREIGN KEY (`expediente_no_docente_id`) REFERENCES `expediente_no_docente` (`id`),
  ADD CONSTRAINT `inasistencia_sin_aviso_no_docente_ibfk_2` FOREIGN KEY (`no_docente_id`) REFERENCES `no_docente` (`id`);

--
-- Filtros para la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`tipo_jornada_id`) REFERENCES `tipo_jornada` (`id`);

--
-- Filtros para la tabla `jornada_docente`
--
ALTER TABLE `jornada_docente`
  ADD CONSTRAINT `jornada_docente_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `jornada_docente_ibfk_2` FOREIGN KEY (`jornada_id`) REFERENCES `jornada` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jornada_docente_ibfk_3` FOREIGN KEY (`catedra_id`) REFERENCES `catedra` (`id`);

--
-- Filtros para la tabla `jornada_docente_mesa`
--
ALTER TABLE `jornada_docente_mesa`
  ADD CONSTRAINT `jornada_docente_mesa_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `jornada_docente_mesa_ibfk_2` FOREIGN KEY (`mesa_examen_id`) REFERENCES `mesa_examen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jornada_docente_mesa_ibfk_3` FOREIGN KEY (`det_jornada_id`) REFERENCES `detalle_jornada` (`id`);

--
-- Filtros para la tabla `jornada_no_docente`
--
ALTER TABLE `jornada_no_docente`
  ADD CONSTRAINT `jornada_no_docente_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`),
  ADD CONSTRAINT `jornada_no_docente_ibfk_2` FOREIGN KEY (`no_docente_id`) REFERENCES `no_docente` (`id`),
  ADD CONSTRAINT `jornada_no_docente_ibfk_3` FOREIGN KEY (`jornada_id`) REFERENCES `jornada` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `marcacion_docente`
--
ALTER TABLE `marcacion_docente`
  ADD CONSTRAINT `marcacion_docente_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`);

--
-- Filtros para la tabla `marcacion_no_docente`
--
ALTER TABLE `marcacion_no_docente`
  ADD CONSTRAINT `marcacion_no_docente_ibfk_1` FOREIGN KEY (`no_docente_id`) REFERENCES `no_docente` (`id`);

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `mesa_examen_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carrera` (`id`),
  ADD CONSTRAINT `mesa_examen_ibfk_2` FOREIGN KEY (`jornada_id`) REFERENCES `jornada` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mesa_examen_ibfk_3` FOREIGN KEY (`llamado_id`) REFERENCES `llamado` (`id`);

--
-- Filtros para la tabla `no_docente`
--
ALTER TABLE `no_docente`
  ADD CONSTRAINT `no_docente_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `planilla_productividad_docente`
--
ALTER TABLE `planilla_productividad_docente`
  ADD CONSTRAINT `planilla_productividad_docente_ibfk_1` FOREIGN KEY (`mes_id`) REFERENCES `mes` (`id`);

--
-- Filtros para la tabla `planilla_productividad_no_docente`
--
ALTER TABLE `planilla_productividad_no_docente`
  ADD CONSTRAINT `planilla_productividad_no_docente_ibfk_1` FOREIGN KEY (`mes_id`) REFERENCES `mes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
