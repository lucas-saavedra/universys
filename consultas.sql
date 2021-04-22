SELECT doc.nombre,cargo.nombre as Cargo,dj.hora_inicio,dj.hora_fin,dj.dia, j.fecha_inicio,j.fecha_fin FROM jornada as j INNER JOIN detalle_jornada as dj ON j.id = dj.id_jornada INNER JOIN cargo ON cargo.id = j.id_cargo INNER JOIN docentes as doc ON doc.id = cargo.docente_id

INSERT into marcacion(fecha,hora_inicio,hola_fin,docente_id, dia_id) VALUES (now(), CURRENT_TIME(), CURRENT_TIME(), 3, WEEKDAY(now()))

SELECT marcacion.dia_id,detalle_jornada.dia,marcacion.id as marcacion_id ,jornada.id as jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM marcacion,jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE marcacion.fecha>= fecha_inicio and marcacion.fecha<=fecha_fin and marcacion.dia_id = detalle_jornada.dia