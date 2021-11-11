<title>Modificar agente</title>
<?php
include("../jornada/navbar.php");
include("./includes/consultas.php");

function modificar_agente($bd, $agente, $data)
{

    mysqli_query($bd, 'START TRANSACTION');

    try {
        if (isset($data['del-doc'])) {
            if (!$result = mysqli_query($bd, "DELETE FROM docente WHERE persona_id={$agente['id']}")) {
                throw new Exception(mysqli_error($bd));
            }
        } else if (isset($data['del-no-doc'])) {
            if (!$result = mysqli_query($bd, "DELETE FROM no_docente WHERE persona_id={$agente['id']}")) {
                throw new Exception(mysqli_error($bd));
            }
        } else {
            $sql_upd = "UPDATE persona 
                SET nombre='{$data['nombre']}', email='{$data['email']}',sexo='{$data['sexo']}', 
                    direccion='{$data['direccion']}', telefono='{$data['tel']}'
                WHERE id={$agente['id']}";

            if (!$result = mysqli_query($bd, $sql_upd)) {

                throw new Exception(mysqli_error($bd));
            }

            if (isset($agente['id_docente'])) {
                mysqli_query($bd, "UPDATE docente SET total_horas={$data['hs_docente']} WHERE persona_id={$agente['id']}");
            }

            if (isset($agente['id_no_docente'])) {
                mysqli_query($bd, "UPDATE no_docente SET total_horas={$data['hs_no_docente']} WHERE persona_id={$agente['id']}");
            }

            if (isset($data['docente'])) {
                mysqli_query($bd, "INSERT INTO docente (persona_id, total_horas) 
                    VALUES ({$agente['id']}, {$data['hs_docente']})");
            }

            if (isset($data['no-docente'])) {
                mysqli_query($bd, "INSERT INTO no_docente (persona_id, total_horas) 
                    VALUES ({$agente['id']}, {$data['hs_no_docente']})");
            }

            mysqli_query($bd, "DELETE FROM persona_rol WHERE persona_id={$agente['id']}");

            if (isset($data['roles'])) {
                crear_roles($bd, $agente['id'], $data['roles']);
            }
        }
        mysqli_commit($bd);
    } catch (Exception $e) {
        mysqli_rollback($bd);

        $pattern_d = "/duplicate/i";
        $pattern_f = "/Cannot delete or update a parent row/i";

        if (preg_match($pattern_d, $e) == 1) {
            $msg = 'El email ya está registrado.';
        } else if (preg_match($pattern_f, $e) == 1) {
            $msg = 'El agente tiene jornadas asociadas, no puede eliminar este tipo de agente.';
        } else {
            $msg = $e->getMessage();
        }
        return [
            'content' => $msg,
            'type' => 'danger'
        ];
    }

    return [
        'content' => 'Agente modificado!',
        'type' => 'success',
    ];
}

function _get_agente_roles($bd, $id)
{
    $sql = "SELECT rol_id FROM persona_rol WHERE persona_id=$id";
    $result = mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    return array_map(function ($n) {
        return $n['rol_id'];
    }, $result);
}


if (isset($_GET['id']) && $id = intval($_GET['id'])) {
    $agente = _get_agente($conexion, $id);
}

if (!isset($agente)) return;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = modificar_agente($conexion, $agente, $_POST);
    $agente = _get_agente($conexion, $agente['id']);
}

$agente_roles = _get_agente_roles($conexion, $agente['id']);

?>

<div class="container">

    <div class="row mt-4">
        <div class="col">
            <h2 class="border-bottom border-black pb-3">Modificar Agente</h2>
        </div>
    </div>
    <?php include "../expediente/includes/msg-box.php" ?>

    <div class="jumbotron p-4 d-flex justify-content-between mb-3">
        <h4 class="m-0">
            Agente: <?= $agente['nombre'] ?>
        </h4>
    </div>
    <div class="row mt-4">
        <div class="col">
            <form action="" method="POST">
                <div class="form-group row">
                    <label for="inputNombre" class="col-sm-2 col-form-label">Nombre y apellido</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombre" class="form-control" id="inputNombre" 
                            value="<?=$agente['nombre']?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="email" class="form-control" id="inputEmail" value="<?= $agente['email'] ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputSexo" class="col-sm-2 col-form-label">Sexo</label>
                    <div class="col-sm-10">
                        <select type="text" name="sexo" class="form-control" id="inputSexo" required>
                            <option value></option>
                            <?php foreach (["Masculino", "Femenino", "Otro"] as $s) : ?>
                                <option value="<?= $s ?>" <?= $s == $agente['sexo'] ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputDir" class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" name="direccion" class="form-control" id="inputDir" value="<?= $agente['direccion'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputTel" class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" name="tel" class="form-control" id="inputTel" value="<?= $agente['telefono'] ?>">
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
                                    <th class="text-center" style="width:30px">-</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($agente['id_docente'])) : ?>
                                    <tr>
                                        <th>Docente</th>
                                        <td>
                                            <input class="form-control" name="hs_docente" type="number" placeholder="Hs" required value=<?= $agente['hs_docente'] ?>>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" type="submit" name="del-doc" value="1" onclick="return confirm('¿Eliminar tipo docente?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php else : ?>
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
                                <?php endif; ?>

                                <?php if (isset($agente['id_no_docente'])) : ?>
                                    <tr>
                                        <th>No Docente</th>
                                        <td>
                                            <input class="form-control" name="hs_no_docente" type="number" placeholder="Hs" required value=<?= $agente['hs_no_docente'] ?>>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" type="submit" name="del-no-doc" value="1" onclick="return confirm('¿Eliminar tipo no docente?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php else : ?>
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
                                <?php endif; ?>


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