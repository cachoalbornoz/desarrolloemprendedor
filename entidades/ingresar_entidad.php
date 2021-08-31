<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$entidad    = strtoupper(ltrim($_POST['entidad']));
$url        = $_POST['url'];
$archivo    = $_FILES['foto']['name'];

if($_FILES['foto']['size'] > 0){

    if(move_uploaded_file($_FILES['foto']['tmp_name'],"image/".$archivo)){            
        chmod("image/".$_FILES['foto']['name'],0777);          
    }
}

mysqli_query($con, "INSERT INTO maestro_entidades (entidad, url, foto) VALUES ('$entidad', '$url', '$archivo')") or die("Error inserc entidades");

$id_entidad = mysqli_insert_id($con);

$usuario    = 'e'.date('Y',time()).$id_entidad;
$apellido   = 'A-'.$id_entidad;
$nombres    = 'N-'.$id_entidad;
$clave      = 'emprendedor'.$id_entidad;
$password   = md5($clave);
$tipo       = 'e';

$query      = "INSERT INTO usuarios (nombre_usuario, apellido, nombres, password, clave, estado)
VALUES ('$usuario','$apellido','$nombres','$password', '$clave', '$tipo')";

mysqli_query($con, $query) or die ('Revisar alta usuarios');

$id_usuario = mysqli_insert_id($con);

mysqli_query($con, "INSERT INTO rel_entidad_usuario (id_entidad, id_usuario) VALUES ($id_entidad, $id_usuario)")
or die ('Revisar relacion entidad - usuarios');


mysqli_close($con);

header("location:padron_entidades.php");

?>
