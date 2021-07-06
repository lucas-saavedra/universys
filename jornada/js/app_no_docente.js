$(document).ready(function () {
    listar_jorn_no_docentes();
    let editar = false;
    /* $('#search').keyup(function (e) {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: '/universys/jornada/backend/select-catedra.php',
                type: 'POST',
                data: {
                    search
                },
                success: function (response) {
                    let catedras = JSON.parse(response);
                    let template = " "
                    catedras.forEach(catedra => {
                        template += ` 
                    <tr catedraId=${catedra.id}>  
                    <th> ${catedra.nombre} </th>
                    <th> ${catedra.carrera} </th>
                    <th> ${catedra.periodo} </th>
                    <th> ${catedra.anio} </th>
                    <td>
                    <a class="catedra btn btn-info" data-dismiss="modal">Aceptar</a>
                    </td>
                    </tr>
                    `
                    });
                    $('#container').html(template);
                }
            });
        }
    }); */
   
    $(document).on('click', '.jorn-no-docente-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_no_doc_id = $(element).attr('jornada_no_docente_id');
        console.log(jornada_no_doc_id);
        $.post('/universys/jornada/backend/listarJornadaNoDocente.php', {
            jornada_no_doc_id
        }, function (response) {
            const jd = JSON.parse(response);
            console.log(jd);
            $('#jornadaId').val(jd[0].jornada_id);
            $('#jornadaNoDocenteId').val(jd[0].jornada_no_doc_id);
            $('#descripcion').val(jd[0].descripcion);
            $('#noDocenteId').val(jd[0].no_docente_id);
            $('#fechaInicio').val(jd[0].fecha_fin);
            $('#fechaFin').val(jd[0].fecha_inicio);
            $('#areaId').val(jd[0].area_id);
            $('#tipoJornadaId').val(jd[0].tipo_jornada_id);
            editar = true; 
        })

    })

    $(document).on('click', '.jorn-no-docente-borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
            console.log(jornada_id);
            $.post('/universys/jornada/backend/borrar-jornada.php', {
                jornada_id
            }, function (response) {
                listar_jorn_no_docentes();
                const msg = JSON.parse(response);
                $('#notif').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${msg[0].message} 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            `)

            })
        }
    })

    $('#jornadaNoDocente').submit(function (e) {
        const jornadaNoDocente = {
            jornadaId:  $('#jornadaId').val(),
            jornadaNoDocenteId:  $('#jornadaNoDocenteId').val(),
            areaId: $('#areaId').val(),
            noDocenteId: $('#noDocenteId').val(),
            tipoJornadaId: $('#tipoJornadaId').val(),
            fechaInicio: $('#fechaInicio').val(),
            fechaFin: $('#fechaFin').val(),
            descripcion: $('#descripcion').val()
        };
        let url = editar === false ? '/universys/jornada/backend/insertar-jornada-no-docente.php' : '/universys/jornada/backend/upd-jornada-nd.php'; 
         $.post(url, jornadaNoDocente, function (response) {
            listar_jorn_no_docentes();
            const msg = JSON.parse(response);
            let template =' ';
                template += ` 
                <div class="alert alert-${msg.type}  alert-dismissible fade show" role="alert">
                ${msg.name} 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>  `;
            
            $('#notif').html(template);
            $('#jornadaNoDocente').trigger('reset');
        }); 
        e.preventDefault();
    });
    
  /*   $(document).on('click', '.catedra', function () {
        let element = $(this)[0].parentElement.parentElement;
        let catedraId = $(element).attr('catedraId');
        obtener_catedra(catedraId);
    })
 */
 /*    function obtener_catedra(catedraId) {
        $.post('/universys/jornada/backend/catedra.php', {
            catedraId
        }, function (response) {
            const catedra = JSON.parse(response);
            $('#catedra').val(catedra.nombre + ', ' + catedra.anio + ' Año, ' + catedra.carrera);
            $('#catedraIdInput').val(catedra.id);
        })
    }; */
    function listar_jorn_no_docentes() {
        $.ajax({
            url: '/universys/jornada/backend/listarJornadaNoDocente.php',
            type: 'GET',
            success: function (response) {
                let jorn_no_docs = JSON.parse(response);
                let template = " "
                jorn_no_docs.forEach(jnd => {
                    template += ` 
        <tr jornada_id='${jnd.jornada_id}' jornada_no_docente_id='${jnd.jornada_no_doc_id}'>  
         <td>   ${jnd.jornada_no_doc_id}  </td>   
         <td>   ${jnd.no_docente}  </td>
         <td>   ${jnd.area}  </td>  
         <td>   ${jnd.fecha_inicio}  </td>   
         <td>   ${jnd.fecha_fin}  </td>   
         <td>   ${jnd.tipo_jornada}  </td>   
         <td>   ${jnd.descripcion}  </td>   
       
         <td> <button class=" jorn-no-docente-item btn btn-info"><i class="fas fa-pen"></i></button>
         <button class=" jorn-no-docente-borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
            
        </tr>

        `
                })
                $('#lista_jorn_no_docente').html(template);

            }
        });
    }

});

