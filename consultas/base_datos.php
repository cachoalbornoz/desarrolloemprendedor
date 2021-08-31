<?php
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();
?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12">
                CONSULTA GENERAL - Seleccione las opciones que desea visualizar
            </div>
        </div>


    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">Tipo Financiamiento</div>
            <div class="col-md-4">Funciona</div>
            <div class="col-md-4">Año</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <select name="id_tipo_financiamiento" id="id_tipo_financiamiento" size="1" class="form-control"
                    onChange="ver_consulta()">
                    <option value="-1" selected>Todos</option>
                    <option value="0">JOVENES EMPRENDEDORES</option>
                    <option value="1">CAPITAL SEMILLA</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="id_funcionamiento" id="id_funcionamiento" size="1" class="form-control"
                    onChange="ver_consulta()">
                    <option value="-1" selected>Todos</option>
                    <option value="1">En funcionamiento</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="ano" id="ano" size="1" onChange="ver_consulta()" class="form-control">
                    <option value="" selected>Todos</option>
                    <?php
                    $fila = mysqli_query($con, "SELECT min(year(date(fecha_otorgamiento))), max(year(date(fecha_otorgamiento))) FROM expedientes");
                    $reg  = mysqli_fetch_array($fila);
                    $min  = $reg[0];
                    $max  = $reg[1];

                    $actual = date('Y', time());
                    $año = $min;

                    while ($año <= $actual) {?>
                    <option value="<?php echo $año ?>"><?php echo $año ?>
                    </option>
                    <?php
                    $año ++;
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">Sector</div>
            <div class="col-md-4">Sub Clasificacion</div>
            <div class="col-md-4">Estado</div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <select name="id" id="id" size="1" class="form-control"
                    onChange="from(this.value,'rubros','rubros.php')" required>
                    <option value="" selected>Todos</option>
                    <option value="1">AGROPECUARIO</option>
                    <option value="2">INDUSTRIAL</option>
                </select>
            </div>
            <div class="col-md-4" name="rubros" id="rubros">
                <select name="id_rubro" id="id_rubro" size="1" tabindex="14" class="form-control"
                    onChange="ver_consulta()" required>
                    <option value="-1" selected>Todos</option>
                </select>
            </div>
            <div class="col-md-4" name="estado" id="estado">
                <select name="id_estado" id="id_estado" size="1" tabindex="14" class="form-control"
                    onChange="ver_consulta()" required>
                    <option value="-1" selected>Todos</option>
                    <option value="0">Sin Determinar</option>
                    <option value="1">Regular</option>
                    <option value="2">Moroso</option>
                    <option value="3">Devolucion Total</option>
                    <option value="4">Fracaso</option>
                    <option value="5">Cambio de Objeto</option>
                    <option value="6">Prorroga</option>
                    <option value="20">Incompleto</option>
                    <option value="21">Evaluacion</option>
                    <option value="22">Rechazado</option>
                    <option value="23">Aprobado</option>
                    <option value="24">Enviado</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">Departamento</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <select name="id_departamento" id="id_departamento" size="1"
                    onchange="ver_consulta(); from(this.value,'ciudad','ciudades.php')" class="form-control">
                    <option value="-1" selected>Todos</option>
                    <?php
                    $departamentos = "SELECT id, nombre FROM departamentos WHERE provincia_id = 7 ORDER BY nombre";
                    $registro = mysqli_query($con, $departamentos);
                    while ($fila = mysqli_fetch_array($registro)) {
                        echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-8" id="ciudad">
                <select name="id_ciudad" id="id_ciudad" class="form-control">
                    <option value="0" selected>Todos</option>
                </select>
            </div>
        </div>

    </div>
</div>



<div class="card">

    <div class="card-header">
        Resultado de Consultas
    </div>

    <div class="card-body">
        <div id="detalle_alertas" style="display:none">
            Recuperando información, aguarde <i class="fa fa-spinner fa-spin fa-fw"></i>
        </div>
    </div>

</div>



<?php   mysqli_close($con);
        require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#detalle_alertas").show();
        $("#detalle_alertas").load('detalle_base_datos.php');
    });



    function ver_consulta() {

        var id_tipo_financiamiento = document.getElementById('id_tipo_financiamiento').value;
        var id_funcionamiento = document.getElementById('id_funcionamiento').value;
        var ano = document.getElementById('ano').value;
        var id_departamento = document.getElementById('id_departamento').value;
        var id_rubro = document.getElementById('id_rubro').value;
        var id_estado = document.getElementById('id_estado').value;
        var id_ciudad = document.getElementById('id_ciudad').value;

        $("#estado").show();

        $("#detalle_alertas").load('detalle_base_datos.php', {
            id_tipo_financiamiento: id_tipo_financiamiento,
            id_funcionamiento: id_funcionamiento,
            ano: ano,
            id_departamento: id_departamento,
            id_rubro: id_rubro,
            id_estado: id_estado,
            id_ciudad: id_ciudad
        })


    }
</script>

<?php require_once('../accesorios/admin-inferior.php');
