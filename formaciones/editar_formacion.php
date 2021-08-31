<?php require('../accesorios/admin-superior.php');

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id = $_GET['id'];

$query      = mysqli_query($con, "SELECT * FROM tipo_formacion WHERE id = $id");

$registro   = mysqli_fetch_array($query);

?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    EDITAR FORMACION
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="formaciones" method="POST" action="actualiza_formacion.php" class="form-horizontal">

                <input id="id" name="id" type="hidden" value="<?php echo $registro['id'] ?>" />

                <div class="form-group">
                    <div class="col-lg-6">
                        <label for="nombre">Nombre </label>
                        <input id="nombre" name="nombre" type="text" class="form-control mayus" required value="<?php echo $registro['formacion'] ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        <input id="activo" name="activo" type="checkbox" <?php if($registro['activo'] == 1){ echo 'checked';} ?> />
                        Activo 
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-info" value="Actualizar" />
                    </div>
                </div>

            </form>
        </div>

    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){

    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
