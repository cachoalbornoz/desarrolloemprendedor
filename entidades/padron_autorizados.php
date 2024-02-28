<?php
require '../accesorios/admin-superior.php';
require '../accesorios/accesos_bd.php';
$con = conectar();

$id_usuario = $_SESSION['id_usuario'];
$sql        = "SELECT id_entidad FROM rel_entidad_usuario WHERE id_usuario = $id_usuario";
$query      = mysqli_query($con, $sql);
$row        = mysqli_fetch_array($query);

$id_entidad = $row['id_entidad'];

?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">
                PADRON AUTOGESTIONADOS A VERIFICAR - Entidad # <?php print $id_entidad; ?>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 mb-3 ">
                &nbsp;
			</div>                  
        </div>

        <div class="row mb-3">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="font-size: small" id="autorizados">
                        <thead>
                            <th>Id</th>
                            <th>Solicitante</th>
                            <th>Dni</th>
                            <th>Localidad</th>
                            <th>Depto</th>
                            <th>Reseña</th>
                            <th>Verifica</th>	
                        </thead>
                    </table>
                </div>
            </div>        
        </div>

    </div>
</div>

<?php
    mysqli_close($con);
require_once '../accesorios/admin-scripts.php';
?>

<script>

    $(document).ready(function(){

        var table = $('#autorizados').DataTable({    
            "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflitp>',          
            "buttons"       : ['copy', 'excel', 'pdf', 'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "processing"    : true,
            "serverSide"    : true,
            "ajax"          : {
                url   : "server-autorizados.php",
                type  : "post"
            },
            "columnDefs"    : [
                { orderable:    false   , targets: [0] },
                { className: 'text-center', targets: [0, 2, 6] },
                { className: 'rowspanning', targets: [5] }
            ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    });

    $('#autorizados').on("click", ".autorizar", function(){

        var id_solicitante  = this.id;

        $.ajax({

            url 	: 'server-a-autorizados.php',
            type 	: 'POST',
            dataType: 'json',
            data 	: {id_solicitante: id_solicitante},
            success: function(data){

                console.log(data);

                if(data == 1){
                    toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                    toastr.info("&nbsp;", "Autorizado ... ");

                }else{

                    toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                    toastr.error("&nbsp;", "Bloqueado ... ");
                }
            }
        });
    });

</script>

<?php require_once '../accesorios/admin-inferior.php'; ?>
