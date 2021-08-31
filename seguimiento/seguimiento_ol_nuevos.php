<?php
require '../accesorios/admin-superior.php';
require '../accesorios/accesos_bd.php';
$id_usuario = $_SESSION['id_usuario'];
$con        = conectar();


?>

<div class="card">

    <div class="card-header">
        <div class="row mb-4">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                RELEVAMIENTO ON-LINE <strong>PROYECTOS AUTOGESTIONADOS</strong>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form id="relevamiento" method="post" action="agregar_seguimiento_ol_nuevo.php">

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?php

                    $registro = mysqli_query(
                        $con,
                        "SELECT t1.id_solicitante, t1.apellido, t1.nombres, t1.dni, t1.cod_area, t1.telefono, t1.celular, t2.nombre AS ciudad
                        FROM solicitantes AS t1
                        INNER JOIN localidades AS t2 ON t1.id_ciudad = t2.id
                        WHERE t1.id_responsabilidad = 1
                        ORDER BY t1.apellido, t1.nombres ASC"
                    );
                    ?>
                    <h5 for="id_expediente">Proyecto Jóvenes Emprendedor</h5>
                    <select id="id_solicitante" name="id_solicitante" class="form-control" required="true" onclick="ver_expediente(this.value)" size="10">
                        <option disabled selected>Seleccione Solicitante</option>
                        <?php
                        while ($fila = mysqli_fetch_array($registro)) { ?>
                        <option value=<?php echo $fila['id_solicitante']; ?>>
                            <?php echo $fila['apellido'] . ', ' . $fila['nombres'] . ' (' . $fila['cod_area'] . ') ' . $fila['telefono'] . ' (Movil) ' . $fila['celular'] . ' - ' . $fila['ciudad']; ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <br />
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5 for="resenia">Reseña </h5>
                    <div id="resenia" class="text-justify alert alert-dismissable alert-secondary">

                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label for="expedientes">Otros Datos - DNI asociado a créditos anteriores </label>
                    <div id="expedientes">

                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <br />
                </div>
            </div>

            <div class="mt-4 mb-4" id="div_situacion" style="display:none">
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <h5>Situación Actual</h5>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <h6>Está funcionando su proyecto ? </h6>
                        <select id="funciona" name="funciona" class="form-control" onChange="ver_funcionamiento()">
                            <option value="-1" selected disabled>Seleccione una opción</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card card-body mt-4 mb-4" id="div_abandona" style="display:none">

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="porqueabandono" name="porqueabandono" class="form-control" placeholder="Porqué no comenzó el mismo ?">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="hidden" id="volverafuncionar" name="volverafuncionar" value="0">
                    </div>
                </div>

            </div>

            <div class="card card-body mt-4 mb-4" id="div_continua" style="display:none">

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Producción</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="productoproducido" name="productoproducido" class="form-control" placeholder="Producto/Servicio creado?">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="cantidadproducida" name="cantidadproducida" class="form-control" placeholder="Cantidad producida">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Comercialización</b></div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="mercado" name="mercado" class="form-control" placeholder="MERCADO donde ubica su producción (Local, regional, provincial, nacional)">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <input type="text" id="comprador" name="comprador" class="form-control" placeholder="Principal comprador">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="comercializacion" name="comercializacion" class="form-control" onChange="ver_comercializacion()">
                            <option value="-1" selected>Forma de Comercialización</option>
                            <option value="0">Directa</option>
                            <option value="1">Indirecta</option>
                            <option value="2">Otra</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div id="div_comercializacion" style="display:none">
                            <input type="text" id="otracomercializacion" name="otracomercializacion" class="form-control" placeholder="Otro tipo comercialización">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="interesexportar" name="interesexportar" class="form-control">
                            <option value="-1" selected>Tiene INTERÉS en Exportar ?</option>
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-lg-8">
                        <input type="text" id="porqueexportar" name="porqueexportar" class="form-control" placeholder="En caso de no tener interés en exportar, porqué no?">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="conocerequisitosexportar" name="conocerequisitosexportar" class="form-control">
                            <option value="-1" selected>Conoce los REQUISITOS para exportar ?</option>
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="capacitarseexportar" name="capacitarseexportar" class="form-control">
                            <option value="-1" selected>Desea capacitarse para exportar y formas de hacerlo ?</option>
                            <option value="0">No</option>
                            <option value="1">Si</option>
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
                        <select id="cuantosempleados" name="cuantosempleados" class="form-control">
                            <option value="-1" selected>Cuántos EMPLEADOS posee ?</option>
                            <?php
                            $i = 0;
                            while ($i <= 20) {
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <select id="cuantosfamiliares" name="cuantosfamiliares" class="form-control">
                            <option value="0" selected>Cuántas pertenecen FAMILIA ?</option>
                            <?php
                            $i = 0;
                            while ($i <= 20) {
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <select id="cuantosinscriptas" name="cuantosinscriptas" class="form-control" onChange="ver_trabajo(this.value)">
                            <option value="0" selected>Cuántas personas están INSCRIPTAS en Relación Dependencia ?</option>
                            <?php
                            $i = 0;
                            while ($i <= 20) {
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                                $i++;
                            }
                            ?>
                            <option value="21">más</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div id="div_trabajo" style="display:none">
                            <input type="text" id="porquenoregistrado" name="porquenoregistrado" class="form-control" placeholder="Porqué motivo no posee personal registrado ?">
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
                        <input type="text" id="necesitacapacitacion" name="necesitacapacitacion" class="form-control" placeholder="Necesita CAPACITACION o ASESORAMIENTO en algún tema particular ?" maxlength="200">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12"><b>Forma Jurídica</b></div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-4 col-lg-4">
                        <select id="id_forma_juridica" name="id_forma_juridica" class="form-control">
                            <option value="-1" selected>Seleccione por favor </option>
                            <?php
                            $registro = mysqli_query($con, "select * from tipo_forma_juridica");
                            while ($fila = mysqli_fetch_array($registro)) { ?>
                            <option value=<?php echo $fila[0]; ?>><?php echo $fila[1]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <br>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

                        <div class=" font-weight-bold pb-4 pt-4">Cuál de éstos programas es de tú interés?</div>

                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio1" value="1" checked class="custom-control-input ml-3 mr-3">
                            <label class="custom-control-label" for="radio1"> Jóvenes Emprendedores</label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio2" value="2" class="custom-control-input ml-3 mr-3">
                            <label class="custom-control-label" for="radio2"> Apoyo al Comercio emprendedor</label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" name="id_programa" id="radio3" value="4" class="custom-control-input ml-3 mr-3">
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


            <div class="card card-body mt-4 mb-4" id="div_guardar" style="display:none">
                <div class="row mb-4">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label>
                            <input type="checkbox" class="autorizar"> Autorizado
                        </label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-right">
                        <input type="submit" value="Guardar" class="btn btn-info">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php
mysqli_close($con);
require_once '../accesorios/admin-scripts.php';
?>

<script type="text/javascript">
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

            url: 'server-a-autorizados.php',
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

    $("#div_guardar").show();
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

function ver_expediente(id) {

    // VER LA RESEÑA ALMACENADA EN EL REGISTRO DEL PROYECTO

    console.log(id);

    var url = 'verificar_resena.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: id
        },
        success: function(resp) {
            if (resp != 0) {
                $("#resenia").html(resp);
            } else {
                $("#resenia").html('');
            }
        }
    });

    $("#div_situacion").show();

    var id_solicitante = id;

    var url = 'verificar_proyecto.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: id_solicitante
        },
        success: function(resp) {
            if (resp != 0) {
                $("#expedientes").html(resp);
            } else {
                $("#expedientes").html('');
            }
        }
    });

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

}

$(window).ready(function() {
    $("#relevamiento").on("keypress", function(event) {
        console.log("aaya");
        var keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            event.preventDefault();
            return false;
        }
    });
});
</script>

<?php
require_once '../accesorios/admin-inferior.php';