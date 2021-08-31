<?php
require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$_SESSION['id_expediente'] = $id_expediente=$_GET['id'];


$tabla_expedientes  = mysqli_query($con, "SELECT * FROM expedientes WHERE id_expediente = $id_expediente") or die("Error leer expedientes");
$registro           = mysqli_fetch_array($tabla_expedientes) ;

$_SESSION['nro_proyecto'] = $nro_proyecto = $registro['nro_proyecto'];
$_SESSION['monto'] = $monto = $registro['monto'];
$_SESSION['fecha_otorgamiento'] = $fecha_otorgamiento = $registro['fecha_otorgamiento'];

$id_rubro = $registro['id_rubro'];

$nro_expediente_madre = $registro['nro_exp_madre'];
$nro_expediente_control = $registro['nro_exp_control'];

////////////////////////////////////////////////////////////////////////////////////////////
$tabla_emprendedores = mysqli_query($con, 
    "SELECT emp.apellido, emp.nombres 
    FROM emprendedores as emp, expedientes as exped, rel_expedientes_emprendedores as rel
    WHERE rel.id_expediente = exped.id_expediente 
    AND rel.id_emprendedor = emp.id_emprendedor 
    AND emp.id_responsabilidad = 1 
    AND exped.id_expediente = $id_expediente ");
$registro_emp = mysqli_fetch_array($tabla_emprendedores);
$_SESSION['titular'] = $registro_emp[0].' '.$registro_emp[1];
///////////////////////////////////////////////////////////////////////////////////////////
$id_localidad = $registro['id_localidad'];

$tabla_ciudad = mysqli_query($con, "SELECT nombre FROM localidades WHERE id = '$id_localidad'");
if ($registro_ciudad = mysqli_fetch_array($tabla_ciudad)) {
    $localidad = $registro_ciudad['nombre'];
}
///////////////////////////////////////////////////////////////////////////////////////////
$id_rubro = $registro['id_rubro'];
$tabla_rubros = mysqli_query($con, "SELECT rubro FROM tipo_rubro_productivos WHERE id_rubro = '$id_rubro'");
if ($registro_rub = mysqli_fetch_array($tabla_rubros)) {
    $rubro = $registro_rub['rubro'];
}
///////////////////////////////////////////////////////////////////////////////////////////
$observaciones = $registro['observaciones'];

if ($observaciones == 1) {
    $consulta_observaciones = "SELECT observaciones FROM observaciones_expedientes WHERE id_expediente = '$id_expediente'";
    $tabla_observaciones = mysqli_query($con, $consulta_observaciones);

    $registro_observaciones = mysqli_fetch_array($tabla_observaciones);
    $observaciones = $registro_observaciones['observaciones'];
} else {
    $observaciones = '';
}

?>


<form action ="editar_expediente.php?id=<?php echo $id_expediente ?>" method="post" name="expedientes" id="expedientes">


    <div class="card">
        <div class="card-header">
            <div class="row mb-2">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <b><?php echo $_SESSION['titular'] ?> </b> - Datos del Expediente
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">   
                    <?php include('../accesorios/menu_expediente.php');?>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    Nro proyecto
                      <input type="text" name="nro_proyecto" id="nro_proyecto" autofocus value="<?php echo $nro_proyecto ?>" class="form-control" required>
                </div>

                <div class="col-xs-12 col-sm-10 col-lg-10">
                        Rubro
                        <select name="id_rubro" id="id_rubro" size="1" class="form-control">
                          <option value = '<?php echo $id_rubro ?>'><?php echo $rubro ?></option>
                            <?php
                            $rubros = "SELECT id_rubro, rubro FROM tipo_rubro_productivos order by rubro";
                            $registro = mysqli_query($con, $rubros);
                            while ($fila = mysqli_fetch_array($registro)) {
                                echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                            }
                            mysqli_free_result($registro);
                            ?>
                        </select>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-3">
                    Nro expediente madre
                    <input type="text" name="nro_expediente_madre" id="nro_expediente_madre" value="<?php echo $nro_expediente_madre ?>" class="form-control"required>
                </div>
                <div class="col-sm-3">
                    
                    Nro expediente control
                    <input type="text" name="nro_expediente_control" id="nro_expediente_control" value="<?php echo $nro_expediente_control ?>" class="form-control"required>
                    
                </div>
                <div class="col-sm-3">
                    Monto
                    <input type="text" name="monto" id="monto" value="<?php echo $monto ?>" class="form-control" required>
                </div>

                <div class="col-sm-3">
                    
                    Fecha otorgamiento
                    <input type="date" name="fecha_otorgamiento" id="fecha_otorgamiento" value="<?php echo $fecha_otorgamiento ?>" class="form-control" required >
                    
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-3 col-lg-6">
                    Localidad
                      <select name="id_localidad" size="1" id="id_localidad" class="form-control">
                      <option value = "<?php echo $id_localidad ?>"><?php echo $localidad ?></option>
                      <?php
                        $con=conectar();
                        $ciudades = "SELECT localidades.id, localidades.nombre FROM localidades, departamentos, provincias WHERE localidades.departamento_id = departamentos.id AND departamentos.provincia_id = provincias.id AND provincias.id = 7 order by localidades.nombre";
                        $registro = mysqli_query($con, $ciudades);
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo "<option value=".$fila[0]."\>".$fila[1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-6">
                    Observaciones
                    <input type="text" name="observaciones" id="observaciones" rows="2" value="<?php echo $observaciones ?>" class="form-control">    
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                    <button type="submit" title="Guardar" name="guardar" id="guardar" class="btn btn-info">Guardar</button>
                </div>
            </div>

        </div>
    </div>


</form>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

    function ver_detalles(){

        location.reload();
    }

</script>



<?php
    mysqli_close($con);
    require_once('../accesorios/admin-inferior.php'); ?>
