<?php
require_once '../accesorios/accesos_bd.php';
$con = conectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8">

    <link href="bootstrap-4.3.1/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="bootstrap-4.3.1/dist/css/ymz_box.css" rel="stylesheet" type="text/css"/>
    <link href="bootstrap-4.3.1/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>

    <style>
        body { padding-top: 70px; padding-bottom: 70px; margin: 15px}
    </style>

<body>
    <nav class="navbar fixed-top    navbar-light bg-light">
        <table class="table table-sm text-center">
            <tr class="bg-info text-white">
                <td>
                    Sistema Móvil - Jóvenes Emprendedores &COPY; - Form-2017
                </td>
            </tr>
        </table>
    </nav>

    <nav class="navbar fixed-bottom navbar-light bg-light">
    
        <table class="table table-bordered text-center">
            <tr class="bg-info">
                <td>
                    <a class="text-white" href="#" onClick="salida()">
                        Salir
                    </a>
                </td>
                <td>
                    <a class="text-white" href="#" onclick="acerca()">
                        Acerca
                    </a>
                </td>
                <td>
                    <a class="text-white" href="#" onclick="chequear()">
                        Guardar
                    </a>
                </td>

            </tr>
        </table>
    </nav>


    <div class="container-fluid p-5 border">

        <form id="relevamiento" class="form-horizontal">  
        
        <div class="row">    
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <select id="1" class="form-control">
                <option value="-1" disabled selected>Seleccione encuestador</option>
                <?php
                $registro = mysqli_query($con, "SELECT id_usuario, nombre_usuario FROM usuarios WHERE estado = 'a' AND id_usuario not in (2,4) ORDER BY nombre_usuario asc");
                while ($fila = mysqli_fetch_array($registro)) { ?>
                <option value=<?php echo $fila[0]; ?> ><?php echo ucfirst($fila[1]); ?></option>
                <?php
                }
                ?>
                </select>
            </div>
        </div>
            
        <div class="row">    
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <select id="2" class="form-control" >
                <option value="-1" disabled selected>Titular del proyecto</option>
                <?php
                $registro = mysqli_query($con, "SELECT exp.id_expediente,emp.apellido,emp.nombres,emp.cuit,te.estado,rp.rubro
                FROM expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp
                WHERE exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor AND
                exp.estado = te.id_estado AND exp.id_rubro = rp.id_rubro AND emp.id_responsabilidad = 1
                GROUP BY exp.id_expediente order by emp.apellido,emp.nombres asc");
                while ($fila = mysqli_fetch_array($registro)) { ?>
                <option value=<?php echo $fila[0]; ?>><?php echo ucwords(strtolower($fila[1] . ', ' . $fila[2] . '(' . $fila[3] . ') ' . $fila[5])); ?></option>
                <?php
                }
                ?>
                </select>
            </div>
        </div>
        
        <div class="row">    
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <select id="3" onchange="ver_funcionamiento(this.value)" class="form-control">
                    <option value="-1" selected>Estado del proyecto</option>
                    <option value="1">Funcionando</option>
                    <option value="2">Por iniciar</option>
                    <option value="3">Desistió de la idea</option>
                    <option value="4">No se puede contactar</option>
                </select>
            </div>
        </div>     
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <hr>
            </div>
        </div>  

        <div id="div_abandona" style="display:none">
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    4 - Porqué motivo desistió ? <span style="color:red">*</span>
                </div>
            </div>
                
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)" checked="true" > No fue Rentable </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="2" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Falta Capital Inicial </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Surgió una Mejor Oportunidad (cambio de rubro del emprendimiento, asociación a otro emprendedor, o en relación de dependencia) </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="4" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Cuestiones de Fuerza Mayor (robos, problemas climáticos, razones personalísimas u otras similares) </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="5" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> No pude dedicarle más Tiempo </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="6" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Problemas internos (mal manejo de la producción, disolución de la sociedad u otros similares) </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox"  name="mdesistio[]" value="7" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Problemas externos (cambios abruptos en los costos, mercado en baja, problemas de financiamiento) </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mdesistio[]" value="8" onClick="if (this.checked) asignar_check(this.value,1,4); else asignar_check(this.value,0,4)"> Otros </label>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="4" name="4" value="1">
                </div>
            </div>      
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    5 - Otros motivos
                </div>
            </div>
                
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="5" name="5" class="form-control" value="--">
                </div>
            </div>                   
        
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <hr>
                </div>
            </div>                   
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    6 - Tiene pensado volver a funcionar ?
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" name="radio6" id="radio0" value="0" onclick="asignar(6,this.value)" checked="checked"> NO</label> <br/>
                </div>
            </div>
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" name="radio6" id="radio1" value="1" onclick="asignar(6,this.value)"> SI</label> <br/>
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="6" name="6" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> 
                    7 - ¿Qué necesita para volver a funcionar ?
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" name="7" id="7" class="form-control" value="--">
                </div>
            </div>
        
        </div>
        <!-- FIN DE LOS QUE DESISTIERON -->        

        <!-- INICIO DE LOS QUE INICIAN PROYECTOS -->
        <div id="div_inicia" style="display:none">
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    Indique 1 a 10, cómo se encuentra en cada una de las siguientes tareas ?
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    8 - Emplazamiento
                </div>
            </div>
                
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="emplazamientoRange" min="0" max="10" value="0" oninput="this.form.emplazamiento.value=this.value" onchange="asignar(8,this.value)" />
                </div>                 
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="emplazamiento" value="0" readonly class="form-control text-center" />
                    <input type="hidden" name="8" id="8" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    9 - Contacto con los proveedores
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="contactoRange" min="0" max="10" value="0" oninput="this.form.contacto.value=this.value" onchange="asignar(9,this.value)"/>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="contacto" id="contacto" value="0" readonly class="form-control text-center" />
                    <input type="hidden" name="9" id="9" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    10 - Método de producción
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="metodoRange" min="0" max="10" value="0" oninput="this.form.metodo.value=this.value" onchange="asignar(10,this.value)"/>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="metodo" id="metodo" value="0" readonly class="form-control text-center"/>
                    <input type="hidden" name="10" id="10" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    11 - Cuestiones vinculadas con el marketing
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="marketingRange" min="0" max="10" value="0" oninput="this.form.marketing.value=this.value" onchange="asignar(11,this.value)"/>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="marketing" id="marketing" value="0" readonly class="form-control text-center"/>
                    <input type="hidden" name="11" id="11" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    12 - Cuestiones vinculadas a los costos-precios
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="costospRange" min="0" max="10" value="0" oninput="this.form.costosp.value=this.value" onchange="asignar(12,this.value)"/>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="costosp" id="costosp" value="0" readonly class="form-control text-center"/>
                    <input type="hidden" name="12" id="12" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    13 - Definición de los canales de venta
                </div>
            </div>
            
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="range" class="form-control-range" name="canalesventaRange" min="0" max="10" value="0" oninput="this.form.canalesventa.value=this.value" onchange="asignar(13,this.value)"/>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-3">
                    <input type="number" name="canalesventa" id="canalesventa" readonly class="form-control text-center"/>
                    <input type="hidden" name="13" id="13" value="0">
                </div>
            </div>
        </div>
        <!-- FIN DE LOS QUE INICIAN PROYECTOS -->

        <!-- INICIO DE LOS QUE CONTINUAN PROYECTOS -->
        <div id="div_continua" style="display:none">
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Producción</h4>
                </div>
            </div>
            
            <div class="row">
                <label class="col-xs-12">14 -  ¿En qué actividad se enmarca su emprendimiento? <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio14" onclick="asignar(14,this.value)" checked="true" > SECTOR AGROPECUARIO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio14" onclick="asignar(14,this.value)"> INDUSTRIA MANUFACTURERA</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio14" onclick="asignar(14,this.value)"> SERVICIOS VINCULADOS A LOS RUBROS ANTERIORES</label> <br/>
                    <input type="hidden" name="14" id="14" value="1">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> <br /> </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">¿Qué produce / producirá su emprendimiento? </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">15 - Producto / Servicio 1 </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="15" name="15" class="form-control" value="-">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">16 - Producto / Servicio 2</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="16" name="16" class="form-control" value="-">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">17 - Producto / Servicio 3</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="17" name="17" class="form-control" value="-">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> <br /> </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">¿En qué cantidades?</div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">18 - Cantidad / Servicio 1 </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="18" name="18" class="form-control" value="-">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">19 - Cantidad / Servicio 2</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="19" name="19" class="form-control" value="0">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">20 - Cantidad / Servicio 3</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="20" name="20" class="form-control" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> <br /> </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">¿Costos por Unidad? </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">21 - Costos / Servicio 1 </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="21" name="21" class="form-control" value="0" >
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">22 - Costos / Servicio 2</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="22" name="22" class="form-control" value="0">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">23 - Costos / Servicio 3</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="23" name="23" class="form-control" value="0">
                </div>
            </div>            
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">24 - Codigo AFIP de la Actividad Principal según encuestador</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="24" name="24" class="form-control" value="0">
                </div>
            </div>
        
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">25 - Es un producto Exportable ?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio25" onclick="asignar(25,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio25" onclick="asignar(25,this.value)"> SI</label> <br/>
                    <input type="hidden" name="25" id="25" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">26 - ¿Tiene deseos de exportarlo?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio26" onclick="asignar(26,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio26" onclick="asignar(26,this.value)"> SI</label> <br/>
                    <input type="hidden" name="26" id="26" value="0">
                </div>
            </div>
            
            <div id="divmercado"></div>

            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Comercialización</h4>
                </div>
            </div>
            
            <div class="row">
                <label class="col-xs-12">27 - ¿En qué mercados coloca / colocará su producción? <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mercado[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,27); else asignar_check(this.value,0,27)" checked="true"> Sólo en mi ciudad </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mercado[]" value="2" onClick="if (this.checked) asignar_check(this.value,1,27); else asignar_check(this.value,0,27)"> En mi ciudad y zonas aledañas </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mercado[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,27); else asignar_check(this.value,0,27)"> Regional y Provincial </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="mercado[]" value="4" onClick="if (this.checked) asignar_check(this.value,1,27); else asignar_check(this.value,0,27)"> Nacional e Internacional </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="27" name="27" value="1">
                </div>
            </div>
            
            <div class="row">
                <label class="col-xs-12">28 - ¿A quién le vende su producción? (Puede elegir más de una) <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="formacomercializacion[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,28); else asignar_check(this.value,0,28)" checked="true"> Directamente al Consumidor Final </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="formacomercializacion[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,28); else asignar_check(this.value,0,28)"> Vendedores Minoristas </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="formacomercializacion[]" value="4" onClick="if (this.checked) asignar_check(this.value,1,28); else asignar_check(this.value,0,28)"> Vendedores Mayoristas e Intermediarios </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="28" name="28" value="1">
                </div>
            </div>

            <div class="row">
            
                <label class="col-xs-12">29 - ¿Dónde vende sus productos ? <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio29" onclick="asignar(55,this.value)"> En Internet</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio29" onclick="asignar(55,this.value)"checked="true" > En ferias</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio29" onclick="asignar(55,this.value)"> Venta a domicilio</label> <br/>
                    <label class="radio-inline"><input type="radio" value="4" name="radio29" onclick="asignar(55,this.value)"> En local comercial propio</label> <br/>
                    <label class="radio-inline"><input type="radio" value="5" name="radio29" onclick="asignar(55,this.value)"> En locales comerciales de terceros</label> <br/>
                    <label class="radio-inline"><input type="radio" value="6" name="radio29" onclick="asignar(55,this.value)"> En local comercial compartido con otros Emprendedores</label> <br/>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="29" name="29" value="2">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">30 - Producto/Servicio 1 - Precio de venta a CONSUMIDOR FINAL </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="30" name="30" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">31 - Producto/Servicio 1 - Precio de venta a INTERMEDIARIO </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="31" name="31" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">32 - Producto/Servicio 1 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="32" name="32" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">33 - Producto/Servicio 2 - Precio de venta a CONSUMIDOR FINAL</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="33" name="33" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">34 - Producto/Servicio 2 - Precio de venta a INTERMEDIARIO</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="34" name="34" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">35 - Producto/Servicio 2 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="35" name="35" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">36 - Producto/Servicio 3 - Precio de venta a CONSUMIDOR FINAL</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="36" name="36" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">37 - Producto/Servicio 3 - Precio de venta a INTERMEDIARIO</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="37" name="37" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">38 - Producto/Servicio 3 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="38" name="38" class="form-control" value="0">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">39 - ¿Conoce algunas ferias donde puede comercializar su producción?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio39" onclick="asignar(39,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio39" onclick="asignar(39,this.value)"> SI</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="39" name="39" value="0">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">40 - ¿Ha participado de alguna feria ?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio40" onclick="asignar(40,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio40" onclick="asignar(40,this.value)" > SI</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="40" name="40" value="0">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">41 - ¿Le interesaría participar de las ferias ?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio41" onclick="asignar(41,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio41" onclick="asignar(41,this.value)"> SI</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="41" name="41" value="0">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">42 - ¿Cuáles considera que son las limitantes para participar de las ferias ?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" class="form-control" name="42" id="42" value="-">
                </div>
            </div>
            
            <div id="divcontrol"></div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Control</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">43 - ¿Realiza algún <b>Registro / Anotación</b> de las operaciones de su emprendimiento? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio43" onclick="asignar(43,this.value)" checked="true" > SI - MANUAL</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio43" onclick="asignar(43,this.value)" > SI - SISTEMATIZADO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio43" onclick="asignar(43,this.value)" > NO - NO REALIZA CONTROL</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="43" name="43" value="1">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> ¿Cuáles considera Ud. como los principales <b>costos</b> de su emprendimiento ?       </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> Costo1 <input type="text" id="44" name="44" class="form-control" value="-"/>       </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> Costo2 <input type="text" id="45" name="45" class="form-control" value="-"/>       </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4"> Costo3 <input type="text" id="46" name="46" class="form-control" value="-"/>       </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">47 - ¿Realiza algún tipo de <b>Control de Costos</b> de su emprendimiento ? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio47" onclick="asignar(47,this.value)" checked="true" > SI - MANUAL</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio47" onclick="asignar(47,this.value)" > SI - SISTEMATIZADO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio47" onclick="asignar(47,this.value)" > NO - REALIZA CONTROL</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="47" name="47" value="1">
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">48 - ¿Realiza algún tipo de <b>Planilla con el detalle de insumos </b> ? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio48" onclick="asignar(48,this.value)" checked="true" > SI - MANUAL</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio48" onclick="asignar(48,this.value)" > SI - SISTEMATIZADO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio48" onclick="asignar(48,this.value)" > NO - REALIZA CONTROL</label> <br/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="48" name="48" value="1">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">49 - ¿Realiza algún tipo de <b>Control de Stock </b> de mercadería ? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio49" onclick="asignar(49,this.value)"checked="true" > SI - MANUAL</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio49" onclick="asignar(49,this.value)"> SI - SISTEMATIZADO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio49" onclick="asignar(49,this.value)"> NO - REALIZA CONTROL</label> <br/>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                <input type="hidden" id="49" name="49" value="1">
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    &nbsp;
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">50- ¿Realiza algún tipo de <b>Control de Producción </b>? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio50" onclick="asignar(50,this.value)" checked="true"> SI - MANUAL</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio50" onclick="asignar(50,this.value)"> SI - SISTEMATIZADO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio50" onclick="asignar(50,this.value)"> NO - REALIZA CONTROL</label> <br/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="50" name="50" value="1">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">51 - En relación a las habilitaciones e impuestos vinculados a su actividad específica, usted diría que : </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio51" onclick="asignar(51,this.value)" checked="true"> Tengo todas las habilitaciones</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio51" onclick="asignar(51,this.value)"> Cuento con la mayoría de las habilitaciones</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio51" onclick="asignar(51,this.value)"> Cuento con algunas habilitaciones</label> <br/>
                    <label class="radio-inline"><input type="radio" value="4" name="radio51" onclick="asignar(51,this.value)"> Aún no he realizado ningún trámite de habilitación</label> <br/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="51" name="51" value="1">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">52 - ¿Con cuál de las siguientes frases se siente más identificado </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio52" onclick="asignar(52,this.value)" checked="true"> Mi capacidad productiva está bien, me cuesta vender</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio52" onclick="asignar(52,this.value)"> No doy abasto con la producción, tengo más pedidos que capacidad productiva</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio52" onclick="asignar(52,this.value)"> Mi emprendimiento está equilibrado entre producción y demanda</label> <br/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="52" name="52" value="1">
                </div>
            </div>
            
            <div id="divproblemacrecimiento">&nbsp;</div>
            
            <div class="row">
                <label class="col-xs-12">53 - ¿Cuáles cree que son los principales problema para su crecimiento ? <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)" checked="true"> Costo de Producción </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="2" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Método de Produción </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Poca capacidad de Producción </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="4" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Poca capacidad de Venta </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="5" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Los costos de los Intermediarios </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="6" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> La gran cantidad de Competencia </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="7" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Problemas administrativos propios </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="8" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Problemas burocráticos relacionados con habilitaciones, reglamentaciones, etc... </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="problemacrecimiento[]" value="9" onClick="if (this.checked) asignar_check(this.value,1,53); else asignar_check(this.value,0,53)"> Otros problemas, cuáles ? </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="53" name="53" value="1">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">54 - Otros problemas</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="text" id="54" name="54" class="form-control" value="-">
                </div>
            </div>
            

            <div id="divfinanciamiento"></div>

            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Financiamiento</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">55 - Además del financiamiento del programa Jóvenes Emprendedores, ¿ha invertido más capital en el proyecto?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio55" onclick="asignar(55,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio55" onclick="asignar(55,this.value)" > SI</label> <br/>
                </div>
            </div>
            <div class=" form-group">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="55" name="55" value="0">
                </div>
            </div>

            <div id="divtipofinanciamiento">&nbsp;</div>
            
            <div class="row">
                <label class="col-xs-12">56 - Tipo financiamiento <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="tipofinanciamiento[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,56); else asignar_check(this.value,0,56)" checked="true"> Dinero propio / de familiares </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="tipofinanciamiento[]" value="2" onClick="if (this.checked) asignar_check(this.value,1,56); else asignar_check(this.value,0,56)"> Otros financiamientos regionales, provinciales y/o nacionales </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="tipofinanciamiento[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,56); else asignar_check(this.value,0,56)"> A través de la banca tradicional </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="56" name="56" value="1">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">

                </div>
            </div>
        
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Empleo</h4>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">57 - Además de usted, ¿trabaja alguien más en el emprendimiento?</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio57" onclick="asignar(57,this.value)" checked="true"> NO</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio57" onclick="asignar(57,this.value)" > SI</label> <br/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="57" name="57" value="0">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">¿Cuántos y en qué condición?</div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">58 - Socios/as</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="58" name="58" class="form-control" value="0" min="0" max="999" onkeyup="imposeMinMax(this)">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">59 - Empleados/as</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="59" name="59" class="form-control" value="0" min="0" max="999" onkeyup="imposeMinMax(this)">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">60 - Otros/as</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="60" name="60" class="form-control" value="0" min="0" max="999" onkeyup="imposeMinMax(this)">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">61 - Colaboradores familiares</div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="61" name="61" class="form-control" value="0" min="0" max="999" onkeyup="imposeMinMax(this)">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">62 - Colaboradores <b>no</b> familiares </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="number" id="62" name="62" class="form-control" value="0" min="0" max="999" onkeyup="imposeMinMax(this)">
                </div>
            </div>
            
            
            <div id="divcapacitacion">&nbsp;</div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Capacitación</h4> 
                </div>
            </div>
            
            <div class="row">
                <label class="col-xs-12">63 - Últimamente, ¿ha detectado alguna necesidad en lo que respecta a capacitación? ¿En qué área? <span style="color:red">*</span></label>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="1" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)" checked="true"> No ha detectado necesidad de capacitación </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="2" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Marketing y Comercialización </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="3" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Exportación </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="4" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Capacitación Orientada al rubro productivo </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="5" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Administración </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="6" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Jurídicas </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="7" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Contables </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="8" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Sanidad Animal / Bromatología </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="9" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Registro de Marcas y Patentes </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label><input type="checkbox" name="capacitacion[]" value="10" onClick="if (this.checked) asignar_check(this.value,1,63); else asignar_check(this.value,0,63)"> Redes Sociales </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="63" name="63" value="1">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">&nbsp; </div>
            </div>

            <div class="row d-none">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">64 - Ha participado de algún otro programa o línea de acompañamiento del Ministerio de Desarrollo Social? En cuáles ? </div>
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="0" name="radio62" onclick="asignar(64,this.value)"checked="true"> No, ninguno</label> <br/>
                    <label class="radio-inline"><input type="radio" value="1" name="radio62" onclick="asignar(64,this.value)"> Manos Entrerrianas</label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio62" onclick="asignar(64,this.value)"> Impulsate</label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio62" onclick="asignar(64,this.value)"> Crédito Jóven</label> <br/>
                    <label class="radio-inline"><input type="radio" value="4" name="radio62" onclick="asignar(64,this.value)"> Cuidadores de la Casa Común</label> <br/>
                    <label class="radio-inline"><input type="radio" value="5" name="radio62" onclick="asignar(64,this.value)"> Incorp de Tecnología</label> <br/>
                    <label class="radio-inline"><input type="radio" value="6" name="radio62" onclick="asignar(64,this.value)"> Crecer</label> <br/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <input type="hidden" id="64" name="64" value="0">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">&nbsp; </div>
            </div>
            
            <div id="divobservacion">&nbsp;</div>
            
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-5 text-center text-primary">
                    <h4>Consultas y observaciones a completar por el Encuestador</h4> 
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    Explicitar cualquier obstáculo, sugerencia u observación planteada por el emprendedor para colaborar en resolverlo. (Abierta)
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <input type="text" id="65" name="65" class="form-control fuente" value=" ">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    &nbsp;
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    Semáforo - clasifique el emprendimiento
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12 mb-4">
                    <label class="radio-inline"><input type="radio" value="1" name="radio66" onclick="asignar(66,this.value)" checked="true"> <span class="btn btn-success"> Verde</span> </label> <br/>
                    <label class="radio-inline"><input type="radio" value="2" name="radio66" onclick="asignar(66,this.value)"> <span class="btn btn-warning"> Amarillo</span> </label> <br/>
                    <label class="radio-inline"><input type="radio" value="3" name="radio66" onclick="asignar(66,this.value)"> <span class="btn btn-danger"> Rojo</span> </label> <br/>
                    <input type="hidden" name="66" id="66" value="1">
                </div>
            </div>
            
        </div>
        <!-- FIN DE LOS QUE CONTINUAN PROYECTOS -->

        </form>
    </div>

    <script src="bootstrap-4.3.1/dist/js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1/dist/js/select2.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1/dist/js/ymz_box.min.js" type="text/javascript"></script>

    <script type="text/javascript">

        function imposeMinMax(el) {
            if (el.value != "") {
                if (parseInt(el.value) < parseInt(el.min)) {
                    el.value = 0;
                }
                if (parseInt(el.value) > parseInt(el.max)) {
                    el.value = 0;
                }
            }
        }

        $(document).ready(function(){
            $("#1, #2, #3").select2();
        });
        
        $('.fuente').on('input', function () { 
            this.value = this.value.replace(/[^0-9a-zA-ZñÑáéíóúÁÉÍÓÚ;.,@ _-]/g,'');
        });

        function ver_funcionamiento(id){
            switch(id) {
                case '1':     // INCIO EL PROYECTO
                    $("#div_continua").show();
                    $("#div_inicia").hide();
                    $("#div_abandona").hide();
                    $("#productoproducido").select();
                    break;
                case '2':     // ESTA POR INCIAR
                    $("#div_inicia").show();
                    $("#div_continua").show();
                    $("#div_abandona").hide();
                    $("#productoproducido").select();
                    break;
                case '3':
                    // NO CONTINUA
                    $("#div_abandona").show();
                    $("#div_inicia").hide();
                    $("#div_continua").hide();
                    $("#porqueabandono").select();
                    break;
                case '4':
                // NO SE PUDO REALIZAR CONTACTO
                    $("#div_abandona").hide();
                    $("#div_inicia").hide();
                    $("#div_continua").hide();
                    break;
            }
        }

        function chequear(){

            var valido  = true;
            var aux     = '';

            for(i=1; i < 4; i++){
                var valor = $("#"+i).val();
                if(valor <= 0){
                    ymz.jq_alert({title:"Complete", text:"Responda " + i, ok_btn:"Ok", close_fn:null});
                    valido = false;
                    $("#"+i).focus();
                    break;
                }else{
                    aux += valor + ";" ;
                }
            }

            if(valido){

                var estado = $("#3").val();

                if(estado == 1 || estado == 2) { // FUNCIONANDO // POR INICIAR

                    if(estado == 2){

                        for(i=8; i < 14; i++){
                            var valor = $.trim($("#"+i).val());
                            if(valor.length == 0){
                                valor = "-";
                            }
                            aux += valor + ";" ;
                        }
                    }

                    for(i=14; i < 67; i++){
                        var valor = $.trim($("#"+i).val());
                        if(valor.length == 0){
                            valor = "-";
                        }
                        aux += valor + ";" ;
                    }

                    var aux = aux.substring(0, aux.length-1); // LE QUITO LA ULTIMA COMA

                    // DESMARCAR LA SIGUIENTE LINEA PARA CONTROLAR LA CADENA QUE GENERA EL SCRIPT
                    // ymz.jq_alert({title:"Resultado", text:aux, ok_btn:"Ok", close_fn:null});
                    Guardar_Android(aux);
                }

                if(estado == 3){    // DESISTIO
                    if (($("input[name*='mdesistio']:checked").length)<=0){
                        ymz.jq_alert({title:" Porqué motivo desistio ? ", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                        $("#mdesistio").focus();
                        return false;
                    }else{
                        for(i=4; i < 8; i++){
                            var valor = $.trim($("#"+i).val());
                            if(valor.length == 0){
                                valor = "-";
                            }
                            aux += valor + ";" ;
                        }
                        var aux = aux.substring(0, aux.length-1); // LE QUITO LA ULTIMA COMA
                        //ymz.jq_alert({title:"Resultado", text:aux, ok_btn:"Ok", close_fn:null});
                        Guardar_Android(aux);
                    }
                }

                if(estado == 4){     // NO SE PUDO REALIZAR CONTACTO
                    var aux = aux.substring(0, aux.length-1); // LE QUITO LA ULTIMA COMA
                    //ymz.jq_alert({title:"Resultado", text:aux, ok_btn:"Ok", close_fn:null});
                    Guardar_Android(aux);
                }

            }else{
                return false;
            }

        }

        function Guardar_Android(texto){
            Android.guardar(texto);
        }

        function salida() {
            Android.salir();
        }

        function acerca(){
            var texto = 'Desarrollo Emprendedor / (343) 4840964';
            ymz.jq_alert({title:"Sistemas", text:texto, ok_btn:"Ok", close_fn:null});
        }

        function asignar(id,valor){
            document.getElementById(id).value = valor;
        }

        function asignar_check(id,operacion,idSelect){

            var aux = document.getElementById(idSelect).value.toString();

            var arreglo = aux.split(',');

            if(operacion == 1){         // Agrega valor
                aux = '';
                for(i=0; i < arreglo.length ; i++){
                    if(arreglo[i] == 0){
                        ;
                    }else{
                        aux = aux + ',' + arreglo[i] ;
                    }
                }
                document.getElementById(idSelect).value = id + aux;
            }else{                      // Quitar valores

                for(i=0; i < arreglo.length ; i++){
                    if(arreglo[i] == id){
                        arreglo.splice(i, 1);
                        break;
                    }
                }
                aux = arreglo.toString();
                var arreglo = aux.split(',');
                aux = '';

                for(i=0; i < arreglo.length ; i++){
                    if(arreglo[i] == 0){
                        ;
                    }else{
                      aux = aux + ',' + arreglo[i] ;
                    }
                }

                if(i == 1){
                    document.getElementById(idSelect).value = 0;
                }else{
                    document.getElementById(idSelect).value = aux;
                }
            }
        }
    </script>

</body>
</html>

<?php
mysqli_close($con);
