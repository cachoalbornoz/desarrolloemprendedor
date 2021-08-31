<?php 
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();

?>


<div class="card">

    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                CARGA DE RESULTADOS       
            </div>                
        </div>
    </div>
    <div class="card-body">
        <div class="row"> 
            <div class="col-md-6">ESTABLECIMIENTO</div>     
            <div class="col-md-2">LATITUD</div>
            <div class="col-md-2">LONGITUD</div>
            <div class="col-md-2">CONTINUA</div>     
        </div>
        
    
    
        <?php

        $lecturas = 1;

        $nombre_archivo = $_FILES['archivo']['name'];
        $archivo_tmp = $_FILES['archivo']['tmp_name'];	

        $archivo = fopen($archivo_tmp,'r') or die('No se puede leer '.$nombre_archivo);

        while (!feof($archivo)){ // RECORRO EL ARCHIVO DE RESPUESTAS
            $registro = explode(';',fgets($archivo));

            if(isset($registro[0]) and isset($registro[1])){
                $id_expediente = $registro[3];         

                $formajuridica = explode(';',$registro[22]);

                $porqueabandono     = lcadena($registro[5]);
                $productoproducido  = lcadena($registro[7]);
                $cantidadproducida  = lcadena($registro[8]);
                $mercado            = lcadena($registro[9]);
                $comprador          = lcadena($registro[10]);
                $otracomercializacion=lcadena($registro[12]);
                $porqueexportar     = lcadena($registro[14]);
                $porquenoregistrado = lcadena($registro[20]);
                $necesitacapacitacion=lcadena($registro[21]);     

                $seleccion_proyectos = mysqli_query($con, "select id_expediente from seguimiento_expedientes where id_expediente = $id_expediente");

                if(mysqli_num_rows($seleccion_proyectos) == 0){
                    mysqli_query($con, "insert into seguimiento_expedientes 
                    (id_usuario,latitud,longitud,id_expediente,funciona,porqueabandono,volverafuncionar,productoproducido,cantidadproducida,mercado,comprador,comercializacion,
                    otracomercializacion,interesexportar,porqueexportar,conocerequisitosexportar,capacitarseexportar,cuantosempleados,cuantosfamiliares,cuantosinscriptas,porquenoregistrado,necesitacapacitacion,id_forma_juridica)
                    values
                    ($registro[2],$registro[0],$registro[1],$registro[3],$registro[4],'$porqueabandono',$registro[6],'$productoproducido','$cantidadproducida','$mercado','$comprador',$registro[11],
                    '$otracomercializacion',$registro[13],'$porqueexportar',$registro[15],$registro[16],$registro[17],$registro[18],$registro[19],'$porquenoregistrado','$necesitacapacitacion',$formajuridica[0])") 
                    or die('Revisar Escritura de Expedientes') ;
                }else{
                    mysqli_query($con,"UPDATE seguimiento_expedientes SET
                    id_usuario = $registro[2], latitud = $registro[0], longitud = $registro[1], funciona = $registro[4], porqueabandono = '$porqueabandono',volverafuncionar = $registro[6],
                    productoproducido = '$productoproducido', cantidadproducida = '$cantidadproducida',mercado='$mercado',comprador = '$comprador', comercializacion = $registro[11],
                    otracomercializacion = '$otracomercializacion',interesexportar = $registro[13],porqueexportar='$porqueexportar',conocerequisitosexportar=$registro[15],capacitarseexportar=$registro[16],cuantosempleados=$registro[17],cuantosfamiliares=$registro[18],cuantosinscriptas=$registro[19],porquenoregistrado='$porquenoregistrado',necesitacapacitacion='$necesitacapacitacion',id_forma_juridica=$formajuridica[0]
                    where id_expediente = $id_expediente" ) or die('Revisar Actualización Relevamiento de Expedientes');
                }


                $tabla_relevamiento = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres, seg.latitud, seg.longitud, seg.funciona  
                from expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, seguimiento_expedientes as seg
                where exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor 
                and exp.id_expediente = seg.id_expediente and emp.id_responsabilidad = 1 and exp.id_expediente = $id_expediente order by emp.apellido,emp.nombres asc") ;

                $registro_relevam = mysqli_fetch_array($tabla_relevamiento);				
                ?>	
                <div class="row"> 
                    <div class="col-md-6"><?php echo $lecturas.'- '.$registro_relevam[1].' '.$registro_relevam[2] ?></div>     
                    <div class="col-md-2"><?php echo $registro_relevam[3] ?></div>
                    <div class="col-md-2"><?php echo $registro_relevam[4] ?></div>
                    <div class="col-md-2"><?php if($registro_relevam[5] == 1){ echo "SI" ;}else{echo " - ";};	?></div>      
                </div>            
                <?php				
                $lecturas ++;
            }					
        }

        fclose($archivo);		



        $nombre_marcador = 'marcadores.xml'; 

        if (file_exists($nombre_marcador)) {
            unlink($nombre_marcador); 
        }

        // CARGAR LAS POSICIONES AL ARCHIVOS MARCADORES

        $marcadores = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres, seg.latitud, seg.longitud, seg.funciona, rub.rubro,if(seg.resena = '','Sin datos',seg.resena) as resena,
        if(seg.archivo = '',0,seg.archivo) as archivo
        from expedientes as exp 
        inner join rel_expedientes_emprendedores as ree on exp.id_expediente = ree.id_expediente 
        inner join emprendedores as emp on ree.id_emprendedor = emp.id_emprendedor 
        inner join seguimiento_expedientes as seg on exp.id_expediente = seg.id_expediente
        left join tipo_rubro_productivos as rub on exp.id_rubro = rub.id_rubro where emp.id_responsabilidad = 1 and round(seg.latitud) < 0
        order by emp.apellido,emp.nombres asc") or die('Revisar Lectura de Posiciones');

        if(mysqli_num_rows($marcadores) > 0){

            $ar=fopen($nombre_marcador,'w+');

            $detalle = '<?xml version="1.0" encoding="utf-8" ?>';
            fputs($ar, $detalle);
            fputs($ar,"\r\n");
            $detalle = '<marcadores>';
            fputs($ar, $detalle);
            fputs($ar,"\r\n");

            while($registro = mysqli_fetch_array($marcadores)){
                $detalle = "\t" .'<marcador>'; fputs($ar, $detalle);fputs($ar,"\r\n");

                $detalle = "\t \t" .'<id_expediente>'.$registro['id_expediente'].'</id_expediente>';	fputs($ar, $detalle); fputs($ar,"\r\n");
                $detalle = "\t \t" .'<propietario>'.trim($registro['apellido']).', '.trim($registro['nombres']).'</propietario>'; fputs($ar, $detalle); fputs($ar,"\r\n");
                $detalle = "\t \t" .'<latitud>'.round($registro['latitud'],8).'</latitud>';	fputs($ar, $detalle); fputs($ar,"\r\n");
                $detalle = "\t \t" .'<longitud>'.round($registro['longitud'],8).'</longitud>';fputs($ar, $detalle); fputs($ar,"\r\n");
                if($registro['funciona'] == 1){$color="green";}else{$color="red";};            
                $detalle = "\t \t" .'<color>'.$color.'</color>';fputs($ar, $detalle); fputs($ar,"\r\n");
                $detalle = "\t \t" .'<funciona>'.$registro['funciona'].'</funciona>';fputs($ar, $detalle); fputs($ar,"\r\n");                    
                $detalle = "\t \t" .'<rubro>'.$registro['rubro'].'</rubro>';fputs($ar, $detalle); fputs($ar,"\r\n"); 
                $detalle = "\t \t" .'<resena>'.$registro['resena'].'</resena>';fputs($ar, $detalle); fputs($ar,"\r\n"); 
                $detalle = "\t \t" .'<archivo>'.$registro['archivo'].'</archivo>';fputs($ar, $detalle); fputs($ar,"\r\n"); 


                $detalle = "\t" .'</marcador>'; fputs($ar, $detalle);	fputs($ar,"\r\n");	
            }

            $detalle = '</marcadores>';
            fputs($ar, $detalle);
            fputs($ar,"\r\n");

            fclose($ar);
        } 

            mysqli_close($con);  

        ?> 
    </div>
</div>


<?php
    require_once('../accesorios/admin-scripts.php'); 

    require_once('../accesorios/admin-inferior.php');