<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once "../accesorios/accesos_bd.php";

$con = conectar();

if (isset($_GET['id_seguimiento'])) {
    $id_seguimiento = $_GET['id_seguimiento'];
}

$id_usuario               = $_SESSION['id_usuario'];
$id_solicitante           = $_POST['id_solicitante'];
$porqueabandono           = $_POST['porqueabandono'];
$funciona                 = $_POST['funciona'];
$volverafuncionar         = $_POST['volverafuncionar'];
$productoproducido        = $_POST['productoproducido'];
$cantidadproducida        = $_POST['cantidadproducida'];
$mercado                  = $_POST['mercado'];
$comprador                = $_POST['comprador'];
$comercializacion         = $_POST['comercializacion'];
$otracomercializacion     = $_POST['otracomercializacion'];
$interesexportar          = $_POST['interesexportar'];
$porqueexportar           = $_POST['porqueexportar'];
$conocerequisitosexportar = $_POST['conocerequisitosexportar'];
$capacitarseexportar      = $_POST['capacitarseexportar'];
$cuantosempleados         = $_POST['cuantosempleados'];
$cuantosfamiliares        = $_POST['cuantosfamiliares'];
$cuantosinscriptas        = $_POST['cuantosinscriptas'];
$porquenoregistrado       = $_POST['porquenoregistrado'];
$necesitacapacitacion     = $_POST['necesitacapacitacion'];
$id_forma_juridica        = $_POST['id_forma_juridica'];
$id_programa              = $_POST['id_programa'];

//

$seleccion_proyectos = mysqli_query($con, "SELECT id_seguimiento FROM seguimiento_proyectos WHERE id_solicitante = $id_solicitante");

if (mysqli_num_rows($seleccion_proyectos) == 0) {
    $inserta = "INSERT INTO seguimiento_proyectos
    (id_usuario,id_solicitante,funciona,porqueabandono,volverafuncionar,productoproducido,cantidadproducida,mercado,comprador,comercializacion,
    otracomercializacion,interesexportar,porqueexportar,conocerequisitosexportar,capacitarseexportar,cuantosempleados,cuantosfamiliares,cuantosinscriptas,
    porquenoregistrado,necesitacapacitacion,id_forma_juridica, id_programa)
    VALUES
    ($id_usuario,$id_solicitante,$funciona,'$porqueabandono',$volverafuncionar,'$productoproducido','$cantidadproducida','$mercado','$comprador',$comercializacion,
    '$otracomercializacion',$interesexportar,'$porqueexportar',$conocerequisitosexportar,$capacitarseexportar,$cuantosempleados,
     $cuantosfamiliares,$cuantosinscriptas,'$porquenoregistrado','$necesitacapacitacion',$id_forma_juridica, $id_programa )";

    mysqli_query($con, $inserta) or die($inserta);

    $id_seguimiento = mysqli_insert_id($con);
} else {
    $registro_proyectos = mysqli_fetch_array($seleccion_proyectos);
    $id_seguimiento     = $registro_proyectos[0];

    $update = "UPDATE seguimiento_proyectos
    SET id_usuario = $id_usuario, funciona = $funciona, porqueabandono = '$porqueabandono',volverafuncionar = $volverafuncionar,productoproducido = '$productoproducido',
    cantidadproducida = '$cantidadproducida',mercado = '$mercado',comprador = '$comprador',comercializacion = $comercializacion,
    otracomercializacion = '$otracomercializacion',interesexportar = $interesexportar,porqueexportar = '$porqueexportar',conocerequisitosexportar = $conocerequisitosexportar,
    capacitarseexportar = $capacitarseexportar,cuantosempleados = $cuantosempleados,cuantosfamiliares = $cuantosfamiliares,cuantosinscriptas = $cuantosinscriptas,
    porquenoregistrado = '$porquenoregistrado',necesitacapacitacion = '$necesitacapacitacion',id_forma_juridica = $id_forma_juridica, id_programa = $id_programa
    WHERE id_solicitante = $id_solicitante";

    mysqli_query($con, $update) or die($update);
}

mysqli_close($con);

header("Location:editar_seguimiento.php?id=$id_seguimiento");
