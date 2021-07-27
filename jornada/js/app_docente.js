$(document).ready(function () {
    let editar = false;
    array_horarios = [];
    let filtros = {};
    let tipo_agente = $('#tipo_agente').attr('tipo_agente');
    filtros.tipo_agente = tipo_agente;
    listar_jornadas(filtros);
    search_catedra();
    search_agente();
    search_agente_horarios();

    function search_catedra() {
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
                        <a class="catedra btn btn-info" data-toggle="collapse" role="button" type="submit" href="#collapseExample">Aceptar</a>
                        </td>
                        </tr>
                        `
                        });
                        $('#container_catedra').html(template);

                    }
                });
            }
        });
    }

    function search_agente() {
        $('#search-agente').keyup(function (e) {
            if ($('#search-agente').val()) {
                let search_agente = $('#search-agente').val();
                let tipo_agente = $('#tipo_agente').attr('tipo_agente');
                let horario = false;
                agente(search_agente, tipo_agente, horario)
            }
        });
    }

    function search_agente_horarios() {
        $('#search-agente-horario').keyup(function (e) {
            if ($('#search-agente-horario').val()) {
                let search_agente = $('#search-agente-horario').val();
                let tipo_agente = $('#tipo_agente').attr('tipo_agente');
                let horario = true;
                agente(search_agente, tipo_agente, horario)
            }
        });
    }

    function agente(search_agente, tipo_agente, horario) {
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
                let href = '';
                let container = '';
                if (horario == true) {
                    href = 'agente_tabla_horarios';
                    container = 'container-agente-horarios';
                } else {
                    href = 'agente_tabla';
                    container = 'container-agente';
                }
                agentes.forEach(agente => {
                    template += ` 
                    <tr tipo_agente=${tipo_agente} agente_id=${agente.id} nombre_agente='${agente.nombre}' >  
                    <th  > ${agente.nombre} </th>
                    <td class="d-flex justify-content-end">
                    <a class="agente btn btn-info" data-toggle="collapse" role="button" type="button" href="#${href}"  >Aceptar</a>
                    </td>
                    </tr>
                    `
                });
                $(`#${container}`).html(template);


            }
        });
    }

    $(document).on('click', '.agente', function () {
        let element = $(this)[0].parentElement.parentElement;
        let agente_id = $(element).attr('agente_id');
        let tipo_agente = $(element).attr('tipo_agente');
        obtener_agente(agente_id, tipo_agente);
        listar_jornadas_agente(agente_id);
    })

    function obtener_agente(agente_id, tipo_agente) {
        $.post('/universys/jornada/backend/select-agente.php', {
            agente_id,
            tipo_agente
        }, function (response) {
            const agente = JSON.parse(response);
            $('#agente').val(agente[0].nombre);
            $('#agente_horarios').val(agente[0].nombre);
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
                listar_jornadas(filtros);
                const msg = JSON.parse(response);
                notif(msg);
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
            listar_jornadas(filtros);

            const msg = JSON.parse(response);
            notif(msg);
            if (msg.success === true) {
                $('#jornada').trigger('reset');
                $('#modal_jornadas').modal('hide');
                editar = false;
            }

        });

    });
    $(document).on('click', '.jornada-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_agente_id = $(element).attr('jornada_agente_id');
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        obtener_jornada(jornada_agente_id, tipo_agente);
        editar = true;
        $('#modal_jornadas').modal('show');

    });

    $(document).on('click', '.horario_item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        let jornada_agente_id = $(element).attr('jornada_agente_id');
        let horario_id = $(element).attr('horario_id');
        let jornada_id = $(element).attr('jornada_id');
        let agente_id = $(element).attr('agente_id');
        editar = true;
        $('#id_agente').val(agente_id);

        obtener_agente(agente_id, tipo_agente);
        obtener_horario(horario_id, jornada_id);
        listar_jornadas_agente(agente_id, jornada_agente_id);

    })
    $(document).on('click', '.horario_item_borrar', function () {
        let element = $(this)[0].parentElement.parentElement;
        let horario_id = $(element).attr('horario_id');
        if (confirm('¿Seguro que desea eliminar este horario?')) {
            $.post('/universys/jornada/backend/borrar-horario.php', {
                horario_id
            }, function (response) {
                const msg = JSON.parse(response);
                notif(msg);
            })
            listar_jornadas(filtros);
        }
    })

    function obtener_horario(horario_id, jornada_id) {
        $.post('/universys/jornada/backend/horarios.php', {
            horario_id,
            jornada_id
        }, function (response) {
            const det_horario = JSON.parse(response);
            $('#horario_id').val(horario_id);
            $('#jornada_agente').val(det_horario[0].jornada_id);
            $('#descripcion_horario').val(det_horario[0].descripcion);
            $('#hora_inicio').val(det_horario[0].hora_inicio);
            $('#hora_fin').val(det_horario[0].hora_fin);
            $('#dia_id').val(det_horario[0].dia_id);

        })


    };

    $(document).on('click', '.jornada-horario', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_agente_id = $(element).attr('jornada_agente_id');
        let jornada_id = $(element).attr('jornada_id');
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        obtener_jornada(jornada_agente_id, tipo_agente);
        $.post('/universys/jornada/backend/horarios.php', {
            jornada_id,
        }, function (response) {
            const horarios = JSON.parse(response);
            let template = " "
            horarios.forEach(horario => {

                template += `
                                <tr>
                                <td class="table-secondary"> ${horario.nombre} </td>
                                <td class="table-secondary"> ${horario.hora_inicio} </td>
                                <td class="table-secondary"> ${horario.hora_fin} </td>
                                <td class="table-secondary"> ${horario.descripcion} </td>
                                </tr>`

            })

            $('#tabla_horarios').html(template);
        })


    });

    function obtener_jornada(jornada_agente_id, tipo_agente) {
        $.post('/universys/jornada/backend/listar_jornada.php', {
            jornada_agente_id,
            tipo_agente
        }, function (response) {
            const jd = JSON.parse(response);
            $('#area_id').val(jd[0].area_id);
            $('#jornadaId').val(jd[0].jornada_id);
            $('#jornada_agente_id').val(jd[0].jornada_agente_id);
            $('#descripcion').val(jd[0].descripcion);

            $('#fechaInicio').val(jd[0].fecha_fin);
            $('#fechaFin').val(jd[0].fecha_inicio);
            $('#tipoJornadaId').val(jd[0].tipo_jornada_id);
            obtener_catedra(jd[0].catedra_id);
            $('#id_agente').val(jd[0].id_agente);
            obtener_agente(jd[0].agente_id, tipo_agente);

            let template = " "
            jd.forEach(jornada => {

                template += `
            
                            <p>Nombre:    ${jornada.docente} | ${jornada.catedra} <p> 
                            <p>Fecha de inicio   ${jornada.fecha_inicio} => Fecha de fin ${jornada.fecha_fin}  <p> 
                            <p> Tipo de jornada   ${jornada.tipo_jornada}  <p> 
                            <p>  Descripción  ${jornada.descripcion}  <p> `;
            })

            $('#alert_jornada').html(template);

        })

    }
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



    $('#horario').submit(function (e) {
        e.preventDefault();
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        const horarioAgente = {
            tipo_agente: tipo_agente,
            jornadaId: $('#jornada_agente').val(),
            horario_id: $('#horario_id').val(),
            descripcion: $('#descripcion_horario').val(),
            hora_inicio: $('#hora_inicio').val(),
            hora_fin: $('#hora_fin').val(),
            dia_id: $('#dia_id').val()
        };
        let url2 = editar === false ? '/universys/jornada/backend/insertar-horario.php' : '/universys/jornada/backend/upd-horario.php';
        $.post(url2,
            horarioAgente,
            function (response) {
                const msg = JSON.parse(response);
                notif(msg);
                listar_jornadas(filtros)
                if (msg.success === true) {
                    $('#horario').trigger('reset');
                    editar = false;
                }

            });
    });

    function listar_jornadas_agente(agente_id) {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        $.post(
            '/universys/jornada/backend/listar_jornada.php', {
                tipo_agente,
                agente_id
            },
            function (response) {
                let jornadas = JSON.parse(response);
                let template = " "

                if (jornadas == '') {
                    template = "Nada por aquí..."
                } else {

                    jornadas.forEach(jornada => {
                        if (tipo_agente == 'docente') {
                            template += `
                            <option id="item_jornada" value=${jornada.jornada_id} 
                            jornada_agente_id=${jornada.jornada_agente_id}> <td> 
                            ${jornada.catedra} | 
                            ${jornada.tipo_jornada} | 
                            ${jornada.descripcion} |  
                            ${jornada.fecha_inicio} => 
                            ${jornada.fecha_fin}
                            </option> `;

                        } else if (tipo_agente == 'docente') {
                            template += ` 
                            <option id="item_jornada" value=${jornada.jornada_id} 
                            jornada_agente_id=${jornada.jornada_agente_id}> <td> 
                            ${jornada.area} | 
                            ${jornada.tipo_jornada} | 
                            ${jornada.descripcion} |  
                            ${jornada.fecha_inicio} => 
                            ${jornada.fecha_fin}
                            </option> `;
                        }
                    })
                }
                $('#jornada_agente').html(template);

            }
        )


    }


    $('#filtroJornada').submit(function (e) {
        e.preventDefault();
        let filtros = {
            filtroFechaFin: $('#filtroFechaFin').val(),
            filtroFechaInicio: $('#filtroFechaInicio').val(),
            filtroTipoJornadaId: $('#filtroTipoJornadaId').val(),
        };
        listar_jornadas(filtros)
    })

    $(document).on('click', '.filtro_reset', function () {
        listar_jornadas(filtros);
    })


    function listar_jornadas(filtros) {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        filtros.tipo_agente = tipo_agente;
        var template = " ";
        $.post(
            '/universys/jornada/backend/listar_jornada.php',
            filtros,
            function (response) {

                let j = JSON.parse(response);
                if (j == '') {
                    template = "Nada por aquí..."
                } else {
                    for (jornada of j) {
                        template += `
                            <tr jornada_id=${jornada.jornada_id} jornada_agente_id=${jornada.jornada_agente_id}> 
                            <td> ${jornada.jornada_agente_id}  </td>
                            <td>   ${jornada.docente} </td>
                            <td>   ${jornada.catedra} </td>
                            <td>   ${jornada.fecha_inicio} </td>
                            <td>   ${jornada.fecha_fin} </td>
                            <td>   ${jornada.tipo_jornada} </td>
                            <td>   ${jornada.descripcion} </td>`;

                        if (filtros.agente_id == undefined) {
                            template += `   
                         <td> 
                                <button class="jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                                <button class="jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button>
                                <button type="button"class=" jornada-horario btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-clock"></i></button>
                                
                                  
                            </tr>
                            <td colspan="4">
                            `;

                        } else {
                            template += `<td> <button type="button" class=" jornada-item  btn btn-success" data-toggle="collapse" data-target=".multi-collapse"  aria-controls="toggle_jornadas agente_tabla search_agente" role="button" type="button" "><i class="fas fa-check-circle"></i></button></td>
                                </tr>
                                <td colspan="4">
                            `;
                        }
                        for (detalle of jornada.detalle_jornada) {
                            template += `
                            <div horario_id="${detalle.id}" 
                                jornada_agente_id="${jornada.jornada_agente_id}" 
                                agente_id="${jornada.agente_id}"
                                jornada_id="${detalle.jornada_id}">
                                <div class="h6 bg-light text-dark" id="basic-addon1">
                                <div class="badge badge-primary p-1"> ${detalle.nombre}</div>
                                ${detalle.hora_inicio}<i class="fas fa-arrow-right p-1"></i>
                                ${detalle.hora_fin}     
                                <strong class="mx-3">  ${detalle.descripcion}</strong>
                                    <button type="button" class="horario_item btn" data-toggle="modal" data-target="#modal_horarios"><i class=" fas fa-pen"></i></button>
                                    <button type="button" class="horario_item_borrar btn"><i class=" fas fa-trash"></i></button>
                                </div>
                            </div>
                       
                        
                            `;

                        }
                        template += ` </td>
                         </tr> `;

                    }


                    /*  jornadas.forEach(jornada => {
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
                                    <td>   ${jornada.detalle_jornada} </td>
                                    `;
                                  


                                if (agente_id == undefined) {
                                    template += `   
                                    <td> 
                                    <button class="jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                                    <button class="jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button>
                                    <button type="button"class=" jornada-horario btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-clock"></i></button>
                                    
                                      
                                </tr>`;


                                } else {
                                    template += `<td> <button type="button" class=" jornada-item  btn btn-success" data-toggle="collapse" data-target=".multi-collapse"  aria-controls="toggle_jornadas agente_tabla search_agente" role="button" type="button" "><i class="fas fa-check-circle"></i></button></td>
                                    </tr>`;

                                }

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


                        }) */
                }

                $('#listar_jornadas').html(template);

            }


        )
    }

    $(document).on('click', '.test', function () {
        let element = $(this)[0].parentElement;
        let id_tiempo_inicio = $(element).attr('id_tiempo_inicio');
        console.log(element);
        console.log(id_tiempo_inicio);
    })

    $(document).on('click', '.horario_mesa_i_add_agente', function () {
        let element = $(this)[0].parentElement;
        $('#horario_id').val($(element).attr('horario_id'));
        $('#mesa_id').val($(element).attr('mesa_id'));

    })

    /****************************************** */
    function notif(msg) {
        let template = ' ';
        template += `
                    <div class="alert alert-${msg.type}  alert-dismissible fade show" role="alert">
                    ${msg.name} 
                    </div>  `;

        $('#toast_notif').html(template);
        $("#toastNotif").toast('show');
    }



    /****************************************** */

    $('#formAddAgente').submit(function (e) {
        e.preventDefault();
        var selected_agente = [];
        $('.checkbox_docentes input:checked').each(function () {
            selected_agente.push($(this).val());
        });
        let agentes = {
            horario_id: $('#horario_id').val(),
            mesa_id: $('#mesa_id').val(),
            docentes_mesa_id: selected_agente
        }
        console.log(agentes);
        $.post(
            '/universys/jornada/backend/test.php',
            agentes,
            function (response) {
                console.log(response);
                const msg = JSON.parse(response);
                notif(msg);

                if (msg.success === true) {
                    $('#formAddAgente').trigger('reset');
                    $('#add_agente').modal('hide');
                    editar = false;
                }

            })

    })

    $(document).on('click', '.horario_mesa_i', function () {
        $('#upd_detalle_mesa').modal('show');
        let element = $(this)[0].parentElement;

        $('#upd_mesa_horario_dia').val($(element).attr('horario_id'));
        $('#mesa_horario_inicio').val($(element).attr('hora_inicio'));
        $('#mesa_horario_fin').val($(element).attr('hora_fin'));
        $('#upd_mesa_dia').val($(element).attr('dia'));


    })
    $('#upd_mesa_horario').submit(function (e) {
        dia_hora = {
            id: $('#upd_mesa_horario_dia').val(),
            inicio: $('#mesa_horario_inicio').val(),
            fin: $('#mesa_horario_fin').val(),
            dia: $('#upd_mesa_dia').val()
        }
        e.preventDefault();
        $.post('/universys/jornada/backend/upd-horario.php',
            dia_hora,
            function (response) {
                console.log(response)
                const msg = JSON.parse(response);
               notif(msg);
                if (msg.success === true) {
                    $('#upd_mesa_horario').trigger('reset');
                    $('#upd_detalle_mesa').modal('hide');
                    editar = false;
                }



            })



    })

    $(document).on('click', '.borrar_agente_mesa', function () {
        if (confirm('¿Seguro que desea eliminar este agente?')) {
            let element = $(this)[0];
            let jornada_agente_mesa_id = $(element).attr('jornada_agente_mesa_id');

            console.log(jornada_agente_mesa_id);
            $.post('/universys/jornada/backend/borrar-jornada.php', {
                jornada_agente_mesa_id
            }, function (response) {
                console.log(response)
                const msg = JSON.parse(response);
                notif(msg);
            })
        }
    })


    $(document).on('click', '.jornada_mesa_borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
            let mesa_id = $(element).attr('mesa_id');
            console.log(jornada_id, mesa_id);
            $.post('/universys/jornada/backend/borrar-jornada.php', {
                jornada_id,
                mesa_id
            }, function (response) {
                console.log(response)
                const msg = JSON.parse(response);
                notif(msg);
            })
        }
    })


    $('#jornada_mesa').submit(function (e) {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        var selected_dias = [];
        var array_dias = [];
        let dia;
        let inicio = document.getElementsByName('inicio[]');
        let fin = document.getElementsByName('fin[]');
        $('.checkbox_dias input:checked').each(function () {
            selected_dias.push(Number($(this).val()));
        });

        for (var i = 0; i < selected_dias.length; i++) {
            dia = {
                dia_id: selected_dias[i],
                hora_inicio: inicio[selected_dias[i]].value,
                hora_fin: fin[selected_dias[i]].value,
            };
            array_dias.push(dia);
        }

        e.preventDefault();
        const jornada_mesa = {
            tipo_agente: tipo_agente,
            fechaInicioMesa: $('#fechaInicioMesa').val(),
            fechaFinMesa: $('#fechaFinMesa').val(),
            descripcion: $('#descripcion_mesa').val(),
            llamado_id: $('#llamado_id').val(),
            carrera_id: $('#carrera_id').val(),
            dia_id: selected_dias,
            hora_inicio_mesa: $('#hora_inicio_mesa').val(),
            hora_fin_mesa: $('#hora_fin_mesa').val(),
            dias_horas: array_dias,


        }
        console.log(jornada_mesa);
        $.post(
            '/universys/jornada/backend/test.php',
            jornada_mesa,
            function (response) {

                const msg = JSON.parse(response);
                notif(msg);
                
                if (msg.success === true) {
                    $('#horario').trigger('reset');
                    editar = false;
                }
            })
    })

})