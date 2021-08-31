<?php require('../accesorios/admin-superior.php');

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id = $_GET['id'];

$query      = mysqli_query($con, "SELECT * FROM formacion_cursos WHERE id = $id");

$registro   = mysqli_fetch_array($query);

?>

    <div class="card">

        <div class="card-header">
            <div class="row mb-3">
                <div class="col-xs-12">
                    EDITAR REGISTRO
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="registro" method="POST" action="actualiza_registro.php" class="form-horizontal">

                <input id="id" name="id" type="hidden" value="<?php echo $registro['id'] ?>" />

                <div class="row mb-3">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="nombre">Nombre </label>
                        <input id="nombre" name="nombre" type="text" class="form-control bg-white" required value="<?php echo $registro['nombre'] ?>" disabled/>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Lugar</label>
                        <input id="lugar" name="lugar" type="text" class="form-control" required value="<?php echo $registro['lugar'] ?>" autofocus/>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Referente</label>
                        <input id="referente" name="referente" type="text" class="form-control" required value="<?php echo $registro['referente'] ?>" />
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Capacitador</label>
                        <input id="capacitador" name="capacitador" type="text" class="form-control" required value="<?php echo $registro['capacitador'] ?>" />
                    </div>

                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <label>Asistentes</label>
                        <input id="asistentes" name="asistentes" type="text" class="form-control" required value="<?php echo $registro['asistentes'] ?>" />
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-lg-12">
                        
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-lg-12">
                        
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-info" value="Actualizar" />
                    </div>
                </div>

            </form>
        </div>

    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


   

    <?php require_once('../accesorios/admin-inferior.php'); ?>
