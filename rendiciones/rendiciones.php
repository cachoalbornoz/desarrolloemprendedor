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
            <div class="col-4">
                <b> <?php echo $_SESSION['titular'] ?> </b> - Rendiciones
            </div>
            <div class="col-4">
                Monto del crédito <b>$ <?php echo number_format($_SESSION['monto'], 0, ',', '.') ?></b>
            </div>
            <div class="col-4">    
                <?php include('../accesorios/menu_expediente.php');?>
            </div>
                           
               
        </div>
    </div>

    <div class="card-body">

        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Fecha rendición
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Importe
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                Comprobante
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                
            </div>
        </div>

        <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <input id="fecha" name="fecha" type="date" class="form-control">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <input id="monto" name="monto" type="text" value="0" class="form-control">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3">
                <select id="tipo" name="tipo" class="form-control">
                    <option value="0">No válido Factura</option>
                    <option value="1" selected>Factura</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 text-center">
                <button onClick="agregar_rendicion()" class="btn btn-secondary">
                    Registrar
                </button>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                &nbsp;
            </div>
        </div>

        
        <div id="detalle_rendicion">  </div>             

    </div>


<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#detalle_rendicion").load('detalle_rendiciones.php');
    });


    function agregar_rendicion(){

        var monto 	= document.getElementById('monto').value;
		var fecha 	= document.getElementById('fecha').value
		var tipo 	= document.getElementById('tipo').value;

		$("#detalle_rendicion").load('detalle_rendiciones.php', {operacion:1, fecha:fecha, monto:monto, tipo:tipo});
    }


    function eliminar_rendicion(id){

        if (confirm("Seguro que desea anular ?")){

            $("#detalle_rendicion").load('detalle_rendiciones.php', {operacion:2, id:id});
        }
    }

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
