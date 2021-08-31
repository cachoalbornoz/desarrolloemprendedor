<?php 

require_once('../accesorios/conexion.php');

$con=conectar();

$id_entidad = $_POST['id_entidad'];
$entidad    = trim(strtoupper($_POST['entidad']));
$url        = $_POST['url'];

if($_FILES['foto']['size'] > 0){

    $archivo    = $_FILES['foto']['name'];

    // BORRAR IMAGEN VIEJA SI HABIA             

    $registro   = $con->query("SELECT foto FROM maestro_entidades WHERE id_entidad = $id_entidad") or die ('Ver seleccion foto vieja'); 
    $fila       = $registro->fetch_array();

    if(strlen($fila['foto']) > 0){

        $imagenVieja  = $fila['foto'];

        if (file_exists("image/".$imagenVieja)) {
            unlink("image/".$imagenVieja); 
        }

    } 

    if(move_uploaded_file($_FILES['foto']['tmp_name'],"image/".$archivo)){            
        chmod("image/".$_FILES['foto']['name'],0777);          
        $con->query("UPDATE maestro_entidades SET foto = '$archivo' WHERE id_entidad = $id_entidad") or die ('Ver ingreso de Foto ');
    }
}



$con->query("UPDATE maestro_entidades SET entidad = '$entidad', url = '$url' WHERE id_entidad = $id_entidad");

mysqli_close($con);


header('Location: padron_entidades.php');

?>