<?php 
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

    $id_proyecto = $_GET['id_proyecto'];

    $tabla    = mysqli_query($con, "SELECT informe FROM proyectos WHERE id_proyecto = '$id_proyecto'");

    if ($registro = mysqli_fetch_array($tabla)) {
        $informe    = $registro['informe'];
    } ;
?> 

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <b><?php echo $_SESSION['titular'] ?> </b> - Pagos realizados
            </div> 
            <div class="col-6">    
                <?php include('../accesorios/menu_expediente.php');?>
            </div>
        </div>
    </div>    
    <div class="card-body">

        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-2">
                Fecha
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                Monto total pago
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                Nº cuenta
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                Tipo movimiento
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                Nro operación
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
            </div>
        </div>    

        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <input type="date" id="fecha" name="fecha" class="form-control" required/>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <input type="number" id="monto" name="monto" class="form-control" required>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <select id="id_cuenta" name="id_cuenta" class="form-control"> 
                    <?php
                        $registro = mysqli_query($con, "select * from tipo_cuenta where id > 1") or die("Error al leer tipo cuentas");
                        while($fila = mysqli_fetch_array($registro)){
                            $selected = ($fila[0]==3)?'selected':null ;                            
                            echo "<option value=".$fila[0]." $selected>".$fila[1]."</option>";
                        }
                    ?>   
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <select id="id_tipo_pago" name="id_tipo_pago" class="form-control" >
                    <?php
                        $registro = mysqli_query($con, "select * from tipo_pago order by pago") or die("Error al leer tipo pagos");
                        while($fila = mysqli_fetch_array($registro)){
                            echo "<option value=".$fila[0].">".$fila[1]."</option>";
                        }
                    ?>   
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <input type="number" id="nro_operacion" name="nro_operacion" class="form-control" required>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2 text-center">
                <button class="btn btn-secondary" onClick="mover()">Registrar</button>
            </div>
        </div>

        <div id="detalle_pago">  </div>

    </div>
</div>


<?php 

  mysqli_close($con); 
  require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#detalle_pago").load('detalle_pago.php');
    });
    
    
    function mover(){
        var fecha = document.getElementById('fecha').value;
        var monto = document.getElementById('monto').value;
        var id_cta = document.getElementById('id_cuenta').value;
        var id_tipo_pago = document.getElementById('id_tipo_pago').value;
        var nro_operacion= document.getElementById('nro_operacion').value; 
            
        if(fecha == 0 || monto == 0){
            $("#estado").html('Todos los datos son necesarios para el Registro de pagos. ');
            $("#estado").fadeOut(4500);
            
        }else{
            $("#detalle_pago").load('detalle_pago.php', {operacion:1, fecha: fecha, monto:monto, id_cuenta:id_cta, id_tipo_pago:id_tipo_pago, nro_operacion:nro_operacion});
            document.getElementById("fecha").value = '';
            document.getElementById('monto').value = '';
            document.getElementById('id_cuenta').value = 3;
            document.getElementById('nro_operacion').value = ''     ;
        }
    }
    
    function eliminar_pago(id_pago){
        var id = id_pago;
        if (confirm("Desea eliminar el pago seleccionado ?")){
            $("#detalle_pago").load('detalle_pago.php', {operacion:2, id: id});
        }   
    }
    
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>