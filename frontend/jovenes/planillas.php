<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-superior.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_proyecto	= $_SESSION['id_proyecto'] ;

?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>        
    </div>
</div>

<div class="card mb-2 bg-info text-white" id="encabezado">      
    <div class="card-header">        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-prepend1">Nro proyecto</span>
                    </div>
                    <input type="text" id="id_proyecto" name="id_proyecto" class="form-control text-center bg-white" readonly value="<?php echo $id_proyecto ; ?>">
                    <input type="hidden" name="_token" value="<?php echo sha1(time()); ?>">
                </div>                
            </div>

            <div class="col-xs-12 col-sm-6 col-lg-6">                
                <button class="save btn btn-info float-right" onClick="enviarResultados();" id="btn1">
                    <i class="fas fa-save"></i> Finalizar y enviar
                </button>             

                <a href="#encabezado" class="btn btn-default float-right" title="Ir a principio">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                </a>
                <a href="#bottom" class="btn btn-default float-right" title="Ir a final">
                    <i class="fas fa-arrow-alt-circle-down"></i> 
                </a>
                <a href="solicitud.php" class="btn btn-default float-right" title="Ir formulario inicial">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>                
            </div>
        </div>
    </div>
</div>

<div id="spopup" style="display: none;">
    <div class="btn-group bg-secondary" role="group" aria-label="botones">
        <a href="solicitud.php" class="btn btn-default float-right" title="Ir formulario inicial">
            <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
        <a href="#encabezado" class="btn btn-default" title="Ir a principio">
            <i class="fas fa-arrow-alt-circle-up"></i>
        </a>
        <a href="#bottom" class="btn btn-default" title="Ir a final">
            <i class="fas fa-arrow-alt-circle-down"></i>
        </a>
        
        <button class="save btn btn-info" onClick="enviarResultados();" id="btn2">
            <i class="fas fa-save"></i> Finalizar y enviar
        </button>
    </div>
</div>

<!-- Resumen presupuestario -->
<div class="card mb-2">

    <div class="card-header">
        <h4>Resumen presupuestario</h4>
        <small>Detalle de gastos a cubrir por el credito y/otras fuentes.</small>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table text-center">
                    <tr>
                        <th class="w-auto">Descripción</th>
                        <th style=" width:100px">Cantidad</th>
                        <th style=" width:300px">Importe</th>
                        <th style=" width:100px">Total</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="descripcion" name="descripcion" type="text" class="form-control mayus">
                        </td>
                        <td>
                            <input id="cantidades" name="cantidades" type="number" class="form-control text-center" value="1">
                        </td>
                        <td>
                            <input id="costounitario" name="costounitario" type="number" class="form-control text-center" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-default" onClick="guardar_resumen()"> 
                                <i class="fas fa-save text-primary"></i>
                            </button>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12"> 
                <div id="resumen_presupuestario"> </div>
            </div>
        </div>        
        
           
    </div>

</div>

<!-- Costos fijos -->
<div class="card mb-2">

    <div class="card-header">
        <h4>Detalle de costos fijos</h4>
        <small>Alquileres, servicios de energía, agua, gas, comunicaciones e Internet, personal, material de oficina, otros.</small>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table text-center">
                    <tr>
                        <th class="w-auto">Concepto</th>
                        <th style=" width:100px">Año</th>
                        <th style=" width:300px">Costo</th>
                        <th style=" width:100px">Total</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="concepto_f" name="concepto_f" type="text" class="form-control mayus" required>
                        </td>
                        <td>
                            <select id="ano_f" class="form-control text-center" class="form-control">
                                <option value="1" selected>1º</option>
                                <option value="2">2º</option>
                            </select>
                        </td>
                        <td>
                            <input id="monto_f" name="monto_f" type="number" class="form-control text-center" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-default" onClick="guardar_f()">
                                <i class="fas fa-save text-primary"></i>
                            </button>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div id="costos_fijos"></div>                
            </div>
        </div>

    </div>
    
</div>


<div class="card mb-2">
    <div class="card-header">
        <h4>Detalle de costos variables</h4>
        <small>Costos previstos de producción, costo de la materia prima, mano de obra directa, servicios y de máquinas y
            herramientas necesarias para la producción; gastos de comercialización y costo de publicidad y promoción,
            comisiones por venta, transporte, etc.
        </small>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table text-center">
                    <tr>
                        <th class="w-auto">Concepto</th>
                        <th style=" width:100px">Año</th>
                        <th style=" width:300px">Costo</th>
                        <th style=" width:100px">Total</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="concepto_v" name="concepto_v" type="text" class="form-control mayus" required>
                        </td>
                        <td>
                            <select id="ano_v" class="form-control text-center" class="form-control">
                                <option value="1" selected>1º</option>
                                <option value="2">2º</option>
                            </select>
                        </td>
                        <td>
                            <input id="monto_v" name="monto_v" type="number" class="form-control text-center" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-default" onClick="guardar_v()">
                                <i class="fas fa-save text-primary"></i>
                            </button>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div id="costos_variables"></div>                
            </div>
        </div>

    </div>    
</div>

<!-- Origen financiacion -->
<div class="card mb-2">
    <div class="card-header">
        <h4>Origen de los montos de la Fuente Financiación prevista</h4>
        <small>
            Origen de las fuentes de financiación y los montos previstos. Diferenciar entre recursos propios, créditos (ya sea
            del Programa Jóvenes Emprendedores u otras fuentes), subsidios y otros.
        </small>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table text-center">
                    <tr>
                        <th class="w-auto">Origen</th>
                        <th style=" width:100px">Año</th>
                        <th style=" width:300px">Monto</th>
                        <th style=" width:100px">Total</th>
                    </tr>
                    <tr>
                        <td class="w-auto">
                            <select name="id_tipo_o" id="id_tipo_o" size="1" class="form-control" required>
                                <option value="0" disabled selected></option>
                                <?php
                                $origenes = "select id_tipo, origen from tipo_origen_financiacion";
                                $registro = mysqli_query($con, $origenes); 
                                while($fila = mysqli_fetch_array($registro)){
                                    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                                }		
                                ?>
                            </select>
                        </td>
                        <td style=" width:100px">
                            <select id="ano_o" class="form-control">
                                <option value="1" selected>1º</option>
                                <option value="2">2º</option>
                            </select>
                        </td>
                        <td style=" width:300px">
                            <input id="monto_o" name="monto_o" type="number" class="form-control text-center">
                        </td>
                        <td style=" width:100px">
                            <button type="button" class="btn btn-default" onClick="guardar_o()">
                                <i class="fas fa-save text-primary"></i>
                            </button>
                        </td>
                    </tr>
                </table>

            </div>        
        </div>            
    
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div id="origen_financiacion"></div>
        </div>
    </div>

</div>


<!-- Ingresos x ventas -->
<div class="card mb-2">
    <div class="card-header">
        <h4>Proyección de Ingresos por Ventas </h4>
        <small>
            Proyección de ventas de unidades de los productos/servicios para los próximos dos años.
        </small>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <table class="table text-center">
                    <tr>
                        <th class="w-auto">Concepto</th>
                        <th style=" width:100px">Año</th>
                        <th style=" width:100px">Cantidad</th>
                        <th style=" width:300px">Importe</th>
                        <th style=" width:100px">Total</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="concepto_ing" name="concepto_ing" type="text" class="form-control mayus">
                        </td>
                        <td>
                            <select id="ano_ing" class="form-control">
                                <option value="1" selected>1º</option>
                                <option value="2">2º</option>
                            </select>
                        </td>
                        <td>
                            <input id="cantidad_ing" name="cantidad_ing" type="number" class="form-control text-center">
                        </td>
                        <td>
                            <input id="punitario_ing" name="punitario_ing" type="number" class="form-control text-center">
                        </td>
                        <td>
                            <button type="button" class="btn btn-default" onClick="guardar_ing()">
                                <i class="fas fa-save text-primary"></i>
                            </button>
                        </td>
                    </tr>
                </table>

            </div>
        </div>  
    
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div id="ingresos_ventas"></div>
        </div>

    </div>
</div>


<!-- Origen financiacion -->
<div class="card mb-2">
    <div class="card-header">

        <div class="row">
            <div class="col-md-11">
                <h4>Planilla de Resultados</h4>
            </div>            
            <div class="col-md-1 float-right">

                <button type="button" class="btn btn-default pull-right" onClick="actualizar()">
                    <i class="fas fa-sync-alt text-primary"></i>
                </button>
            </div>            
        </div>        
        <div class="row">
            <div class="col">
                <small>
                    Cálculo en base con la proyección de ingresos por ventas y a los costos estructurales y proporcionales declarados para los próximos dos años el resultado de los ingresos menos egresos.
                </small>
            </div>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="box-body table-responsive no-padding">
                <div id="planilla_resultados"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 mb-5" id="bottom">
    <div class="col text-center">
        <a href="solicitud.php" class="btn btn-info">
            <i class="fas fa-calculator"></i> - Formulario inicial
        </a>
    </div>
</div>

<div class="row mt-5 mb-5">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>



<?php 

mysqli_close($con);

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-scripts.php'); 

?>

<style>
    #spopup{
        opacity: 0.8;
        width:auto;
        position:fixed;
        bottom:13px;
        right:25px;
        display:none;
        z-index:90;
    }

</style>

<script>

    $(window).scroll(function(){
        if($(document).scrollTop()>= ($(document).height()/50)) 
            $("#spopup").show("slow");
        else 
            $("#spopup").hide("slow");
    });

    $(document).ready(function () {

        $("#resumen_presupuestario").load('detalle_presupuestario.php');
        $("#costos_fijos").load('detalle_costos_fijos.php');
        $("#costos_variables").load('detalle_costos_variables.php');
        $("#origen_financiacion").load('detalle_origen_financiacion.php');
        $("#ingresos_ventas").load('detalle_ingresos_ventas.php');
        $("#planilla_resultados").load('detalle_planilla_resultados.php');
    });

    function actualizar(){
        $("#planilla_resultados").load('detalle_planilla_resultados.php');
    }

    function guardar_resumen() {
        var descripcion = (document.getElementById('descripcion').value).toUpperCase();
        var cantidades = document.getElementById('cantidades').value;
        var costounitario = document.getElementById('costounitario').value;

        if (descripcion.length > 0) {
            if (cantidades > 0 && costounitario > 0) {
                $("#resumen_presupuestario").load('detalle_presupuestario.php', {
                    operacion: 1,
                    descripcion: descripcion,
                    cantidades: cantidades,
                    costounitario: costounitario
                });
                document.getElementById('descripcion').value = '';
                document.getElementById('cantidades').value = 1;
                document.getElementById('costounitario').value = 0;
                $("#descripcion").focus();
            } else {
                alert('Cantidad y Costo deben ser superiores a 0.');
                $("#cantidades").focus();
            }
        } else {
            alert('Complete Descripción producto.');
            $("#descripcion").focus();
        }
    }

    function borrar_producto_resumen(id) {
        if (confirm('Desea eliminar producto ?')) {
            id_producto = id;
            $("#resumen_presupuestario").load('detalle_presupuestario.php', {
                operacion: 2,
                id_producto: id_producto
            });
        }
    }

    function guardar_f() {
        var concepto = (document.getElementById('concepto_f').value).toUpperCase();
        var monto = document.getElementById('monto_f').value;
        var ano = document.getElementById('ano_f').value;

        if (concepto.length > 0) {
            if (monto > 0) {
                $("#costos_fijos").load('detalle_costos_fijos.php', {
                    operacion: 1,
                    concepto: concepto,
                    monto: monto,
                    ano: ano
                });
                document.getElementById('concepto_f').value = '';
                document.getElementById('monto_f').value = 0;
                $("#concepto_f").focus();
            } else {
                alert('Monto debe ser mayor 0 / Separador Decimal es incorrecto.');
                $("#monto_f").focus();
            }
        } else {
            alert('Complete Concepto.');
            $("#concepto_f").focus();
        }
    }


    function borrar_producto_f(id) {
        if (confirm('Desea eliminar el concepto ?')) {
            id_concepto = id;
            $("#costos_fijos").load('detalle_costos_fijos.php', {operacion: 2, id_concepto: id_concepto});
        }
    }


    function guardar_v() {
        var concepto = (document.getElementById('concepto_v').value).toUpperCase();
        var monto = document.getElementById('monto_v').value;
        var ano = document.getElementById('ano_v').value;

        if (concepto.length > 0) {
            if (monto > 0) {
                $("#costos_variables").load('detalle_costos_variables.php', {
                    operacion: 1,
                    concepto: concepto,
                    monto: monto,
                    ano: ano
                });
                document.getElementById('concepto_v').value = '';
                document.getElementById('monto_v').value = 0;
                $("#concepto_v").focus();
            } else {
                alert('Monto debe ser mayor 0 / Separador Decimal es incorrecto.');
                $("#monto_v").focus();
            }
        } else {
            alert('Complete Concepto.');
            $("#concepto_v").focus();
        }
    }

    function borrar_producto_v(id) {
        if (confirm('Desea eliminar el concepto ?')) {
            id_concepto = id;
            $("#costos_variables").load('detalle_costos_variables.php', {
                operacion: 2,
                id_concepto: id_concepto
            });
        }
    }


    function guardar_o() {
        var id_tipo = document.getElementById('id_tipo_o').value;
        var monto = document.getElementById('monto_o').value;
        var ano = document.getElementById('ano_o').value;

        if (id_tipo != 0) {
            if (monto > 0) {
                $("#origen_financiacion").load('detalle_origen_financiacion.php', {
                    operacion: 1,
                    id_tipo: id_tipo,
                    monto: monto,
                    ano: ano
                });

                document.getElementById('id_tipo_o').value = 0;
                document.getElementById('monto_o').value = 0;
                $("#id_tipo_o").focus();
            } else {
                alert('Monto debe ser mayor 0 / Separador Decimal es incorrecto.');
                $("#monto_o").focus();
            }
        } else {
            alert('Seleccione Origen Financiación.');
            $("#id_tipo_o").focus();
        }
    }

    function borrar_producto_o(id) {
        if (confirm('Desea eliminar el Origen Financiación ?')) {
            id_fuente = id;
            $("#origen_financiacion").load('detalle_origen_financiacion.php', {
                operacion: 2,
                id_fuente: id_fuente
            });
        }
    }

    function guardar_ing() {
        var concepto = (document.getElementById('concepto_ing').value).toUpperCase();
        var cantidad = document.getElementById('cantidad_ing').value;
        var pu = document.getElementById('punitario_ing').value;
        var ano = document.getElementById('ano_ing').value;

        if (concepto.length > 0) {
            if (cantidad > 0) {
                if (pu > 0) {
                    $("#ingresos_ventas").load('detalle_ingresos_ventas.php', {
                        operacion: 1,
                        concepto: concepto,
                        cantidad: cantidad,
                        pu: pu,
                        ano: ano
                    });
                    document.getElementById('concepto_ing').value = '';
                    document.getElementById('cantidad_ing').value = 0;
                    document.getElementById('punitario_ing').value = 0;
                    $("#concepto_ing").focus();
                } else {
                    alert('P.Unitario debe ser mayor 0 / Separador Decimal es incorrecto.');
                    $("#punitario_ing").focus();
                }
            } else {
                alert('Cantidad debe ser mayor 0.');
                $("#cantidad_ing").focus();
            }
        } else {
            alert('Seleccione Concepto Ingreso x Ventas.');
            $("#concepto_ing").focus();
        }
    }

    function borrar_producto_ing(id) {
        if (confirm('Desea eliminar el Concepto de Ingreso Venta ?')) {
            id_ingreso = id;
            $("#ingresos_ventas").load('detalle_ingresos_ventas.php', {
                operacion: 2,
                id_ingreso: id_ingreso
            });
        }
    }

    

    function enviarResultados() {

        var url = 'verifica_edad.php';

        $.ajax({
            type: 'POST',
            async: true,
            url: url,
            success: function (response) {

                if(response == 1 ){
                    var mensaje = 'El titular y/o asociados superan los 40 años de edad';
                    var texto = mensaje + '<br>';
                    $('.save').attr('disabled', false);
                    $('.save').html('Finalizar y enviar');
                    ymz.jq_alert({title:"Edad excedida ", text:texto, ok_btn:"Aceptar", close_fn:null}); 

                    verificado  = 0;
                    var ficha   = 6;

                    return false;

                }else{
                    guardarResultados();       
                }            
            }                  
        });
    }    

    function guardarResultados() {    


        $('.save').html('Esperando respuesta <i class="fa fa-spinner fa-spin"></i>');

        var cant_rp = document.getElementById('cant_rp').value;
        var cant_cf = document.getElementById('cant_cf').value;
        var cant_cv = document.getElementById('cant_cv').value;
        var cant_ff = document.getElementById('cant_ff').value;
        var cant_pv = document.getElementById('cant_pv').value;

        var verificado = 1;
        var mensaje = '';

        if (cant_rp == 0) {
            verificado = 0;
            var ficha = 1;
        } else {
            if (cant_cf == 0) {
                verificado = 0;
                var ficha = 2;
            } else {
                if (cant_cv == 0) {
                    verificado = 0;
                    var ficha = 3;
                } else {
                    if (cant_ff == 0) {
                        verificado = 0;
                        var ficha = 4;
                    } else {
                        if (cant_pv == 0) {
                            verificado = 0;
                            var ficha = 5;
                        }
                    }
                }
            }
        }

        if (verificado == 0) {

            switch (ficha) {
                case 1:
                    var mensaje = 'Resumen Presupuestario.';
                    break;
                case 2:
                    var mensaje = 'Detalle Costos Fijos.';
                    break;
                case 3:
                    var mensaje = 'Detalle Costos Variables.';
                    break;
                case 4:
                    var mensaje = 'Origen Montos de la Fuente Financiación Prevista.';
                    break;
                case 5:
                    var mensaje = 'Proyección de Ingresos por Ventas.';
                    break;
            }

            var texto = '<i class="fa fa-exclamation-triangle fa-2x text-warning" aria-hidden="true"></i> ' + 'Complete ' + mensaje + '<br>';
            
            $('.save').attr('disabled', false);
            $('.save').html('Finalizar y enviar');

            ymz.jq_alert({title:"Formulario incompleto ", text:texto, ok_btn:"Aceptar", close_fn:null}); 

        } else {

            var texto = "<div class=' text-center'> <b>Desea enviar de su proyecto ? </b></div>  "

            ymz.jq_confirm({
                title:'', 
                text: texto, 
                no_btn:"Cancelar", 
                yes_btn:"Confirma", 
                no_fn:function(){

                    $('.save').attr('disabled', false);
                    $('.save').html('Finalizar y enviar');
                    return false;
                },
                yes_fn:function(){
                        
                    var url = 'modificar_estado_proyecto.php';

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {estado: 24},
                        success: function (resp) {
                            $('.enviado').removeClass('hidden');
                            $('.save').attr('disabled', true);

                            setTimeout(function(){ $('.save').html('Proyecto enviado'); }, 1000);   

                            console.log(resp);
                            
                            window.location = 'bienvenida.php';
                                         
                        }                  
                    });
                }
            });

        }
    }

</script>


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-inferior.php'); ?>