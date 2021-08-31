<?php

include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();

?>

<form autocomplete="false" action='guardarConsulta.php' method="post">
    <div class="card">

        <div class="card-header bg-info text-white">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6 p-3">
                    <i class="fas fa-edit"></i> Formulario de contacto.
                </div>
            </div>

        </div>

        <div class="card-body">

            <div class="row mb-4">
                <div class="col-xs-12 col-md-6 col-lg-2 p-3">
                    <label>Dni</label>
                    <input id="dni" name="dni" type="number" class="form-control text-center shadow" autofocus required min=1 max=999999999 onkeyup=imposeMinMax(this)>
                    <div class="messages"></div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Apellido</label>
                    <input id="apellido" name="apellido" type="text" class="form-control mayus shadow" required>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5 p-3">
                    <label>Nombres</label>
                    <input id="nombres" name="nombres" type="text" class="form-control mayus shadow" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-md-4 col-lg-4 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Teléfono &nbsp; <i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input id="telefono" name="telefono" type="text" class="form-control shadow" required placeholder="Ej. 343 4840356" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="col-xs-12 col-md-8 col-lg-8 p-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Email &nbsp; <i class="far fa-envelope"></i>
                            </span>
                        </div>
                        <input name="email" type="email" id="email" class="form-control minus shadow" required>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <label>Elegí el tema que te gustaría recibir asesoramiento</label>
                    <select name="categoria" id="categoria" class="form-control shadow" required>
                        <option value="" disabled selected></option>
                        <?php
                        $categoria = "SELECT id, tipo FROM tipo_asesoramiento ORDER BY tipo";
                        $registro = mysqli_query($con, $categoria);
                        while ($fila = mysqli_fetch_array($registro)) {
                            echo "<option value=" . $fila['id'] . ">" . $fila['tipo'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <span class=" text-danger">(*)</span> Todos los datos son necesarios
                </div>
            </div>

            <div class="row mt-5 mb-5">
                <div class="col-xs-12 col-sm-6 col-lg-6 mt-3">
                    <div class="g-recaptcha" data-sitekey="6LdxcnUUAAAAAM5R_2E_NknVIft2KxtIiEoJNx3h"></div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6 align-self-center mt-3">
                    <input id="btnguardar" type="submit" class="btn btn-info btn-block" value=' Enviar mi consulta' />
                </div>
            </div>

        </div>

    </div>
</form>


<?php

mysqli_close($con);

include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php';

include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php';
