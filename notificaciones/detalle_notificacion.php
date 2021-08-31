<?php 
session_start();

include("../accesorios/accesos_bd.php");

$con=conectar();

$id_expediente = $_SESSION['id_expediente'];

if(isset($_POST['operacion'])){
    $operacion = $_POST['operacion'] ;	
    if($operacion == 1){
        $fecha 			= $_POST['fecha'];
        $apellido 		= $_POST['apellido'];
        $dni 			= $_POST['dni'];
        $id_emprendedor = $_POST['id_emprendedor'];
        $id_parentesco 	= $_POST['id_parentesco'];
        $id_tipo_postal = $_POST['id_tipo_postal'];
        $id_notificacion= $_POST['id_notificacion'];
        $monto 			= $_POST['monto'];

        mysqli_query($con, "INSERT INTO expedientes_notificaciones (fecha, id_expediente, id_emprendedor, apellido, dni, id_parentesco, id_tipo_postal, id_tipo_notificacion, monto) 
        values ('$fecha', $id_expediente, $id_emprendedor, '$apellido', '$dni', $id_parentesco, $id_tipo_postal, $id_notificacion, $monto)") or die("Revisar inserc. notificaciones");			

    }else{
        if($operacion == 2){
            $id_notificacion = $_POST['id'];
            mysqli_query($con, "DELETE FROM expedientes_notificaciones WHERE id_notificacion = $id_notificacion");						
        }
    }
}
?>

<div class="row m-3">
    <div class="col-xs-12 col-sm-12 col-lg-2">
        &nbsp;
    </div>
</div>

<div class="table-responsive m-3">  

    <table class="table table-hover">
        <?php 
        $tabla_notificaciones = mysqli_query($con, 
        "SELECT notif.id_notificacion, notif.fecha, emp.apellido, notif.apellido, notif.dni, pare.tipo_parentesco,tp.postal, tn.notificacion, notif.monto, emp.nombres 
        FROM expedientes_notificaciones as notif, emprendedores as emp, tipo_parentesco as pare, tipo_notificacion as tn, tipo_postal as tp 
        WHERE notif.id_emprendedor = emp.id_emprendedor 
        AND notif.id_parentesco = pare.id_parentesco AND notif.id_tipo_notificacion = tn.id_notificacion AND notif.id_tipo_postal = tp.id_tipo_postal AND notif.id_expediente = $id_expediente 
        ORDER BY notif.fecha desc");
        
        while($fila = mysqli_fetch_array($tabla_notificaciones)){ 
        ?>
        <tr>
            <td><?php echo date('d-m-Y', strtotime($fila[1])) ?></td>
            <td><?php echo $fila[2].', '.$fila[9] ?></td>
            <td><?php echo $fila[3] ?></td>
            <td><?php echo $fila[5] ?></td>
            <td><?php echo $fila[4] ?></td>
            <td><?php echo $fila[7] ?></td>
            <td><?php echo substr($fila[6],0,13) ?></td>
            <td><?php echo number_format($fila[8],2,',','.') ?></td>
            <td>        
                <a href='javascript: void(0)' title='Elimina notificación actual' onclick="eliminar_notificacion('<?php echo $fila[0] ?>')">
                    <i class="fas fa-trash text-danger"></i>
                </a>        
            </td>
        </tr>        
        <?php	 
        }
        ?>
    </table>
</div>
 <?php mysqli_close($con); ?>