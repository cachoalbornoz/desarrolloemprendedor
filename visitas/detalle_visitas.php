<?php 
session_start();

$id_expediente	= $_SESSION['id_expediente'] ;

require('../accesorios/accesos_bd.php');
$con=conectar();

if(isset($_POST['operacion'])){

    $operacion = $_POST['operacion'];

    if($operacion == 1){
        $fecha   	    = $_POST['fecha'];
        $motivo 	    = $_POST['motivo'];
        $responsable	= $_POST['responsable'];
        $resultado      = $_POST['resultado'];

        mysqli_query($con,"INSERT into expedientes_visitas (id_expediente, fecha, motivo,responsable,resultado)
            VALUES ($id_expediente,'$fecha','$motivo','$responsable','$resultado')");  
    }else{

        if($operacion == 2){

            $id_visita = $_POST['id'];	
            mysqli_query($con,"DELETE FROM expedientes_visitas WHERE id_visita = $id_visita");				
        }
    }
}
?>

<table class="table table-hover">
<?php
// MOSTRAR LAS VISITAS REALIZADAS A ESE EXPEDIENTE
$tabla_visitas   = mysqli_query($con,"SELECT * FROM expedientes_visitas WHERE id_expediente = $id_expediente");

while($registro_visitas= mysqli_fetch_array($tabla_visitas)){
?>
<tr>       
    <td class="col-md-2">
        <a href="javascript:void(0)"  onclick="borrar_visita(<?php echo $registro_visitas['id_visita']?>)"> 
            <i class="fas fa-trash"></i>
        </a>
        <?php echo date('d-m-Y', strtotime($registro_visitas['fecha'])) ; ?>
    </td>
    <td class="col-md-3"><?php echo $registro_visitas['motivo'];?></td>
    <td class="col-md-3"><?php echo $registro_visitas['responsable'];?></td>
    <td class="col-md-4"><?php echo $registro_visitas['resultado'];?></td>
</tr>
<?php
}
mysqli_close($con); 
?>
</table>
    

