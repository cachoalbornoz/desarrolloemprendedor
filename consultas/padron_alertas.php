<?php
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

    $fila = mysqli_query($con,"select min(year(date(fecha_otorgamiento))), max(year(date(fecha_otorgamiento))) from expedientes");
    $reg  = mysqli_fetch_array($fila);
    $min  = $reg[0];
    $max  = $reg[1];

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                LLAMADAS A REALIZAR
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-6">
                <select name="id_estado" id="id_estado" size="1" class="form-control" onChange="ver_estadisticas()">
                    <option value="1" selected>Regular</option>
                    <option value="6">Prórroga</option>
                </select>
            </div>

            <div class=" col-xs-12 col-sm-12 col-lg-6">
                <select name="ano" id="ano" size="1" class="form-control" onChange="ver_estadisticas()">
                <?php
                  $actual = date('Y',time());
                  $año = $min;
                  while ($año <= $actual){
                    ?>
                        <option value="<?php echo $año ?>"><?php echo $año ?></option>
                    <?php
                    $año ++;
                  }
                  ?>
                </select>
            </div>
        </div>

    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col">
                <div id="detalle_alertas">
                    <div id="estado" style="display:none">
                        Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#estado").show();
        var tipo = document.getElementById('id_estado').value
        var anio = document.getElementById('ano').value
        $("#detalle_alertas").load('detalle_alertas.php',{ano: anio,tipo:tipo},function(){})
    });



    function ver_estadisticas(){
        $("#estado").show();
        var anio = document.getElementById('ano').value;
        var tipo = document.getElementById('id_estado').value;

        $("#detalle_alertas").load('detalle_alertas.php',{ano: anio, tipo:tipo},function(){});
    }
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
