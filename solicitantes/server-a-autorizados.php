<?php

require_once '../accesorios/accesos_bd.php';
require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/mailer.php';

$con = conectar();

$id_solicitante     = $_POST['id_solicitante'];
$tabla_solicitantes = mysqli_query($con, "SELECT fecha_nac FROM solicitantes WHERE id_solicitante = $id_solicitante");
$registro           = mysqli_fetch_array($tabla_solicitantes);

$fecha_nac = $registro['fecha_nac'];
$fecha     = getEdadconMes($fecha_nac);
$edad      = $fecha->format('%Y');

// SI TIENE ENTRE 18 y 40 AÑOS
if(($edad >= 18) and ($edad < 41)) {

    $enviar = 0;
    $tabla    = mysqli_query($con, "SELECT * FROM habilitaciones WHERE id_solicitante = $id_solicitante AND id_programa = 1");
    
    if ($registro = mysqli_fetch_array($tabla)) {

        $habilitado = $registro['habilitado'];

        if ($habilitado == 0) {

            mysqli_query($con, "UPDATE habilitaciones SET habilitado = 1 WHERE id_solicitante = $id_solicitante AND id_programa = 1") or die('Ver habilitar');

            $enviar = 1;

        } else {

            mysqli_query($con, "UPDATE habilitaciones SET habilitado = 0 WHERE id_solicitante = $id_solicitante AND id_programa = 1") or die('Ver deshabilitar');
        }
    } else {

        mysqli_query($con, "INSERT INTO habilitaciones (id_solicitante, id_programa, habilitado) value ($id_solicitante, 1, 1)") or die('Ver insertar habilitacion');

        $enviar = 1;
    }

    print $enviar;

    // SI SE AUTORIZO LE ENVIO UN MAIL

    if ($enviar == 1) {

        // OBTENER DATOS DEL SOLICITANTE
        $tabla    = mysqli_query($con, "SELECT apellido, nombres, email FROM solicitantes WHERE id_solicitante = $id_solicitante");
        $registro = mysqli_fetch_array($tabla);
        $email    = $registro['email'];
        $nombres  = $registro['nombres'] . ', ' . $registro['apellido'];

        // OBTENER DATOS DEL PROGRAMA

        $titulo  = 'Programa Jovenes Emprendedores - Autorizacion -';
        $mensaje = '<br>' . $nombres . ' estas <b>habilitada/o</br> para cargar tu proyecto. Saludos <br>';
        $logo    = $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/public/imagenes/mail-inscripcion.jpeg';

        $envio = enviar($email, $titulo, $nombres, $mensaje, $logo);
    }

} else {

    // DESHABILITAR SOLICITANTE

    print $enviar = 3;

    mysqli_query($con, "UPDATE habilitaciones SET habilitado = 0 WHERE id_solicitante = $id_solicitante AND id_programa = 1") or die('Ver deshabilitar');
}
