create table persona (
    id int AUTO_INCREMENT, 
	nombre varchar(100),
    email varchar(50),
    contrasenia varchar(20),
    dni varchar(8),
    direccion varchar(30),
    telefono varchar(20),
    PRIMARY key (id) 
);

create table docente (
	id int AUTO_INCREMENT,
    persona_id int,
    antiguedad int,
    PRIMARY key (id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

create table no_docente (
	id int AUTO_INCREMENT,
    persona_id int,
    antiguedad int,
    PRIMARY key (id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

create table tipo_jornada (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);

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
    descripcion varchar(100),
    PRIMARY key (id),
    FOREIGN KEY (jornada_id) REFERENCES jornada(id)
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
    FOREIGN KEY (jornada_id) REFERENCES jornada(id)
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
    FOREIGN KEY (jornada_id) REFERENCES jornada(id),
    FOREIGN KEY (catedra_id) REFERENCES catedra(id)
);

create table jornada_docente_mesa (
	id int AUTO_INCREMENT,
    docente_id int,
    det_jornada_id int,
    PRIMARY key (id),
    FOREIGN KEY (docente_id) REFERENCES docente(id),
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
    fecha_recepcion DATE,
    PRIMARY key (id)
);

create table tipo_inasistencia (
	id int AUTO_INCREMENT,
    nombre varchar(50),
    PRIMARY key (id)
);

create table codigo (
	id int AUTO_INCREMENT,
    nombre int,
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
    codigo_id int,
    cantidad_max_dias int,
    rango varchar(20),
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
    PRIMARY key (id),
    FOREIGN KEY (doc_justificada_id) REFERENCES documentacion_justificada(id),
    FOREIGN KEY (aviso_id) REFERENCES aviso(id),
    FOREIGN KEY (codigo_id) REFERENCES codigo(id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

create table expediente_docente (
	id int AUTO_INCREMENT,
    expediente_id int,
    docente_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id),
    FOREIGN KEY (docente_id) REFERENCES docente(id)
);

create table expediente_no_docente (
	id int AUTO_INCREMENT,
    expediente_id int,
    no_docente_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id),
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id)
);

create table expediente_detalle (
	id int AUTO_INCREMENT,
    expediente_id int,
    det_jornada_id int,
    PRIMARY key (id),
    FOREIGN KEY (expediente_id) REFERENCES expediente(id),
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
    PRIMARY key (id),
    FOREIGN KEY (expediente_docente_id) REFERENCES expediente_docente(id),
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
    PRIMARY key (id),
    FOREIGN KEY (expediente_no_docente_id) REFERENCES expediente_no_docente(id),
    FOREIGN KEY (no_docente_id) REFERENCES no_docente(id)
);

create table expediente_planilla_docente (
	id int AUTO_INCREMENT,
    planilla_productividad_docente_id int,
    expediente_docente_id int,
    hs_descontadas int,
    PRIMARY key (id),
    FOREIGN KEY (planilla_productividad_docente_id) REFERENCES planilla_productividad_docente(id),
    FOREIGN KEY (expediente_docente_id) REFERENCES expediente_docente(id)
);

create table expediente_planilla_no_docente (
	id int AUTO_INCREMENT,
    planilla_productividad_no_docente_id int,
    expediente_no_docente_id int,
    hs_descontadas int,
    PRIMARY key (id),
    FOREIGN KEY (planilla_productividad_no_docente_id) REFERENCES planilla_productividad_no_docente(id),
    FOREIGN KEY (expediente_no_docente_id) REFERENCES expediente_no_docente(id)
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

create table planilla_productividad_no_docente (
	id int AUTO_INCREMENT,
    mes_id int,
    anio int,
    observaciones varchar(50),
    confirmado boolean,
    PRIMARY key (id),
    FOREIGN KEY (mes_id) REFERENCES mes(id)
);
