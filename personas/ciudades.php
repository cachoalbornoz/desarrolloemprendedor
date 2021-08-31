<?php
session_start();


require_once('../accesorios/accesos_bd.php');

$cadena = explode('-', $_GET['id']);

$id_departamento= $cadena[0];
if (isset($cadena[1])) {
    $id = $cadena[1];
} else {
    $id = 'id_ciudad';
}


?>
<select name="<?php echo $id ?>" size="1" id="<?php echo $id ?>" class="form-control" required>
<option value="0" disabled selected></option>
<?php
$con=conectar();
$ciudades = "select localidades.id, localidades.nombre from localidades, departamentos
where localidades.departamento_id = departamentos.id and departamentos.id = $id_departamento order by localidades.nombre";
$registro = mysqli_query($con, $ciudades);
while ($fila = mysqli_fetch_array($registro)) {
    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
}

mysqli_close($con);
?>
</select>
