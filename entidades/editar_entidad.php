<?php 

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/conexion.php');

$con=conectar();


$id_entidad = $_GET['id_entidad'];

$consulta   = "SELECT * FROM maestro_entidades WHERE id_entidad = $id_entidad";

if ($resultado  = $con->query($consulta)) {

    $fila       = $resultado->fetch_array();

    $entidad    = $fila['entidad'];
    $url        = $fila['url'];
    $foto       = $fila['foto'];
}
 
?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class=" col-xs-12 col-sm-12 col-lg-12">
                    EDITAR ENTIDAD
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="cursos" method="POST" action="actualizar_entidad.php" enctype="multipart/form-data" >

                <div class="form-group">
                    <div class="col-lg-4">
                        
                        <input id="id_entidad" name="id_entidad" type="hidden"value="<?php echo $id_entidad ?>" />

                        <label for="entidad">Nombre </label>
                        <input id="entidad" name="entidad" type="text" class="form-control mayus" value="<?php echo $entidad ?>" required />

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-4">
                        <label for="url">URL </label>
                        <input id="url" name="url" type="text" class="form-control" value="<?php echo $url ?>"/>  
                    </div>
                </div>

                <div class="form-group">
                    <div class="row m-1">
                        <div class="col-xs-12 col-sm-6 col-lg-6">
                            <label for="foto">Foto </label>
                            <input id="foto" name="foto" type="file" class="form-control-file" />  
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-6 text-center">
                            <img src="/desarrolloemprendedor/entidades/image/<?php echo $foto?>" alt="IMAGEN" class=" img-thumbnail"/>  
                        </div>
                    </div>
                </div>    


                <div class="form-group">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-info" value="Guardar" />
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
