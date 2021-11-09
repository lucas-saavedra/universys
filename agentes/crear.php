<title>Crear agente</title>
<?php
include("../jornada/navbar.php");
include("./includes/consultas.php");
?>

<?php

function crear_agente($data, $bd)
{

    mysqli_query($bd, 'START TRANSACTION');

    try {

        $sql = "SELECT * FROM persona WHERE cuil = '{$data['cuil']}'";
        if (mysqli_num_rows(mysqli_query($bd, $sql)) != 0) {
            throw new Exception('Ese CUIL ya está registrado');
        }

        $insert_persona = "INSERT INTO persona (nombre, email, contrasenia, cuil, sexo, direccion, telefono) 
                VALUES ('{$data['nombre']}', '{$data['email']}', '{$data['pass']}', '{$data['cuil']}', '{$data['sexo']}', '{$data['direccion']}', '{$data['tel']}')";

        if (!$result = mysqli_query($bd, $insert_persona)) {
            throw new Exception(mysqli_error($bd));
        }

        $id_persona = mysqli_insert_id($bd);

        if ($is_docente = isset($data['docente'])) {
            $insert_docente = "INSERT INTO docente (persona_id, total_horas) 
                    VALUES ({$id_persona}, {$data['hs_docente']})";

            if (!$result = mysqli_query($bd, $insert_docente)) {
                throw new Exception(mysqli_error($bd));
            }
        }

        if ($is_no_docente = isset($data['no-docente'])) {
            $insert_docente = "INSERT INTO no_docente (persona_id, total_horas) 
                    VALUES ({$id_persona}, {$data['hs_no_docente']})";

            if (!$result = mysqli_query($bd, $insert_docente)) {
                throw new Exception(mysqli_error($bd));
            }
        }

        if (!$is_docente && !$is_no_docente) {
            throw new Exception('Debe seleccionar al menos un tipo de agente (Docente o No Docente)');
        }

        if (isset($data['roles'])) {
            crear_roles($bd, $id_persona, $data['roles']);
        }
        mysqli_commit($bd);
    } catch (Exception $e) {
        mysqli_rollback($bd);
        $pattern = "/duplicate/i";
        if (preg_match($pattern, $e) == 1) {
            $msg = 'El email ya está registrado';
        } else {
            $msg = $e->getMessage();
        }
        return [
            'content' => $msg,
            'type' => 'danger'
        ];
    }

    return [
        'content' => 'Agente creado!',
        'type' => 'success',
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = crear_agente($_POST, $conexion);
}
?>


<div class="container">

    <div class="row mt-4">
        <div class="col">
            <h2 class="border-bottom border-black pb-3">Crear Agente</h2>
        </div>
    </div>
    <?php include "../expediente/includes/msg-box.php" ?>
    <div class="row mt-4">
        <div class="col">
            <form action="" method="POST">
                <div class="form-group row">
                    <label for="inputNombre" class="col-sm-2 col-form-label">Nombre y apellido</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombre" class="form-control" id="inputNombre" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPass" class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" name="pass" class="form-control" id="inputPass" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputCuil" class="col-sm-2 col-form-label">CUIL</label>
                    <div class="col-sm-10">
                        <input type="text" pattern="^(20|2[3-7]|30|3[3-4])(\d{8})(\d)$" name="cuil" class="form-control" id="inputCuil" maxlength="11" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputSexo" class="col-sm-2 col-form-label">Sexo</label>
                    <div class="col-sm-10">
                        <select type="text" name="sexo" class="form-control" id="inputSexo" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDir" class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" name="direccion" class="form-control" id="inputDir">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputTel" class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" name="tel" class="form-control" id="inputTel">
                    </div>
                </div>

                <div class="form-group row mt-4">
                    <div class="col-12">
                        <h4 class="border-bottom border-black pb-2 text-secondary">Tipo de agente</h4>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <table class="table table-agente m-0 table-bordered">
                            <thead>
                                <tr class="bg-light">
                                    <th>Tipo</th>
                                    <th>Total Hs Mensuales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input name="docente" class="form-check-input" type="checkbox" value="1" id="checkDoc">
                                            <label class="form-check-label" for="checkDoc">
                                                Docente
                                            </label>
                                        </div>
                                    </th>
                                    <td>
                                        <input class="form-control" name="hs_docente" type="number" placeholder="Hs" disabled>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input name="no-docente" class="form-check-input" type="checkbox" value="1" id="checkNoDoc">
                                            <label class="form-check-label" for="checkNoDoc">
                                                No Docente
                                            </label>
                                        </div>
                                    </th>
                                    <td>
                                        <input class="form-control" name="hs_no_docente" type="number" placeholder="Hs" disabled>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php include "./includes/roles-seccion.php"; ?>

                <div class="row my-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-lg btn-primary">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./js/tipos_agente.js"></script>
<?php include("../includes/footer.php"); ?>