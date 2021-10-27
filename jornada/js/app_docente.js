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
            $('#catedraCollapse').collapse('show');
            if ($('#search').val()) {
                let search = $('#search').val();
                $.ajax({
                    url: '../jornada/backend/select-catedra.php',
                    type: 'POST',
                    data: {
                        search
                    },
                    success: function (response) {

                        let catedras = JSON.parse(response);
                        let template = " ";
                        if (catedras == '') {
                            template = "Nada por aquí..."
                        } else {
                            catedras.forEach(catedra => {
                                template += ` 
                        <tr catedraId=${catedra.id}>  
                        <th> ${catedra.nombre} </th>
                        <th> ${catedra.carrera} </th>
                        <th> ${catedra.periodo} </th>
                        <th> ${catedra.anio} </th>
                        <td class="d-flex justify-content-end">
                        <a class="catedra btn btn-info" data-toggle="collapse" role="button" type="submit" href="#catedraCollapse">Aceptar</a>
                        </td>
                        </tr>
                        `
                            });
                            $('#container_catedra').html(template);

                        }
                    }
                });
            } else $('#catedraCollapse').collapse('hide');
        });
    }

    function search_agente() {
        $('#search-agente').keyup(function (e) {
            $('#agente_tabla').collapse('show');
            if ($('#search-agente').val()) {
                let search_agente = $('#search-agente').val();
                let tipo_agente = $('#tipo_agente').attr('tipo_agente');
                let horario = false;
                agente(search_agente, tipo_agente, horario)
            } else {
                $('#agente_tabla').collapse('hide');
            }
        });
    }

    function search_agente_horarios() {
        $('#search-agente-horario').keyup(function (e) {
            $('#agente_tabla_horarios').collapse('show');
            if ($('#search-agente-horario').val()) {
                let search_agente = $('#search-agente-horario').val();
                let tipo_agente = $('#tipo_agente').attr('tipo_agente');
                let horario = true;
                agente(search_agente, tipo_agente, horario)
            } else $('#agente_tabla_horarios').collapse('hide');
        });
    }

    function agente(search_agente, tipo_agente, horario) {
        $.ajax({
            url: '../jornada/backend/select-agente.php',
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
                    <tr tipo_agente=${tipo_agente} agente_id=${agente.id} persona_id=${agente.persona_id}  nombre_agente='${agente.nombre}' >  
                    <th > ${agente.nombre} </th>
                    <td class="d-flex justify-content-end">
                    <a class="agente btn btn-info" data-toggle="collapse" role="button" type="button" href="#${href}">Aceptar</a>
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
        $.post('../jornada/backend/select-agente.php', {
            agente_id,
            tipo_agente
        }, function (response) {
            const agente = JSON.parse(response);
            $('#agente').val(agente[0].nombre);
            $('#agente_horarios').val(agente[0].nombre);
            $('#id_agente').val(agente[0].id);
            $('#persona_id').val(agente[0].persona_id);
        })
    };

    $(document).on('click', '.jornada_borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
            $.post('../jornada/backend/borrar-jornada.php', {
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
            area_id: $('#area_id').val(),
            dias_horas: array_dias,
            persona_id: $('#persona_id').val()
        };
        e.preventDefault();
        let url = editar === false ? '../jornada/backend/insertar-jornada-docente.php' : '../jornada/backend/upd-jornada.php';

        $.post(url, jornadaAgente, function (response) {

            listar_jornadas(filtros);
            const msg = JSON.parse(response);
            notif(msg);
            if (msg.success === true) {
                resetEditForm('jornada');
                $('#modal_jornadas').modal('hide');
                editar = false;
                $("#fechaInicio").removeAttr("disabled", "");
                /*   $("#fechaFin").removeAttr("disabled", ""); */
                $("#search-agente").removeAttr("disabled", "");
            }

        });

    });

    $(document).on('click', '.jornada-item', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_agente_id = $(element).attr('jornada_agente_id');
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');

        $.post('../jornada/backend/listar_jornada_agente.php', {
            jornada_agente_id,
            tipo_agente
        }, function (response) {
            let jornada = JSON.parse(response);
            jornada.forEach(e => {
                bool = e.detalle_jornada != '';
            });
            if (bool) {
                $("#fechaInicio").attr("disabled", "");
                /* $("#fechaFin").attr("disabled", ""); */
                $("#search-agente").attr("disabled", "");
            }

        })

        obtener_jornada(jornada_agente_id, tipo_agente);
        editar = true;
        $('#modal_jornadas').modal('show');

    });
    $(document).on('click', '.horario_item', function () {
        let element = $(this)[0].parentElement;
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
        let element = $(this)[0].parentElement;
        let horario_id = $(element).attr('horario_id');
        if (confirm('¿Seguro que desea eliminar este horario?')) {
            $.post('../jornada/backend/borrar-jornada.php', {
                horario_id
            }, function (response) {
                const msg = JSON.parse(response);
                notif(msg);
            })
            listar_jornadas(filtros);
        }
    })

    function obtener_horario(horario_id, jornada_id) {
        $.post('../jornada/backend/horarios.php', {
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
        $.post('../jornada/backend/horarios.php', {
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
        tipo_agente = $('#tipo_agente').attr('tipo_agente');
        $.post('../jornada/backend/listar_jornada_agente.php', {
            jornada_agente_id,
            tipo_agente
        }, function (response) {
            const jd = JSON.parse(response);
            $('#area_id').val(jd[0].area_id);
            $('#jornadaId').val(jd[0].jornada_id);
            $('#jornada_agente_id').val(jd[0].jornada_agente_id);
            $('#descripcion').val(jd[0].descripcion);
            $('#fechaInicio').val(jd[0].fecha_inicio);
            $('#fechaFin').val(jd[0].fecha_fin);
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
        $.post('../jornada/backend/select-catedra.php', {
            catedraId
        }, function (response) {
            const catedra = JSON.parse(response);
            $('#catedraIdInput').val(catedra[0].id);
            $('#search').val(catedra[0].nombre + ', ' + catedra[0].anio + ' Año, ' + catedra[0].carrera);
        })

    };

    $('#horarios_one').submit(function (e) {
        e.preventDefault();

        const horarioAgenteOne = {
            tipo_agente: tipo_agente,
            jornadaId: $('#jornada_agente').val(),
            id_agente: $('#id_agente').val(),
            horario_id: $('#horario_id').val(),
            hora_inicio: $('#hora_inicio').val(),
            hora_fin: $('#hora_fin').val(),
            dia_id: $('#dia_id').val()
        };


        $.post('../jornada/backend/upd-horario.php',
            horarioAgenteOne,
            function (response) {

                const msg = JSON.parse(response);
                notif(msg);
                listar_jornadas(filtros)
                if (msg.success === true) {
                    $('#horario_one').trigger('reset');
                    editar = false;
                    $('#modal_horarios_one').modal('hide');
                }

            });
    });

    $('#horario').submit(function (e) {
        e.preventDefault();
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        var selected_dias = [];
        var array_dias = [];
        let dia;
        let inicio = document.getElementsByName('inicio_horarios[]');
        let fin = document.getElementsByName('fin_horarios[]');
        $('.checkbox_dias_horarios input:checked').each(function () {
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
        const horarioAgente = {
            tipo_agente: tipo_agente,
            jornadaId: $('#jornada_agente').val(),
            id_agente: $('#id_agente').val(),
            descripcion: $('#descripcion_horario').val(),
            dias_horas: array_dias,
        };

        let url2 = editar === false ? '../jornada/backend/insertar-horario.php' : '../jornada/backend/upd-horario.php';
        $.post(url2,
            horarioAgente,
            function (response) {
                ;
                const msg = JSON.parse(response);
                notif(msg);
                listar_jornadas(filtros)
                if (msg.success === true) {
                    $('#horario').trigger('reset');
                    editar = false;
                    $('#modal_horarios').modal('hide');
                }

            });
    });

    $(document).on('click', '.reset', function () {
        let element = $(this)[0].parentElement.parentElement.parentElement;
        resetEditForm($(element).attr('id'))
        $("#mesa_horario_inicio").removeAttr("disabled", "");
        $("#mesa_horario_fin").removeAttr("disabled", "");
    })

    function resetEditForm(form) {
        editar = false;
        $(`#${form}`).trigger('reset');
        let template = '';
        template = ` <option selected value="" disabled>Escoja una jornada</option>`;
        $('#jornada_agente').html(template);
        $('#agente').val('');
        $('#agente_horarios').val('');
        $('#id_agente').val('');
        $('#catedraIdInput').val('');
        $("#fechaInicio").removeAttr("disabled", "");
        /* $("#fechaFin").removeAttr("disabled", ""); */
        $("#search-agente").removeAttr("disabled", "");
    }

    function listar_jornadas_agente(agente_id, jornada_agente_id) {
        let tipo_agente = $('#tipo_agente').attr('tipo_agente');
        $.post(
            '../jornada/backend/listar_jornada_agente.php', {
                tipo_agente,
                agente_id,
                jornada_agente_id
            },
            function (response) {
                let jornadas = JSON.parse(response);

                let template = " "
                if (jornadas == '') {
                    template = ` <option selected value="" disabled >No contiene jornadas</option>`;
                } else {
                    let area;
                    if (editar == false) {
                        template += ` <option selected value="" disabled>Escoja una jornada</option>`;
                    }
                    jornadas.forEach(jornada => {

                        if (tipo_agente == 'docente') {
                            area = jornada.catedra;
                        } else {
                            area = jornada.area;
                        }
                        template += `
                            <option id="item_jornada" value=${jornada.jornada_id} 
                            jornada_agente_id=${jornada.jornada_agente_id}> <td>
                            ${area} | 
                            ${jornada.tipo_jornada} | 
                            ${jornada.descripcion} |  
                            ${jornada.fecha_inicio} => 
                            ${jornada.fecha_fin}
                            </option> `;


                    })

                }
                $('#jornada_agente').html(template);

            }
        )


    }


    $('#filtroJornada').click(function (e) {
        e.preventDefault();

        let filtros = {
            filtroFechaFin: $('#filtroFechaFin').val(),
            filtroFechaInicio: $('#filtroFechaInicio').val(),
            filtroTipoJornadaId: $('#filtroTipoJornadaId').val(),
            filtroCarreraId: $('#filtroCarreraId').val(),
            filtroAreaId: $('#filtroAreaId').val(),
            filtroAnioId: $('#filtroAnioId').val(),
            tipo_agente: tipo_agente
        };

        listar_jornadas(filtros)
    })

    $(document).on('click', '.filtro_reset', function () {
        listar_jornadas(filtros);
    })

    function listar_jornadas(filtros) {
        if (tipo_agente != '') {
            var template = " ";
            $.post(
                '../jornada/backend/listar_jornada.php',
                filtros,
                function (response) {
                    let j = JSON.parse(response);
                    if (j == '') {
                        template = "Nada por aquí..."
                    } else {
                        for (jornada of j) {

                            template += `
                            <tr jornada_id=${jornada.jornada_id} jornada_agente_id=${jornada.jornada_agente_id} class="table-secondary"> 
                            <td> ${jornada.jornada_agente_id}  </td>`;

                            if (tipo_agente == 'docente') {
                                template += `
                                <td>  ${jornada.docente} </td>
                                <td>  <p class="h6"> ${jornada.carrera} - ${jornada.anio_plan} Año</p> <p class="mb-0"> ${jornada.catedra} </p>   </td>
                                `;
                            } else {
                                template += `
                                <td> ${jornada.no_docente}</td>
                                <td> ${jornada.area}</td>
                                `;
                            }


                            template += `
                            
                            <td>   ${jornada.fecha_inicio} </td>
                            <td>   ${jornada.fecha_fin} </td>
                            <td>   ${jornada.tipo_jornada} </td>
                            <td>   ${jornada.descripcion} </td>
                           
                            <td> 
                                <button class="jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                                <button class="jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button>
                              
                            </td>     
                            </tr>
                            <tr>
                                    <td colspan="6">
                                        <table class="table mb-0">
                                            <thead class="table-borderless">
                                                <tr>
                                                    <th scope="col">Dia</th>
                                                    <th scope="col">Hora Inicio</th>
                                                    <th scope="col">Hora Fin</th>
                                                   
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                            `;

                            for (detalle of jornada.detalle_jornada) {
                                template += `
                            <tr>
                           

                            <td> <strong>${detalle.nombre}</strong> </td>
                               <td> ${detalle.hora_inicio}</td>
                               <td> ${detalle.hora_fin}</td>
                               <td horario_id="${detalle.id}" jornada_agente_id="${jornada.jornada_agente_id}" agente_id="${jornada.agente_id}"
                                jornada_id="${detalle.jornada_id}"> 
                                    <button type="button" class="horario_item btn" data-toggle="modal" data-target="#modal_horarios_one"><i class=" fas fa-pen"></i></button>
                                    <button type="button" class="horario_item_borrar btn"><i class=" fas fa-trash"></i></button>
                                </td>
                                </tr>
                             `;


                            }
                            template += ` 
                        </tbody>
                        </table>
                    </td>
                    </tr> `;

                        }
                    }
                    $('#listar_jornadas').html(template);
                }
            )
        }

    }


    $(document).on('click', '.horario_mesa_i_add_agente', function () {
        let element = $(this)[0].parentElement;
        $('#horario_id').val($(element).attr('horario_id'));
        $('#hora_inicio_agente').val($(element).attr('hora_inicio'));
        $('#hora_fin_agente').val($(element).attr('hora_fin'));
        $('#mesa_id').val($(element).attr('mesa_id'));

    })

    /****************************************** */
    function notif(msg) {
        let template = ' ';
        template += `
                    <div class="alert alert-${msg.type}  alert-dismissible fade show" role="alert">`;
        template += `${msg.name}`
        template += `</div>`;

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
            hora_inicio: $('#hora_inicio_agente').val(),
            hora_fin: $('#hora_fin_agente').val(),
            mesa_id: $('#mesa_id').val(),
            docentes_mesa_id: selected_agente
        }

        $.post(
            '../jornada/backend/insertar-jornada-docente-mesa.php',
            agentes,
            function (response) {

                const msg = JSON.parse(response);
                notif(msg);
                if (msg.success === true) {
                    $('#formAddAgente').trigger('reset');
                    $('#add_agente').modal('hide');
                    editar = false;
                }
                listar_jornadas_mesa();
            })


    })

    $(document).on('click', '.horario_mesa_i', function () {
        $('#upd_detalle_mesa').modal('show');
        let element = $(this)[0].parentElement;
        $('#upd_mesa_horario_dia').val($(element).attr('horario_id'));
        $('#mesa_horario_inicio').val($(element).attr('hora_inicio'));
        $('#mesa_horario_fin').val($(element).attr('hora_fin'));
        $('#hora_inicio_agente').val($(element).attr('hora_inicio'));
        $('#hora_fin_agente').val($(element).attr('hora_fin'));
        $('#upd_mesa_dia').val($(element).attr('dia'));
        $('#upd_mesa_dia_id').val($(element).attr('dia_id'));
        $('#upd_mesa_id').val($(element).attr('mesa_id'));





        $('#descripcion_dia_mesa_updt').val($(element).attr('descripcion_dia'));


        const horario_id = $(element).attr('horario_id');
        $.post('../jornada/backend/consulta_descripcion_horario.php', {
            horario_id
        }, function (response) {
            let res = JSON.parse(response);
            $('#descripcion_dia_mesa_updt').val(res.descripcion)
        })
        $.post('../jornada/backend/consulta_mesa_horario.php', {
            horario_id
        }, function (response) {
            let res = JSON.parse(response);
            if (res != null) {
                $("#mesa_horario_inicio").attr("disabled", "");
                $("#mesa_horario_fin").attr("disabled", "");
            }
        })
    })

    $('#upd_mesa_horario').submit(function (e) {

        data = {
            horario_id: $('#upd_mesa_horario_dia').val(),
            hora_inicio: $('#mesa_horario_inicio').val(),
            hora_fin: $('#mesa_horario_fin').val(),
            dia_id: $('#upd_mesa_dia_id').val(),
            mesa_id: $('#upd_mesa_id').val(),
            descripcion_dia: $('#descripcion_dia_mesa_updt').val()
        }

        e.preventDefault();
        $.post('../jornada/backend/upd-horario.php',
            data,
            function (response) {

                const msg = JSON.parse(response);
                notif(msg);
                if (msg.success === true) {

                    $('#upd_mesa_horario').trigger('reset');
                    $('#upd_detalle_mesa').modal('hide');
                    editar = false;
                    $("#mesa_horario_inicio").removeAttr("disabled", "");
                    $("#mesa_horario_fin").removeAttr("disabled", "");
                }



            })
        listar_jornadas_mesa();
    })

    $(document).on('click', '.borrar_agente_mesa', function () {
        if (confirm('¿Seguro que desea eliminar este agente?')) {
            let element = $(this)[0];
            let jornada_agente_mesa_id = $(element).attr('jornada_agente_mesa_id');
            $.post('../jornada/backend/borrar-jornada.php', {
                jornada_agente_mesa_id
            }, function (response) {
                const msg = JSON.parse(response);
                notif(msg);
                listar_jornadas_mesa();
            })

        }

    })


    $(document).on('click', '.jornada_mesa_borrar', function () {
        if (confirm('¿Seguro que desea eliminar esta jornada?')) {
            let element = $(this)[0].parentElement.parentElement;
            let jornada_id = $(element).attr('jornada_id');
            let mesa_id = $(element).attr('mesa_id');

            $.post('../jornada/backend/borrar-jornada.php', {
                jornada_id,
                mesa_id
            }, function (response) {

                const msg = JSON.parse(response);
                notif(msg);
                listar_jornadas_mesa()
            })

        }

    })


    /*  $('#jornada_mesa').submit(function (e) {
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
             '../jornada/backend/test.php',
             jornada_mesa,
             function (response) {

                 const msg = JSON.parse(response);
                 notif(msg);
                 
                 if (msg.success === true) {
                     $('#horario').trigger('reset');
                     editar = false;
                 }
             })
     }) */

    $(document).on('click', '.jornada_item_mesa', function () {
        let element = $(this)[0].parentElement.parentElement;
        let jornada_id = $(element).attr('jornada_id');
        let mesa_id = $(element).attr('mesa_id');
        editar = true;
        $.post(
            '../jornada/backend/upd_jornada_mesa.php', {
                jornada_id
            },
            function (response) {
                const jornada_mesa = JSON.parse(response);
                $('#fechaInicioMesaUpdt').val(jornada_mesa.fecha_inicio);
                $('#fechaFinMesaUpdt').val(jornada_mesa.fecha_fin);
                $('#descripcion_mesa_updt').val(jornada_mesa.descripcion);
                $('#llamado_id_updt').val(jornada_mesa.llamado_id);
                $('#carrera_id_updt').val(jornada_mesa.carrera_id);
                $('#mesa_examen_id').val(jornada_mesa.id);
                $('#jornada_id_mesa').val(jornada_mesa.jornada_id);

            })

        $('#upd_jornada_mesa').modal('show');
        listar_jornadas_mesa();
    });

    $('#act_jornada_mesa').submit(function (e) {
        e.preventDefault();
        const jornada_mesa_upd = {
            fechaInicioMesa: $('#fechaInicioMesaUpdt').val(),
            fechaFinMesa: $('#fechaFinMesaUpdt').val(),
            descripcion: $('#descripcion_mesa_updt').val(),
            llamado_id: $('#llamado_id_updt').val(),
            carrera_id: $('#carrera_id_updt').val(),
            mesa_examen_id: $('#mesa_examen_id').val(),
            jornada_id_mesa: $('#jornada_id_mesa').val(),

        }

        $.post(
            '../jornada/backend/upd_jornada_mesa.php',
            jornada_mesa_upd,
            function (response) {
                const msg = JSON.parse(response);
                notif(msg);
                if (msg.success === true) {
                    $('#upd_jornada_mesa').modal('hide');
                    editar = false;
                }
                listar_jornadas_mesa();
            })

    })

    $('#jornada_mesa').submit(function (e) {
        e.preventDefault();
        var selected_dias = [0, 1, 2, 3, 4, 5];
        const jornada_mesa = {
            fechaInicioMesa: $('#fechaInicioMesa').val(),
            fechaFinMesa: $('#fechaFinMesa').val(),
            descripcion: $('#descripcion_mesa').val(),
            llamado_id: $('#llamado_id').val(),
            carrera_id: $('#carrera_id').val(),
            dia_id: selected_dias,
            hora_inicio_mesa: $('#hora_inicio_mesa').val(),
            hora_fin_mesa: $('#hora_fin_mesa').val(),
        }
        $.post(
            '../jornada/backend/insertar-jornada-docente-mesa.php',
            jornada_mesa,
            function (response) {
                const msg = JSON.parse(response);

                notif(msg);
                listar_jornadas_mesa();
                if (msg.success === true) {
                    $('#jornada_mesa').trigger('reset');
                    editar = false;
                }
            })

    });
    listar_jornadas_mesa();

    function listar_jornadas_mesa(filtros) {
        let template = '';
        $.post(
            '../jornada/backend/listar_jornada_mesa.php',
            filtros,
            function (response) {
                let jm = JSON.parse(response);
                if (jm == '') {
                    template = "Nada por aquí..."
                } else {
                    for (mesa of jm) {
                        template += `
                        
                        <tr jornada_id="${mesa.jornada_id}" mesa_id="${mesa.id}" class="table-secondary">
                        <td>  ${mesa.jornada_id     }</td>
                        <td>  ${mesa.carrera_nombre }</td>
                        <td>  ${mesa.llamado_nombre } </td>
                        <td > Inicio: ${mesa.fecha_inicio}
                        <br> Fin: ${mesa.fecha_fin      }</td>
                        <td>  ${mesa.descripcion    }</td>
                        <td colspan="6"> <button class="jornada_item_mesa btn btn-info" type="button" data-toggle="modal" data-target="#upd_jornada_mesa"><i class="fas fa-pen"></i></button>
                        <button class="jornada_mesa_borrar btn btn-danger"><i class="fas fa-trash"></i></button>
                        <a type="button" class="btn btn-success" href="./backend/exportar_horarios_mesa.php?mesa_id=${mesa.id}" ><i class="fas fa-download"></i></a>
                        </td>
                    </tr>
                    <tr>
                            <td colspan="6">
                                <table class="table mb-0 table-responsive-md">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">Dia</th>
                                            <th scope="col">Hora Inicio</th>
                                            <th scope="col">Hora Fin</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col-3">Docentes</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                        for (horarios of mesa.detalle_mesa) {

                            template += `

                            
                            <tr>
                                <td>${horarios.nombre} </td>
                                <td>${horarios.hora_inicio}</td>
                                <td>${horarios.hora_fin}</td>
                                <td>${ horarios.descripcion_dia==null? 'No contiene descripción': horarios.descripcion_dia}</td>
                                <td class="align-middle">
                                `;
                            horarios.docentes.forEach(agente => {
                                template += `
                                <button class=" btn badge badge-warning borrar_agente_mesa" jornada_agente_mesa_id="${agente.jornada_agente_id}">
                                ${agente.docente}
                                <i class=" fas fa-trash"></i>
                                </button>
                                `;
                            })
                            template += `
                                 </td>
                                    <td horario_id="${horarios.det_jorn_id}" mesa_id="${mesa['id']}" hora_inicio="${horarios.hora_inicio}" hora_fin="${horarios.hora_fin}"dia_id="${horarios.dia_id}" dia="${horarios.nombre}">
                                        <button type="button" class="horario_mesa_i btn" data-bs-toggle="modal"><i class=" fas fa-pen"></i></button>
                                        
                                        <button type="button" class="horario_mesa_i_add_agente btn" data-toggle="modal" data-target="#add_agente"><i class="fas fa-user-plus"></i> </button>
                                </td>
                            </tr>

                           `;

                        }

                        template += `            
                         </tbody>
                        </table>
                    </td>
                    </tr>`;
                    }

                }



                $('#listar_jornadas_mesa').html(template);
            }

        )
    }

    $('#filtroJornadaMesa').click(function (e) {
        e.preventDefault();
        let filtrosMesa = {
            filtroFechaFin: $('#filtroFechaFin').val(),
            filtroFechaInicio: $('#filtroFechaInicio').val(),
            filtroCarreraId: $('#filtroCarreraId').val(),
            filtroLlamadoId: $('#filtroLlamadoId').val(),
        };
        listar_jornadas_mesa(filtrosMesa);
    })

    $(document).on('click', '.filtro_reset_mesa', function () {
        listar_jornadas_mesa();
    })
})