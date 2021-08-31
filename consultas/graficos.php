<?php 
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();
?>  
    
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                ESTADISTICAS DEL SISTEMA        
            </div>                
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <label for="ano">Año crédito</label>
                <select name="ano" id="ano" onChange="ver_estadisticas()" class="form-control">
                <option value="0"></option>
                <?php 
                $fila = mysqli_query($con,"SELECT min(year(date(fecha_otorgamiento))), max(year(date(fecha_otorgamiento))) FROM expedientes");
                $reg  = mysqli_fetch_array($fila);
                $min  = $reg[0];
                $max  = $reg[1];

                $actual = date('Y',time());
                $año = $min;

                while ($año <= $actual){
                    if( $año == $min){
                    ?>
                    <option value="<?php echo $año ?>" selected><?php echo $año ?></option>
                    <?php
                    }else{
                        ?>
                        <option value="<?php echo $año ?>"><?php echo $año ?></option>
                    <?php
                    }
                 
                $año ++;
                }
                ?>
                </select>
            </div>                 
        </div>
        <br>

        <div id="graficos"> 	
            <div id="estado" style="display:none">
                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i> 
            </div>
        </div>   

    </div>

</div>    
    
<?php 
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>


<script type="text/javascript">

$(document).ready(function(){
    var anio = document.getElementById('ano').value
    $("#estado").show();
    $("#graficos").load('detalle_graficos.php',{ano: anio});
});


function ver_estadisticas(){
    var anio = document.getElementById('ano').value
    $("#estado").show();
    $("#graficos").load('detalle_graficos.php',{ano: anio});
}

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>  