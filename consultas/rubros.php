<?php
require_once("../accesorios/accesos_bd.php");
$rubro_general=$_GET['id'];
?>
<select name="id_rubro" id="id_rubro" size="1" tabindex="14" class="form-control" onChange="ver_consulta()" required>
   <option value="-1" disabled selected>SELECCIONE</option>
	<?php
	 $con=conectar();

      $rubros = "SELECT id_rubro, rubro FROM tipo_rubro_productivos WHERE id_rubro_general = $rubro_general order by rubro";
      $registro = mysqli_query($con, $rubros); 

      	while($fila = mysqli_fetch_array($registro)){

    			echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
          
        }

	  mysqli_close($con);
	?>
</select>
	
      

