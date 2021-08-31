<?php

require '../accesorios/admin-superior.php';

require_once "../accesorios/accesos_bd.php";

$con = conectar();

$id_solicitante = $_GET['id'];
if(is_null($_GET['categoria'])){
    $categoria = 1;
}else{
    $categoria = $_GET['categoria'];
}

$select         = mysqli_query($con, "SELECT apellido, nombres FROM solicitantes WHERE id_solicitante = $id_solicitante");
$registro       = mysqli_fetch_array($select);
$apellido       = $registro['apellido'];
$nombres        = $registro['nombres'];

$id_seguimiento = null;
$asesor         = null;
$tematica       = null;
$usuario        = null;
$fecha_ini      = null;
$fecha_fin      = null;
$minutos        = null;

$select         = mysqli_query($con, "SELECT * FROM asesorar_seguimiento WHERE id_solicitante = $id_solicitante AND categoria = $categoria");

if (mysqli_num_rows($select) > 0) {
    
    $registro   = mysqli_fetch_array($select);

    $id_seguimiento = $registro['id'];
    $asesor         = $registro['asesor'];
    $tematica       = $registro['tematica'];
    $usuario        = $registro['usuario'];
    $fecha_ini      = $registro['fecha_ini'];
    $fecha_fin      = $registro['fecha_fin'];
    $minutos        = $registro['minutos'];
}



?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                <h5>
                    Seguimiento <strong> <?php echo $apellido . ', ' . $nombres; ?></strong>
                </h5>
            </div>
        </div>
    </div>

    <div class="card-body">

        <form id="seguimiento" autocomplete="false" action='guardarSeguimiento.php' method="post">

            <div class="row mb-2">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?php echo $id_solicitante; ?>">
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 text-right">
                    <a href="padron_autogestionados.php" class="btn btn-secondary <?php echo (is_null($id_seguimiento))?'d-none':null; ?>">Volver</a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <label>Tema asesoramiento registrado</label>
                    <select name="categoria" id="categoria" class="form-control" required>
                        <option value="" disabled selected></option>
                        <?php
                            $asesoramiento = "SELECT id, tipo FROM tipo_asesoramiento ORDER BY tipo";
                            $registro = mysqli_query($con, $asesoramiento);
                            while ($fila = mysqli_fetch_array($registro)) {

                                if ($fila['id'] == $categoria) {
                                    echo "<option value=" . $fila['id'] . " selected>" . $fila['tipo'] . "</option>";
                                } else {
                                    echo "<option value=" . $fila['id'] . ">" . $fila['tipo'] . "</option>";
                                }                                
                            }
                        ?>
                    </select>
                </div>                
            </div>

            
            <div class="row mb-4">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <label>Descripción del asesoramiento</label>
                    <input type="text" name="tematica" id="tematica" autofocus class="form-control" maxlength="250" value="<?php echo $tematica; ?>" required>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <label>Persona que realizará el asesoramiento</label>
                    <input type="text" name="asesor" id="asesor" class="form-control" maxlength="150" value="<?php echo $asesor; ?>" required>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <label>Usuario que registra</label>
                    <select name="usuario" id="usuario" class="form-control" required>
                        <option value="" disabled selected></option>
                        <?php
                            $asesoramiento = "SELECT id_usuario, apellido, nombres
                                FROM usuarios
                                WHERE estado = 'a'
                                ORDER BY apellido";
                            $registro = mysqli_query($con, $asesoramiento);
                            while ($fila = mysqli_fetch_array($registro)) {

                                if ($fila['id_usuario'] == $usuario) {

                                    echo "<option value=" . $fila['id_usuario'] . " selected>" . $fila['apellido'] . ', ' . $fila['nombres'] . "</option>";

                                } else {
                                    
                                    echo "<option value=" . $fila['id_usuario'] . ">" . $fila['apellido'] . ', ' . $fila['nombres'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-2">

                <div class="col-xs-12 col-md-4 col-lg-4 p-3">
                    <label>Fecha Inicio</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="date" id="fecha_ini" name="fecha_ini" class="form-control text-center" required
                            value="<?php echo (!is_null($fecha_ini))?$fecha_ini:date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4 p-3">
                    <label>Fecha Fin</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control text-center" required
                            value="<?php echo (!is_null($fecha_fin))?$fecha_fin:date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="col-xs-12 col-md-4 col-lg-4 p-3">
                    <label>Minutos asignados</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-clock"></i>
                            </span>
                        </div>
                        <input type="number" id="minutos" name="minutos" class="form-control text-center" required
                            value="<?php echo (!is_null($minutos))?$minutos:120; ?>">
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    &nbsp;
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 text-right">
                    <input type="submit" class="btn btn-primary" value="Guardar ">
                </div>
            </div>


        </form>

    </div>

    <div class="card-footer border border-primary <?php echo (is_null($id_seguimiento))?'d-none':null; ?>" >

        <div class="row mb-2">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <p>Detalle de novedades (Cod #<?php echo (!is_null($id_seguimiento))?$id_seguimiento:null; ?>) </p>
                <input type="hidden" name="id_seguimiento" id="id_seguimiento"
                    value="<?php echo (!is_null($id_seguimiento))?$id_seguimiento:null; ?>">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="w-50">
                            <input type="text" name="observacion" id="observacion" class=" form-control" required placeholder="Describa la novedad ">
                        </td>
                        <td>
                            <select name="tipo_estado" id="tipo_estado" class="form-control" required>
                                <option value="" disabled selected>Seleccione un color de estado </option>
                                <?php
                                    $tipo_estado= "SELECT id, estado FROM tipo_estado_seguimiento ORDER BY id DESC";
                                    $registro   = mysqli_query($con, $tipo_estado);
                                    while ($fila = mysqli_fetch_array($registro)) {

                                        echo "<option value=" . $fila['id'] . ">" . $fila['estado'] . "</option>";
                                        
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-secondary" id="cargar" title="Carga novedad">
                                <i class=" fa fa-save"></i>                                        
                            </button>
                        </div>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-12 col-sm-12 col-lg-12">
            </div>
        </div>

        <div id="formdetalle">
            
        </div>

    </div>

</div>


<?php require_once '../accesorios/admin-scripts.php';?>

<script type="text/javascript">

    $("#formdetalle").load('guardarDetalle.php', {
        id_seguimiento: $("#id_seguimiento").val(),
        movimiento: 3,
    });


    function borrar(id) {

        $("#formdetalle").load('guardarDetalle.php', {
            movimiento: 2,
            id_seguimiento: $("#id_seguimiento").val(),
            id: id,
        });
    };


    $("#cargar").on('click', function () {

        $("#formdetalle").load('guardarDetalle.php', {
            movimiento: 1,
            id_seguimiento: $("#id_seguimiento").val(),
            observacion: $("#observacion").val(),
            tipo_estado: $("#tipo_estado").val(),
        });

    });

    $("#seguimiento").validate({

        submitHandler: function (form) {

            var form = $('#seguimiento');
            var url = 'guardarSeguimiento.php';
            var d = new Date();
            var n = d.getTime();

            $.ajax({
                type: 'post',
                url: url,
                data: form.serialize(),
                success: function (response) {
                    location.reload();
                }
            })
        }
    });
</script>

<?php

mysqli_close($con);

require_once '../accesorios/admin-inferior.php';

?>