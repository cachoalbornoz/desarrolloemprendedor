<?php

require_once("../accesorios/accesos_bd.php");
require_once("../accesorios/mailer.php");

$con=conectar();

$id_solicitante = $_POST['id_solicitante'];

$tabla 		    = mysqli_query($con,"SELECT * FROM habilitaciones WHERE id_solicitante = $id_solicitante AND id_programa = 2");
$registro	    = mysqli_fetch_array($tabla);

$enviar         = 0;


if($registro){

    $habilitado = $registro['habilitado'];

    if($habilitado == 0){

        mysqli_query($con,"UPDATE habilitaciones SET habilitado = 1 WHERE id_solicitante = $id_solicitante AND id_programa = 2") or die ('Ver habilitar');

        $enviar = 1;

    }else{

        mysqli_query($con,"UPDATE habilitaciones SET habilitado = 0 WHERE id_solicitante = $id_solicitante AND id_programa = 2") or die ('Ver deshabilitar');
    }    

}else{

    mysqli_query($con,"INSERT INTO habilitaciones (id_solicitante, id_programa, habilitado) value ($id_solicitante, 2, 1)") or die ('Ver insertar habilitacion');

    $enviar = 1;
}

// SI SE AUTORIZO LE ENVIO UN MAIL

if($enviar == 1){

    // OBTENER DATOS DEL SOLICITANTE
    $tabla 		= mysqli_query($con,"SELECT apellido, nombres, email FROM solicitantes WHERE id_solicitante = $id_solicitante") or die ('Ver seleccion solicitantes');
    $registro	= mysqli_fetch_array($tabla);
    $email		= $registro['email'];
    $nombres	= $registro['nombres'] .' '. $registro['apellido'];

    // OBTENER DATOS DEL PROGRAMA
    $tabla 		= mysqli_query($con,"SELECT programa FROM tipo_programas WHERE id_programa = 1") or die ('Ver seleccion programas');
    $registro	= mysqli_fetch_array($tabla);
    $programa 	= $registro['programa'];

    $titulo 	= $programa.' - Autorización -';
    $mensaje	= '';
    $logo		= '../public/imagenes/mail.jpg';

    $envio      = enviar($email, $titulo, $nombres, $mensaje, $logo);

}

echo $enviar;

?>