<?php
require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$id_usuario = $_SESSION['id_usuario'];
$con = conectar();


$id_seguimiento = $_GET['id'];

// OBTENER DATOS SEGUIMIENTO
$seleccion =
    "SELECT apellido, nombres, segui.*, forma, dni, segui.id_seguimiento, soli.id_solicitante
    FROM seguimiento_proyectos segui
    INNER JOIN solicitantes soli ON segui.id_solicitante = soli.id_solicitante
    LEFT JOIN tipo_forma_juridica fj ON segui.id_forma_juridica = fj.id_forma
    WHERE id_seguimiento = $id_seguimiento
    ORDER BY apellido, nombres";

$tabla          = mysqli_query($con, $seleccion);
$fila           = mysqli_fetch_array($tabla);
$id_solicitante = $fila['id_solicitante'];

$id_programa    = $fila['id_programa'];

// SELECCIONAR RESEÑA    
$tabla_resena   = mysqli_query($con, "SELECT observaciones FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");
$registro_res   = mysqli_fetch_array($tabla_resena);

if ($registro_res) {
    $resenia =  $registro_res['observaciones'];
} else {
    $resenia = '';
}



?>

<div class="card">

    <div class="card-header">
        <div class="row mb-4">
            <div class="col-xs-12 col-sm-10 col-lg-10">
                RELEVAMIENTO ON-LINE <b>PROYECTOS AUTOGESTIONADOS</b>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2">
                <input type="text" id="id_seguimiento" name="id_seguimiento" class="form-control text-center" readonly value="<?php echo $id_seguimiento ?>">
            </div>
        </div>
    </div>

    <div class="card-body">
        <form id="relevamiento" method="post" action="agregar_seguimiento_ol_nuevo.php">

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5 for="id_expediente">Proyecto Jóvenes Emprendedor</h5>
                    <select id="id_solicitante" name="id_solicitante" class="form-control">
                        <option value="<?php echo $fila['id_solicitante'] ?>" selected><?php echo $fila['apellido'] . ', ' . $fila['nombres'] ?></option>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5 for="resenia">Reseña </h5>
                    <div id="resenia" class=" text-justify alert alert-dismissable alert-secondary">
                        <?php echo $resenia ?>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="expedientes">Otros Datos - DNI asociado a creditos anteriores </label>
                    <div id="expedientes">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <br>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>Situación Actual</h5>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    <h6>Está funcionando su proyecto ? </h6>
                    <select id="funciona" name="funciona" class="form-control" onChange="ver_funcionamiento()">
                        <option value="1" <?php echo ($fila[8] == 1) ? "selected" : ""; ?>>SI</option>
                        <option value="0" <?php echo ($fila[8] == 0) ? "selected" : ""; ?>>NO</option>
                    </select>
                </div>
            </div>

            <div class="card card-body mt-4 mb-4" id="div_abandona" <?php if ($fila[8] == 1) {
                                                                        echo 'style="display:none"';
                                                                    } ?>>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="porqueabandono">Comente porqué no comenzó el mismo ?</label>
                        <input type="text" id="porqueabandono" name="porqueabandono" class="form-control" value="<?php echo $fila[9] ?>">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="hidden" id="volverafuncionar" name="volverafuncionar" value="<?php echo $fila[10] ?>">
                    </div>
                </div>
            </div>

            <div class="card card-body mt-4 mb-4" id="div_continua" <?php if ($fila[8] == 0) {
                                                                        echo 'style="display:none"';
                                                                    } ?>>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Producción</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="productoproducido">Producto producido </label>
                        <input type="text" id="productoproducido" name="productoproducido" class="form-control" placeholder="Producto/Servicio creado?" value=" <?php echo $fila['productoproducido']  ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="cantidadproducida">Cantidad producida </label>
                        <input type="text" id="cantidadproducida" name="cantidadproducida" class="form-control" placeholder="cantidad producida" value=" <?php echo $fila['cantidadproducida']  ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Comercialización</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="mercado">Mercado donde ubica su producción (Local, regional, provincial, nacional)</label>
                        <input type="text" id="mercado" name="mercado" class="form-control" placeholder="MERCADO donde ubica su producción (Local, regional, provincial, nacional)" value=" <?php echo $fila['mercado']  ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="comprador">Principal comprador</label>
                        <input type="text" id="comprador" name="comprador" class="form-control" placeholder="PRINCIPAL COMPRADOR?" value=" <?php echo $fila['comprador']  ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <label for="comprador">Forma de comercializacion</label>
                        <select id="comercializacion" name="comercializacion" class="form-control" onChange="ver_comercializacion()">
                            <option value="-1">Seleccione</option>
                            <option value="0" <?php echo ($fila[15] == 0) ? "selected" : ""; ?>>Directa </option>
                            <option value="1" <?php echo ($fila[15] == 1) ? "selected" : ""; ?>>Indirecta </option>
                            <option value="2" <?php echo ($fila[15] == 2) ? "selected" : ""; ?>>Otra </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div id="div_comercializacion" style="display:none">
                            <label for="otracomercializacion">Otra forma de comercializacion</label>
                            <input type="text" id="otracomercializacion" name="otracomercializacion" class="form-control" placeholder="Otro tipo comercialización" value="<?php echo $fila[16] ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <label for="interesexportar">Tiene interes en Exportar</label>
                        <select id="interesexportar" name="interesexportar" class="form-control">
                            <option value="-1">Seleccione</option>
                            <option value="0" <?php echo ($fila[17] == 0) ? "selected" : ""; ?>>No </option>
                            <option value="1" <?php echo ($fila[17] == 1) ? "selected" : ""; ?>>Si </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label for="porqueexportar">Porqué no tiene interés en Exportar ?</label>
                        <input type="text" id="porqueexportar" name="porqueexportar" class="form-control" placeholder="Porqué no desea Exportar?" <?php echo $fila[18] ?>>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <label for="conocerequisitosexportar">Conoce requisitos para Exportar ?</label>
                        <select id="conocerequisitosexportar" name="conocerequisitosexportar" class="form-control">
                            <option value="-1">Seleccione</option>
                            <option value="0" <?php echo ($fila[20] == 0) ? "selected" : ""; ?>>NO </option>
                            <option value="1" <?php echo ($fila[20] == 1) ? "selected" : ""; ?>>SI </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <label for="capacitarseexportar">Desea capacitarse para Exportar ?</label>
                        <select id="capacitarseexportar" name="capacitarseexportar" class="form-control">
                            <option value="0" <?php echo ($fila[21] == 0) ? "selected" : ""; ?>>NO </option>
                            <option value="1" <?php echo ($fila[21] == 1) ? "selected" : ""; ?>>SI </option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Empleo</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="cuantosempleados">Cuantos empleados posee ?</label>
                        <select id="cuantosempleados" name="cuantosempleados" class="form-control">

                            <?php
                            $i = 0;
                            while ($i <= 20) {
                                if ($fila[21] == $i) {

                                    echo '<option value=' . $i . ' selected >' . $i . '</option>';
                                } else {

                                    echo '<option value=' . $i . '>' . $i . '</option>';
                                }
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="cuantosfamiliares">Cuántos empleados pertenecen a sus familia?</label>
                        <select id="cuantosfamiliares" name="cuantosfamiliares" class="form-control">

                            <?php
                            $i = 0;
                            while ($i <= 20) {
                                if ($fila[22] == $i) {

                                    echo '<option value=' . $i . ' selected >' . $i . '</option>';
                                } else {

                                    echo '<option value=' . $i . '>' . $i . '</option>';
                                }
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label for="cuantosinscriptas">Cuántos empleados están inscriptas en Relación de Dependencia?</label>
                        <select id="cuantosinscriptas" name="cuantosinscriptas" class="form-control" onChange="ver_trabajo(this.value)">

                            <?php

                            $i = 0;
                            while ($i <= 20) {
                                if ($fila[23] == $i) {

                                    echo '<option value=' . $i . ' selected >' . $i . '</option>';
                                } else {

                                    echo '<option value=' . $i . '>' . $i . '</option>';
                                }
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div id="div_trabajo" style="display:none">
                            <input type="text" id="porquenoregistrado" name="porquenoregistrado" class="form-control" placeholder="Porqué motivo no posee personal registrado ?" value="<?php echo $fila[24] ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Capacitación / Asesoramiento</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="necesitacapacitacion" name="necesitacapacitacion" class="form-control" placeholder="Cree que necesita CAPACITACION o ASESORAMIENTO en algún area o tema particular ?" value="<?php echo $fila[25] ?>">
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Forma Jurídica</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="id_forma_juridica" name="id_forma_juridica" class="form-control">
                            <?php
                            $registro  = mysqli_query($con, "SELECT * FROM tipo_forma_juridica");

                            while ($forma = mysqli_fetch_array($registro)) {


                                if ($fila[26] == $forma[0]) {
                                    echo '<option value=' . $forma[0] . ' selected >' . $forma[1] . '</option>';
                                } else {

                                    echo '<option value=' . $forma[0] . '>' . $forma[1] . '</option>';
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

                        <div class=" font-weight-bold pb-4 pt-4">Cuál de éstos programas es de tú interés?</div>

                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio1" value="1" <?php if ($id_programa == 1) {
                                                                                                echo 'checked';
                                                                                            } ?> class="custom-control-input ml-3 mr-3">
                            <label class="custom-control-label" for="radio1"> Jóvenes Emprendedores</label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio2" value="2" <?php if ($id_programa == 2) {
                                                                                                echo 'checked';
                                                                                            } ?> class="custom-control-input ml-3 mr-3">
                            <label class="custom-control-label" for="radio2"> Apoyo al Comercio emprendedor</label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio3" value="4" <?php if ($id_programa == 4) {
                                                                                                echo 'checked';
                                                                                            } ?> class="custom-control-input ml-3 mr-3">
                            <label class="custom-control-label" for="radio3"> Formación</label>
                        </div>

                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>

            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div id="estado"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <label>
                        <input type="checkbox" class="autorizar">
                        Autorizado
                    </label>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 text-right">
                    <input type="submit" value="Guardar" class="btn btn-info">
                </div>
            </div>

        </form>
    </div>
</div>

<?php
mysqli_close($con);
require_once('../accesorios/admin-scripts.php');
?>

<script type="text/javascript">

    var id_solicitante = $("#id_solicitante").val();

    // VER SI ESTA AUTORIZADO

    var url = 'verificar_autorizacion.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: id_solicitante
        },
        success: function(resp) {


            if (resp == 1) {

                $('.autorizar').prop("checked", true);

            } else {

                $('.autorizar').prop("checked", false);

            }
        }
    });

    

    $('.autorizar').on("click", function() {

        var id_solicitante = $("#id_solicitante").val();

        if (id_solicitante > 0) {

            if ($(this).prop("checked") == true) {
                toastr.options = {
                    "progressBar": true,
                    "showDuration": "300",
                    "timeOut": "1000"
                };
                toastr.success("&nbsp;", "Autorizado ... ");
            } else if ($(this).prop("checked") == false) {
                toastr.options = {
                    "progressBar": true,
                    "showDuration": "300",
                    "timeOut": "1000"
                };
                toastr.error("&nbsp;", "Bloqueado ... ");
            }

            $.ajax({

                url: '../solicitantes/server-a-autorizados.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_solicitante: id_solicitante
                },
                success: function(data) {

                    console.log(data);
                }
            });

        } else {

            $(this).prop("checked", false);

            toastr.options = {
                "progressBar": true,
                "showDuration": "300",
                "timeOut": "1000"
            };
            toastr.error("&nbsp;", "Seleccione un solicitante por favor  ... ");

        }


    });

    function ver_funcionamiento(id) {

        var funcio = document.getElementById('funciona').value;

        if (funcio == 1) { // SIGUE FUNCIONANDO
            $("#div_continua").show();
            $("#div_abandona").hide();
            $("#productoproducido").select();

        } else { // NO FUNCIONA MAS !!
            $("#div_abandona").show();
            $("#div_continua").hide();
            $("#porqueabandono").select();
        }
    }

    function ver_comercializacion(id) {
        var comer = document.getElementById('comercializacion').value;

        if (comer == 2) {
            $("#div_comercializacion").show();
            $("#otracomercializacion").focus();
        } else {
            $("#div_comercializacion").hide();
        }
    }

    function ver_trabajo(id) {
        if (id == 0) {
            $("#div_trabajo").show();
        } else {
            $("#div_trabajo").hide();
        }
    }
</script>

<?php
require_once('../accesorios/admin-inferior.php');
