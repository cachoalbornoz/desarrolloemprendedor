<?php 

require('../accesorios/admin-superior.php');

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id_formacion = $_GET['id_formacion'];

$tabla      = mysqli_query($con, "SELECT formacion FROM tipo_formacion WHERE id = $id_formacion");
$registro   = mysqli_fetch_array($tabla);
$curso      = $registro['formacion'];

?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    Lista de personas interados en <span class="text-info font-weight-bold"><?php echo $curso ?> </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="detalle_interesados">
                <div id="estado" style="display:none">
                    Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){
        $("#estado").show();
        $("#detalle_interesados").load('detalle_interesados.php', {id_formacion: <?php echo $id_formacion?> });
    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
