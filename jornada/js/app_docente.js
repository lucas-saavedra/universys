$(document).ready(function () {
    listar_jornadas();
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
                    let template = " ";

                    catedras.forEach(catedra => {
                        template += ` 
                    <tr catedraId=${catedra.id}>  
                    <th> ${catedra.nombre} </th>
                    <th> ${catedra.carrera} </th>
                    <th> ${catedra.periodo} </th>
                    <th> ${catedra.anio} </th>
                    <td class="d-flex justify-content-end">
                    <a class="catedra btn btn-info" data-toggle="collapse" role="button" type="submit" href="#collapseExample" data-dismiss="modal">Aceptar</a>
                    </td>
                    </tr>
                    `
                    });


                    $('#container').html(template);

                }
            });
        }
    });

    $('#search-agente').keyup(function (e) {
        if ($('#search-agente').val()) {
            
            let search_agente = $('#search-agente').val();
            let tipo_agente = $('#tipo_agente').attr('tipo_agente');
            $.ajax({
                url: '/universys/jornada/backend/select-agente.php',
                type: 'POST',
                data: {
                    search_agente,
                    tipo_agente
                },

                success: function (response) {
                    
                    let agentes = JSON.parse(response);
                    let template = " ";
                    agentes.forEach(agente => {
                        template += ` 
                    <tr tipo_agente=${tipo_agente} agente_id=${agente.id} nombre_agente='${agente.nombre}' >  
                    <th  > ${agente.nombre} </th>
                    <td class="d-flex justify-content-end">
                    <a class="agente btn btn-info" data-toggle="collapse" role="button" type="submit" href="#agente_tabla" data-dismiss="modal">Aceptar</a>
                    </td>
                    </tr>
                    `
                    });
                    $('#container-agente').html(template);
                    

                }
            });
        }
    });

    $(document).on('click', '.agente', function () {
        let element = $(this)[0].parentElement.parentElement;
        let agente_id = $(element).attr('agente_id');
        let tipo_agente = $(element).attr('tipo_agente');
        $('#search-agente').val(obtener_agente(agente_id, tipo_agente));
        $('#search-agente').trigger('reset');
    })

    function obtener_agente(agente_id, tipo_agente) {
        $.post('/universys/jornada/backend/select-agente.php', {
            agente_id,
            tipo_agente
        }, function (response) {
            const agente = JSON.parse(response);
               $('#agente').val(agente[0].nombre);
            $('#id_agente').val(agente[0].id);
            
        })
      
    };



    $(document).on('click', '.jornada_borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
          
            $.post('/universys/jornada/backend/borrar-jornada.php', {
                jornada_id
            }, function (response) {
                listar_jornadas();
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

    $('#jornada').submit(function (e) {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        const jornadaAgente = {
            tipo_agente: tipo_agente, 
            jornadaId: $('#jornadaId').val(),
            jornada_agente_id: $('#jornada_agente_id').val(),
            id_agente: $('#id_agente').val(), 
            tipoJornadaId: $('#tipoJornadaId').val(),
            fechaInicio: $('#fechaInicio').val(),
            fechaFin: $('#fechaFin').val(),
            descripcion: $('#descripcion').val(),
            catedraId: $('#catedraIdInput').val(),
            area_id: $('#area_id').val()
        };
         
         e.preventDefault();
       
           let url = editar === false ? '/universys/jornada/backend/insertar-jornada-docente.php' : '/universys/jornada/backend/upd-jornada.php';
         $.post(url, jornadaAgente, function (response) {
            
            listar_jornadas();
             const msg = JSON.parse(response);
            
            let template = ' ';
            template += ` 
                <div class="alert alert-${msg.type}  alert-dismissible fade show" role="alert">
                ${msg.name} 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>  `;

            $('#notif').html(template);
            if (msg.success === true) {
                $('#jornada').trigger('reset');
                editar = false;
            } 

        }); 
       
    });

    $(document).on('click', '.jornada-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_agente_id = $(element).attr('jornada_agente_id');
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');

        $.post('/universys/jornada/backend/listar_jornada.php', {
            jornada_agente_id,
            tipo_agente
        }, function (response) {
            const jd = JSON.parse(response);
             $('#area_id').val(jd[0].area_id);  
            $('#jornadaId').val(jd[0].jornada_id);
            $('#jornada_agente_id').val(jd[0].jornada_agente_id);
            $('#descripcion').val(jd[0].descripcion);
            $('#id_agente').val(jd[0].id_agente);
            $('#fechaInicio').val(jd[0].fecha_fin);
            $('#fechaFin').val(jd[0].fecha_inicio);
            $('#tipoJornadaId').val(jd[0].tipo_jornada_id);
            obtener_catedra(jd[0].catedra_id);
            obtener_agente(jd[0].agente_id, tipo_agente);
            editar = true;
        })

    });

    $(document).on('click', '.catedra', function () {
        let element = $(this)[0].parentElement.parentElement;
        let catedraId = $(element).attr('catedraId');
        obtener_catedra(catedraId);
        $('#search').val(obtener_catedra(catedraId));
    })

    function obtener_catedra(catedraId) {
        $.post('/universys/jornada/backend/select-catedra.php', {
            catedraId
        }, function (response) {
            const catedra = JSON.parse(response);
           /*  $('#catedra').val(catedra[0].nombre + ', ' + catedra[0].anio + ' Año, ' + catedra[0].carrera); */
            $('#catedraIdInput').val(catedra[0].id);
            $('#search').val(catedra[0].nombre + ', ' + catedra[0].anio + ' Año, ' + catedra[0].carrera);
        })
        
    };

    function listar_jornadas() {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        $.post(
            '/universys/jornada/backend/listar_jornada.php', {
                tipo_agente
            },
            function (response) {
               
                let jornadas = JSON.parse(response);
                let template = " "
                jornadas.forEach(jornada => {
            if (tipo_agente == 'docente') {
                        template += ` 
                        <tr jornada_id=${jornada.jornada_id} jornada_agente_id=${jornada.jornada_agente_id}> 
                        
                        <td> ${jornada.jornada_agente_id}  </td>
                        <td>   ${jornada.docente} </td>
                        <td>   ${jornada.catedra} </td>
                        
                        <td>   ${jornada.fecha_inicio} </td>
                        <td>   ${jornada.fecha_fin} </td>
                        <td>   ${jornada.tipo_jornada} </td>
                        <td>   ${jornada.descripcion} </td>
                        <td> <button class=" jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                        <button class=" jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
                            
                        </tr>`;
                    } else {
                        template += ` 
                        <tr jornada_id='${jornada.jornada_id}' jornada_agente_id='${jornada.jornada_agente_id}'>  
                        <td>   ${jornada.jornada_agente_id}  </td>   
                        <td>   ${jornada.no_docente}  </td>
                        <td>   ${jornada.area}  </td>  
                        <td>   ${jornada.fecha_inicio}  </td>   
                        <td>   ${jornada.fecha_fin}  </td>   
                        <td>   ${jornada.tipo_jornada}  </td>   
                        <td>   ${jornada.descripcion}  </td>   
                    
                        <td> <button class=" jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                        <button class=" jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
                            
                        </tr>
                
                        `;

                    }


                })
                $('#listar_jornadas').html(template);

            }
        )


    }



});