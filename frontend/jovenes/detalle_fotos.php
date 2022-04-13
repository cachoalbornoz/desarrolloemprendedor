<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';
$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];
$id_proyecto    = $_SESSION['id_proyecto'];

$mensaje   = '';
$error     = false;
$extension = '';

if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
    print $name  = $_FILES['file']['name'];
    print $error = $_FILES['file']['error'];
    print $size  = $_FILES['file']['size'];
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['size'] > 3000000) {
        $error   = true;
        $mensaje = 'Archivo demasiado grande';
    } else {
        switch ($_FILES['file']['type']) {
            case 'image/jpeg':
                $extension = 'jpeg';
                break;
            case 'image/jpg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
        }
    }
}

if (isset($_FILES['file']) && !$error) {
    $nombre = $id_proyecto . '_foto1.' . $extension;
    array_map('unlink', glob("fotos/$id_proyecto*"));
    move_uploaded_file($_FILES['file']['tmp_name'], 'fotos/' . $nombre);

    $tabla_fotos = mysqli_query($con, "SELECT * FROM rel_proyectos_fotos WHERE id_proyecto = $id_proyecto");
    if ($registro_fotos = mysqli_fetch_array($tabla_fotos)) {
        // Actualiza foto
        mysqli_query($con, "UPDATE rel_proyectos_fotos set foto1 = '$nombre' WHERE id_proyecto = $id_proyecto ");
    } else {
        // Subir la nueva foto
        mysqli_query($con, "INSERT INTO rel_proyectos_fotos (id_proyecto, foto1) VALUES  ($id_proyecto, '$nombre') ");
    }
}

if (isset($_POST['operacion']) && $_POST['operacion'] == 2) {
    mysqli_query($con, "DELETE FROM rel_proyectos_fotos WHERE id_proyecto = $id_proyecto");
}

// Fotos del Proyecto
$foto1       = null;
$tabla_fotos = mysqli_query($con, "SELECT * FROM rel_proyectos_fotos WHERE id_proyecto = $id_proyecto");

if ($registro_fotos = mysqli_fetch_array($tabla_fotos)) {
    $foto1 = $registro_fotos['foto1'];
}

mysqli_close($con);

if (is_null($foto1)) {
    ?>

<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3 text-center">
        <img src="/desarrolloemprendedor/frontend/jovenes/fotos/no-disponible.png" alt="" height="500" width="500">
    </div>
</div>

<?php
} else {
        ?>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6">
        <img src="/desarrolloemprendedor/frontend/jovenes/fotos/<?php print $foto1; ?>" alt="" class=" img-fluid" height="500" width="500">
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 ">
        <a href="javascript:quitarFoto()">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</div>
<?php
    }
