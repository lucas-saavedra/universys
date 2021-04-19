$(document).ready(function () {

    lunes();

    function lunes() {
        var dia = 1;
        for (dia; dia <= 5; dia++) {
            var hora = 1;
            for (hora; hora <= 6; hora++) {
                
                $.ajax({
                    url: 'tablas.php',
                    type: 'POST',
                    data: { dia, hora },
                    success: function (response) {
                        
                        let tasks = JSON.parse(response);
                        let template = '';
                        tasks.forEach(task => {
                            template += `
                        ${task.catedra}<br>
                        ${task.docente}<br>
                       
                        </tr>`

                        if (task.dia == 1){
                            if (task.hora == 1) {
                                $('#lunesA').html(template);
                            } else if (task.hora == 2) {
                                $('#lunesB').html(template);
                            } else if (task.hora == 3) {
                                $('#lunesC').html(template);
                            } else if (task.hora == 4) {
                                $('#lunesD').html(template);
                            } else if (task.hora == 5) {
                                $('#lunesE').html(template);
                            } else if (task.hora == 6) {
                                $('#lunesF').html(template);
                            }
                        }else if(task.dia == 2){
                            if (task.hora == 1) {
                                $('#martesA').html(template);
                            } else if (task.hora == 2) {
                                $('#martesB').html(template);
                            } else if (task.hora == 3) {
                                $('#martesC').html(template);
                            } else if (task.hora == 4) {
                                $('#martesD').html(template);
                            } else if (task.hora == 5) {
                                $('#martesE').html(template);
                            } else if (task.hora == 6) {
                                $('#martesF').html(template);
                            }
                        }else if(task.dia == 3){
                            if (task.hora == 1) {
                                $('#miercolesA').html(template);
                            } else if (task.hora == 2) {
                                $('#miercolesB').html(template);
                            } else if (task.hora == 3) {
                                $('#miercolesC').html(template);
                            } else if (task.hora == 4) {
                                $('#miercolesD').html(template);
                            } else if (task.hora == 5) {
                                $('#miercolesE').html(template);
                            } else if (task.hora == 6) {
                                $('#miercolesF').html(template);
                            }
                        }else if(task.dia == 4){
                            if (task.hora == 1) {
                                $('#juevesA').html(template);
                            } else if (task.hora == 2) {
                                $('#juevesB').html(template);
                            } else if (task.hora == 3) {
                                $('#juevesC').html(template);
                            } else if (task.hora == 4) {
                                $('#juevesD').html(template);
                            } else if (task.hora == 5) {
                                $('#juevesE').html(template);
                            } else if (task.hora == 6) {
                                $('#juevesF').html(template);
                            }
                        }else if(task.dia == 5){
                            if (task.hora == 1) {
                                $('#viernesA').html(template);
                            } else if (task.hora == 2) {
                                $('#viernesB').html(template);
                            } else if (task.hora == 3) {
                                $('#viernesC').html(template);
                            } else if (task.hora == 4) {
                                $('#viernesD').html(template);
                            } else if (task.hora == 5) {
                                $('#viernesE').html(template);
                            } else if (task.hora == 6) {
                                $('#viernesF').html(template);
                            }
                        }
                        });
                    }
                })
            }
        }
    }

    function modificar(){ 
        var dia = 1;
        for (dia; dia <= 5; dia++) {
            var hora = 1;
            for (hora; hora <= 6; hora++) {
                $.ajax({
                    url: 'modif.php',
                    type: 'POST',
                    data: { dia, hora },
                    success: function (response) {
                        console.log(response);
                        let tasks = JSON.parse(response);
                        let template = '';
                        tasks.forEach(task => {
                            template += `
                            <select  hora='${task.hora}' dia='${task.dia}' class='lista-catedras' > 
                                <option >${task.catedra}</option>
                            </select>
                            <select  hora='${task.hora}' dia='${task.dia}' class='lista-docente'> 
                                <option>${task.docente}</option> 
                            </select>
                            `
                            
                        if (task.dia == 1){
                            if (task.hora == 1) {
                                $('#lunesA').html(template);
                            } else if (task.hora == 2) {
                                $('#lunesB').html(template);
                            } else if (task.hora == 3) {
                                $('#lunesC').html(template);
                            } else if (task.hora == 4) {
                                $('#lunesD').html(template);
                            } else if (task.hora == 5) {
                                $('#lunesE').html(template);
                            } else if (task.hora == 6) {
                                $('#lunesF').html(template);
                            }
                        }else if(task.dia == 2){
                            if (task.hora == 1) {
                                $('#martesA').html(template);
                            } else if (task.hora == 2) {
                                $('#martesB').html(template);
                            } else if (task.hora == 3) {
                                $('#martesC').html(template);
                            } else if (task.hora == 4) {
                                $('#martesD').html(template);
                            } else if (task.hora == 5) {
                                $('#martesE').html(template);
                            } else if (task.hora == 6) {
                                $('#martesF').html(template);
                            }
                        }else if(task.dia == 3){
                            if (task.hora == 1) {
                                $('#miercolesA').html(template);
                            } else if (task.hora == 2) {
                                $('#miercolesB').html(template);
                            } else if (task.hora == 3) {
                                $('#miercolesC').html(template);
                            } else if (task.hora == 4) {
                                $('#miercolesD').html(template);
                            } else if (task.hora == 5) {
                                $('#miercolesE').html(template);
                            } else if (task.hora == 6) {
                                $('#miercolesF').html(template);
                            }
                        }else if(task.dia == 4){
                            if (task.hora == 1) {
                                $('#juevesA').html(template);
                            } else if (task.hora == 2) {
                                $('#juevesB').html(template);
                            } else if (task.hora == 3) {
                                $('#juevesC').html(template);
                            } else if (task.hora == 4) {
                                $('#juevesD').html(template);
                            } else if (task.hora == 5) {
                                $('#juevesE').html(template);
                            } else if (task.hora == 6) {
                                $('#juevesF').html(template);
                            }
                        }else if(task.dia == 5){
                            if (task.hora == 1) {
                                $('#viernesA').html(template);
                            } else if (task.hora == 2) {
                                $('#viernesB').html(template);
                            } else if (task.hora == 3) {
                                $('#viernesC').html(template);
                            } else if (task.hora == 4) {
                                $('#viernesD').html(template);
                            } else if (task.hora == 5) {
                                $('#viernesE').html(template);
                            } else if (task.hora == 6) {
                                $('#viernesF').html(template);
                            }
                        }
                        });
                    }
                })
            }
        }
       
       }

    $(document).on('click', '#modificar', function () {
      modificar();
    })

    $(document).on('click', '.lista-catedras', function () {
        modificar();

        let elemento = $(this)[0];
        let id_dia = $(elemento).attr('dia');
        let id_hora = $(elemento).attr('hora');
        
         $.get('buscar-catedra.php' ,function (response) {
                const tasks = JSON.parse(response);
                let template = '';
                tasks.forEach(task => {
                    template += `
                    <select class='opcion-catedra' dia='${id_dia}' hora='${id_hora}' id-catedra='${task.id}'> 
                        <option >${task.nombre}</option>
                    </select>
                    `
            });
            if (id_dia == 1){
                if (id_hora == 1) {
                    $('#lunesA').html(template);
                } else if (id_hora == 2) {
                    $('#lunesB').html(template);
                } else if (id_hora == 3) {
                    $('#lunesC').html(template);
                } else if (id_hora == 4) {
                    $('#lunesD').html(template);
                } else if (id_hora == 5) {
                    $('#lunesE').html(template);
                } else if (id_hora == 6) {
                    $('#lunesF').html(template);
                }
            }else if(id_dia == 2){
                if (id_hora == 1) {
                    $('#martesA').html(template);
                } else if (id_hora == 2) {
                    $('#martesB').html(template);
                } else if (id_hora == 3) {
                    $('#martesC').html(template);
                } else if (id_hora == 4) {
                    $('#martesD').html(template);
                } else if (id_hora == 5) {
                    $('#martesE').html(template);
                } else if (id_hora == 6) {
                    $('#martesF').html(template);
                }
            }else if(id_dia == 3){
                if (id_hora == 1) {
                    $('#miercolesA').html(template);
                } else if (id_hora == 2) {
                    $('#miercolesB').html(template);
                } else if (id_hora == 3) {
                    $('#miercolesC').html(template);
                } else if (id_hora == 4) {
                    $('#miercolesD').html(template);
                } else if (id_hora == 5) {
                    $('#miercolesE').html(template);
                } else if (id_hora == 6) {
                    $('#miercolesF').html(template);
                }
            }else if(id_dia == 4){
                if (id_hora == 1) {
                    $('#juevesA').html(template);
                } else if (id_hora == 2) {
                    $('#juevesB').html(template);
                } else if (id_hora == 3) {
                    $('#juevesC').html(template);
                } else if (id_hora == 5) {
                    $('#juevesE').html(template);
                } else if (id_hora == 6) {
                    $('#juevesF').html(template);
                }
            }else if(id_dia == 5){
                if (id_hora == 1) {
                    $('#viernesA').html(template);
                } else if (id_hora == 2) {
                    $('#viernesB').html(template);
                } else if (id_hora == 3) {
                    $('#viernesC').html(template);
                } else if (id_hora == 4) {
                    $('#viernesD').html(template);
                } else if (id_hora == 5) {
                    $('#viernesE').html(template);
                } else if (id_hora == 6) {
                    $('#viernesF').html(template);
                }
            }
                
        })

    })
    $(document).on('click', '.opcion-catedra', function () {
        let elemento = $(this)[0];
        let id = $(elemento).attr('id-catedra');
        let id_dia = $(elemento).attr('dia');
        let id_hora = $(elemento).attr('hora');
        
        $.post('cambio-catedra.php', {id,id_dia,id_hora}, function(response){
            console.log(response);
        })
        modificar();
    })


$(document).on('click', '.lista-docente', function () {
    modificar();

    let elemento = $(this)[0];
    let id_dia = $(elemento).attr('dia');
    let id_hora = $(elemento).attr('hora');
    
     $.get('buscar-docente.php' ,function (response) {
            const tasks = JSON.parse(response);
            let template = '';
            tasks.forEach(task => {
                template += `
                <select class='opcion-docente' dia='${id_dia}' hora='${id_hora}' id-docente='${task.id}'> 
                    <option >${task.nombre}</option>
                </select>
                `
        });
        if (id_dia == 1){
            if (id_hora == 1) {
                $('#lunesA').html(template);
            } else if (id_hora == 2) {
                $('#lunesB').html(template);
            } else if (id_hora == 3) {
                $('#lunesC').html(template);
            } else if (id_hora == 4) {
                $('#lunesD').html(template);
            } else if (id_hora == 5) {
                $('#lunesE').html(template);
            } else if (id_hora == 6) {
                $('#lunesF').html(template);
            }
        }else if(id_dia == 2){
            if (id_hora == 1) {
                $('#martesA').html(template);
            } else if (id_hora == 2) {
                $('#martesB').html(template);
            } else if (id_hora == 3) {
                $('#martesC').html(template);
            } else if (id_hora == 4) {
                $('#martesD').html(template);
            } else if (id_hora == 5) {
                $('#martesE').html(template);
            } else if (id_hora == 6) {
                $('#martesF').html(template);
            }
        }else if(id_dia == 3){
            if (id_hora == 1) {
                $('#miercolesA').html(template);
            } else if (id_hora == 2) {
                $('#miercolesB').html(template);
            } else if (id_hora == 3) {
                $('#miercolesC').html(template);
            } else if (id_hora == 4) {
                $('#miercolesD').html(template);
            } else if (id_hora == 5) {
                $('#miercolesE').html(template);
            } else if (id_hora == 6) {
                $('#miercolesF').html(template);
            }
        }else if(id_dia == 4){
            if (id_hora == 1) {
                $('#juevesA').html(template);
            } else if (id_hora == 2) {
                $('#juevesB').html(template);
            } else if (id_hora == 3) {
                $('#juevesC').html(template);
            } else if (id_hora == 5) {
                $('#juevesE').html(template);
            } else if (id_hora == 6) {
                $('#juevesF').html(template);
            }
        }else if(id_dia == 5){
            if (id_hora == 1) {
                $('#viernesA').html(template);
            } else if (id_hora == 2) {
                $('#viernesB').html(template);
            } else if (id_hora == 3) {
                $('#viernesC').html(template);
            } else if (id_hora == 4) {
                $('#viernesD').html(template);
            } else if (id_hora == 5) {
                $('#viernesE').html(template);
            } else if (id_hora == 6) {
                $('#viernesF').html(template);
            }
        }
            
    })
    })
    $(document).on('click', '.opcion-docente', function () {
        let elemento = $(this)[0];
        let id = $(elemento).attr('id-docente');
        let id_dia = $(elemento).attr('dia');
        let id_hora = $(elemento).attr('hora');
        
        $.post('cambio-docente.php', {id,id_dia,id_hora}, function(response){
            console.log(response);
        })
        modificar();
    })
})
