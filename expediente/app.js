$(document).ready(function(){
    console.log('funca');

    $(document).on('click','.task-delete_docente', function(){
        let element = $(this)[0].parentElement.parentElement;
        let id_docente = $(element).attr('inasistencia_id');
        console.log(id_docente);
        $.post('inasistencia_delete.php', {id_docente} , function(response) {
            console.log(response);

        })
    })
    $(document).on('click','.task-delete_no_docente', function(){
        let element = $(this)[0].parentElement.parentElement;
        let id_no_docente = $(element).attr('inasistencia_id');
        console.log(id_no_docente);
        $.post('inasistencia_delete.php', {id_no_docente} , function(response) {
            console.log(response);

        })
    })
})

