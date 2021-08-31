<?php
require('../accesorios/admin-superior.php');
require_once('../accesorios/accesos_bd.php');
$con = conectar();


?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                NUEVO SOLICITANTE DEL CREDITO
            </div>
        </div>
    </div>

    <div class="card-body">

        <form action="agregar_emprendedor.php" method="post" name="emprendedor" id="emprendedor" class="form-horizontal">

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    DNI
                    <input id="dni" name="dni" type="number" required class="form-control" autofocus>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    CUIT / CUIL
                    <input id="cuit" name="cuit" type="number" size="13" maxlength="11" required class="form-control">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    RESPONSABILIDAD
                    <select name="id_responsabilidad" size="1" id="id_responsabilidad" class="form-control">
                        <option value='0'>CODEUDOR</option>
                        <option value='1' selected>TITULAR</option>
                    </select>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    APELLIDO
                    <input id="apellido" name="apellido" type="text" class="form-control mayus">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    NOMBRES
                    <input id="nombres" name="nombres" type="text" class="form-control mayus">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    CONDICION LABORAL
                    <select name="id_condicion_laboral" size="1" id="id_condicion_laboral" class="form-control">
                        <option value="1">AUTONOMO</option>
                        <?php
                        $registro = mysqli_query($con, "select * from tipo_condicion_laboral where id_condicion_laboral <> 1 order by condicion_laboral");
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo "<option value=" . $fila[0] . ">" . $fila[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    DOMICILIO
                    <input id="direccion" name="direccion" type="text" class="form-control mayus">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    E-MAIL
                    <input name="email" type="email" id="email" class="form-control" />
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    FECHA NACIMIENTO
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" />
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    PROVINCIA
                    <select name="provincia" id="provincia" size="1" onchange="from(document.emprendedor.provincia.value,'ciudad','ciudades.php')" class="form-control">
                        <option value="0">Seleccione ...</option>
                        <?php
                        $registro   = mysqli_query($con, "SELECT id, nombre FROM provincias ORDER BY nombre");
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo "<option value=" . $fila[0] . ">" . $fila[1] . "</option>";
                        }
                        ?>
                    </select>

                </div>
                <div class="col-xs-12 col-sm-12 col-lg-8">
                    LOCALIDAD
                    <div id="ciudad">
                        <select name="ciudad" id="ciudad" size="1" class="form-control">
                            <option value="">... </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    COD. AREA <input id="cod_area" name="cod_area" type="text" class="form-control" maxlength="5">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    CELULAR - Sin 15
                    <input id="celular" name="celular" type="text" class="form-control">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-4">
                    FIJO
                    <input id="telefono" name="telefono" type="text" class="form-control">
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    &nbsp;
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    OBSERVACIONES
                    <input id="observaciones" name="observaciones" type="text" class="form-control mayus">
                </div>
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    (*) Todos los datos son obligatorios
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    <button type="submit" name="guardar" id="guardar" onClick="guardar()" class="btn btn-primary float-right">Guardar</button>
                </div>
            </div>

        </form>

    </div>

</div>

<?php
mysqli_close($con);
require_once('../accesorios/admin-scripts.php');    ?>

<script type="text/javascript">
function chequea_cuit() {

    var cuit = document.getElementById('cuit').value
    var url = 'verifica_emprendedor.php'

    $.ajax({
        type: 'GET',
        url: url,
        data: {
            id: cuit
        },
        success: function(resp) {
            if (resp == 0) {
                document.getElementById("estado").innerHTML = "CUIT ya está registrado, presione Guardar.";
                setTimeout(function() {
                    document.getElementById("cuit").focus();
                }, 0);
                return false
            }
        }
    });

    document.getElementById("estado").innerHTML = ""
    return true
}
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>