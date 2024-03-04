<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();

?>



<div class="row">

    <div class="col-xs-12 col-md-6 col-lg-6 mx-auto">

        <div class="card card-signin my-5">

            <form action='/desarrolloemprendedor/registro/verifica_usuario.php' role="form" method="post" id="loggin" autocomplete="off">

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <p>Usuario</p>
                            <input type="text" class="form-control" id="usuario" name="usuario" autofocus required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <p>Clave</p>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control" name="password" required>
                                <div class=" input-group-append">
                                    <span class="input-group-text">
                                        <span class="fa fa-eye" id="mostrar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <input type="hidden" name="_token" value="<?php print md5(time()); ?>">
                            &nbsp;
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xs-12 col-md-12 col-lg-12" style="transform:scale(0.85);transform-origin:0 0">
                            <div class="g-recaptcha" data-sitekey="6LdxcnUUAAAAAM5R_2E_NknVIft2KxtIiEoJNx3h"></div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <input type="submit" class="btn btn-secretaria-2024 btn-block" id="ingresar" value="INGRESAR" />
                        </div>
                    </div>


                </div>

            </form>

        </div>
    </div>
</div>


<?php

require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php';

mysqli_close($con);

require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php';

?>