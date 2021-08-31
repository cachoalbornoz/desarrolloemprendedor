<?php require('../accesorios/admin-superior.php'); ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    NUEVO TEMA DE FORMACION
                </div>
            </div>
        </div>

        <div class="card-body">

            <form id="cursos" method="POST" action="ingresar_formacion.php" class="form-horizontal">

                <div class="form-group">
                    <div class="col-lg-4">
                        <label for="nombre">Nombre del tema</label>
                        <input id="nombre" name="nombre" type="text" class="form-control mayus" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
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
