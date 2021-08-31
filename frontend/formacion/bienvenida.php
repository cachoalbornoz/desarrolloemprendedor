<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-superior.php';
require $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php';
$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>

<div class="card">
    <div class="card-header text-white" style=" background-color: #9968bc">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
                Programa Formación
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <p>Inscribite en el curso que más se ajuste a tu necesidad </p>
            </div>
        </div>

        <?php

        $contador = 1;
        $tabla_cursos = mysqli_query($con, 'SELECT * FROM formacion_cursos WHERE activo = 1 ORDER BY fechaRealizacion asc');
        while ($fila = mysqli_fetch_array($tabla_cursos)) {
            ?>
        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table table-condensed table-hover table-bordered" id="cursos">
                    <tr class=" bg-secondary text-white">
                        <td class="w-25">
                            Nombre curso
                        </td>
                        <td class="text-center">
                            <?php echo strtoupper($fila['nombre']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Hora
                        </td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($fila['fechaRealizacion'])); ?>
                            <?php echo $fila['hora'].' Hs.'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Lugar
                        </td>
                        <td>
                            <?php echo $fila['lugar']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Reseña
                        </td>
                        <td>
                            <?php echo $fila['resenia']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Destinatarios
                        </td>
                        <td>
                            <?php echo $fila['destinatarios']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right bg-secondary text-white">

                            <?php

                            $id_curso = $fila['id'];

            $registro = mysqli_query($con, "SELECT id FROM rel_solicitante_curso WHERE id_solicitante = $id_solicitante AND id_curso = $id_curso") or die('Revisar formaciones');

            if (mysqli_fetch_array($registro)) {
                $checked = 'checked';
            } else {
                $checked = null;
            } ?>
                            <label for="<?php echo $fila['id']; ?>">
                                <input type="checkbox" id="<?php echo $fila['id']; ?>" <?php echo $checked; ?>
                                    onclick="inscribirse(this)"> Inscribirme en éste curso
                            </label>
                        </td>
                    </tr>
                </table>


            </div>
        </div>
        <?php
        }

        ?>

        <div class="row mb-3">
            <div class="col-xs-12 col-md-12 col-lg-12">

            </div>
        </div>

        <div class="row mb-3 text-center">
            <div class="col-xs-12 col-md-12 col-lg-12">

            </div>
        </div>


        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class=" table table-dark table-striped table-hover" id="inscriptos">
                    <tr style="background-color:#9968bc">
                        <td>
                            <img src="/desarrolloemprendedor/public/imagenes/formacion-chica.png"
                                class="rounded w-25" />
                        </td>
                        <td class="text-center align-middle w-25">
                            Indicanos el tema que te interesa
                        </td>
                    </tr>

                    <?php
                    $contador = 1;
                    $tabla_cursos = mysqli_query($con, 'SELECT * FROM tipo_formacion WHERE activo = 1');
                    while ($fila = mysqli_fetch_array($tabla_cursos)) {
                        ?>
                    <tr>
                        <td>
                            <?php echo $contador.') '.$fila['formacion']; ?>
                        </td>
                        <td class="text-center align-middle w-25">
                            <?php

                                $id_formacion = $fila['id'];

                        $registro = mysqli_query($con, "SELECT id
                                FROM rel_solicitante_formacion 
                                WHERE id_solicitante = $id_solicitante AND id_formacion = $id_formacion") or die('Revisar formaciones');

                        if (mysqli_fetch_array($registro)) {
                            $checked = 'checked';
                        } else {
                            $checked = null;
                        } ?>
                            <input class="form-check-input inscripto" type="checkbox" id="<?php echo $fila['id']; ?>"
                                <?php echo $checked; ?>>
                        </td>
                    </tr>
                    <?php
                    ++$contador;
                    }
                    ?>

                </table>

            </div>

        </div>

    </div>
</div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-scripts.php';
?>

<script>
function inscribirse(objeto) {

    var id_curso = objeto.id;
    var inscripto = 0;

    if ($(objeto).prop("checked") == true) {

        toastr.options = {
            "progressBar": true,
            "showDuration": "500",
            "timeOut": "1000"
        };
        toastr.info("&nbsp;", "Te has registrado para éste curso ! ");

        inscripto = 1;

    } else {

        toastr.options = {
            "progressBar": true,
            "showDuration": "500",
            "timeOut": "1000"
        };
        toastr.warning("&nbsp;", "Hemos registrado ésta novedad ! ");
    }

    $.ajax({

        url: 'server-actualizaCursado.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id_curso: id_curso,
            inscripto: inscripto
        },
        success: function(data) {

            console.log(data);
        }
    });

};


$('#inscriptos').on("click", ".inscripto", function() {

    var id_formacion = this.id;
    var inscribir = 0;

    if ($(this).prop("checked") == true) {

        toastr.options = {
            "progressBar": true,
            "showDuration": "500",
            "timeOut": "1000"
        };
        toastr.info("&nbsp;", "Te agendamos en éste tema ");

        inscribir = 1;

    }

    $.ajax({

        url: 'server-inscripto.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id_formacion: id_formacion,
            inscribir: inscribir
        },
        success: function(data) {

            console.log(data);
        }
    });

});
</script>


<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-inferior.php';