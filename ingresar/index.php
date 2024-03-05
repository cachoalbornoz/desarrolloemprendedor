<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();

?>



<div class="row mb-5">

    <div class="col-xs-12 col-md-6 col-lg-6 mx-auto">

        <div class="card card-signin my-5">

            <form action='/desarrolloemprendedor/registro/verifica_usuario.php' role="form" method="post" id="loggin" autocomplete="off">

                <div class="card-body">

                    <div class="row mt-3 mb-3">
                        <label for="usuario" class="col-md-4 col-form-label text-md-end">
                            Usuario
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="usuario" name="usuario" autofocus required>
                        </div>
                    </div>

                    <div class="row mt-5 mb-5">
                        <label for="password" class="col-md-4 col-form-label text-md-end">
                            Clave
                        </label>
                        <div class="col-8">
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

                    <div class="row mt-3 mb-3">
                        <label class="col-md-4 col-form-label text-md-end">                            
                        </label>
                        <div class="col-8" style="transform:scale(0.85);transform-origin:0 0">
                            <input type="hidden" name="_token" value="<?php print md5(time()); ?>">
                            <div class="g-recaptcha" data-sitekey="6LdxcnUUAAAAAM5R_2E_NknVIft2KxtIiEoJNx3h"></div>
                        </div>
                    </div>   

                    <div class="row mt-3 mb-3">
                        <label class="col-md-4 col-form-label text-md-end">
                        </label>
                        <div class="col-8">
                            <input type="submit" class="btn btn-secretaria-2024 btn-block" id="ingresar" value="INGRESAR" />
                        </div>
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