<?php
require_once("../accesorios/accesos_bd.php");
$id_departamento=$_GET['id'];

?>
<select name="id_ciudad" id="id_ciudad" class="form-control" onChange="ver_consulta()">
<option value="0" disabled selected>SELECCIONE</option>

<?php
	$con=conectar();
	$ciudades = "select localidades.id, localidades.nombre from localidades, departamentos 
	where localidades.departamento_id = departamentos.id and departamentos.id = $id_departamento order by localidades.nombre";
	$registro = mysqli_query($con, $ciudades); 
	while($fila = mysqli_fetch_array($registro)){
	    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
	}	

mysqli_close($con);		
?>      
</select>