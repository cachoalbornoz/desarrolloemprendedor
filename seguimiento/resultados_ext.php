<?php

require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$con=conectar();

?>


<div class="card">

    <div class="card-header">      
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                CARGA DE RESULTADOS       
            </div>               
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">            
        <tr> 
            <th>Establecimiento</th>     
            <th>Estado</th>
            <th>Latitud</th>
            <th>Longitud</th>     
        </tr> 
        
        <?php        
        
        $lecturas   = 0;

        $archivo_tmp = $_FILES['archivo']['tmp_name'];  
        
        $archivo = fopen($archivo_tmp,'r') or die('No se puede leer archivo '.$_FILES['archivo']['name']);

        while (!feof($archivo)){ // RECORRO EL ARCHIVO DE RESPUESTAS
            
            $registro = explode(';',fgets($archivo));
            
            if(isset($registro[0]) and isset($registro[1])){

                $latitud        = $registro[0];
                $longitud       = $registro[1];
                $id_usuario     = $registro[2];
                $id_expediente  = $registro[3]; 
                $estado         = $registro[4];
                
                // ACTUALIZA EL ESTADO DEL RELEVAMIENTO
                $seleccion_exp = mysqli_query($con, "SELECT id_expediente 
                FROM seguimiento_expedientes_ext 
                WHERE id_expediente = $id_expediente") or die('Ver seleccion exped');
                
                $registro_exp = mysqli_fetch_array($seleccion_exp);
                
                if ($registro_exp) {
                    
                    mysqli_query($con, "UPDATE seguimiento_expedientes_ext SET latitud=$latitud, longitud=$longitud, id_usuario=$id_usuario, estado=$estado WHERE id_expediente = $id_expediente") or die('Ver edicion Relevamiento');
                    
                } else {
                    
                    mysqli_query($con, "INSERT INTO seguimiento_expedientes_ext  (id_expediente, latitud, longitud, id_usuario, estado) VALUES ($id_expediente, $latitud,$longitud,$id_usuario,$estado)") or die('Ver inserción Relevamiento');
                }
                
                
                switch ($estado) {
                    case 1:
                        $estado_cadena = "Funcionando";
                        break;
                    case 2:
                        $estado_cadena = "Inicia";
                        break;
                    case 3:
                        $estado_cadena = "Desistió";
                        break;
                    case 4:
                        $estado_cadena = "No se pudo contactar";
                        break;
                }
                
                $seleccion_datos    = mysqli_query($con,"SELECT exp.id_expediente, emp.apellido, emp.nombres 
                FROM expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp
                WHERE exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor and emp.id_responsabilidad = 1 and exp.id_expediente = $id_expediente
                GROUP BY exp.id_expediente 
                ORDER BY emp.apellido,emp.nombres asc");
                $registro_datos     = mysqli_fetch_array($seleccion_datos);
                
                $datos = '('. str_pad($registro_datos[0],5,'0',STR_PAD_LEFT).') '.$registro_datos[1].', '.$registro_datos[2];
                
                ?>
                <tr>
                    <td><?php echo $datos ?></td>     
                    <td><?php echo $estado_cadena ?></td>
                    <td><?php echo $latitud  ?></td>
                    <td><?php echo $longitud ?></td>
                </tr>       
                <?php
                switch ($estado){
                    
                    case 1: // EXPEDIENTE FUNCIONANDO
                        
                        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
                        mysqli_query($con, "DELETE FROM expedientes_ext_desis  WHERE id_expediente = $id_expediente") or die('Limpia siguen');
                        mysqli_query($con, "DELETE FROM expedientes_ext_inicia WHERE id_expediente = $id_expediente") or die('Limpia inician');
                        //
                        
                        $tipoactividad  = $registro[5];              

                        $prodserv1      = $registro[6];
                        $prodserv2      = $registro[7];
                        $prodserv3      = $registro[8];
                        
                        $cantserv1      = $registro[9];
                        $cantserv2      = $registro[10];
                        $cantserv3      = $registro[11];
                        
                        $costosserv1    = $registro[12];
                        $costosserv2    = $registro[13];
                        $costosserv3    = $registro[14];
                        
                        $codigoafip     = $registro[15];
                        
                        $esexportable   = $registro[16];
                        $deseaexportar  = $registro[17];

                        $mer_ciudad     = 0;
                        $mer_zonas      = 0;
                        $mer_provincia  = 0;
                        $mer_nacional   = 0;
                        
                        $cadena = explode(',',$registro[18]);
                        
                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $mer_ciudad = 1;
                                    break;
                                case 2:
                                    $mer_zonas  = 1;
                                    break;
                                case 3:
                                    $mer_provincia = 1;
                                    break;
                                case 4:
                                    $mer_nacional= 1;
                                    break;
                            }
                        }       

                        $comer_directo      = 0;
                        $comer_cooperativa  = 0;
                        $comer_minorista    = 0;
                        $comer_mayorista    = 0;
                        
                        $cadena = explode(',',$registro[19]);
                        
                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $comer_directo      = 1;
                                    break;
                                case 2:
                                    $comer_cooperativa  = 1;
                                    break;
                                case 3:
                                    $comer_minorista    = 1;
                                    break;
                                case 4:
                                    $comer_mayorista    = 1;
                                    break;
                            }
                        }      
                        
                        $dondevende                 = $registro[20];
                        
                        $pventaserv1                = substr($registro[21],0,50);
                        $pintermediarioserv1        = substr($registro[22],0,50);
                        $pventainteralconsumserv1   = substr($registro[23],0,50);
                        $pventaserv2                = substr($registro[24],0,50);
                        $pintermediarioserv2        = substr($registro[25],0,50);
                        $pventainteralconsumserv2   = substr($registro[26],0,50);
                        $pventaserv3                = substr($registro[27],0,50);
                        $pintermediarioserv3        = substr($registro[28],0,50);
                        $pventainteralconsumserv3   = substr($registro[29],0,50);
                        
                        
                        $conoceferia                = $registro[30];
                        $participoferia             = $registro[31];
                        $interesparticipar          = $registro[32];
                        $limitanteferias            = $registro[33];
                        
                        $tipocontrolcontable        = $registro[34];
                        
                        $costoemp1                  = $registro[35];                     
                        $costoemp2                  = $registro[36];
                        $costoemp3                  = $registro[37];

                        $tipocontrolcostos          = $registro[38];                        
                        $tipocontrolinsumos         = $registro[39];
                        $tipocontrolstock           = $registro[40];
                        $tipocontrolproduccion      = $registro[41];
                        
                        $tipohabilitacion           = $registro[42];    
                        
                        $frases                     = $registro[43];                        
                    
                        $pcrecimiento_cp            = 0;
                        $pcrecimiento_mp            = 0;
                        $pcrecimiento_pcp           = 0;
                        $pcrecimiento_pcv           = 0;
                        $pcrecimiento_ci            = 0;
                        $pcrecimiento_gcc           = 0;
                        $pcrecimiento_pap           = 0;
                        $pcrecimiento_pb            = 0;
                        $pcrecimiento_op            = 0;                        
                        
                        $cadena = explode(',',$registro[44]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $pcrecimiento_cp    = 1;
                                    break;
                                case 2:
                                    $pcrecimiento_mp    = 1;
                                    break;
                                case 3:
                                    $pcrecimiento_pcp   = 1;
                                    break;
                                case 4:
                                    $pcrecimiento_pcv   = 1;
                                    break;
                                case 5:
                                    $pcrecimiento_ci    = 1;
                                    break;
                                case 6:
                                    $pcrecimiento_gcc   = 1;
                                    break;
                                case 7:
                                    $pcrecimiento_pap   = 1;
                                    break;
                                case 8:
                                    $pcrecimiento_pb    = 1;
                                    break;
                                case 9:
                                    $pcrecimiento_op    = 1;
                                    break;
                            }
                        } 
                        
                        $otrocrecimiento    = $registro[45];
                        
                        $invirtiomascapital = $registro[46];

                        $tipofinan_dp   = 0;
                        $tipofinan_of   = 0;
                        $tipofinan_bt   = 0;                        
                        
                        $cadena = explode(',',$registro[47]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $tipofinan_dp   = 1;
                                    break;
                                case 2:
                                    $tipofinan_of   = 1;
                                    break;
                                case 3:
                                    $tipofinan_bt   = 1;
                                    break;
                            }
                        }                        

                        $trabajaalguienm= $registro[48];
                        
                        $cantsocios     = $registro[49];
                        $cantempleados  = $registro[50];
                        $cantotros      = $registro[51];
                        $colaborafami   = $registro[52];
                        $colaboranofami = $registro[53];                        

                        $capac_no       = 0;
                        $capac_mc       = 0;
                        $capac_e        = 0;
                        $capac_or       = 0;
                        $capac_a        = 0;
                        $capac_j        = 0;
                        $capac_c        = 0;
                        $capac_sa       = 0;
                        $capac_mp       = 0;
                        $capac_rs       = 0;
                        
                        
                        $cadena = explode(',',$registro[54]);                        

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $capac_no   = 1;
                                    break;
                                case 2:
                                    $capac_mc   = 1;
                                    break;
                                case 3:
                                    $capac_e    = 1;
                                    break;
                                case 4:
                                     $capac_or  = 1;
                                    break;
                                case 5:
                                    $capac_a    = 1;
                                    break;
                                case 6:
                                    $capac_j    = 1;
                                    break;
                                case 7:
                                    $capac_c    = 1;
                                    break;
                                case 8:
                                    $capac_sa   = 1;
                                    break;
                                case 9:
                                    $capac_mp   = 1;
                                    break;
                                case 10:
                                    $capac_rs   = 1;
                                    break;
                            }
                        }
                        
                        $programafinanc     = $registro[55];
                        $sugerencia         = $registro[56];
                        $semaforo           = $registro[57];

                        $seleccion = mysqli_query($con, "SELECT id_expediente FROM expedientes_ext_sigue WHERE id_expediente = $id_expediente");                        
                        $registro = mysqli_fetch_array($seleccion);

                        // ACTUALIZA EXPEDIENTE                         
                        $actualiza = 
                        "UPDATE expedientes_ext_sigue SET 
                            tipoactividad   = $tipoactividad, 
                            prodserv1       = '$prodserv1', 
                            prodserv2       = '$prodserv2', 
                            prodserv3       = '$prodserv3', 
                            cantserv1       = '$cantserv1', 
                            cantserv2       = '$cantserv2', 
                            cantserv3       = '$cantserv3', 
                            costosserv1     = '$costosserv1', 
                            costosserv2     = '$costosserv2', 
                            costosserv3     = '$costosserv3', 
                            codigoafip      = '$codigoafip',
                            esexportable    = $esexportable, 
                            deseaexportar   = $deseaexportar, 
                            mer_ciudad      = $mer_ciudad, 
                            mer_zonas       = $mer_zonas, 
                            mer_provincia   = $mer_provincia, 
                            mer_nacional    = $mer_nacional, 
                            comer_directo   = $comer_directo, 
                            comer_cooperativa=$comer_cooperativa, 
                            comer_minorista = $comer_minorista, 
                            comer_mayorista = $comer_mayorista,
                            dondevende      = $dondevende, 
                            tipohabilitacion= $tipohabilitacion, 
                            pventaserv1     = '$pventaserv1', 
                            pintermediarioserv1='$pintermediarioserv1', 
                            pventainteralconsumserv1='$pventainteralconsumserv1', 
                            pventaserv2     ='$pventaserv2', 
                            pintermediarioserv2='$pintermediarioserv2', 
                            pventainteralconsumserv2='$pventainteralconsumserv2', 
                            pventaserv3     ='$pventaserv3', 
                            pintermediarioserv3='$pintermediarioserv3', 
                            pventainteralconsumserv3='$pventainteralconsumserv3',                            
                            conoceferia     =$conoceferia, 
                            participoferia  =$participoferia, 
                            interesparticipar=$interesparticipar, 
                            limitanteferias='$limitanteferias', 
                            costoemp1       = '$costoemp1', 
                            costoemp2       = '$costoemp2', 
                            costoemp3       = '$costoemp3',
                            tipocontrolcontable=$tipocontrolcontable, 
                            tipocontrolcostos=$tipocontrolcostos, 
                            tipocontrolinsumos=$tipocontrolinsumos, 
                            tipocontrolstock= $tipocontrolstock, 
                            tipocontrolproduccion=$tipocontrolproduccion, 
                            frases          = $frases,
                            pcrecimiento_cp = $pcrecimiento_cp, 
                            pcrecimiento_mp = $pcrecimiento_mp, 
                            pcrecimiento_pcp= $pcrecimiento_pcp, 
                            pcrecimiento_pcv= $pcrecimiento_pcv, 
                            pcrecimiento_ci = $pcrecimiento_ci, 
                            pcrecimiento_gcc= $pcrecimiento_gcc, 
                            pcrecimiento_pap= $pcrecimiento_pap, 
                            pcrecimiento_pb = $pcrecimiento_pb, 
                            pcrecimiento_op = $pcrecimiento_op, 
                            otrocrecimiento = '$otrocrecimiento',
                            colaborafami    = $colaborafami, 
                            colaboranofami  = $colaboranofami,
                            invirtiomascapital=$invirtiomascapital, 
                            tipofinan_dp    = $tipofinan_dp, 
                            tipofinan_of    = $tipofinan_of, 
                            tipofinan_bt    = $tipofinan_bt, 
                            trabajaalguienm = $trabajaalguienm, 
                            cantsocios      = $cantsocios, 
                            cantempleados   = $cantempleados, 
                            cantotros       = $cantotros, 
                            capac_no        = $capac_no, 
                            capac_mc        = $capac_mc, 
                            capac_e         = $capac_e, 
                            capac_or        = $capac_or, 
                            capac_a         = $capac_a,
                            capac_j         = $capac_j, 
                            capac_c         = $capac_c, 
                            capac_sa        = $capac_sa, 
                            capac_mp        = $capac_mp, 
                            capac_rs        = $capac_rs,
                            programafinanc  = $programafinanc,
                            sugerencia      = '$sugerencia',
                            semaforo        = $semaforo
                            
                            WHERE id_expediente = $id_expediente";
                            
                            
                        
                        if (isset($registro)) { 
                            
                            mysqli_query($con, $actualiza) or die($actualiza .' L347');

                        } else {
                            
                            $inserta = "INSERT INTO expedientes_ext_sigue (id_expediente) VALUES ($id_expediente)" ;
                            
                            mysqli_query($con, $inserta) or die('Ver inserción siguen - L353');
                            
                            mysqli_query($con, $actualiza) or die('Ver actualiza - L355');
                            
                        }     
                        
                        
                        break;
                    
                    case 2: // EN VIAS DE FUNCIONAR 
                        
                        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
                        mysqli_query($con, "DELETE FROM expedientes_ext_desis  WHERE id_expediente = $id_expediente") or die('Limpia siguen');
                        mysqli_query($con, "DELETE FROM expedientes_ext_sigue WHERE id_expediente = $id_expediente") or die('Limpia inician');
                        //
                              
                        $emplazamiento  = $registro[5];
                        $contacto       = $registro[6];
                        $metodo         = $registro[7];
                        $marketing      = $registro[8];
                        $costosp        = $registro[9];
                        $canalesventa   = $registro[10];

                        $seleccion_exp = mysqli_query($con, "SELECT id_expediente FROM expedientes_ext_inicia WHERE id_expediente = $id_expediente") or die('Ver seleccion inician');
                        $registro_exp = mysqli_fetch_array($seleccion_exp);
                        if ($registro_exp) {

                            mysqli_query($con, "UPDATE expedientes_ext_inicia SET emplazamiento = $emplazamiento, contacto = $contacto, metodo = $metodo, marketing=$marketing, costosp=$costosp, canalesventa=$canalesventa
                            WHERE id_expediente = $id_expediente") or die('Ver edicion inician');
                        } else {

                            mysqli_query($con, "INSERT INTO expedientes_ext_inicia
                            (id_expediente, emplazamiento, contacto, metodo, marketing, costosp, canalesventa) VALUES ($id_expediente, $emplazamiento, $contacto, $metodo, $marketing, $costosp, $canalesventa)")
                            or die('Ver inserción inician');
                        }

                        $tipoactividad  = $registro[11];                        
                        $prodserv1      = $registro[12];
                        $prodserv2      = $registro[13];
                        $prodserv3      = $registro[14];
                        $cantserv1      = $registro[15];
                        $cantserv2      = $registro[16];
                        $cantserv3      = $registro[17];
                        $costosserv1    = $registro[18];
                        $costosserv2    = $registro[19];
                        $costosserv3    = $registro[20];
                        $codigoafip     = $registro[21];
                        $esexportable   = $registro[22];
                        $deseaexportar  = $registro[23];

                        $mer_ciudad     = 0;
                        $mer_zonas      = 0;
                        $mer_provincia  = 0;
                        $mer_nacional   = 0;
                        
                        $cadena = explode(',',$registro[24]);
                        
                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $mer_ciudad = 1;
                                    break;
                                case 2:
                                    $mer_zonas  = 1;
                                    break;
                                case 3:
                                    $mer_provincia = 1;
                                    break;
                                case 4:
                                    $mer_nacional= 1;
                                    break;
                            }
                        }       

                        $comer_directo      = 0;
                        $comer_cooperativa  = 0;
                        $comer_minorista    = 0;
                        $comer_mayorista    = 0;
                        
                        $cadena = explode(',',$registro[25]);
                        
                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $comer_directo      = 1;
                                    break;
                                case 2:
                                    $comer_cooperativa  = 1;
                                    break;
                                case 3:
                                    $comer_minorista    = 1;
                                    break;
                                case 4:
                                    $comer_mayorista    = 1;
                                    break;
                            }
                        }      
                        
                        $dondevende                 = $registro[26];
                        $pventaserv1                = substr($registro[27],0,50);
                        $pintermediarioserv1        = substr($registro[28],0,50);
                        $pventainteralconsumserv1   = substr($registro[29],0,50);
                        $pventaserv2                = substr($registro[30],0,50);
                        $pintermediarioserv2        = substr($registro[31],0,50);
                        $pventainteralconsumserv2   = substr($registro[32],0,50);
                        $pventaserv3                = substr($registro[33],0,50);
                        $pintermediarioserv3        = substr($registro[34],0,50);
                        $pventainteralconsumserv3   = substr($registro[35],0,50);
                        $conoceferia                = $registro[36];
                        $participoferia             = $registro[37];
                        $interesparticipar          = $registro[38];
                        $limitanteferias            = $registro[39];
                        $tipocontrolcontable        = $registro[40];

                        $costoemp1                  = $registro[41];
                        $costoemp2                  = $registro[42];
                        $costoemp3                  = $registro[43];

                        $tipocontrolcostos          = $registro[44];
                        $tipocontrolinsumos         = $registro[45];
                        $tipocontrolstock           = $registro[46];
                        $tipocontrolproduccion      = $registro[47];
                        $tipohabilitacion           = $registro[48];    
                        $frases                     = $registro[49];
                        $pcrecimiento_cp    = 0;
                        $pcrecimiento_mp    = 0;
                        $pcrecimiento_pcp   = 0;
                        $pcrecimiento_pcv   = 0;
                        $pcrecimiento_ci    = 0;
                        $pcrecimiento_gcc   = 0;
                        $pcrecimiento_pap   = 0;
                        $pcrecimiento_pb    = 0;
                        $pcrecimiento_op    = 0;
                        
                        $cadena = explode(',',$registro[50]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $pcrecimiento_cp    = 1;
                                    break;
                                case 2:
                                    $pcrecimiento_mp    = 1;
                                    break;
                                case 3:
                                    $pcrecimiento_pcp   = 1;
                                    break;
                                case 4:
                                    $pcrecimiento_pcv   = 1;
                                    break;
                                case 5:
                                    $pcrecimiento_ci    = 1;
                                    break;
                                case 6:
                                    $pcrecimiento_gcc   = 1;
                                    break;
                                case 7:
                                    $pcrecimiento_pap   = 1;
                                    break;
                                case 8:
                                    $pcrecimiento_pb    = 1;
                                    break;
                                case 9:
                                    $pcrecimiento_op    = 1;
                                    break;
                            }
                        } 
                        
                        $otrocrecimiento    = $registro[51];
                        $invirtiomascapital = $registro[52];

                        $tipofinan_dp   = 0;
                        $tipofinan_of   = 0;
                        $tipofinan_bt   = 0;
                        
                        $cadena = explode(',',$registro[53]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $tipofinan_dp   = 1;
                                    break;
                                case 2:
                                    $tipofinan_of   = 1;
                                    break;
                                case 3:
                                    $tipofinan_bt   = 1;
                                    break;
                            }
                        }       

                        $trabajaalguienm= $registro[54];
                        $cantsocios     = $registro[55];
                        $cantempleados  = $registro[56];
                        $cantotros      = $registro[57];
                        $colaborafami   = $registro[58];
                        $colaboranofami = $registro[59];

                        $capac_no       = 0;
                        $capac_mc       = 0;
                        $capac_e        = 0;
                        $capac_or       = 0;
                        $capac_a        = 0;
                        $capac_j        = 0;
                        $capac_c        = 0;
                        $capac_sa       = 0;
                        $capac_mp       = 0;
                        $capac_rs       = 0;
                        
                        $cadena = explode(',',$registro[60]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $capac_no   = 1;
                                    break;
                                case 2:
                                    $capac_mc   = 1;
                                    break;
                                case 3:
                                    $capac_e    = 1;
                                    break;
                                case 4:
                                     $capac_or  = 1;
                                    break;
                                case 5:
                                    $capac_a    = 1;
                                    break;
                                case 6:
                                    $capac_j    = 1;
                                    break;
                                case 7:
                                    $capac_c    = 1;
                                    break;
                                case 8:
                                    $capac_sa   = 1;
                                    break;
                                case 9:
                                    $capac_mp   = 1;
                                    break;
                                case 10:
                                    $capac_rs   = 1;
                                    break;
                            }
                        }         

                        $programafinanc  = $registro[61];
                        $sugerencia      = $registro[62];
                        $semaforo        = $registro[63];
                        
                        $seleccion = mysqli_query($con, "SELECT id_expediente FROM expedientes_ext_sigue WHERE id_expediente = $id_expediente");
                        $registro  = mysqli_fetch_array($seleccion);
                        
                        // ACTUALIZA EXPEDIENTE                         
                        $actualiza = 
                        "UPDATE expedientes_ext_sigue SET 
                            tipoactividad   = $tipoactividad, 
                            prodserv1       = '$prodserv1', 
                            prodserv2       = '$prodserv2', 
                            prodserv3       = '$prodserv3', 
                            cantserv1       = '$cantserv1', 
                            cantserv2       = '$cantserv2', 
                            cantserv3       = '$cantserv3', 
                            costosserv1     = '$costosserv1', 
                            costosserv2     = '$costosserv2', 
                            costosserv3     = '$costosserv3', 
                            codigoafip      = '$codigoafip',
                            esexportable    = $esexportable, 
                            deseaexportar   = $deseaexportar, 
                            mer_ciudad      = $mer_ciudad, 
                            mer_zonas       = $mer_zonas, 
                            mer_provincia   = $mer_provincia, 
                            mer_nacional    = $mer_nacional, 
                            comer_directo   = $comer_directo, 
                            comer_cooperativa=$comer_cooperativa, 
                            comer_minorista = $comer_minorista, 
                            comer_mayorista = $comer_mayorista,
                            dondevende      = $dondevende, 
                            tipohabilitacion= $tipohabilitacion, 
                            pventaserv1     = '$pventaserv1', 
                            pintermediarioserv1='$pintermediarioserv1', 
                            pventainteralconsumserv1='$pventainteralconsumserv1', 
                            pventaserv2     ='$pventaserv2', 
                            pintermediarioserv2='$pintermediarioserv2', 
                            pventainteralconsumserv2='$pventainteralconsumserv2', 
                            pventaserv3     ='$pventaserv3', 
                            pintermediarioserv3='$pintermediarioserv3', 
                            pventainteralconsumserv3='$pventainteralconsumserv3',                            
                            conoceferia     =$conoceferia, 
                            participoferia  =$participoferia, 
                            interesparticipar=$interesparticipar, 
                            limitanteferias='$limitanteferias', 
                            costoemp1       = '$costoemp1', 
                            costoemp2       = '$costoemp2', 
                            costoemp3       = '$costoemp3',
                            tipocontrolcontable=$tipocontrolcontable, 
                            tipocontrolcostos=$tipocontrolcostos, 
                            tipocontrolinsumos=$tipocontrolinsumos, 
                            tipocontrolstock= $tipocontrolstock, 
                            tipocontrolproduccion=$tipocontrolproduccion, 
                            frases          = $frases,
                            pcrecimiento_cp = $pcrecimiento_cp, 
                            pcrecimiento_mp = $pcrecimiento_mp, 
                            pcrecimiento_pcp= $pcrecimiento_pcp, 
                            pcrecimiento_pcv= $pcrecimiento_pcv, 
                            pcrecimiento_ci = $pcrecimiento_ci, 
                            pcrecimiento_gcc= $pcrecimiento_gcc, 
                            pcrecimiento_pap= $pcrecimiento_pap, 
                            pcrecimiento_pb = $pcrecimiento_pb, 
                            pcrecimiento_op = $pcrecimiento_op, 
                            otrocrecimiento = '$otrocrecimiento',
                            colaborafami    = $colaborafami, 
                            colaboranofami  = $colaboranofami,
                            invirtiomascapital=$invirtiomascapital, 
                            tipofinan_dp    = $tipofinan_dp, 
                            tipofinan_of    = $tipofinan_of, 
                            tipofinan_bt    = $tipofinan_bt, 
                            trabajaalguienm = $trabajaalguienm, 
                            cantsocios      = $cantsocios, 
                            cantempleados   = $cantempleados, 
                            cantotros       = $cantotros, 
                            capac_no        = $capac_no, 
                            capac_mc        = $capac_mc, 
                            capac_e         = $capac_e, 
                            capac_or        = $capac_or, 
                            capac_a         = $capac_a,
                            capac_j         = $capac_j, 
                            capac_c         = $capac_c, 
                            capac_sa        = $capac_sa, 
                            capac_mp        = $capac_mp, 
                            capac_rs        = $capac_rs,
                            programafinanc  = $programafinanc,
                            sugerencia      = '$sugerencia',
                            semaforo        = $semaforo
                            
                            WHERE id_expediente = $id_expediente";
                            
                            
                        
                        if (isset($registro)) { 
                            
                            mysqli_query($con, $actualiza) or die( $actualiza .' L769');

                        } else {
                            
                            $inserta = "INSERT INTO expedientes_ext_sigue (id_expediente) VALUES ($id_expediente)" ;
                            
                            mysqli_query($con, $inserta) or die('Ver inserción siguen - L775');
                            
                            mysqli_query($con, $actualiza) or die( $actualiza .' L777');
                            
                        }                        
                        
                        break;
                        
                    case 3: // DESISTIO DEL PROYECTO 
                        
                        $cadena = explode(',',$registro[5]);                        
                                           
                        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
                        mysqli_query($con, "DELETE FROM expedientes_ext_sigue  WHERE id_expediente = $id_expediente") or die('Limpia siguen');
                        mysqli_query($con, "DELETE FROM expedientes_ext_inicia WHERE id_expediente = $id_expediente") or die('Limpia inician');
                        //
                        $norentable         = 0;
                        $faltacapital       = 0;
                        $surgiomejor        = 0;
                        $fuerzamayor        = 0;
                        $sintiempo          = 0;
                        $problemasinternos  = 0;
                        $problemasexternos  = 0;
                        $otros              = 0;
                        $porqueabandono     = lcadena($registro[6]);
                        $vuelvefuncionar    = $registro[7];
                        $necesita           = lcadena($registro[8]);

                        for ($i = 0; $i < count($cadena); $i++) {

                            switch ($cadena[$i]) {
                                case 1:
                                    $norentable = 1;
                                    break;
                                case 2:
                                    $faltacapital = 1;
                                    break;
                                case 3:
                                    $surgiomejor = 1;
                                    break;
                                case 4:
                                    $fuerzamayor = 1;
                                    break;
                                case 5:
                                    $sintiempo = 1;
                                    break;
                                case 6:
                                    $problemasinternos = 1;
                                    break;
                                case 7:
                                    $problemasexternos = 1;
                                    break;
                                case 8:
                                    $otros = 1;
                                    break;
                            }
                        }

                        $seleccion = mysqli_query($con, "SELECT id_expediente FROM expedientes_ext_desis WHERE id_expediente = $id_expediente") or die('Ver seleccion desisten');
                        $registro = mysqli_fetch_array($seleccion);

                        if ($registro) {

                            mysqli_query($con, "UPDATE expedientes_ext_desis SET `norentable` = $norentable, `faltacapital`=$faltacapital, `surgiomejor` = $surgiomejor, `fuerzamayor`=$fuerzamayor,
                            `sintiempo`=$sintiempo, `problemasinternos`=$problemasinternos, `problemasexternos`=$problemasexternos, `otros`=$otros, `porqueabandono`='$porqueabandono', 
                            `vuelvefuncionar`=$vuelvefuncionar, `necesita`='$necesita' WHERE id_expediente = $id_expediente") or die('Ver edicion desisten');
                        } else {

                            mysqli_query($con, "INSERT INTO expedientes_ext_desis
                            (id_expediente, norentable, faltacapital, surgiomejor, fuerzamayor, sintiempo, problemasinternos, problemasexternos, otros, porqueabandono, vuelvefuncionar, necesita) 
                            VALUES ($id_expediente, $norentable, $faltacapital, $surgiomejor, $fuerzamayor, $sintiempo, $problemasinternos, $problemasexternos, $otros, '$porqueabandono', $vuelvefuncionar, '$necesita')")
                            or die('Ver inserción desisten');
                        }                           
                        
                    break;                     
                }                
                			
                $lecturas ++;
            }					
        }

        fclose($archivo);
        
        mysqli_close($con);  

        ?> 
        <tr>
            <td colspan="4">
                &nbsp;
            </td>
        </tr>        
        <tr>
            <td colspan="4">TOTAL REGISTROS PROCESADOS :: <b> <?php echo $lecturas ?> </b></td>
        </tr>        
            
        </table>
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                <a class="btn btn-info" href="carga_resultados_ext.php">Volver</a>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('../accesorios/admin-scripts.php'); 
    
    require_once('../accesorios/admin-inferior.php');