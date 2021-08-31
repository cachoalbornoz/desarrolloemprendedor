<?php
session_start();

require_once("../accesorios/accesos_bd.php");
require_once("../accesorios/mailer.php");

$con=conectar();

$id_usuario = $_SESSION['id_usuario'];
$sqle       = "SELECT id_entidad FROM rel_entidad_usuario WHERE id_usuario = $id_usuario";
$querye     = mysqli_query($con, $sqle);
$rowe       = mysqli_fetch_array($querye);
$id_entidad = $rowe['id_entidad'];


$id_solicitante = $_POST['id_solicitante'];

$tabla 		    = mysqli_query($con,"SELECT * FROM registro_solicitantes WHERE id_solicitante = $id_solicitante AND id_programa = 1 AND id_entidad = $id_entidad");
$registro	    = mysqli_fetch_array($tabla);

if($registro){

    if($registro['verificado_e'] == 0){

        mysqli_query($con,"UPDATE registro_solicitantes SET verificado_e = 1 WHERE id_solicitante = $id_solicitante AND id_programa = 1 AND id_entidad = $id_entidad") or die ('Ver habilitar');

        $enviar = 1;

    }else{

        mysqli_query($con,"UPDATE registro_solicitantes SET verificado_e = 0 WHERE id_solicitante = $id_solicitante AND id_programa = 1 AND id_entidad = $id_entidad") or die ('Ver deshabilitar');
    }    
}

echo $enviar;

?>