<?php
require_once("../accesos_bd.php");
$id_provincia=$_GET['id'];

?>
<select name="id_localidad" tabindex="8" size="1" id="id_localidad" class="select">
<option value = "0">Seleccione</option>
<?php
$con=conectar();
$ciudades = "select localidades.id, localidades.nombre from localidades, departamentos, provincias where localidades.departamento_id = departamentos.id and departamentos.provincia_id = provincias.id and provincias.id = '$id_provincia' order by localidades.nombre";
$registro = mysqli_query($con, $ciudades); 
while($fila = mysqli_fetch_array($registro)){
    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
}	
mysqli_close($con);		
?>      
</select>






