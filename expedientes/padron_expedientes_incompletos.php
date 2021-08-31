<?php 
    require('../accesorios/admin-superior.php');

    if (isset($_SESSION['id_expediente'])){
        unset($_SESSION['id_expediente'], $_SESSION['nro_proyecto'], $_SESSION['titular'], $_SESSION['monto'], $_SESSION['fecha_otorgamiento']);
    }
?>
 
<div class="card">
    <div class="card-header"></div>
        <div class="row">
            <div class="col-sm-12">
                LISTADO DE EXPEDIENTES INCOMPLETOS
            </div>
        </div>
    </div>    
    <div class="card-body">
        <div id="estado">  </div>
        <div id="detalle_expediente_incompleto"> 	</div>
    </div>    
</div>


<?php 
    require_once('../accesorios/admin-scripts.php'); 
?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#detalle_expediente_incompleto").load('detalle_expedientes_incompleto.php',function(){});    
    });

    function eliminar_expediente(id_exped, expediente){
        
        if (confirm("BORRAR EXPEDIENTE COMPLETO DE : \n\n" + expediente + " ?")){
            $("#estado").css("font-size","0.7em")  
            $("#estado").html('Eliminando expediente, aguarde ... <img src="/desarrolloemprendedor/public/imagenes/cargando.gif" width="12" height="12"> ')
            $("#estado").css("color","#F00");
            $("#estado").css("display", "inline");

            $("#detalle_expediente_incompleto").load('detalle_expedientes_incompleto.php',{id:id_exped})
            $("#estado").css("display", "none");
        }   
    }

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>

