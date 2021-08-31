<?php 
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();
?>  	

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <b><?php echo $_SESSION['titular'] ?> </b> - Ubicación del expediente
            </div>  
            <div class="col-6">    
                <?php include('../accesorios/menu_expediente.php');?>
            </div>
        </div>
    </div>    
    <div class="card-body">
    
        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Fecha traslado
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Ubicación / lugar
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Motivo / respuesta
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                &nbsp;
            </div>
        </div>
        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <input type="date" id="fecha" name="fecha" class="form-control"/>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <select name="id_tipo_ubicacion" size="1" id="id_tipo_ubicacion" class="form-control">
                    <option value = "0">...</option>
                    <?php
                    $registro = mysqli_query($con, "SELECT * FROM tipo_ubicaciones ORDER BY ubicacion asc"); 
                    while($fila = mysqli_fetch_array($registro)){
                        echo "<option value=".$fila[0].">".$fila[1]."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <input type="text" id="motivo" name="motivo" required class="form-control">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                <input type="button" value="Registrar" onClick="mover()" class="btn btn-secondary">
            </div>
        </div>

        <div id="detalle_ubicacion">  </div>
    </div>    
</div>        
 
<?php 

  mysqli_close($con); 
  require_once('../accesorios/admin-scripts.php'); ?>


<script type="text/javascript">
    
    $(document).ready(function(){
        $("#detalle_ubicacion").load('detalle_ubicacion.php');
    });
    
    
    function mover(){
        var fecha = document.getElementById('fecha').value;
        var id_tipo_ubi = document.getElementById('id_tipo_ubicacion').value;
        var motivo = document.getElementById('motivo').value;
           
        $("#detalle_ubicacion").load('detalle_ubicacion.php', {operacion:1, fecha: fecha, id_tipo_ubicacion:id_tipo_ubi, motivo:motivo});
        document.getElementById("fecha").value = '';
        document.getElementById("id_tipo_ubicacion").value = 0;
        document.getElementById("motivo").value = '';
    }
    
    function eliminar_movimiento(id_movimiento){
        var id = id_movimiento;
        if (confirm("Desea eliminar el movimiento seleccionado ?")){
            $("#detalle_ubicacion").load('detalle_ubicacion.php', {operacion:2, id: id});
        } 
    }
    
</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>