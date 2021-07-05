$(document).ready(function () {
    listar_jorn_docentes();
    let editar = false;
    $('#search').keyup(function (e) {
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
    });
   
    $(document).on('click', '.jorn-docente-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_doc_id = $(element).attr('jornada_docente_id');
        console.log(jornada_doc_id);
        $.post('/universys/jornada/backend/listarJornadaDocente.php', {
            jornada_doc_id
        }, function (response) {
            const jd = JSON.parse(response);
            $('#jornadaId').val(jd[0].jornada_id);
            $('#jornadaDocenteId').val(jd[0].jornada_doc_id);
            $('#descripcion').val(jd[0].descripcion);
            $('#docenteId').val(jd[0].docente_id);
            $('#fechaInicio').val(jd[0].fecha_fin);
            $('#fechaFin').val(jd[0].fecha_inicio);
            obtener_catedra(jd[0].catedra_id);
            editar = true;
        })

    })

    $(document).on('click', '.jorn-docente-borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
            console.log(jornada_id);
            $.post('/universys/jornada/backend/borrar-jornada.php', {
                jornada_id
            }, function (response) {
                listar_jorn_docentes();
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

    $('#jornadaDocente').submit(function (e) {
        const jornadaDocente = {
            jornadaId:  $('#jornadaId').val(),
            jornadaDocenteId:  $('#jornadaDocenteId').val(),
            catedraId: $('#catedraIdInput').val(),
            docenteId: $('#docenteId').val(),
            tipoJornadaId: $('#tipoJornadaId').val(),
            fechaInicio: $('#fechaInicio').val(),
            fechaFin: $('#fechaFin').val(),
            descripcion: $('#descripcion').val()
        };
        let url = editar === false ? '/universys/jornada/backend/insertar-jornada.php' : '/universys/jornada/backend/upd-jornada.php'; 
        $.post(url, jornadaDocente, function (response) {
            listar_jorn_docentes();
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
            $('#jornadaDocente').trigger('reset');
        });
        e.preventDefault();
    });

    $(document).on('click', '.catedra', function () {
        let element = $(this)[0].parentElement.parentElement;
        let catedraId = $(element).attr('catedraId');
        obtener_catedra(catedraId);
    })

    function obtener_catedra(catedraId) {
        $.post('/universys/jornada/backend/catedra.php', {
            catedraId
        }, function (response) {
            const catedra = JSON.parse(response);
            $('#catedra').val(catedra.nombre + ', ' + catedra.anio + ' Año, ' + catedra.carrera);
            $('#catedraIdInput').val(catedra.id);
        })
    };
    function listar_jorn_docentes() {
        $.ajax({
            url: '/universys/jornada/backend/listarJornadaDocente.php',
            type: 'GET',
            success: function (response) {
                let jorndocs = JSON.parse(response);
                let template = " "
                jorndocs.forEach(jorndoc => {
                    template += ` 
        <tr jornada_id=${jorndoc.jornada_id} jornada_docente_id=${jorndoc.jornada_doc_id}>  
         <td> ${jorndoc.jornada_doc_id}  </td>
         <td>   ${jorndoc.docente} </td>
         <td>   ${jorndoc.catedra} </td>
         <td>   ${jorndoc.fecha_inicio} </td>
         <td>   ${jorndoc.fecha_fin} </td>
         <td>   ${jorndoc.tipo_jornada} </td>
         <td>   ${jorndoc.descripcion} </td>
         <td> <button class=" jorn-docente-item btn btn-info"><i class="fas fa-pen"></i></button>
         <button class=" jorn-docente-borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
            
        </tr>

        `
                })
                $('#lista_jorn_docente').html(template);

            }
        });
    }

});

