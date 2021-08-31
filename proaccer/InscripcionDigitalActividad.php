<?php
require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$con = conectar();

$id_encuestador          = $_GET['id_encuestador'];
$id_solicitante          = $_GET['id_solicitante'];

$tabla_solcitantes      = mysqli_query($con, "SELECT * FROM solicitantes WHERE id_solicitante = $id_solicitante");
$registro_solicitantes    = mysqli_fetch_array($tabla_solcitantes);

$dni                    = $registro_solicitantes['dni'];
$apellido               = $registro_solicitantes['apellido'];
$nombres                = $registro_solicitantes['nombres'];

// LEER RUBRO PRODUCTIVO

$tabla_registro      = mysqli_query($con, "SELECT id_rubro, id_empresa FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");
$registro_registros    = mysqli_fetch_array($tabla_registro);
$id_rubro              = $registro_registros['id_rubro'];
$id_empresa            = $registro_registros['id_empresa'];

mysqli_query($con, "UPDATE proaccer_inscripcion SET id_rubro = $id_rubro, id_empresa = $id_empresa WHERE id_solicitante = $id_solicitante");

// INICIA LAS VARIABLES

$prodserv1                 = NULL;
$prodserv2                 = NULL;
$prodserv3                 = NULL;
$cantserv1                 = NULL;
$cantserv2                 = NULL;
$cantserv3                 = NULL;
$detalleproducto         = NULL;
$vendeafueraprovincia     = 0;
$lugarfueraprovincia     = '';
$productovende             = 1;
$comer_directo             = 1;
$comer_intermediario    = NULL;
$comer_otra                = NULL;
$otraformacomercializacion = NULL;
$esexportable            = 0;
$deseaexportar            = 0;
$paisexporta              = '';
$productoexporta         = 0;

// LEE INFORMACION DE INSCRIPCION
$query_inscripcion = mysqli_query($con, "SELECT * FROM proaccer_inscripcion WHERE id_solicitante = $id_solicitante");
$registro_inscrip  = mysqli_fetch_array($query_inscripcion);

if (isset($registro_inscrip)) {

    $prodserv1                 = $registro_inscrip['prodserv1'];
    $prodserv2                 = $registro_inscrip['prodserv2'];
    $prodserv3                 = $registro_inscrip['prodserv3'];
    $cantserv1                 = $registro_inscrip['cantserv1'];
    $cantserv2                 = $registro_inscrip['cantserv2'];
    $cantserv3                 = $registro_inscrip['cantserv3'];
    $detalleproducto         = $registro_inscrip['detalleproducto'];
    $vendeafueraprovincia     = $registro_inscrip['vendeafueraprovincia'];
    $lugarfueraprovincia     = $registro_inscrip['lugarfueraprovincia'];
    $productovende             = $registro_inscrip['productovende'];
    $comer_directo             = $registro_inscrip['comer_directo'];
    $comer_intermediario     = $registro_inscrip['comer_intermediario'];
    $comer_otra             = $registro_inscrip['comer_otra'];
    $otraformacomercializacion = $registro_inscrip['otraformacomercializacion'];
    $esexportable            = $registro_inscrip['esexportable'];
    $deseaexportar            = $registro_inscrip['deseaexportar'];
    $paisexporta              = $registro_inscrip['paisexporta'];
    $productoexporta         = $registro_inscrip['productoexporta'];
}

require_once('../accesorios/admin-scripts.php');

?>

<form action="editar_inscripcion_proaccer.php" method="post" name="solicitantes" id="solicitantes" class="form-horizontal" onsubmit="return chequear();">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-9">
                    FORMULARIO DE INSCRIPCION DIGITAL - <b>PROACCER</b>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-3 text-right">
                    <?php
                    if (isset($_GET['actualizado'])) { ?>
                    <a href="InscripcionProaccer.php" class="btn btn-info">
                        Finalizar
                    </a>

                    <a href="InscripcionDigitalImpresion.php?id_solicitante=<?php echo $id_solicitante ?>" class="btn btn-info">
                        <i class="fas fa-print"></i> Formulario
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="form-group">
                        <input id="id_solicitante" name="id_solicitante" type="hidden" value="<?php echo $id_solicitante ?>">
                        <input id="id_encuest" name="id_encuestador" type="hidden" value="<?php echo $id_encuestador ?>">
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            CORRESPONDE A
                            <label><?php echo $apellido . ', ' . $nombres ?> </label> DNI <b><?php echo $dni; ?> </b>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-lg-12">
                            <table class="table table-condensed borderless">
                                <tr class="bg-secondary text-white">
                                    <td colspan="3">
                                        <b>Producción</b> - Productos / Cantidades / Detalles
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Producto / Servicio 1 <input type="text" id="prodserv1" name="prodserv1" class="form-control" value="<?php echo $prodserv1 ?>" required autofocus>
                                    </td>
                                    <td>
                                        Producto / Servicio 2 <input type="text" id="prodserv2" name="prodserv2" class="form-control" value="<?php echo $prodserv2 ?>">
                                    </td>
                                    <td>
                                        Producto / Servicio 3 <input type="text" id="prodserv3" name="prodserv3" class="form-control" value="<?php echo $prodserv3 ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Cantidad / Servicio 1 <input type="text" id="cantserv1" name="cantserv1" class="form-control" value="<?php echo $cantserv1 ?>" required>
                                    </td>
                                    <td>
                                        Cantidad / Servicio 2 <input type="text" id="cantserv2" name="cantserv2" class="form-control" value="<?php echo $cantserv2 ?>">
                                    </td>
                                    <td>
                                        Cantidad / Servicio 3 <input type="text" id="cantserv3" name="cantserv3" class="form-control" value="<?php echo $cantserv3 ?>">
                                    </td>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td colspan="3">
                                        <label>Producto a exponer en ferias / eventos. Detalle</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input id="detalleproducto" name="detalleproducto" placeholder="Ingrese detalle relevantes" value="<?php echo $detalleproducto ?>" maxlength="400" class="form-control" required="required">
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-condensed mt-5">
                                <tr class="bg-secondary text-white">
                                    <td>
                                        Comercio Interno
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Vende su producto y/o servicio a otras provincias ?</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio">
                                            <input type="radio" name="vendeafueraprovincia" value="0" onclick="hide_vendefueraprovincia()" <?php if ($vendeafueraprovincia == 0) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>> No
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="vendeafueraprovincia" value="1" onclick="show_vendefueraprovincia()" <?php if ($vendeafueraprovincia == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>> Si
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="div_vendefueraprovincia" <?php if ($vendeafueraprovincia == 0) {
                                                                                echo 'class="d-none"';
                                                                            } ?>>
                                            <label>Mencione ciudad y provincia </label> <input class="form-control" name="lugarfueraprovincia" id="lugarfueraprovincia" value="<?php echo $lugarfueraprovincia ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Producto que comercializa </label>
                                        <select id="productovende" name="productovende" class="form-control">
                                            <option value="1" <?php if ($productovende == 1) {
                                                                    echo 'selected';
                                                                } ?>>Producto 1</option>
                                            <option value="2" <?php if ($productovende == 2) {
                                                                    echo 'selected';
                                                                } ?>>Producto 2</option>
                                            <option value="3" <?php if ($productovende == 3) {
                                                                    echo 'selected';
                                                                } ?>>Producto 3</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>¿Por qué medios comercializa su producción?</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="formacomercializacion[]" value="1" <?php if ($comer_directo == 1) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Venta Directa
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="formacomercializacion[]" value="2" <?php if ($comer_intermediario == 1) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Con Intermediarios
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="formacomercializacion[]" value="3" <?php if ($comer_otra == 1) {
                                                                                                            echo 'checked';
                                                                                                        } ?> onclick="show_otraformacomercializacion(this)"> Otra

                                        <div id="div_otraformacomercializacion" <?php if ($comer_otra == 0) {
                                                                                    echo 'class="d-none"';
                                                                                } ?>>
                                            <label>Cuál</label>
                                            <input type="text" class="form-control" name="otraformacomercializacion" id="otraformacomercializacion" value="<?php echo $otraformacomercializacion ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Comercio Externo</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Es un producto Exportable ?
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="esexportable" value="0" <?php if ($esexportable == 0) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> No</label>
                                        <label class="radio-inline"><input type="radio" name="esexportable" value="1" <?php if ($esexportable == 1) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> Si</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Tiene deseos de exportarlo?
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="0" <?php if ($deseaexportar == 0) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> No</label>
                                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="1" <?php if ($deseaexportar == 1) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> Si</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Pais que exporta</label>
                                        <input type="text" class="form-control" name="paisexporta" id="paisexporta" value="<?php echo $paisexporta ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Producto que exporta </label>
                                        <select id="productoexporta" name="productoexporta" class="form-control">
                                            <option value="0" <?php if ($productoexporta == 0) {
                                                                    echo 'checked';
                                                                } ?>>Ninguno</option>
                                            <option value="1" <?php if ($productoexporta == 1) {
                                                                    echo 'checked';
                                                                } ?>>Producto 1</option>
                                            <option value="2" <?php if ($productoexporta == 2) {
                                                                    echo 'checked';
                                                                } ?>>Producto 2</option>
                                            <option value="3" <?php if ($productoexporta == 3) {
                                                                    echo 'checked';
                                                                } ?>>Producto 3</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <div class="form-group text-right">
                <div class="col-lg-12">
                    <input type="submit" value="Guardar" class="btn btn-info">
                </div>
            </div>
        </li>
    </ul>

</form>


<script>
function show_vendefueraprovincia() {
    $("#div_vendefueraprovincia").show();
}

function hide_vendefueraprovincia() {
    $("#div_vendefueraprovincia").hide();
}

function show_otraformacomercializacion(objeto) {

    if ($(objeto).is(':checked')) {
        $('#div_otraformacomercializacion').removeClass('d-none');
    } else {
        $('#div_otraformacomercializacion').addClass('d-none');
    }
}


function chequear() {
    var valido = true;

    if (($("input[name*='formacomercializacion']:checked").length) <= 0) {
        $("input[name*='formacomercializacion']")[0].focus();
        alert("¿Por que medios comercializa sus productos ? ");
        valido = false;
    }

    if (valido) {
        return true;
    } else {
        return false;
    }
}
</script>

<?php
mysqli_close($con);
require_once('../accesorios/admin-inferior.php');