<?php require('../accesorios/admin-superior.php'); ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    LISTADO DE CURSOS <a href="crear_curso.php"> (+) Agregar curso</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="detalle_curso">
                <div id="estado" style="display:none">
                    Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){
        $("#estado").show();
        $("#detalle_curso").load('detalle_curso.php',function(){ });
    });


    function eliminar_curso(id){

        if(confirm('Seguro que desea desactivar el curso ')){

            $("#detalle_curso").load('detalle_curso.php',{id: id, elimina:true});

            toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
            toastr.error("&nbsp;", "Curso desactivado ... ");

        }else {
            return false;
        }
    };

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
