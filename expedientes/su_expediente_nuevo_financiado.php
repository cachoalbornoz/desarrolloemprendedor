<?php
require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$solicitante= $_GET['solicitante'];
$IdProyecto = $_GET['IdProyecto'];
$IdRubro    = $_GET['IdRubro'];
$rubro      = $_GET['rubro'];
$IdLocalidad= $_GET['IdLocalidad'];
$localidad  = $_GET['localidad'];

$query      = mysqli_query($con, "SELECT id_solicitante FROM rel_proyectos_solicitantes WHERE id_proyecto = $IdProyecto");
$registro   = mysqli_fetch_array($query);

$id_solicitante = $registro['id_solicitante'];


?>

<div class="card">
    <div class="card-header">
        <div class="row mb-2">
            <div class="col-xs-12 col-sm-2 col-lg-2">
                EXPEDIENTE NUEVO -
            </div>
            <div class="col-xs-12 col-sm-10 col-lg-10">
                TITULAR DEL PROYECTO ::  # <?php echo $id_solicitante ?> - <b> <?php echo $solicitante ?></b>
            </div>
        </div>
    </div>
    <div class="card-body">

        <form action ="agregar_expediente_f.php" method="post" name="expedientes" id="expedientes">

         <div class="row mb-5">
            <div class="col-xs-12 col-sm-2 col-lg-3">
                Nro proyecto
                <input type="text" name="nro_proyecto" id="nro_proyecto" value="<?php echo $IdProyecto ?>" class="form-control">
            </div>
            <div class="col-xs-12 col-sm-10 col-lg-6">
                Rubro
                <select name="id_rubro" id="id_rubro" size="1" class="form-control">
                    <option value="<?php echo $IdRubro ?>"><?php echo $rubro ?></option>
                </select>                
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-3">
                <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?php echo $id_solicitante ?>" class="form-control" readonly>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xs-12 col-sm-3 col-lg-3">
                Nro expediente madre
                <input type="number" name="nro_expediente_madre" id="nro_expediente_madre" class="form-control" required autofocus>
            </div>
            <div class="col-xs-12 col-sm-3 col-lg-3 d-none">
                Nro expediente control
                <input type="number" name="nro_expediente_control" id="nro_expediente_control" class="form-control" required>
            </div>
            <div class="col-xs-12 col-sm-3 col-lg-3">
                Monto
                <input type="number" name="monto" id="monto" class="form-control" required>
            </div>
            <div class="col-xs-12 col-sm-3 col-lg-3">
                Fecha otorgamiento
                <input type="date" name="fecha_otorgamiento" id="fecha_otorgamiento" class="form-control" required>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xs-12 col-sm-3 col-lg-6">
                Localidad
                <select name="id_localidad" size="1" id="id_localidad" class="form-control">
                    <option value="<?php echo $IdLocalidad ?>"><?php echo $localidad ?></option>
                </select>        
            </div>
            <div class="col-xs-12 col-sm-3 col-lg-6">
                Observaciones
                <input type="text" name="observaciones" id="observaciones" class="form-control">
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                <button  type="submit" title="Guardar" name="guardar" id="guardar" class="btn btn-info">Guardar</button>
            </div>
        </div>
        </form>
    </div>
</div>

<?php
    require_once('../accesorios/admin-scripts.php');

    require_once('../accesorios/admin-inferior.php'); ?>
