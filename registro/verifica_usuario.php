<?php

session_start();

$mensaje    = null;
$enlace     = null;
$clase      = null;

$response = $_POST["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => '6LdxcnUUAAAAADI2DkqCkGZ1WAp4y8zzG9S2y-Ow',
    'response' => $response
);
$query = http_build_query($data);
$options = array(
    'http' => array(
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        "Content-Length: " . strlen($query) . "\r\n" .
            "User-Agent:MyAgent/1.0\r\n",
        'method' => 'POST',
        'content' => $query
    )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();


if ($captcha_success->success) {

    $usuario    =   $_POST['usuario'];
    $password   =   $_POST['password'];
    $cadena     =   $_POST['usuario'];
    $pos        =   strpos($cadena, '@');

    if ($pos === false) {   // NO ENCUENTRA @ EN EL USUARIO

        $tabla = mysqli_query($con, "SELECT * FROM usuarios WHERE nombre_usuario=\"" . mysqli_real_escape_string($con, $usuario) . "\"") or die("Error lectura de usuarios");

        if (mysqli_num_rows($tabla) > 0) {
            $registro = mysqli_fetch_array($tabla);
            $clave = $registro['password'];

            if (md5($password) == $clave) {
                $_SESSION['id_usuario']     = $registro['id_usuario'];
                $_SESSION['usuario']        = $registro['nombre_usuario'];
                $_SESSION['apellido']       = $registro['apellido'];
                $_SESSION['nombres']        = $registro['nombres'];
                $_SESSION['tipo_usuario']   = $registro['estado'];
            }
        }
    } else {                // ENCUENTRO @ EN EL USUARIO 

        $_SESSION['es_expediente']  = false;

        // PRIMERO ME FIJO EN NUEVO REGISTRADOS
        $tabla = mysqli_query($con, "SELECT * FROM solicitantes WHERE email=\"" . mysqli_real_escape_string($con, $usuario) . "\" AND dni = '$password'")
            or die("Error lectura de solicitantes");

        if (mysqli_num_rows($tabla) > 0) {

            $registro = mysqli_fetch_array($tabla);

            $_SESSION['id_usuario']     = $registro['id_solicitante'];
            $_SESSION['usuario']        = $registro['email'];
            $_SESSION['apellido']       = $registro['apellido'];
            $_SESSION['nombres']        = $registro['nombres'];
            $_SESSION['dni']            = $registro['dni'];
            $_SESSION['tipo_usuario']   = 'b';
        } else {

            // DESPUES ME FIJO EN LOS EXPEDIENTES
            $tabla = mysqli_query($con, "SELECT * FROM emprendedores WHERE email=\"" . mysqli_real_escape_string($con, $usuario) . "\" AND dni = '$password'")
                or die("Error lectura de emprendedores");

            if (mysqli_num_rows($tabla) > 0) {

                $registro = mysqli_fetch_array($tabla);

                $_SESSION['id_usuario']     = $registro['id_emprendedor'];

                $_SESSION['usuario']        = $registro['email'];
                $_SESSION['apellido']       = $registro['apellido'];
                $_SESSION['nombres']        = $registro['nombres'];
                $_SESSION['dni']            = $registro['dni'];
                $_SESSION['tipo_usuario']   = 'b';
                $_SESSION['es_expediente']  = true;
            }
        }
    }

    mysqli_close($con);

    if (isset($_SESSION['tipo_usuario'])) {

        if (!isset($_SESSION)) {

            ini_set('session.gc_maxlifetime', 3600); // EXTENDER A UNA HORA TIEMPO DE LA SESSION
            session_start();

            // each client should remember their session id for EXACTLY 24 hour
            session_set_cookie_params(60 * 60 * 24);
        }


        switch ($_SESSION['tipo_usuario']) {

            case ($_SESSION['tipo_usuario'] == 'a' || $_SESSION['tipo_usuario'] == 'c'): {
                    ///////////////// USUARIOS ADMINISTRATIVOS  ////////////////////////
                    header("location:/desarrolloemprendedor/expedientes/bienvenida_direccion.php");
                    break;
                }
            case 'b': {
                    /////////////////       SOLICITANTES        ////////////////////////
                    header("location:/desarrolloemprendedor/frontend/registro_edita.php?id_solicitante=" . $_SESSION['id_usuario']);
                    break;
                }
            case 'd': {
                    ///////////////// USUARIOS ASESORES         ///////////////////////
                    header("location:/desarrolloemprendedor/expedientes/bienvenida_direccion.php");
                    break;
                }
            case 'e': {
                    ///////////////// USUARIOS ASESORES         ///////////////////////
                    header("location:/desarrolloemprendedor/entidades/bienvenida_direccion.php");
                    break;
                }
            case 'f': {
                    ///////////////// USUARIOS ASESORES         ///////////////////////
                    header("location:/desarrolloemprendedor/expedientes/bienvenida_direccion.php");
                    break;
                }
        }
    } else {

        $mensaje     = "Credenciales incorrectas .";
        $enlace        = "<a href='javascript:history.go(-1);' class='btn btn-warning'> Regresar</a>";
        $clase        = 'class="alert alert-warning"';
    }
} else {

    $mensaje     = "Código <b>captcha erroneo / nulo </b>.";
    $enlace        = "<a href='javascript:history.go(-1);' class='btn btn-warning'> Regresar</a>";
    $clase        = 'class="alert alert-warning"';
}

?>


<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div <?php echo $clase; ?>>
                    <?php echo $mensaje; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <?php echo $enlace; ?>
            </div>
        </div>



    </div>

</div>


<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php';


?>