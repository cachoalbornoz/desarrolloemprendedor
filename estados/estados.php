<?php
require '../accesorios/admin-superior.php';
require_once '../accesorios/accesos_bd.php';
$con = conectar();

$id_proyecto = $_GET['id_proyecto'];

$tabla = mysqli_query($con, "SELECT * FROM proyectos WHERE id_proyecto = '$id_proyecto'");

if ($registro = mysqli_fetch_array($tabla)) {
    $informe = $registro['informe'];
}
?> 

 
<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <b><?php print $_SESSION['titular']; ?> </b> - Estado del expediente
            </div>  
            <div class="col-6">    
                <?php include '../accesorios/menu_expediente.php'; ?>
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
                    Fecha de prórroga límite
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
                        <option value = "0" disabled selected>Seleccione ... </option>
                        <?php
                        $registro = mysqli_query($con, 'SELECT * FROM tipo_estado 
                            WHERE id_estado < 20 and id_estado <> 0
                            ORDER BY estado asc');
                        while($fila = mysqli_fetch_array($registro)) {
                        print '<option value=' . $fila[0] . '>' . $fila[1] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3">
                    <input type="date" id="fecha_prorroga" name="fecha_prorroga" class="form-control"/>
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
require_once '../accesorios/admin-scripts.php'; ?>


<script type="text/javascript">
    $(document).ready(function(){
        $("#detalle_estado").load('detalle_estado.php')
    });
    
    function mover(){

        let fecha           = document.getElementById('fecha').value
        let fecha_prorroga  = document.getElementById('fecha_prorroga').value
        let id_tipo_estado  = document.getElementById('id_tipo_estado').value

        if(fecha != 0 && fecha_prorroga !=0 && id_tipo_estado !=0){
                
            $("#detalle_estado").load('detalle_estado.php', {operacion:1, fecha, fecha_prorroga, id_tipo_estado})
            document.getElementById("fecha").value = ''
            document.getElementById("fecha_prorroga").value = ''
            document.getElementById("id_tipo_estado").value = 0
        }else{
            toastr.options = { "progressBar": true, "showDuration": "3000", "timeOut": "3000" };
            toastr.success("&nbsp;", "Verifique Fecha estado, Tipo estado ó Fecha prórroga");            
        }
    }
    
    function eliminar_estado(id_estado){
        let id = id_estado
        if (confirm("Desea eliminar el estado seleccionado ?")){
            $("#detalle_estado").load('detalle_estado.php', {operacion:2, id})
        }   
    }
    
</script>

<?php require_once '../accesorios/admin-inferior.php'; ?>