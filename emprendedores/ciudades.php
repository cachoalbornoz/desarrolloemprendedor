<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit();
}

require_once('../accesorios/accesos_bd.php');

$id_provincia=$_GET['id'];

?>
<select name="id_ciudad" tabindex="11" size="1" id="id_ciudad" class="form-control">
<option value = "0">Seleccione</option>
<?php
$con=conectar();
$ciudades = "select localidades.id, localidades.nombre from localidades, departamentos, provincias where localidades.departamento_id = departamentos.id and departamentos.provincia_id = provincias.id and provincias.id = '$id_provincia' order by localidades.nombre";
$registro = mysqli_query($con, $ciudades);
while ($fila = mysqli_fetch_array($registro)) {
    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
}

mysqli_close($con);
?>
</select>
