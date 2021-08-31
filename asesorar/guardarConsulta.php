<?php

$response = $_POST['g-recaptcha-response'];
$url      = 'https://www.google.com/recaptcha/api/siteverify';
$data     = [
    'secret'   => '6LdxcnUUAAAAADI2DkqCkGZ1WAp4y8zzG9S2y-Ow',
    'response' => $response,
];
$query   = http_build_query($data);
$options = [
    'http' => [
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'Content-Length: ' . strlen($query) . "\r\n" .
            "User-Agent:MyAgent/1.0\r\n",
        'method'  => 'POST',
        'content' => $query,
    ],
];

$context         = stream_context_create($options);
$verify          = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

require_once $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php';

if ($captcha_success->success) {
    require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/mailer.php';

    $con = conectar();

    // LEO E INICIALIZO LOS DATOS DEL SOLICITANTES

    $dni                = $_POST['dni'];
    $apellido           = strtoupper(ltrim($_POST['apellido']));
    $nombres            = strtoupper(ltrim($_POST['nombres']));
    $genero             = 0;    // MUJER
    $otrogenero         = null;
    $direccion          = 'Complete';
    $fecha_nac          = '2000-01-01';
    $cuit               = $dni;
    $email              = strtolower($_POST['email']);
    $cod_area           = '000';
    $telefono           = $_POST['telefono'];
    $celular            = $telefono;
    $id_ciudad          = 2548; // PARANA
    $id_responsabilidad = 1;

    // DATOS INICIALIZADOS PARA EL EMPRENDEDOR

    $id_medio      = 6;                 // OTRO MEDIO
    $id_programa   = 5;                 // ASESORAMIENTO
    $id_rubro      = 30;                // AGROINDUSTRIA
    $id_empresa    = 0;                 // EMPRESA RESETEADA
    $id_entidad    = 0;                 // ENTIDAD RESETEADA
    $funciona      = 0;                 // NO FUNCIONA - TIENE QUE CARGAR DATOS DE LA EMPRESA
    $observaciones = 0;                 // NO TIENE OBSERVACIONES

    $select = mysqli_query($con, "SELECT id_solicitante FROM solicitantes WHERE dni = $dni");

    if (mysqli_num_rows($select) > 0) {

        $registro       = mysqli_fetch_array($select);
        $id_solicitante = $registro['id_solicitante'];
        
    } else {

        $inserta = "INSERT INTO solicitantes (dni, apellido, nombres, genero, otrogenero, direccion, fecha_nac, email, cuit, cod_area, telefono, celular, id_ciudad, observaciones, id_responsabilidad)
        VALUES ('$dni','$apellido','$nombres', $genero, '$otrogenero', '$direccion', '$fecha_nac', '$email', '$cuit', '$cod_area','$telefono','$celular',$id_ciudad,'1',1)";

        mysqli_query($con, $inserta) or die($inserta . 'Linea 71');

        $id_solicitante = mysqli_insert_id($con);
    }


    // REVISA DATOS EN EL REGISTRO DEL SOLICITANTE

    $select = mysqli_query(
        $con,

        "SELECT id_solicitante 
            FROM registro_solicitantes 
            WHERE id_solicitante = $id_solicitante AND id_programa = $id_programa"
    );

    if (mysqli_num_rows($select) == 0) {

        $inserta = "INSERT INTO registro_solicitantes (id_solicitante, id_rubro, id_medio, id_programa, observaciones, id_empresa, id_entidad) 
        VALUES ($id_solicitante, $id_rubro, $id_medio, $id_programa, '$observaciones', $id_empresa, $id_entidad)";

        mysqli_query($con, $inserta) or die($inserta . 'Linea 92');
    }

    $categoria          = $_POST['categoria'];

    // REVISA DATOS EN EL REGISTRO DE ASESORAR SEGUIMIENTO

    $select = mysqli_query(
        $con,

        "SELECT id_solicitante 
            FROM asesorar_seguimiento 
            WHERE id_solicitante = $id_solicitante AND categoria = $categoria"
    );

    if (mysqli_num_rows($select) == 0) {

        $inserta = "INSERT INTO asesorar_seguimiento (id_solicitante, categoria) VALUES ($id_solicitante, $categoria)";

        mysqli_query($con, $inserta) or die($inserta);
    }

    mysqli_close($con);

    $titulo  = 'correcto';
    $mensaje = "<h5><i class='far fa-edit'></i> " . $nombres . ' </h5> <br> Tu consulta  <b> ha sido enviada correctamente !</b>';
    $enlace  = '<a href="../index.php" class=" btn btn-info">Volver</a>';
    $clase   = 'class="alert alert-success"';

    $email   = 'dir.formacionemprendedora@gmail.com';
    $titulo  = 'Consulta del Programa Asesorar ';
    $mensaje = 'Hemos recibido tu consulta. Gracias ' . $nombres . ', ' . $apellido . '. <br> </br> ';
    $mensaje .= '<hr> <br>Saludos ';
    $logo = $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/public/imagenes/cabecera.png';

    //$envio = enviar($email, $titulo, $nombres, $mensaje, $logo);

} else {
    
    $titulo  = 'fallido';
    $mensaje = 'Ha ingresado un código captcha erroneo.';
    $enlace  = "<a href='javascript:history.go(-1);' class='btn btn-warning'> Regresar</a>";
    $clase   = 'class="alert alert-warning"';
}

?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <i class='icon fa fa-check'></i> Estado mensaje: <?php echo $titulo; ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-6  text-right">
                <?php echo $enlace; ?>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="form-group">
            <div class="row m-5">
                <div class="col-xs-12 mx-auto">
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row m-3">
                <div class="col-xs-12 mx-auto">
                    <div <?php echo $clase; ?>>
                        <?php echo $mensaje; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row m-5">
                <div class="col-xs-12 mx-auto">
                    &nbsp;
                </div>
            </div>
        </div>

    </div>

</div>


<?php

include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php';

include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php';