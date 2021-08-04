

SELECT catedra.id as id ,catedra.nombre as catedra, carrera.nombre as carrera,periodo.nombre as periodo, anio_plan.nombre as anio FROM catedra
LEFT JOIN carrera ON catedra.carrera_id  = carrera.id
LEFT JOIN periodo ON catedra.periodo_id = periodo.id
LEFT JOIN anio_plan ON catedra.anio_plan_id = anio_plan.id
where carrera

SELECT jd.id as jornada_docente_id, docente_id,catedra_id,jornada_id, docente_nombre.nombre AS docente, c.nombre as catedra ,
j.fecha_inicio,j.fecha_fin,j.nombre as tipo_jornada, j.descripcion
FROM `jornada_docente` as jd
LEFT JOIN docente_nombre on jd.docente_id = docente_nombre.id
LEFT JOIN catedra as c on c.id = catedra_id
LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id


SELECT 
 jdm.id as jornada_agente_id,
 jdm.docente_id as agente_id ,
 docente_nombre.nombre as docente,
 mesa_examen.id
from jornada_docente_mesa as jdm 
LEFT JOIN jornada_docente_mesa on mesa_examen.id =  jdm.mesa_examen_id
LEFT JOIN docente_nombre on jdm.docente_id = docente_nombre.id;








SELECT 
 jdm.id as jornada_agente_id,
 jdm.docente_id as agente_id ,
 docente_nombre.nombre as docente,
detalle_jornada.jornada_id ,detalle_jornada.id as det_jorn_id, hora_inicio,hora_fin, dia.nombre
from jornada_docente_mesa as jdm
LEFT JOIN  mesa_examen_jornada on mesa_examen_jornada.id=  jdm.mesa_examen_id
LEFT JOIN docente_nombre on jdm.docente_id = docente_nombre.id
left JOIN detalle_jornada on mesa_examen_jornada.jornadaId = detalle_jornada.jornada_id
left join dia on detalle_jornada.dia = dia.id
