<?php 
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

    $id_proyecto = $_GET['id_proyecto'];

    $tabla    = mysqli_query($con, "SELECT * FROM proyectos WHERE id_proyecto = '$id_proyecto'");

    if ($registro = mysqli_fetch_array($tabla)) {
        $informe    = $registro['informe'];
    } ;
?> 

 
<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <b><?php echo $_SESSION['titular'] ?> </b> - Estado del expediente
            </div>  
            <div class="col-6">    
                <?php include('../accesorios/menu_expediente.php');?>
            </div>
        </div>
    </div>    

    <div class="card-body">

        <form action ="" method="post" name="estado" id="estado"> 

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Fecha de estado
                </div>   
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    Estado
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                </div>    
            </div>

            <div class="row m-3">
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    <input type="date" id="fecha" name="fecha" required class="form-control"/>
                </div>   
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    <select name="id_tipo_estado" size="1" id="id_tipo_estado" class="form-control">
                        <option value = "0">...</option>
                        <?php
                        $registro = mysqli_query($con, "SELECT * FROM tipo_estado where id_estado < 20 order by estado asc"); 
                        while($fila = mysqli_fetch_array($registro)){
                            echo "<option value=".$fila[0].">".$fila[1]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                    <input type="button" value="Registrar" onClick="mover()" class="btn btn-secondary">
                </div>    
            </div>
            
        </form>

        <div id="detalle_estado"> </div>
            
    </div>
</div>
    


<?php 

  mysqli_close($con); 
  require_once('../accesorios/admin-scripts.php'); ?>


<script type="text/javascript">
    $(document).ready(function(){
        $("#detalle_estado").load('detalle_estado.php')
    });
    
    function mover(){
        var fecha = document.getElementById('fecha').value
        var id_tipo_estado = document.getElementById('id_tipo_estado').value
                
        $("#detalle_estado").load('detalle_estado.php', {operacion:1, fecha: fecha, id_tipo_estado:id_tipo_estado})
        document.getElementById("fecha").value = ''
        document.getElementById("id_tipo_estado").value = 0
    }
    
    function eliminar_estado(id_estado){
        var id = id_estado
        if (confirm("Desea eliminar el estado seleccionado ?")){
            $("#detalle_estado").load('detalle_estado.php', {operacion:2, id: id})
        }   
    }
    
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>