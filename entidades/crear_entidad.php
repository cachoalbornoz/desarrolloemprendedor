<?php require('../accesorios/admin-superior.php'); ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class=" col-xs-12 col-sm-12 col-lg-12">
                    NUEVA ENTIDAD
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="cursos" method="POST" action="ingresar_entidad.php" class="form-horizontal" enctype="multipart/form-data" >

                <div class="form-group">
                    <div class="col-lg-4">
                        <label for="entidad">Nombre </label>
                        <input id="entidad" name="entidad" type="text" class="form-control mayus" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-4">
                        <label for="url">URL </label>
                        <input id="url" name="url" type="text" class="form-control" required />  
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-4">
                        <label for="foto">Foto </label>
                        <input id="foto" name="foto" type="file" class="form-control-file" required />  
                    </div>
                </div>


                <div class="form-group">
                    <div class=" col-xs-12 col-sm-12 col-lg-12 text-right">
                        <input type="submit" class="btn btn-info" value="Guardar" />
                    </div>
                </div>

            </form>
        </div>

    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){

    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
