<?php 
session_start();

include("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_SESSION['id_expediente'];

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'] ;
    	
	if($operacion == 1){

            $fecha = $_POST['fecha'];
            $id_tipo_ubicacion = $_POST['id_tipo_ubicacion'];
            $motivo = $_POST['motivo'];

            $insercion = "INSERT INTO expedientes_ubicaciones (fecha, id_tipo_ubicacion, motivo) VALUES ('$fecha', $id_tipo_ubicacion, '$motivo')";
            mysqli_query($con, $insercion) or die ("Error en la insercion Ubicacion");

            $id_ubicacion = mysqli_insert_id($con);

            $tabla_insercion = "INSERT INTO rel_expedientes_ubicacion (id_expediente, id_ubicacion) VALUES ('$id_expediente', '$id_ubicacion')";
            $resultado = mysqli_query($con, $tabla_insercion) or die ("Error en la insercion relacion expedientes - ubicaciones");		
		
	}else{
            if($operacion == 2){

                $id = $_POST['id'];

                $elimina = "DELETE FROM expedientes_ubicaciones WHERE id_ubicacion = $id";
                mysqli_query($con, $elimina) or die ("Error en la eliminacion de ubicaciones");
            }
	}
}
?>
 
 
    <div class="row m-3">
        <div class="col-xs-12 col-sm-12 col-lg-12">
        </div>
    </div>
    <?php 
          
    $tabla_ubicaciones = mysqli_query($con, "SELECT ubi.id_ubicacion, ubi.fecha, tu.ubicacion, ubi.motivo 
    FROM rel_expedientes_ubicacion as reu, expedientes_ubicaciones as ubi, tipo_ubicaciones as tu
    WHERE reu.id_ubicacion = ubi.id_ubicacion AND tu.id_ubicacion = ubi.id_tipo_ubicacion AND reu.id_expediente = $id_expediente 
    ORDER BY ubi.fecha desc");
      
      while($fila = mysqli_fetch_array($tabla_ubicaciones)){ 
      ?>
        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <?php echo date('d-m-Y', strtotime($fila[1])) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <?php echo $fila[2] ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <?php echo $fila[3] ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                <a href='javascript: void(0)' title='Elimina el registro actual' onclick="eliminar_movimiento('<?php echo $fila[0] ?>')">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </div>
        </div>
      <?php
      }
    mysqli_close($con);
    ?>

