<?php 
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();

?>
    
<div class="card">
    
    <div class="card-header">      
        <div class="row mb-3">
            <div class="col-lg-6">
                RELEVAMIENTO ON-LINE - <strong>PROYECTOS FINANCIADOS </strong>
            </div>
            <div class="col-lg-6">
                Form-2017
            </div>
        </div>
    </div>
    
    <div class="card-body">  
        
        <form id="relevamiento" method="post" action="agregar_seguimiento_ol.php" onsubmit="return chequear();">
    
        <div class="row mt-5 mb-5">	
            <div class="col-xs-12 col-sm-9 col-lg-9 mb-3">
            
                <select id="id_expediente" name="id_expediente" required class="form-control">
                <option value="" disabled selected>Titular del proyecto</option>
                <?php
                $registro  = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres,emp.cuit,te.estado,rp.rubro   
                from expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp 
                where exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor and 
                exp.estado = te.id_estado and exp.id_rubro = rp.id_rubro and emp.id_responsabilidad = 1 
                group by exp.id_expediente order by emp.apellido,emp.nombres asc");
                while($fila = mysqli_fetch_array($registro)){ ?>
                <option value=<?php echo $fila[0] ?>><?php echo ucwords(strtolower($fila[1].', '.$fila[2].'('.$fila[3].') '.$fila[5])) ?></option>
                <?php
                }
                ?> 
                </select>                
            </div>
         
            <div class="col-xs-12 col-sm-3 col-lg-3 mb-3">   
             
                <select id="estado" name="estado" required onchange="ver_funcionamiento(this.value)" class="form-control">
                    <option value="" disabled selected>Estado proyecto</option>
                    <option value="1">Funcionando</option>
                    <option value="2">En vias de funcionar</option>
                    <option value="3">Desistió de la idea</option>
                    <option value="4">No se puede realizar contacto</option>
                </select>
                
            </div>
        </div>       
            
        <div id="div_abandona" class="mt-5 mb-5" style="display:none">
            
            <table class="table table-striped"> 
                <tr>
                    <td>
                        <label>Porqué motivo desistió ? <span style="color:red">*</span></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="1" checked> No fue Rentable
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="2"> Falta Capital Inicial
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="3"> Surgió una Mejor Oportunidad (cambio de rubro del emprendimiento, asociación a otro emprendedor, o en relación de dependencia)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="4"> Cuestiones de Fuerza Mayor (robos, problemas climáticos, razones personalísimas u otras similares)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="5"> No pude dedicarle más Tiempo
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="6"> Problemas internos (mal manejo de la producción, disolución de la sociedad u otros similares)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"  name="mdesistio[]" value="7"> Problemas externos (cambios abruptos en los costos, mercado en baja, problemas de financiamiento)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mdesistio[]" value="8" onchange="ver_desistio()"> Otros
                        <div id="otro_desistio" style="display: none">
                            <input type="text" id="porqueabandono" name="porqueabandono" class="form-control" placeholder="Mencione otros motivos porqué abandonó el proyecto">
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
                        Tiene pensado volver a funcionar ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="volverafuncionar" value="0" onChange="ver_vuelve(0)" checked> NO</label>
                        <label class="radio-inline"><input type="radio" name="volverafuncionar" value="1" onChange="ver_vuelve(1)"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divuelve" style="display: none">
                            ¿Qué necesita para volver a funcionar ?
                            <input type="text" id="necesita" name="necesita" class="form-control" placeholder="Describa por favor que necesitaria ">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr> 
                <tr>
                    <td>
                        Ha participado de algún otro programa o línea de acompañamiento del Ministerio de Desarrollo Social? En cuáles ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="0" checked="true"> No, ninguno</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="1" > Manos Entrerrianas</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="2" > Impulsate</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="3" > Crédito Jóven</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="4" > Cuidadores de la Casa Común</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="5" > Incorp de Tecnología</label>
                        <label class="radio-inline"><input type="radio" name="programafinancd" value="6" > Crecer</label>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>  
            </table>             
        </div>   
        <!-- FIN DE LOS QUE DESISTIERON --> 
        
        <div id="div_inicia"   class="mt-5 mb-5" style="display:none">            
            <table class="table table-borderless table-condensed"> 
                <tr class="bg-primary">
                    <td colspan="3">
                        <b>INDIQUE DE <strong> 1 a 10 </strong> COMO SE ENCUENTRA CADA UNA DE LAS SIGUIENTES TAREAS . </b>
                    </td>
                </tr>
                <tr>
                    <td>
                        - EMPLAZAMIENTO
                    </td>
                    <td>
                        <input type="range" name="emplazamientoRange" min="0" max="10" value="0" oninput="this.form.emplazamiento.value=this.value" />
                    </td>    
                    <td>    
                        <input type="number" name="emplazamiento" class="text-center" min="0" max="10" value="0" oninput="this.form.emplazamientoRange.value=this.value" /> 
                    </td>                
                </tr>
                <tr>
                    <td>
                        - CONTACTO CON LOS PROVEEDORES
                    </td>
                    <td>
                        <input type="range" name="contactoRange" min="0" max="10" value="0" oninput="this.form.contacto.value=this.value"/>
                    </td>
                    <td>
                        <input type="number" name="contacto" id="contacto" class="text-center" min="0" max="10" value="0" oninput="this.form.contactoRange.value=this.value" /> 
                    </td> 
                </tr>
                <tr>
                    <td>
                        - METODO DE PRODUCCION
                    </td>
                    <td>
                        <input type="range" name="metodoRange" min="0" max="10" value="0" oninput="this.form.metodo.value=this.value"/>
                    </td>
                    <td>
                        <input type="number" name="metodo" id="metodo" class="text-center" min="0" max="10" value="0" oninput="this.form.metodoRange.value=this.value" /> 
                    </td> 
                </tr>
                <tr>
                    <td>
                        - CUESTIONES VINCULADAS CON EL MARKETING
                    </td>
                    <td>
                        <input type="range" name="marketingRange" min="0" max="10" value="0" oninput="this.form.marketing.value=this.value"/>
                    </td>
                    <td>
                        <input type="number" name="marketing" id="marketing" class="text-center" min="0" max="10" value="0" oninput="this.form.marketingRange.value=this.value" /> 
                    </td> 
                </tr>
                <tr>
                    <td>
                        - CUESTIONES VINCULADAS A LOS COSTOS-PRECIOS
                    </td>
                    <td>
                        <input type="range" name="costospRange" min="0" max="10" value="0" oninput="this.form.costosp.value=this.value"/>
                    </td>
                    <td>
                        <input type="number" name="costosp" id="costosp" class="text-center" min="0" max="10" value="0" oninput="this.form.costospRange.value=this.value" /> 
                    </td> 
                </tr>
                <tr>
                    <td>
                        - DEFINICION DE LOS CANALES DE VENTA
                    </td>
                    <td>
                        <input type="range" name="canalesventaRange" min="0" max="10" value="0" oninput="this.form.canalesventa.value=this.value"/>
                    </td>
                    <td>
                        <input type="number" name="canalesventa" id="canalesventa" class="text-center" min="0" max="10" value="0" oninput="this.form.canalesventaRange.value=this.value" /> 
                    </td> 
                </tr>           
            </table>      
        </div>       
        <!-- FIN DE LOS QUE RECIEN INCIAN --> 
        
        <div id="div_continua" class="mt-5 mb-5" style="display:none">
            
            <table class="table table-condensed table-borderless"> 
                <tr class="bg-primary">
                    <td>
                        <b>PRODUCCION</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>¿En qué <strong>actividad</strong> se enmarca su emprendimiento? <span style="color:red"> *</span></label>
                    </td>
                </tr>
                <tr>
                    <td>      
                        <label class="radio-inline">
                            <input type="radio" value="1" id="tipoactividad" name="tipoactividad" checked="true" > SECTOR AGROPECUARIO
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline">
                            <input type="radio" value="2" id="tipoactividad" name="tipoactividad"> INDUSTRIA MANUFACTURERA
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline">
                            <input type="radio" value="3" id="tipoactividad" name="tipoactividad"> SERVICIOS VINCULADOS A LOS RUBROS ANTERIORES
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Qué <strong>produce / producirá</strong> su emprendimiento?
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto / Servicio 1 <input type="text" id="prodserv1" name="prodserv1" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto / Servicio 2 <input type="text" id="prodserv2" name="prodserv2" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto / Servicio 3 <input type="text" id="prodserv3" name="prodserv3" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿En qué <strong>cantidades</strong>?
                    </td>
                </tr>
                <tr>
                    <td>
                        Cantidad / Servicio 1 <input type="text" id="cantserv1" name="cantserv1" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Cantidad / Servicio 2 <input type="text" id="cantserv2" name="cantserv2" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Cantidad / Servicio 3 <input type="text" id="cantserv3" name="cantserv3" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿<strong>Costos</strong> por Unidad?
                    </td>
                </tr>
                <tr>
                    <td>
                        Costos / Servicio 1 <input type="text" id="costosserv1" name="costosserv1" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Costos / Servicio 2 <input type="text" id="costosserv2" name="costosserv2" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        Costos / Servicio 3 <input type="text" id="costosserv3" name="costosserv3" class="form-control" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Código AFIP de la Actividad Principal según encuestador
                    </td>
                </tr>
                <tr>
                    <td>
                        Código <input type="text" id="codigoafip" name="codigoafip" class="form-control" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Es un producto <strong>Exportable</strong> ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="esexportable" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="esexportable" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Tiene deseos de <strong>exportarlo</strong>?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr class="bg-primary">
                    <td>
                        <b>COMERCIALIZACION</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>¿En qué mercados coloca / colocará su producción?</b> <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mercado[]" value="1" checked="true"> Sólo en mi ciudad
                    </td>
                </tr>
                <tr>
                    <td>
                       <input type="checkbox" name="mercado[]" value="2"> En mi ciudad y zonas aledañas
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mercado[]" value="3"> Regional y Provincial
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mercado[]" value="4"> Nacional e Internacional
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divformacomercializacion"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>¿A quién le vende su producción?</b> <span style="color:red"> *</span> <small>(puede elegir más de una)</small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="formacomercializacion[]" value="1" checked="true"> Directamente al consumidor final
                    </td>
                </tr>
                <tr class="hidden">
                    <td>
                        <input type="checkbox" name="formacomercializacion[]" value="2" > Mediante cooperativa
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="formacomercializacion[]" value="3"> Vendedores minoristas
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="formacomercializacion[]" value="4"> Vendedores mayoristas e intermediarios
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>¿Dónde</strong> vende sus productos ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="2" checked="true"> En Ferias</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="3"> Venta a domicilio</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="4"> En local comercial propio</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="5"> En locales comerciales de terceros</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="6"> En local comercial compartido con otros Emprendedores</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="1"> En Internet</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 1 - Precio de venta a CONSUMIDOR FINAL <input type="text" id="pventaserv1" name="pventaserv1" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 1 - Precio de venta a INTERMEDIARIO    <input type="text" id="pintermediarioserv1" name="pintermediarioserv1" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 1 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL <input type="text" id="pventainteralconsumserv1" name="pventainteralconsumserv1" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 2 - Precio de venta a CONSUMIDOR FINAL <input type="text" id="pventaserv2" name="pventaserv2" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 2 - Precio de venta a INTERMEDIARIO    <input type="text" id="pintermediarioserv2" name="pintermediarioserv2" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 2 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL <input type="text" id="pventainteralconsumserv2" name="pventainteralconsumserv2" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 3 - Precio de venta a CONSUMIDOR FINAL <input type="text" id="pventaserv3" name="pventaserv3" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 3 - Precio de venta a INTERMEDIARIO    <input type="text" id="pintermediarioserv3" name="pintermediarioserv3" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Producto/Servicio 3 - Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL <input type="text" id="pventainteralconsumserv3" name="pventainteralconsumserv3" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Conoce algunas ferias donde puede comercializar su producción?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="conoceferia" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="conoceferia" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Ha participado de alguna feria?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="participoferia" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="participoferia" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Le interesaría participar de las ferias?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="interesparticipar" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="interesparticipar" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Cuál considera son las limitantes para participar de las ferias?
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="limitanteferias" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr> 
                <tr class="bg-primary" >
                    <td>
                        <b>CONTROL</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza algún tipo de <b>Registro / Anotación</b> de las operaciones de su emprendimiento?
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="1" checked="true"> MANUAL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="2"> SISTEMATIZADO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Cuáles considera Ud. como los principales <b>costos</b> de su emprendimiento ? 
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Costo1 <input type="text" id="costoemp1" name="costoemp1" class="form-control" value="-"/> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Costo2 <input type="text" id="costoemp2" name="costoemp2" class="form-control" value="-"/> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Costo3 <input type="text" id="costoemp3" name="costoemp3" class="form-control" value="-"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza algún tipo de <b>Cálculo de los Costos</b> de sus emprendimiento ?
                    </td>
                </tr> 
                <tr>
                    <td>   
                        <label class="radio-inline"><input type="radio" name="tipocontrolcostos" value="1" checked="true"> MANUAL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcostos" value="2"> SISTEMATIZADO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcostos" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza alguna <b>Planilla de producción con Detalle de Insumos</b> utilizados ? 
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolinsumos" value="1" checked="true"> MANUAL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolinsumos" value="2"> SISTEMATIZADO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolinsumos" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza alguna <b>Planilla de Stock de Mercaderia</b> de su emprendimiento ? 
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolstock" value="1" checked="true"> MANUAL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolstock" value="2"> SISTEMATIZADO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolstock" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza alguna <b>Planilla de Stock de Producción</b> de su emprendimiento ? 
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolproduccion" value="1" checked="true"> MANUAL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolproduccion" value="2"> SISTEMATIZADO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipocontrolproduccion" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        En relación a las habilitaciones e impuestos vinculados a su actividad específica, usted diría que :
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="1" checked="true"> Tengo todas las habilitaciones</label>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="2"> Cuento con la mayoría de las habilitaciones</label>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="3"> Cuento con algunas habilitaciones</label>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="4"> Aún no he realizado ningún trámite de habilitación</label>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>¿Con cuál de las siguientes frases se siente más identificado?<span style="color:red"> *</span></label>
                    </td>
                </tr> 
                <tr>
                    <td> 
                        <label class="radio-inline"><input type="radio" name="frases" value="1" checked="true"> Mi capacidad productiva está bien, me cuesta vender</label>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label class="radio-inline"><input type="radio" name="frases" value="2"> No doy abasto con la producción, tengo más pedidos que capacidad productiva</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="frases" value="3"> Mi emprendimiento está equilibrado entre producción y demanda</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divproblemacrecimiento"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>¿Cuáles cree que son los principales problema para su crecimiento ?</b> <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="1" checked="true"> Costo de Producción
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="2"> Método de Produción
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="3"> Poca capacidad de Producción
                    </td>
                </tr>
                <tr>
                    <td>
                       <input type="checkbox" name="problemacrecimiento[]" value="4"> Poca capacidad de Venta
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="5"> Los costos de los Intermediarios
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="6"> La gran cantidad de Competencia
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="7"> Problemas administrativos propios
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="8"> Problemas burocráticos relacionados con habilitaciones, reglamentaciones, etc... 
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="problemacrecimiento[]" value="9" onclick="ver_problema_crecimiento()"> Otros problemas, cuáles ? 
                        <div id="div_otro_crecimiento" style="display: none">
                            <input type="text" id="otrocrecimiento" name="otrocrecimiento" class="form-control" value=" ">
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr class="bg-primary">
                    <td>
                        <b>FINANCIAMIENTO</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Además del financiamiento del programa Jóvenes Emprendedores, ¿ha invertido más capital en el proyecto?</b>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="invirtiomascapital" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="invirtiomascapital" value="0" checked="true"> NO</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divtipofinanciamiento"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tipo de Financiamiento </b> <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="1" checked="true"> Dinero propio / de familiares
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="2"> Otros financiamientos regionales, provinciales y/o nacionales
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="3"> A través de la banca tradicional
                    </td>
                </tr>                    
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>        
                <tr class="bg-primary">
                    <td>
                        EMPLEO
                    </td>
                </tr>
                <tr>
                    <td>
                        Además de usted, ¿trabaja alguien más en el emprendimiento?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="trabajaalguienm" value="0" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="trabajaalguienm" value="1" > SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Cuántos y en que condición?
                    </td>
                </tr>
                <tr>
                    <td>
                        Socios/as: <input type="number" id="cantsocios" name="cantsocios" class="form-control" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Empleados/as registrados/as: <input type="number" id="cantempleados" name="cantempleados" class="form-control" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Colaboradores familiares: <input type="number" id="colaborafami" name="colaborafami" class="form-control" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Colaboradores <b>no</b> familiares: <input type="number" id="colaboranofami" name="colaboranofami" class="form-control" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Otros/as : <input type="number" id="cantotros" name="cantotros" class="form-control" value="0">
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div id="divcapacitacion"></div>
                    </td>
                </tr>
                <tr class="bg-primary">
                    <td>
                        <b>CAPACITACION</b> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Últimamente, ¿ha detectado alguna necesidad en lo que respecta a capacitación? ¿En qué área?</b> <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="1" checked="true"> No ha detectado necesidad de capacitación</d>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="2"> Marketing y Comercialización</tr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="3"> Exportación</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="4"> Capacitación Orientada al rubro productivo</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="5"> Administración</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="6"> Jurídicas</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="7"> Contables</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="8"> Sanidad Animal / Bromatología</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="9"> Registro de Marcas y Patentes</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="10"> Redes Sociales</>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr> 
                <tr class="d-none">
                    <td>
                        Ha participado de algún otro programa o línea de acompañamiento del Ministerio de Desarrollo Social? En cuáles ?
                    </td>
                </tr>
                <tr class="d-none">
                    <td>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="0" checked="true"> No, ninguno</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="1" > Manos Entrerrianas</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="2" > Impulsate</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="3" > Crédito Jóven</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="4" > Cuidadores de la Casa Común</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="5" > Incorp de Tecnología</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="6" > Crecer</label>
                    </td>
                </tr>  
                <tr>
                    <td>&nbsp;</td>
                </tr>         
                <tr class="bg-primary">
                    <td>
                        <b>Consultas y observaciones a completar por el Encuestador</b> 
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        Explicar cualquier obstáculo, sugerencia u observación planteada por el emprendedor para colaborar en resolverlo. (Abierta)
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="sugerencia" name="sugerencia" class="form-control fuente" value=" ">
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        Semáforo: Clasifique el emprendimiento:
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <input type="radio" value="1" name="semaforo" checked="true"> <span class="btn btn-success"> Verde</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <input type="radio" value="2" name="semaforo" > <span class="btn btn-warning"> Amarillo</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <input type="radio" value="3" name="semaforo" > <span class="btn btn-danger"> Rojo</span>
                        </label>
                    </td>
                </tr>
                  
            </table>    
            
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-xs-12 col-sm-9 col-lg-9 mb-3">
                
            </div> 
            <div class="col-xs-12 col-sm-3 col-lg-3 mb-3">
                <input type="submit" value="Guardar" class="btn btn-primary btn-block">
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
    
    function chequear(){     
        var valido = true; 
        var estado = $("#estado").val();    
        
        switch(estado) {
            case '1':     // INICIO EL PROYECTO
            case '2':     // ESTA POR INICIAR  
                
                if($("#tipoactividad").val() < 0 ){
                    setTimeout(function(){$("#tipoactividad").focus();},0);
                    ymz.jq_alert({title:"¿En qué actividad se enmarca su emprendimiento ? ", text:"Seleccione ", ok_btn:"Ok", close_fn:null});
                    valido = false;
                }else{                    
                    if (($("input[name*='mercado']:checked").length)<=0){
                        $("input[name*='mercado']")[0].focus();
                        ymz.jq_alert({title:"¿En qué mercados coloca / colocará su producción? ", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                        valido = false;
                    }else{
                        if (($("input[name*='formacomercializacion']:checked").length)<=0) {
                            $("input[name*='formacomercializacion']")[0].focus();
                            ymz.jq_alert({title:"¿De qué manera comercializa/comercializará su producción ? ", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                            valido = false;
                        }else{
                            
                            if($("#frases").val() <= 0){
                                setTimeout(function(){$("#tipocontrolcontable").focus();},0);
                                ymz.jq_alert({title:"CONTROLES ", text:"Item obligatorios sin responder", ok_btn:"Ok", close_fn:null});
                                valido = false;
                            }else{
                                if (($("input[name*='problemacrecimiento']:checked").length)<=0){
                                    $("input[name*='problemacrecimiento']")[0].focus();
                                    ymz.jq_alert({title:"¿Cuáles cree que son los principales problema para su crecimiento ? ", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                                    valido = false;
                                }else{
                                    if($('input:radio[name=invirtiomascapital]:checked').val() == 1 && $("input[name*='tipofinanciamiento']:checked").length <=0 ){
                                        $("input[name*='tipofinanciamiento']")[0].focus();
                                        ymz.jq_alert({title:"Tipo Financiamiento", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                                        valido = false;                                     
                                    }else{
                                        
                                        if (($("input[name*='capacitacion']:checked").length)<=0) {
                                            $("input[name*='capacitacion']")[0].focus();
                                            ymz.jq_alert({title:"Capacitación ¿ha detectado alguna necesidad en lo que respecta a capacitación? ¿En qué área? ", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                                            valido = false;
                                        }                                        
                                    }                                   
                                }
                            }                                                                                    
                        }                  
                    }              
                }    
                         
            break;                
            case '3':     
                // NO CONTINUA
                if (($("input[name*='mdesistio']:checked").length)<=0) {
                    ymz.jq_alert({title:"Porque desistió", text:"Seleccione al menos un item ", ok_btn:"Ok", close_fn:null});
                    valido = false;
                }               
            break;
            case '4':     
               // NO SE PUDO REALIZAR CONTACTO
            break;    
        }      
        
        if(valido){            
            if(confirm("Confirma  enviar los datos ? ")){   
                return true;
            }else{
                return false;
            }            
        }else{
            return false;
        }  
    }   
    
    $(document).ready(function(){
        $("#id_expediente").select2();
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
                break;    
        }
    }
    
    function ver_desistio(){
        $("#otro_desistio").toggle();        
    }

    function ver_comercializacion(){

        var comer = document.getElementById('comercializacion').value;

        if(comer == 2){
            $("#div_comercializacion").show();
            $("#otracomercializacion").focus();
        }else{
            $("#div_comercializacion").hide();
        }       
    }

    function ver_trabajo(id){            

        if(id == 0){
            $("#div_trabajo").show();   
        }else{
            $("#div_trabajo").hide();
        }
    }    
    
    
    function ver_vuelve(id){
               
        if(id == 1){
             $("#divuelve").show();
             $("#vuelve").focus();
         }else{
             $("#divuelve").hide();
         }        
    }
    
    
    function ver_problema_crecimiento(){
        $("#div_otro_crecimiento").toggle();             
    }       
    
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>