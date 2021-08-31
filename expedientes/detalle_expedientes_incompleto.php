<?php 
session_start();

include("../accesorios/accesos_bd.php");
$con=conectar();


if(isset($_POST['id'])){
  $id_expediente=$_POST['id'];

  $tabla_elimina = "DELETE FROM expedientes WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
  ///////////////////////////////////////////
  $tabla_elimina = "DELETE FROM expedientes_detalle_cuotas WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
  /////// Elimina las Observaciones /////////
  $tabla_elimina = "DELETE FROM observaciones_expedientes WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);	
  ////////////////////////////////////////////////////
  
  $registro = mysqli_query($con, "SELECT id_emprendedor from rel_expedientes_emprendedores WHERE id_expediente = '$id_expediente'");
  
  while($fila_rel_emp = mysqli_fetch_array($registro)){
      $id_emprendedor = $fila_rel_emp[0];
      
      $registro_emp_exp = mysqli_query($con,"SELECT id_emprendedor from rel_expedientes_emprendedores WHERE id_emprendedor = '$id_emprendedor'");
      
      if(mysqli_num_rows($registro_emp_exp) == 1){
        //// ELIMINA DE TABLA EMPRENDEDORES 
        $tabla_elimina = "DELETE FROM emprendedores WHERE id_emprendedor = '$id_emprendedor'";
        $result = mysqli_query($con,$tabla_elimina);
        
        //// ELIMINA DE TABLA EMPRENDEDORES - OBSERVACIONES  
        $tabla_elimina = "DELETE FROM observaciones_emprendedores WHERE id_emprendedor = '$id_emprendedor'";
        $result = mysqli_query($con,$tabla_elimina);
      }
  }
  
  /////// Elimina relación con Emprendedores /////////
  $tabla_elimina = "DELETE FROM rel_expedientes_emprendedores WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);	
  
  
  /////// Elimina relación con Ubicaciones /////////
  $tabla_ubicaciones = mysqli_query($con, "SELECT ubi.id_ubicacion, ubi.fecha, tu.ubicacion, ubi.motivo from rel_expedientes_ubicacion as reu, ubicaciones as ubi, tipo_ubicaciones as tu
        WHERE reu.id_ubicacion = ubi.id_ubicacion AND tu.id_ubicacion = ubi.id_tipo_ubicacion AND reu.id_expediente = $id_expediente");

  while($fila = mysqli_fetch_array($tabla_ubicaciones)){ 
    $id_ubicacion = $fila[0];
    $tabla_elimina = "DELETE FROM ubicaciones WHERE id_ubicacion = '$id_ubicacion'";
    $result = mysqli_query($con,$tabla_elimina);
  }
  $tabla_elimina = "DELETE FROM rel_expedientes_ubicacion WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);	
  
          
  /////// Elimina relación con Estados /////////
  $tabla_elimina = "DELETE FROM expedientes_estados WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);	
  /////// Elimina las Expedientes Detalle Cuotas /////////
  $tabla_elimina = "DELETE FROM expedientes_detalle_cuotas WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
  /////// Elimina las Expedientes Detalle Puotas /////////
  $tabla_elimina = "DELETE FROM expedientes_pagos WHERE id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
      
}
?>
<div class="table-responsive">         
    <table class="table table-hover">
    <tr>
        <td>Nro</td>
        <td>Proyecto</td>
        <td>Titular</td>
        <td>Cuit</td>
        <td>Estado</td>
        <td>Finalidad</td>
        <td>FechaOtorg.</td>
        <td>Monto$</td>
        <td>Saldo</td> 
        <td>&nbsp;</td>            
    </tr>
    <?php
    $tabla_expedientes = mysqli_query($con, "SELECT exped.* from expedientes as exped, rel_expedientes_emprendedores as ree WHERE exped.id_expediente = ree.id_expediente AND ree.id_emprendedor = 0");
    while($fila = mysqli_fetch_array($tabla_expedientes)){ 
    $id_expediente = $fila[0] ;?>
    <tr>
        <td><a href='sesion_usuario_expediente.php?id=<?php echo $fila[0] ?>' title='Ver expediente' class="link" ><?php echo $fila[1] ?></a> </td>
        <td>No resistrado</td>
        <td>Sin completar</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>-</td>
        <td><?php echo fechanormal($fila[7]) ?></td>
        <td><?php echo number_format($fila[6],2,',','.') ?></td>
        <td><?php echo number_format($fila[9],2,',','.') ?></td>
        <td><a href='javascript:void(0)' title='Elimina el expediente actual' onClick="eliminar_expediente('<?php echo $fila[0] ?>', 'No registrado')"><img src='/desarrolloemprendedor/public/imagenes/eliminar_registro.gif' width='15' height='15' border="0"   /></a></td>
    </tr>
    <?php  
    }
    ?>
    </table>
</div> 
<?php 
mysqli_close($con);
