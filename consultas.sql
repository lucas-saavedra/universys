SELECT doc.nombre,cargo.nombre as Cargo,dj.hora_inicio,dj.hora_fin,dj.dia, j.fecha_inicio,j.fecha_fin FROM jornada as j INNER JOIN detalle_jornada as dj ON j.id = dj.id_jornada INNER JOIN cargo ON cargo.id = j.id_cargo INNER JOIN docentes as doc ON doc.id = cargo.docente_id

INSERT into marcacion(fecha,hora_inicio,hola_fin,docente_id, dia_id) VALUES (now(), CURRENT_TIME(), CURRENT_TIME(), 3, WEEKDAY(now()))

SELECT marcacion.dia_id,detalle_jornada.dia,marcacion.id as marcacion_id ,jornada.id as jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM marcacion,jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE marcacion.fecha>= fecha_inicio and marcacion.fecha<=fecha_fin and marcacion.dia_id = detalle_jornada.dia


SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin, cargo.nombre, cargo.docente_id FROM jornada 
INNER JOIN detalle_jornada ON jornada.id = detalle_jornada.id_jornada
INNER JOIN cargo on detalle_jornada.cargo_id = cargo.id
WHERE now() >= fecha_inicio 
AND now() <=fecha_fin 
AND WEEKDAY(now()) = detalle_jornada.dia
AND '11:14:00' >= ADDTIME(detalle_jornada.hora_inicio, '-00:15:00') 
AND '11:14:00' <= ADDTIME(detalle_jornada.hora_fin, '00:15:00')

CREATE TRIGGER `chrono_trigger` BEFORE INSERT ON `marcacion`
 FOR EACH ROW BEGIN
    select count(*) into @contador from marcacion GROUP by docente_id having docente_id=new.docente_id;
    
    if (mod(@contador+1, 2) = 0) THEN
    	set new.estado = 'salida';
    end if;
END

select m1.hora_registro, m2.hora_registro, m2.docente_id, m2.detalle_jornada_id from (select * from marcacion where estado ='entrada') as m1 inner join (select * from marcacion where estado ='salida') as m2 on m1.fecha=m2.fecha and m1.docente_id=m2.docente_id and m1.detalle_jornada_id = m2.detalle_jornada_id