<?php 
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

if(isset($_POST['id'])){
	
  $id_expediente=$_POST['id'];

  $tabla_elimina = "delete from expedientes where id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
  /////// Elimina las Observaciones /////////
  $tabla_elimina = "delete from observaciones_expedientes where id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);	
  ////////////////////////////////////////////////////
  
  $registro = mysqli_query($con, "select id_emprendedor from rel_expedientes_emprendedores where id_expediente = '$id_expediente'");
  
  while($fila_rel_emp = mysqli_fetch_array($registro)){
    $id_emprendedor = $fila_rel_emp[0];

    $registro_emp_exp = mysqli_query($con,"select id_emprendedor from rel_expedientes_emprendedores where id_emprendedor = '$id_emprendedor'");

    if(mysqli_num_rows($registro_emp_exp) == 1){
      //// ELIMINA DE TABLA EMPRENDEDORES 
      $tabla_elimina = "delete from emprendedores where id_emprendedor = '$id_emprendedor'";
      $result = mysqli_query($con,$tabla_elimina);

      //// ELIMINA DE TABLA EMPRENDEDORES - OBSERVACIONES  
      $tabla_elimina = "delete from observaciones_emprendedores where id_emprendedor = '$id_emprendedor'";
      $result = mysqli_query($con,$tabla_elimina);
    }
  }
  
  /////// Elimina relación con Emprendedores /////////
  $tabla_elimina = "delete from rel_expedientes_emprendedores where id_expediente = '$id_expediente'";
  $result = mysqli_query($con,$tabla_elimina);
}  



?>
<div class="table-responsive">
    <table class="table table-striped dt-responsive nowrap" style="font-size: small">
        <thead>    
        <tr>
            <th>#</th>    
            <th>Apellido, Nombres</th>
            <th>Dni</th>
            <th>Email</th>
            <th>Telefonos</th>
            <th>Rubro</th>
            <th>Localidad</th> 
            <th>F.Otorgam.</th>
            <th>$ Monto</th>
            <th>&nbsp;</th>              
        </tr>
        </thead>
        <tbody>
        <?php
        $contador = 1; 
 
        $tabla_expedientes = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres,emp.telefono,rp.rubro,exp.fecha_otorgamiento,exp.monto,loc.nombre,emp.dni,emp.email
        from expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_rubro_productivos as rp, localidades as loc
        where exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor and exp.id_localidad = loc.id
        and exp.id_rubro = rp.id_rubro and rp.tipo = 1 and exp.nro_exp_madre = 0 and exp.nro_exp_control = 0 group by exp.id_expediente order by emp.apellido,emp.nombres asc");


        while($fila = mysqli_fetch_array($tabla_expedientes)){ 
        $id_expediente = $fila[0] ;
        ?>
            <tr>
                <td><?php echo $contador ?></td>
                <td><?php echo strtoupper($fila[1].', '.$fila[2]) ?></td>
                <td><?php echo $fila[8] ?></td>
                <td><?php echo $fila[9] ?></td>
                <td><?php echo $fila[3] ?></td>
                <td><?php echo substr($fila[4],0,35) ?></td>
                <td><?php echo $fila[7] ?></td>  
                <td><?php echo fechanormal($fila[5]) ?></td>
                <td><?php echo number_format($fila[6],0,'.',',') ?></td>
                <td>
                    <a href='javascript:void(0)' title='Elimina el expediente actual' onClick="eliminar_expediente('<?php echo $fila[0] ?>', '<?php echo $fila[1].', '.$fila[2] ?>')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php
        $contador ++ ;
        }
        ?>
        </tbody>
    </table>
</div>    
<?php  

mysqli_close($con);
