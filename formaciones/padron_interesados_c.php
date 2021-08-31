<?php 

require('../accesorios/admin-superior.php');

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id_curso   = $_GET['id_curso'];

$tabla      = mysqli_query($con, "SELECT nombre FROM formacion_cursos WHERE id = $id_curso");
$registro   = mysqli_fetch_array($tabla);
$curso      = $registro['nombre'];

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
            <div id="detalle_interesados_c">
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
        $("#detalle_interesados_c").load('detalle_interesados_c.php', {id_curso: <?php echo $id_curso?> });
    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
