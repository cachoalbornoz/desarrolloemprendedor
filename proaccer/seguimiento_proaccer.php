<?php 
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();

?>
    
<div class="card">
    
    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                RELEVAMIENTO ON-LINE - <strong>PROYECTOS PROACCER </strong>
            </div>
        </div>
    </div>
    <div class="card-body">  
        
        <form id="relevamiento" method="post" action="agregar_seguimiento_ol.php">

        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label>Titular del proyecto </label>
                    <select id="id_proyecto" name="id_proyecto" required class="form-control select">
                        <option value="" disabled selected>Seleccione emprendedor</option>
                        <?php
                        $registro  = mysqli_query($con, 
                        "SELECT  t3.id_proyecto, t1.apellido, t1.nombres, t1.cuit
                        FROM solicitantes t1
                        INNER JOIN rel_proyectos_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
                        INNER JOIN proyectos t3 ON t2.id_proyecto = t3.id_proyecto
                        INNER JOIN habilitaciones t4 ON t1.id_solicitante = t4.id_solicitante
                        INNER JOIN proaccer_inscripcion t5 ON t1.id_solicitante = t5.id_solicitante
                        LEFT JOIN proaccer_seguimientos t6 ON t5.id = t6.id_proyecto
                        WHERE t1.id_responsabilidad = 1 AND t4.id_programa = 2 AND t4.habilitado = 1 AND t6.resultado_final > 49
                        ORDER BY t1.apellido, t1.nombres");

                        while($fila = mysqli_fetch_array($registro)){ ?>
                            <option value=<?php echo $fila[0] ?>><?php echo ucwords(strtolower($fila[1].', '.$fila[2].' ('.$fila[3].')')) ; ?></option>
                        <?php
                        }
                        ?> 
                    </select>
                </div>
                <div class="col">
                    <label>Estado</label>
                    <select id="estado" name="estado" onchange="ver_funcionamiento(this.value)" required class="form-control">
                        <option value="" disabled selected>Seleccione una opcion ...</option>                    
                        <option value="1">Funcionando</option>
                        <option value="3">Desistió de la idea</option>
                        <option value="4">No se puede realizar contacto</option>
                    </select>
                </div>
            </div>
        </div>

        <br>    
            
        <div id="div_abandona" style="display:none">
            
            <br/>
            
            <table class="table table-condensed"> 
                <tr>
                    <td>
                        <label>
                            Porqué motivo desistió ?                     
                        </label>
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
                        <label>
                            Tiene pensado volver a funcionar ?
                        </label>                        
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
                        &nbsp;
                    </td>
                </tr>
            </table>             
        </div>   
        <!-- FIN DE LOS QUE DESISTIERON --> 
        
        <div id="div_continua" style="display:none">
            
            <table class="table table-condensed"> 
                <tr class="bg-secondary table-bordered">
                    <td>
                        COMERCIALIZACION
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>¿En qué mercados coloca / colocará su producción?</b> <span style="color:red"> *</span> <small>(puede elegir más de una)</small>
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
                        <input type="checkbox" name="mercado[]" value="3"> Provincial
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mercado[]" value="4"> Nacional
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="mercado[]" value="5"> Internacional
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
                        <b>¿Dónde vende sus productos ? </b> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="1" checked="true"> En Internet</label>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="2"> En Ferias</label>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="3"> Venta a domicilio</label>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="4"> En local comercial propio</label>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="5"> En locales comerciales de terceros</label>
                        <label class="radio-inline"><input type="radio" name="dondevende" value="6"> En local comercial compartido con otros Emprendedores</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        Preguntar y completar según corresponda
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><i>Producto/Servicio 1</i></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a CONSUMIDOR FINAL <input type="text" id="pventaserv1" name="pventaserv1" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a INTERMEDIARIO    <input type="text" id="pintermediarioserv1" name="pintermediarioserv1" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL <input type="text" id="pventainteralconsumserv1" name="pventainteralconsumserv1" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><i>Producto/Servicio 2</i></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a CONSUMIDOR FINAL <input type="text" id="pventaserv2" name="pventaserv2" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a INTERMEDIARIO    <input type="text" id="pintermediarioserv2" name="pintermediarioserv2" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        Precio de venta a del INTERMEDIARIO al CONSUMIDOR FINAL <input type="text" id="pventainteralconsumserv2" name="pventainteralconsumserv2" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" id="pventaserv3" name="pventaserv3" class="form-control" value="-">
                        <input type="hidden" id="pintermediarioserv3" name="pintermediarioserv3" class="form-control" value="-">
                        <input type="hidden" id="pventainteralconsumserv3" name="pventainteralconsumserv3" class="form-control" value="-">
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Ha conocido, mediante la participación en <b>PROACCER</b>, alguna feria o evento referido a su emprendimiento?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="conoceferia" value="0" onclick="vernombreferia()" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="conoceferia" value="1" onclick="vernombreferia()"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divnombreferia" style="display: none">
                            Nombre de la feria en la cual ha participado
                            <input type="text" class="form-control" name="nombreferia" value=" " />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Participó o proyecta participar de la misma?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="participoferia" value="0" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="participoferia" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        Cuál/es son las principales limitantes para participar o desistir de la misma? 
                        <input type="text" id="limitanteferias" name="limitanteferias" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Si proyecta participar </b>, cuál es su principal interés? (pueden ser varios) <span style="color:red">*</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="interesf[]" value="1" checked> Ampliar mercados
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="interesf[]" value="2"> Conocer nuevos clientes y proveedores
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="interesf[]" value="3"> Conocer mejor a la competencia
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="interesf[]" value="4"> Difundir su marca
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="interesf[]" value="5" onchange="ver_interes()"> Otros
                        <div id="divotrointeres" style="display: none">
                            <input type="text" id="otrointeres" name="otrointeres" class="form-control" placeholder="Qué interés persigue participando de la feria ?">
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
                        <b>Si ya participó </b>, cuál diría que fueron los resultados de su participación? (pueden ser varios) <span style="color:red">*</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="1" checked> Ampliar mercados
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="2"> Conocer nuevos clientes y proveedores
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="3"> Conocer mejor a la competencia
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="4"> Difundir su marca
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="5"> No obtuve ningún resultados
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="resultadosf[]" value="6" onchange="ver_resultado()"> Otros
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divotroresultado" style="display: none">
                            <input type="text" id="otroresultado" name="otroresultado" class="form-control"  placeholder="Cuál fue el otro resultado de participar en la feria ?">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr class="bg-secondary table-bordered">
                    <td>
                        PRODUCCION
                    </td>
                </tr>
                <tr >
                    <td>
                        <label>¿En qué actividad se enmarca su emprendimiento? <span style="color:red"> *</span></label>
                    </td>
                </tr>
                <tr>
                    <td>                        
                        <select id="tipoactividad" name="tipoactividad" class="form-control">
                            <option value="1">SECTOR AGROPECUARIO</option>
                            <option value="2">INDUSTRIA MANUFACTURERA</option>
                            <option value="3" selected>SERVICIOS VINCULADOS A LOS RUBROS (AGRO e INDUSTRIA)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        En qué <b>actividad específica</b> se enmarca su emprendimiento ? <small>Nota: en el apartado anterior, debe describirse la actividad que realiza el emprendedor, para luego catalogarlo en el código AFIP </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        Describa <input type="text" id="actividadafip" name="actividadafip" class="form-control" value=" ">
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
                        ¿Qué <b>produce / producirá </b> su emprendimiento?
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
                        ¿En qué <b>cantidades</b> (mensuales) ?
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
                        ¿<b>Costos</b> por unidad?
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
                        Es un producto Exportable ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="esexportable" value="0" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="esexportable" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Tiene deseos de exportarlo?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="0" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="deseaexportar" value="1"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>                
                <tr class="bg-secondary table-bordered">
                    <td>
                        CONTROL
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
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="1" checked="true">SI MANUAL</label>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="2">SI SISTEMATIZADO</label>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcontable" value="3"> NO REALIZA CONTROL</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Cuáles considera Ud. cómo los principales costos de su emprendimiento?
                    </td>
                </tr>
                <tr>
                    <td>
                        Costo 1 <input type="text" class="form-control" name="costoemp1"> <br/>
                        Costo 2 <input type="text" class="form-control" name="costoemp2"> <br/>
                        Costo 3 <input type="text" class="form-control" name="costoemp3"> <br/>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Realiza algún tipo de <b>control de costos</b> de las operaciones de su emprendimiento?
                    </td>
                </tr>
                <tr>
                    <td>   
                        <label class="radio-inline"><input type="radio" name="tipocontrolcostos" value="1" checked="true"> MANUAL</label>
                        <label class="radio-inline"><input type="radio" name="tipocontrolcostos" value="2"> SISTEMATIZADO</label>
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
                        <label class="radio-inline"><input type="radio" name="tipocontrolinsumos" value="2"> SISTEMATIZADO</label>
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
                        <label class="radio-inline"><input type="radio" name="tipocontrolstock" value="2"> SISTEMATIZADO</label>
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
                        <label class="radio-inline"><input type="radio" name="tipocontrolproduccion" value="2"> SISTEMATIZADO</label>
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
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="2"> Cuento con la mayoría de las habilitaciones</label>
                        <label class="radio-inline"><input type="radio" name="tipohabilitacion" value="3"> Cuento con algunas habilitaciones</label>
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
                        <label class="radio-inline"><input type="radio" name="frases" value="2"> No doy abasto con la producción, tengo más pedidos que capacidad productiva</label>
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
                <tr class="bg-secondary table-bordered">
                    <td>
                        Aporte no reintegrable de PROACCER y acompañamiento de tutores
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        ¿Encontró alguna complicación a la hora de realizar la inversión del aporte no reembolsable recibido por parte del PROACCER ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="complicainv" value="0" onclick="vercomplicainv()" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="complicainv" value="1" onclick="vercomplicainv()"> SI</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="divcomplicainv" style="display: none">
                            Cuál ?
                            <input type="text" class="form-control" name="complicacion" value=" " >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Ud. diría que a partir del aporte PROACCER pudo <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="1" checked="true"> Conseguir participar en nuevos mercados
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="2"> Mejorar la presentación de su marcar / emprendimiento
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="3"> Definir mejor la escructura de costos
                    </td>
                </tr>  
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="4"> Repensar la misión / visión de su emprendimiento
                    </td>
                </tr> 
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="5"> Vincularse a nuevos profesionales o técnicos
                    </td>
                </tr>   
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="6"> Modificar la esctructura administrativa de la empresa
                    </td>
                </tr>  
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="7"> Cumplimentar tareas referidas a habilitaciones municipales o provinciales
                    </td>
                </tr>  
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="8"> Ninguna de las anteriores
                    </td>
                </tr>  
                <tr>
                    <td>
                        <input type="checkbox" name="aportepudo[]" value="9"> Otras ¿Cuáles?
                    </td>
                </tr>  
                <tr>
                    <td>
                        <input type="text" class="form-control" name="aportepudootra" placeholder="Qué otros objetivos pudo concretar ?"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Además del aporte no reintegrable del PROACCER, ¿ha invertido más capital en el proyecto?</b>
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="invirtiomascapital" value="0" checked="true"> NO</label>
                        <label class="radio-inline"><input type="radio" name="invirtiomascapital" value="1"> SI</label>
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
                        <input type="checkbox" name="tipofinanciamiento[]" value="1" checked="true"> Dinero propio 
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="2"> Dinero de familiares
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="3"> Financiamiento de un programa <b>Municipal</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="4"> Financiamiento de un programa <b>Provincial</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="5"> Financiamiento de un programa <b>Nacional</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="6"> Banca tradicional
                    </td>
                </tr>                    
                <tr>
                    <td>
                        <input type="checkbox" name="tipofinanciamiento[]" value="7"> Otro 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr> 
                <tr>
                    <td>
                        Mencione otra fuente  <input type="text" name="otrotipofinanciamiento" value="" class="form-control"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>  
                <tr>
                    <td>
                        ¿Cómo evalúa la <b>experiencia de trabajo</b> junto al tutor propuesto por la Secretaría de Desarrollo Emprendedor ?
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="1" checked="true"> Excelente</label>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="2" > Muy buena</label>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="3" > Buena</label>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="4" > Regular</label>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="5" > Mala</label>
                        <label class="radio-inline"><input type="radio" name="evaluaciontutor" value="6" > Muy mala</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>  
                <tr>
                    <td>
                        ¿Qué recomendaciones realizaría para mejorar el <b>Programa de Apoyo al Comercio Emprendedor</b> ?
                    </td>
                </tr> 
                <tr>
                    <td>
                        <input type="text" class="form-control" name="recomendaciones" />
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>               

                <tr class="bg-secondary table-bordered">
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
                        En caso de ser afirmativo ¿Cuántos y en que condición?
                    </td>
                </tr>
                <tr>
                    <td>
                        Socios/as: <input type="number" id="cantsocios" name="cantsocios" class="form-control" value="0"> <br/>
                    
                        Empleados/as registrados/as: <input type="number" id="cantempleados" name="cantempleados" class="form-control" value="0"> <br/>
                    
                        Colaboradores familiares: <input type="number" id="colaborafami" name="colaborafami" class="form-control" value="0"> <br/>
                    
                        Colaboradores <b>no</b> familiares: <input type="number" id="colaboranofami" name="colaboranofami" class="form-control" value="0"> <br/>
                    
                        Otros/as : <input type="number" id="cantotros" name="cantotros" class="form-control" value="0"> <br/>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div id="divcapacitacion"></div>
                    </td>
                </tr>
                <tr class="bg-secondary table-bordered">
                    <td>
                        CAPACITACION
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Últimamente, ¿ha detectado alguna necesidad en lo que respecta a capacitación? ¿En qué área?</b> <span style="color:red"> *</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="1" checked="true"> No ha detectado necesidad de capacitación</>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="capacitacion[]" value="2"> Marketing y Comercialización</>
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
                <tr>
                    <td>
                        Ha participado de algún otro programa o línea de acompañamiento de la SubSecretaria de Desarrollo Emprendedor? En cuáles ?
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="programafinancsub" value="0" checked="true"> No, ninguno</label>
                        <label class="radio-inline"><input type="radio" name="programafinancsub" value="1" > Programa Jóvenes Emprendedores</label>
                        <label class="radio-inline"><input type="radio" name="programafinancsub" value="2" > Programa Formación de Competencias Emprendedoras</label>
                        <label class="radio-inline"><input type="radio" name="programafinancsub" value="3" > Tutorías</label>
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
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="0" checked="true"> No, ninguno</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="1" > Manos Entrerrianas</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="2" > Impulsate</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="3" > Crédito Jóven</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="4" > Cuidadores de la Casa Común</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="5" > Incorp de Tecnología</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="6" > Crecer</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="7" > Micro Créditos</label>
                        <label class="radio-inline"><input type="radio" name="programafinanc" value="8" > Otro </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        Mencione otro programa o línea de acompañamiento
                        <input type="text" class="form-control" name="otroprogramafinanc">
                    </td>
                </tr>
            </table>    
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <br/>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col">
                    <span class="text-danger">(*)</span> Datos obligatorios
                </div>
            </div>
        </div>

        <div id="spopup" style="display: none;">
            <div class="btn-group" role="group" aria-label="botones">
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

    .hidden{ 
        display: none;
    }

</style>

<script type="text/javascript"> 

    $(window).scroll(function(){
        if($(document).scrollTop()>= ($(document).height()/50))
            $("#spopup").show("slow");
        else
            $("#spopup").hide("slow");
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

    function vernombreferia(){
        $("#divnombreferia").toggle();
        $("#nombreferia").select();
    }

    function vercomplicainv(){
        $("#divcomplicainv").toggle();
    }

    function ver_desistio(){
        $("#otro_desistio").toggle();        
    }

    function ver_interes(){
        $("#divotrointeres").toggle();        
    }

    function ver_resultado(){
        $("#divotroresultado").toggle();        
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