<?php 
session_start();

include("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_SESSION['id_expediente'];

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'] ;	

    if($operacion == 1){
        $seleccion          = mysqli_query($con,"SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc limit 1" );
        $fila_estado        = mysqli_fetch_array($seleccion);
        $id_tipo_estado_ant = $fila_estado[0];

        $fecha              = $_POST['fecha'];
        $id_tipo_estado     = $_POST['id_tipo_estado'];
        $insercion          = "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, $id_tipo_estado, $id_tipo_estado_ant)";
        mysqli_query($con, $insercion);	

        $edicion = mysqli_query($con, "UPDATE expedientes SET estado = $id_tipo_estado WHERE id_expediente = $id_expediente");	

    }else{

        if($operacion == 2){

            $seleccion          = mysqli_query($con,"SELECT id_tipo_estado_ant FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc limit 1" );
            $fila_estado        = mysqli_fetch_array($seleccion);
            $id_tipo_estado_ant = $fila_estado[0];
            $id = $_POST['id'];
            $elimina = "DELETE FROM expedientes_estados WHERE id_estado = $id";
            mysqli_query($con, $elimina) ;

            $edicion = mysqli_query($con, "UPDATE expedientes SET estado = $id_tipo_estado_ant WHERE id_expediente = $id_expediente");			
        }
    }
}
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        &nbsp;
    </div> 
</div>

<?php 
      
    $tabla_estados = mysqli_query($con, "SELECT est.id_estado, est.fecha, te.estado 
    FROM expedientes_estados as est, tipo_estado as te, expedientes as exp 
    WHERE exp.id_expediente = est.id_expediente AND est.id_tipo_estado = te.id_estado AND est.id_expediente = $id_expediente 
    ORDER BY est.id_estado desc");
  
    $filas_estados = mysqli_num_rows($tabla_estados);
  

    while($fila = mysqli_fetch_array($tabla_estados)){ ?>
        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <?php echo date('d-m-Y',strtotime($fila[1])); ?>
            </div>   
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <?php echo $fila[2] ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                <a href='javascript: void(0)' title='Elimina el estado actual' onclick="eliminar_estado('<?php echo $fila[0] ?>')">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </div>    
        </div>
     
    <?php  
    }
   
   ?>
   

<?php mysqli_close($con); ?>
