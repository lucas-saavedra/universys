create table persona (
    id int AUTO_INCREMENT, 
	nombre varchar(100),
    email varchar(50),
    contrasenia varchar(20),
    cuil varchar(11),
    direccion varchar(40),
    telefono varchar(20),
    sexo varchar(10),
    UNIQUE(email),
    PRIMARY key (id)
);
create table rol (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);
create table persona_rol (
    id int AUTO_INCREMENT,
	rol_id int,
	persona_id int,
    PRIMARY key (id),
    FOREIGN KEY (rol_id) REFERENCES rol(id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);
/* Volcado de datos para la tabla rol */
INSERT INTO rol (nombre) VALUES
('admin'),
('personal'),
('mesa_entrada'),
('coordinacion'),
('alumnado'),
('director_de_carrera');
/* Volcado de datos para la tabla persona_rol */

create table docente (
	id int AUTO_INCREMENT,
    persona_id int,
    total_horas int,
    PRIMARY key (id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

create table no_docente (
	id int AUTO_INCREMENT,
    persona_id int,
    total_horas int,
    PRIMARY key (id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

create table tipo_jornada (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    pertenece varchar(20) NOT NULL,
    PRIMARY key (id)
);

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


create table jornada (
	id int AUTO_INCREMENT,
    fecha_inicio DATE,
    fecha_fin DATE,
    tipo_jornada_id int,
    descripcion varchar(100),
    PRIMARY key (id),
    FOREIGN KEY (tipo_jornada_id) REFERENCES tipo_jornada(id)
);


create table detalle_jornada (
	id int AUTO_INCREMENT,
    jornada_id int,
    hora_inicio TIME,
    hora_fin TIME,
    dia int,
    descripcion varchar(256),
    PRIMARY key (id),
    FOREIGN KEY (jornada_id) REFERENCES jornada(id)  ON DELETE CASCADE
);

create table area (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    PRIMARY key (id)
);

create table jornada_no_docente (
	id int AUTO_INCREMENT,
    no_docente_id int,
    area_id int,
    jornada_id int,
    PRIMARY key (id),
    FOREIGN KEY (area_id) REFERENCES area(id),
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id),
    FOREIGN KEY (jornada_id) REFERENCES jornada(id) ON DELETE CASCADE
);

create table carrera (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    PRIMARY key (id)
);

create table periodo (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    PRIMARY key (id)
);

create table anio_plan (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    PRIMARY key (id)
);

create table catedra (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    carrera_id int,
    anio_plan_id int,
    periodo_id int,
    total_horas int,
    PRIMARY key (id),
    FOREIGN KEY (carrera_id) REFERENCES carrera(id),
    FOREIGN KEY (anio_plan_id) REFERENCES anio_plan(id),
    FOREIGN KEY (periodo_id) REFERENCES periodo(id)
);

create table jornada_docente (
	id int AUTO_INCREMENT,
    docente_id int,
    jornada_id int,
    catedra_id int,
    PRIMARY key (id),
    FOREIGN KEY (docente_id) REFERENCES docente(id),
    FOREIGN KEY (jornada_id) REFERENCES jornada(id)
    ON DELETE CASCADE,
    FOREIGN KEY (catedra_id) REFERENCES catedra(id)
);

create table llamado (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);
INSERT INTO llamado (id, nombre) VALUES
(1, '1er Llamado'),
(2, '2do Llamado'),
(3, '3er Llamado'),
(4, '4to Llamado');
create table mesa_examen (
	id int AUTO_INCREMENT,
    carrera_id int,
    llamado_id int,
    jornada_id int,
    PRIMARY key (id),
    FOREIGN KEY (carrera_id) REFERENCES carrera(id),
    FOREIGN KEY (jornada_id) REFERENCES jornada(id)
    ON DELETE CASCADE,
    FOREIGN KEY (llamado_id) REFERENCES llamado(id)
);
create table jornada_docente_mesa (
	id int AUTO_INCREMENT,
    docente_id int,
    det_jornada_id int,
    mesa_examen_id int,
    PRIMARY key (id),
    FOREIGN KEY (docente_id) REFERENCES docente(id),
    FOREIGN KEY (mesa_examen_id) REFERENCES mesa_examen(id)
    ON DELETE CASCADE,
    FOREIGN KEY (det_jornada_id) REFERENCES detalle_jornada(id)
    
);
create table marcacion_docente (
	id int AUTO_INCREMENT,
    docente_id int,
    fecha date,
    hora_registro TIME,
    dia int,
    estado enum('entrada','salida'),
    PRIMARY key (id),
    FOREIGN KEY (docente_id) REFERENCES docente(id)
);
create table marcacion_no_docente (
	id int AUTO_INCREMENT,
    no_docente_id int,
    fecha date,
    hora_registro TIME,
    dia int,
    estado enum('entrada','salida'),
    PRIMARY key (id),
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id)
);

create table asistencia_docente (
	id int AUTO_INCREMENT,
    detalle_jornada_id int,
    docente_id int,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    dia int,
    estado_asistencia enum('presente','falta','tarde'),
    descripcion varchar(100),
    PRIMARY key (id),
    FOREIGN KEY (docente_id) REFERENCES docente(id),
    FOREIGN KEY (detalle_jornada_id) REFERENCES detalle_jornada(id)
);

create table asistencia_no_docente (
	id int AUTO_INCREMENT,
    detalle_jornada_id int,
    no_docente_id int,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    dia int,
    estado_asistencia enum('presente','falta','tarde'),
    descripcion varchar(100),
    PRIMARY key (id),
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id),
    FOREIGN KEY (detalle_jornada_id) REFERENCES detalle_jornada(id)
);

create table tipo_justificacion (
	id int AUTO_INCREMENT,
    descripcion varchar(100),
    PRIMARY key (id)
);

create table documentacion_justificada (
	id int AUTO_INCREMENT,
    tipo_justificacion_id int,
    archivo varchar(255),
    descripcion varchar(100),
    entrega_en_termino boolean,
    fecha_recepcion DATETIME,
    persona_id int,
    PRIMARY key (id),
    FOREIGN KEY (tipo_justificacion_id) REFERENCES tipo_justificacion(id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);
create table aviso (
	id int AUTO_INCREMENT,
    descripcion varchar(100),
    validez boolean,
    fecha_recepcion DATETIME,
    PRIMARY key (id)
);

create table tipo_inasistencia (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);

create table codigo (
	id int AUTO_INCREMENT,
    nombre varchar(100),
    descripcion varchar(100),
    referencia varchar(100),
    es_docente boolean,
    es_no_docente boolean,
    tipo_inasistencia_id int,
    con_descuento boolean,
    requiere_aviso boolean,
    requiere_doc boolean,
    PRIMARY key (id),
    FOREIGN KEY (tipo_inasistencia_id) REFERENCES tipo_inasistencia(id)
);

create table cupo (
	id int AUTO_INCREMENT,
    codigo_id int not null,
    longitud int not null,
    tipo enum('Año', 'Mes'),
    cantidad_max_dias int not null,
    PRIMARY key (id),
    FOREIGN KEY (codigo_id) REFERENCES codigo(id)
);

create table expediente (
	id int AUTO_INCREMENT,
    persona_id int,
    fecha_inicio date,
    fecha_fin date,
    confirmado boolean,
    cupo_superado boolean,
    doc_justificada_id int,
    aviso_id int,
    codigo_id int,
    /* --------------- actualizacion ale 30/9/2021 (historial de cambios del expediente)------------*/
    cambios varchar(500),
    ult_cambio varchar(60),
    /* --------------- Nuevo ------------*/
    PRIMARY key (id),
    FOREIGN KEY (doc_justificada_id) REFERENCES documentacion_justificada(id),
    FOREIGN KEY (aviso_id) REFERENCES aviso(id),
    FOREIGN KEY (codigo_id) REFERENCES codigo(id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

alter table expediente add constraint chk_fecha_inicio_menor check (fecha_inicio <= fecha_fin);

create table expediente_docente (
	id int AUTO_INCREMENT,
    expediente_id int,
    docente_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id) ON DELETE CASCADE,
    FOREIGN KEY (docente_id) REFERENCES docente(id)
);

create table expediente_no_docente (
	id int AUTO_INCREMENT,
    expediente_id int,
    no_docente_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id) ON DELETE CASCADE,
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id)
);

create table expediente_detalle (
	id int AUTO_INCREMENT,
    expediente_id int,
    det_jornada_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id) ON DELETE CASCADE,
    FOREIGN KEY (det_jornada_id) REFERENCES detalle_jornada(id)
);

create table inasistencia_sin_aviso_docente (
	id int AUTO_INCREMENT,
    expediente_docente_id int,
    docente_id int,
    fecha date,
    hora_inicio time,
    hora_fin time,
    dia int,
    /*-------- actualizacion ale 30/9/202 (que la inasistencia tenga catedra y jornada)---------*/
    descripcion varchar(100),
    catedra_id int,
    FOREIGN KEY (catedra_id) REFERENCES catedra(id),
    /*-------- nuevo --------- */
    PRIMARY key (id),
    FOREIGN KEY (expediente_docente_id) REFERENCES expediente_docente(id) ON DELETE CASCADE,
    FOREIGN KEY (docente_id) REFERENCES docente(id)
);

create table inasistencia_sin_aviso_no_docente (
	id int AUTO_INCREMENT,
    expediente_no_docente_id int,
    no_docente_id int,
    fecha date,
    hora_inicio time,
    hora_fin time,
    dia int,
    /*------- actualizacion ale 30/9/202 (que la inasistencia tenga area)    -------*/
    area VARCHAR (60),
    /*------- NUEVO  -------- */
    PRIMARY key (id),
    FOREIGN KEY (expediente_no_docente_id) REFERENCES expediente_no_docente(id) ON DELETE CASCADE,
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id)
);
create table mes (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);

create table planilla_productividad_docente (
	id int AUTO_INCREMENT,
    mes_id int,
    anio int,
    observaciones varchar(50),
    confirmado boolean,
    PRIMARY key (id),
    FOREIGN KEY (mes_id) REFERENCES mes(id)
);

create table expediente_planilla_docente (
	id int AUTO_INCREMENT,
    planilla_productividad_docente_id int,
    expediente_docente_id int,
    hs_descontadas int,
    PRIMARY key (id),
    FOREIGN KEY (planilla_productividad_docente_id) REFERENCES planilla_productividad_docente(id),
    FOREIGN KEY (expediente_docente_id) REFERENCES expediente_docente(id) ON DELETE CASCADE
);
create table planilla_productividad_no_docente (
	id int AUTO_INCREMENT,
    mes_id int,
    anio int,
    observaciones varchar(50),
    confirmado boolean,
    PRIMARY key (id),
    FOREIGN KEY (mes_id) REFERENCES mes(id)
);

create table expediente_planilla_no_docente (
	id int AUTO_INCREMENT,
    planilla_productividad_no_docente_id int,
    expediente_no_docente_id int,
    hs_descontadas int,
    PRIMARY key (id),
    FOREIGN KEY (planilla_productividad_no_docente_id) REFERENCES planilla_productividad_no_docente(id),
    FOREIGN KEY (expediente_no_docente_id) REFERENCES expediente_no_docente(id) ON DELETE CASCADE
);


/* Carga de archivo */

INSERT INTO anio_plan (id, nombre) VALUES
(1, '1ro'),
(2, '2do'),
(3, '3ro');

INSERT INTO area(nombre) VALUES 
('Personal'),('Coordinacion'),('Alumnado'),('Extension'),('Ordenanza'),('Prensa'),('Mesa Entrada')
,('Biblioteca'),('Informatica'),('Director Carrera'),('Mesa Envios');

INSERT INTO periodo(nombre) VALUES ('1er Cuatrimestre'),('2do Cuatrimestre'),('Anual');

INSERT INTO carrera(nombre) VALUES ('Analisis de Sistemas'),('Prod. Agropecuaria'),('Gestion Ambiental');

INSERT INTO `catedra` (`nombre`, `carrera_id`, `anio_plan_id`, `periodo_id`) VALUES 
/*---------------- Analisis de sistemas--------------- */
/* 1er año */
( 'Lógica y Álgebra', '1', '1', '3'),
( 'Cálculo Diferencial e Integral', '1', '1', '3'),
( 'Sistemas y Organizaciones', '1', '1', '3'),
( 'Derechos Humanos y Tecnología', '1', '1', '1'),
( 'Fundamentos De Computación', '1', '1', '1'),
/* 2do año */

( 'Matemática Discreta', '1', '2', '3'),
( 'Ec. Diferenciales y Calc. Multivariado', '1', '2', '2'),
( 'Arquitectura De Computadoras', '1', '2', '1'),

/* 3er año */
( 'Probabilidad y Estadística', '1', '3', '3'),
( 'Paradigmas y Lenguajes', '1', '3', '2'),
( 'Ética Profesional', '1', '3', '1'),
/*---------- Gestion Ambiental--------------- */
/* 1er año */
( 'Inglés Técnico I', '3', '1', '3'),
( 'Química General', '3', '1', '1'),
( 'Biología', '3', '1', '2'),

/* 2do año */

( 'Inglés Técnico II', '3', '2', '3'),
( 'Derecho Ambiental', '3', '2', '2'),
( 'Informática II', '3', '2', '1'),

/* 3er año */
( 'Tratamiento de Residuos Sólidos', '3', '3', '3'),
( 'Efluentes Líquidos', '3', '3', '2'),
( 'Gestión Recurso Suelo', '3', '3', '1'),

/*---------- Produccion Agropecuaria--------------- */
/* 1er año */
( 'Inglés Técnico I', '2', '1', '3'),
( 'Administración Agropecuaria I', '2', '1', '1'),
( 'Anatomía Animal', '2', '1', '2'),

/* 2do año */

( 'Inglés Técnico II', '2', '2', '3'),
( 'Microbiología', '2', '2', '2'),
( 'Fisiología Vegetal', '2', '2', '1'),

/* 3er año */
( 'Práctica Profesional', '2', '3', '3'),
( 'Ética y Deontología Profesional', '2', '3', '2'),
( 'Cultivo Extensivo', '2', '3', '1');


INSERT INTO persona( `nombre`, `email`, `contrasenia`) VALUES ('Admin','admin@gmail.com','root');
/* ('Nayra Asensio','nayra@gmail.com','1234'),
('Roman Morano','roman@gmail.com','1234'),
('Ion Machado','ion@gmail.com','1234'),
('Andoni Roig','andoni@gmail.com','1234'),
('Samuel Vicente','samuel@gmail.com','1234'),
('Enriqueta Galan','enriqueta@gmail.com','1234'),
('Pilar Fernandez','pilar@gmail.com','1234'),
('Emilio Espino','emi@gmail.com','1234'),
('Angelina Nieto','angi@gmail.com','1234'),
('Trinidad Moyano','trinidad@gmail.com','1234');



/* 
1 admin
2 personal
3 mesa_entrada
4 coordinacion 
*/

/* Volcado de datos para la tabla persona_rol */
INSERT INTO persona_rol (rol_id,persona_id) VALUES ( 1, 1);
/*  ( 4, 6),
( 3, 5),
( 2, 7),
( 6, 8),
( 5, 3),
( 2, 10); */

/* INSERT INTO `docente`(`persona_id`) VALUES ('2'),('3'),('6'),('7'),('8'),('9');
INSERT INTO `no_docente`(`persona_id`) VALUES ('4'),('5'),('6'),('7'),('8'),('10'),('11'); */

INSERT INTO tipo_justificacion (descripcion) VALUES 
('LIS'), 
('Certificado de justificacion'), 
('LIS + Certificado'), 
('Justificación sin certificado');

INSERT INTO tipo_inasistencia(nombre) VALUES
('Licencia'),
('Justificación'),
('Inasistencia Común');

INSERT INTO `codigo` (`nombre`, `descripcion`, `referencia`, `es_docente`, `es_no_docente`, `tipo_inasistencia_id`, `con_descuento`, `requiere_aviso`, `requiere_doc`) VALUES
-- Falta común
('Falta C/Aviso', 'Falta con aviso', '4', '1', '0', '3', '0', '1', '0'),
('Falta S/Aviso', 'Falta sin aviso', '5','1','1','3', '1', '0','0'),
('Inasis. Docente Injustificada', 'Inasistencia docente injustificada', '6','1','0','3', '1', '1','0'),
('Imprevisto', 'Falta imprevista', 'I','0','1','3', '0', '1','0'),
('Suspensión', 'Suspensión', '3', '1', '1', '3', '1', '0', '0'), 
-- Licencia
('Lic. Extraordinaria', 'Licencia Extraordinaria', '2','1','1','1', '0', '1','1'),
('Maternidad', 'Licencia por Maternidad', '12','1','1','1', '0', '1','1'),
('Lic. Enfermedad S/S', 'Licencia por enfermedad (Sin sueldo)', '1', '1', '1', '1', '1', '1', '1'), 
('Lic. Anual Ordinaria', 'Licencia Anual Ordinaria', '7', '1', '1', '1', '0', '1', '1'), 
('Lic. por Enfermedad C/S', 'Licencia por Enfermedad (Con sueldo)', '8', '1', '1', '1', '0', '1', '1'), ('Duelo', 'Duelo', '10', '1', '1', '1', '0', '1', '1'), 
('Estudios', 'Estudios', '11', '1', '1', '2', '0', '1', '1'), 
('Matrimonio', 'Matrimonio', '13', '1', '1', '1', '0', '1', '1'), 
('Casamiento Hijos', 'Casamiento Hijos', '14', '1', '1', '1', '0', '1', '1'), 
('Nac. Hijos', 'Nacimiento Hijos', '15', '1', '1', '1', '0', '1', '1'), 
('Cuidado Familiar Enfermo', 'Cuidado Familiar Enfermo', '16', '1', '1', '1', '0', '1', '1'), 
('Perfeccionamento', 'Perfeccionamento', '20', '1', '0', '1','0','1','1'),
-- Justificación
('Inasis. Docente Justificada', 'Inasistencia docente justificada', '18','1','0','2', '0', '1','1'),
('Franco Compensatorio', 'Franco Compensatorio', '17', '1', '1', '2', '0', '1', '1'), 
('Paro', 'Paro', '19', '1', '0', '2', '1', '1', '1');


-- Falta C/Aviso: ejemplo de cupo
INSERT INTO `cupo` (`id`, `codigo_id`, `longitud`, `tipo`, `cantidad_max_dias`) VALUES (NULL, '1', '1', 'Mes', '2'), (NULL, '1', '1', 'Año', '6');

insert into mes(nombre) values 
('Enero'),('Febrero'), ('Marzo'), ('Abril'), ('Mayo'), ('Junio'), ('Julio'), ('Agosto'), ('Septiembre'), ('Octubre'), ('Noviembre'), ('Diciembre');
CREATE TABLE dia ( id INT NOT NULL , nombre VARCHAR(20) NOT NULL , PRIMARY KEY (`id`));
INSERT INTO dia (id, `nombre`) VALUES 
('0', 'Lunes'),('1', 'Martes'),('2', 'Miércoles'),
('3', 'Jueves'),('4', 'Viernes'),('5', 'Sábado'),
('6', 'Domingo');

/* --------------VISTAS----------- */

-- Estructura Stand-in para la vista `agente_nombre`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `agente_nombre` (
`id` int(11)
,`nombre` varchar(100)
);

-- Estructura para la vista `agente_nombre`
--
DROP TABLE IF EXISTS `agente_nombre`;

CREATE ALGORITHM=UNDEFINED
 SQL SECURITY DEFINER VIEW `agente_nombre`  AS 
 SELECT `no_docente`.`id` AS `id`, `persona`.`nombre` AS `nombre` 
 FROM (`no_docente` left join `persona` on(`no_docente`.`persona_id` = `persona`.`id`)) ;

-- --------------------------------------------------------

-- Estructura Stand-in para la vista `docente_nombre`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `docente_nombre` (
`id` int(11)
,`nombre` varchar(100)
);
-- Estructura para la vista `docente_nombre`
--
DROP TABLE IF EXISTS `docente_nombre`;

CREATE ALGORITHM=UNDEFINED 
 SQL SECURITY DEFINER VIEW `docente_nombre`  AS 
 SELECT `docente`.`id` AS `id`, `persona`.`nombre` AS `nombre` 
 FROM (`docente` left join `persona` on(`docente`.`persona_id` = `persona`.`id`)) ;

-- --------------------------------------------------------


-- --------------------------------------------------------
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
-- Estructura para la vista `v_jornada`
--
DROP TABLE IF EXISTS `v_jornada`;

CREATE ALGORITHM=UNDEFINED 
SQL SECURITY DEFINER VIEW `v_jornada`  AS
SELECT `jornada`.`id` AS `id`, `tipo_jornada`.`id` AS `tipo_jornada_id`,
`jornada`.`fecha_inicio` AS `fecha_inicio`, `jornada`.`fecha_fin` AS `fecha_fin`, 
`tipo_jornada`.`nombre` AS `nombre`, `jornada`.`descripcion` AS `descripcion`,
`tipo_jornada`.`pertenece` AS `pertenece` 
FROM (`jornada` left join `tipo_jornada` on(`jornada`.`tipo_jornada_id` = `tipo_jornada`.`id`)) ;

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
-- Estructura para la vista `mesa_examen_jornada`
--
DROP TABLE IF EXISTS `mesa_examen_jornada`;

CREATE ALGORITHM=UNDEFINED 
SQL SECURITY DEFINER VIEW `mesa_examen_jornada`  AS
 SELECT `mesa_examen`.`id` AS `id`, `mesa_examen`.`jornada_id` AS `jornada_id`,
`carrera`.`nombre` AS `carrera_nombre`, `carrera`.`id` AS `carreraId`,
`llamado`.`id` AS `llamadoId`, `llamado`.`nombre` AS `llamado_nombre`,
`v_jornada`.`fecha_inicio` AS `fecha_inicio`, `v_jornada`.`fecha_fin` AS `fecha_fin`,
`v_jornada`.`descripcion` AS `descripcion` 
 FROM (((`mesa_examen` left join `carrera` on(`mesa_examen`.`carrera_id` = `carrera`.`id`)) 
 left join `llamado` on(`mesa_examen`.`llamado_id` = `llamado`.`id`)) 
 left join `v_jornada` on(`mesa_examen`.`jornada_id` = `v_jornada`.`id`)) ;
