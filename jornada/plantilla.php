<!DOCTYPE html>
<html>

<head>
    <title>Ajax PHP MySQL Live Search Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("test.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.agente', function() {
                let element = $(this)[0].parentElement;
                let agente_id = $(element).attr('agente_id');
                $('.valor').val(agente_id);
                $('#live_search').attr('disabled', true);
            })


            $("#live_search").keyup(function() {
                $('#search_result').attr('disabled', false);
                let tipo_agente = 'docente';
                var search_agente = $(this).val();
                if (search_agente != "") {
                    $.ajax({
                        url: '/universys/jornada/backend/select-agente.php',
                        method: 'POST',
                        data: {
                            search_agente,
                            tipo_agente
                        },
                        success: function(data) {
                            $('#search_result').html(data);
                            $('#search_result').css('display', 'block');
                            $("#live_search").focusin(function() {
                                $('#search_result').css('display', 'block');
                            });
                        }
                    });
                } else {
                    $('#search_result').css('display', 'none');
                }
            });
        });
    </script>
</body>

</html>