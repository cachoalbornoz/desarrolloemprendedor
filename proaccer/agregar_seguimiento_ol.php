<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con = conectar();

$id_usuario     = $_SESSION['id_usuario'];
$id_proyecto  = $_POST['id_proyecto'];
$latitud        = 0;
$longitud       = 0;
$estado         = $_POST['estado'];

if ($estado == 3) { // DESISTIO DEL PROYECTO
    
    // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
    mysqli_query($con, "DELETE FROM proaccer_sigue  WHERE id_proyecto = $id_proyecto") or die('Limpia siguen');
    //
    
    $norentable         = 0;
    $faltacapital       = 0;
    $surgiomejor        = 0;
    $fuerzamayor        = 0;
    $sintiempo          = 0;
    $problemasinternos  = 0;
    $problemasexternos  = 0;
    $otros              = 0;
    $porqueabandono     = $_POST['porqueabandono'];
    $vuelvefuncionar    = $_POST['volverafuncionar'];
    $necesita           = $_POST['necesita'];

    for ($i = 0; $i < count($_POST['mdesistio']); $i++) {

        switch ($_POST['mdesistio'][$i]) {
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

    $seleccion = mysqli_query($con, "SELECT id_proyecto FROM proaccer_desis WHERE id_proyecto = $id_proyecto") or die('Ver seleccion desisten proaccer');
    $registro = mysqli_fetch_array($seleccion, MYSQLI_BOTH);

    if ($registro) {
        
        mysqli_query($con, "UPDATE proaccer_desis SET norentable = $norentable, faltacapital=$faltacapital, surgiomejor = $surgiomejor, fuerzamayor=$fuerzamayor,
        sintiempo=$sintiempo, problemasinternos=$problemasinternos, problemasexternos=$problemasexternos, otros=$otros, porqueabandono='$porqueabandono', 
        vuelvefuncionar=$vuelvefuncionar, necesita='$necesita' WHERE id_proyecto = $id_proyecto") or die('Ver edicion desisten proaccer');
    } else {
        
        mysqli_query($con, "INSERT INTO proaccer_desis
        (id_proyecto, norentable, faltacapital, surgiomejor, fuerzamayor, sintiempo, problemasinternos, problemasexternos, otros, porqueabandono, vuelvefuncionar, necesita) 
        VALUES ($id_proyecto, $norentable, $faltacapital, $surgiomejor, $fuerzamayor, $sintiempo, $problemasinternos, $problemasexternos, $otros, '$porqueabandono', $vuelvefuncionar, '$necesita')")
        or die('Ver inserción desisten proaccer');
    }
}else{

    if ($estado == 1) { // EXPEDIENTE FUNCIONANDO
        
        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
        mysqli_query($con, "DELETE FROM proaccer_desis  WHERE id_proyecto = $id_proyecto") or die('Limpia siguen');
        //
        
        // EXPEDIENTE FUNCIONANDO      
        
        $mer_ciudad         = 0;
        $mer_zonas          = 0;
        $mer_provincia      = 0;
        $mer_nacional       = 0;
        $mer_internacional  = 0;
        
        for ($i = 0; $i < count($_POST['mercado']); $i++) {

            switch ($_POST['mercado'][$i]) {
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
                case 5:
                    $mer_internacional= 1;
                    break;    
            }
        }

        $comer_directo      = 0;
        $comer_cooperativa  = 0;
        $comer_minorista    = 0;
        $comer_mayorista    = 0;
        
        for ($i = 0; $i < count($_POST['formacomercializacion']); $i++) {

            switch ($_POST['formacomercializacion'][$i]) {
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

        //

        $dondevende     = $_POST['dondevende'];
        
        $pventaserv1                = $_POST['pventaserv1'];
        $pintermediarioserv1        = $_POST['pintermediarioserv1'];
        $pventainteralconsumserv1   = $_POST['pventainteralconsumserv1'];
        $pventaserv2                = $_POST['pventaserv2'];
        $pintermediarioserv2        = $_POST['pintermediarioserv2'];
        $pventainteralconsumserv2   = $_POST['pventainteralconsumserv2'];
        $pventaserv3                = $_POST['pventaserv3'];
        $pintermediarioserv3        = $_POST['pintermediarioserv3'];
        $pventainteralconsumserv3   = $_POST['pventainteralconsumserv3'];

        $conoceferia            = $_POST['conoceferia'];
        $nombreferia            = $_POST['nombreferia'];
        $participoferia         = $_POST['participoferia'];
        $limitanteferias        = $_POST['limitanteferias'];

        $tipoactividad  = $_POST['tipoactividad'];
        $prodserv1      = $_POST['prodserv1'];
        $prodserv2      = $_POST['prodserv2'];
        $prodserv3      = $_POST['prodserv3'];
        $cantserv1      = $_POST['cantserv1'];
        $cantserv2      = $_POST['cantserv2'];
        $cantserv3      = $_POST['cantserv3'];
        $costosserv1    = $_POST['costosserv1'];
        $costosserv2    = $_POST['costosserv2'];
        $costosserv3    = $_POST['costosserv3'];

        $actividadafip  = $_POST['actividadafip'];
        $codigoafip     = $_POST['codigoafip'];
        $esexportable   = $_POST['esexportable'];
        $deseaexportar  = $_POST['deseaexportar'];  


        $tipocontrolcontable    = $_POST['tipocontrolcontable'];
        $costoemp1              = $_POST['costoemp1'];  
        $costoemp2              = $_POST['costoemp2'];
        $costoemp3              = $_POST['costoemp3'];

        $tipocontrolcostos      = $_POST['tipocontrolcostos'];
        $tipocontrolinsumos     = $_POST['tipocontrolinsumos'];
        $tipocontrolstock       = $_POST['tipocontrolstock'];
        $tipocontrolproduccion  = $_POST['tipocontrolproduccion'];
        $frases                 = $_POST['frases'];
        
        $pcrecimiento_cp    = 0;
        $pcrecimiento_mp    = 0;
        $pcrecimiento_pcp   = 0;
        $pcrecimiento_pcv   = 0;
        $pcrecimiento_ci    = 0;
        $pcrecimiento_gcc   = 0;
        $pcrecimiento_pap   = 0;
        $pcrecimiento_pb    = 0;
        $pcrecimiento_op    = 0;
        $otrocrecimiento    = $_POST['otrocrecimiento'];
        
        for ($i = 0; $i < count($_POST['problemacrecimiento']); $i++) {

            switch ($_POST['problemacrecimiento'][$i]) {
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

        $complicainv    = $_POST['complicainv'];
        $complicacion   = $_POST['complicacion'];

        $interesfam     = 0;
        $interesfcnc    = 0;
        $interesfcmc    = 0;
        $interesfdm     = 0;
        $interesfot     = 0;
        
        for ($i = 0; $i < count($_POST['interesf']); $i++) {

            switch ($_POST['interesf'][$i]) {
                case 1:
                    $interesfam     = 1;
                    break;
                case 2:
                    $interesfcnc     = 1;
                    break;
                case 3:
                    $interesfcmc    = 1;
                    break;
                case 4:
                    $interesfdm     = 1;
                    break;
                case 5:
                    $interesfot     = 1;
                    break;    
            }
        }

        $otrointeres    = $_POST['otrointeres'];

        //

        $resultadosfam     = 0;
        $resultadosfcnc    = 0;
        $resultadosfcmc    = 0;
        $resultadosfdm     = 0;
        $resultadosfnor    = 0;
        $resultadosfot     = 0;
        
        for ($i = 0; $i < count($_POST['resultadosf']); $i++) {

            switch ($_POST['resultadosf'][$i]) {
                case 1:
                    $resultadosfam     = 1;
                    break;
                case 2:
                    $resultadosfcnc     = 1;
                    break;
                case 3:
                    $resultadosfcmc    = 1;
                    break;
                case 4:
                    $resultadosfdm     = 1;
                    break;
                case 5:
                    $resultadosfnor    = 1;
                    break;  
                case 6:
                    $resultadosfot     = 1;
                    break;        
            }
        }

        $otroresultado    = $_POST['otroresultado'];

        //

        $tipohabilitacion           = $_POST['tipohabilitacion'];

        //

        $aportepudonm   = 0;
        $aportepudompm  = 0;
        $aportepudomec  = 0;
        $aportepudomrmv = 0;
        $aportepudovnp  = 0;
        $aportepudomea  = 0;
        $aportepudoch   = 0;
        $aportepudona   = 0;
        $aportepudoot   = 0;


        for ($i = 0; $i < count($_POST['aportepudo']); $i++) {

            switch ($_POST['aportepudo'][$i]) {
                case 1:
                    $aportepudonm   = 1;
                    break;
                case 2:
                    $aportepudompm  = 1;
                    break;
                case 3:
                    $aportepudomec  = 1;
                    break;
                case 4:
                    $aportepudomrmv = 1;
                    break;
                case 5:
                    $aportepudovnp  = 1;    
                    break;
                case 6:
                    $aportepudomea  = 1;
                    break;
                case 7:
                    $aportepudoch   = 1;
                    break;
                case 8:
                    $aportepudona   = 1;
                    break;
                case 9:
                    $aportepudoot   = 1;
                    break;
            }
        }
        
        $aportepudootra = $_POST['aportepudootra'];
        
        $invirtiomascapital = $_POST['invirtiomascapital'];

        $tipofinandp   = 0;
        $tipofinandf   = 0;
        $tipofinanfm   = 0;
        $tipofinanfp   = 0;
        $tipofinanfn   = 0;
        $tipofinanbt   = 0;
        $tipofinanot   = 0;        
        
        for ($i = 0; $i < count($_POST['tipofinanciamiento']); $i++) {

            switch ($_POST['tipofinanciamiento'][$i]) {
                case 1:
                    $tipofinandp   = 1;
                    break;
                case 2:
                    $tipofinandf   = 1;
                    break;
                case 3:
                    $tipofinanfm   = 1;
                    break;
                case 4:
                    $tipofinanfp   = 1;
                    break;        
                case 5:
                    $tipofinanfn   = 1;
                    break;
                case 6:
                    $tipofinanbt   = 1;
                    break;
                case 7:
                    $tipofinanot   = 1;
                    break;            
                
            }
        }       

        $otrotipofinanciamiento = $_POST['otrotipofinanciamiento'];
        $evaluaciontutor        = $_POST['evaluaciontutor'];
        $recomendaciones        = $_POST['recomendaciones'];
        
        $trabajaalguienm= $_POST['trabajaalguienm'];
        $cantsocios     = $_POST['cantsocios'];
        $cantempleados  = $_POST['cantempleados'];
        $colaborafami   = $_POST['colaborafami'];
        $colaboranofami = $_POST['colaboranofami'];
        $cantotros      = $_POST['cantotros'];
 
        $capacno       = 0;
        $capacmc       = 0;
        $capace        = 0;
        $capacor       = 0;
        $capaca        = 0;
        $capacj        = 0;
        $capacc        = 0;
        $capacsa       = 0;
        $capacmp       = 0;
        $capacrs       = 0;

        for ($i = 0; $i < count($_POST['capacitacion']); $i++) {

            switch ($_POST['capacitacion'][$i]) {
                case 1:
                    $capacno   = 1;
                    break;
                case 2:
                    $capacmc   = 1;
                    break;
                case 3:
                    $capace    = 1;
                    break;
                case 4:
                    $capacor  = 1;
                    break;
                case 5:
                    $capaca    = 1;
                    break;
                case 6:
                    $capacj    = 1;
                    break;
                case 7:
                    $capacc    = 1;
                    break;
                case 8:
                    $capacsa   = 1;
                    break;
                case 9:
                    $capacmp   = 1;
                    break;
                case 10:
                    $capacrs   = 1;
                    break;
            }
        } 
        
        
        $programafinancsub  = $_POST['programafinancsub'];
        $programafinanc     = $_POST['programafinanc'];
        $otroprogramafinanc = $_POST['otroprogramafinanc'];



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $seleccion = mysqli_query($con, "SELECT id_proyecto FROM proaccer_sigue WHERE id_proyecto = $id_proyecto") or die('Ver seleccion siguen');

        $registro = mysqli_fetch_array($seleccion, MYSQLI_BOTH);

        if ($registro) {

            mysqli_query($con, "UPDATE proaccer_sigue SET 
            tipoactividad = $tipoactividad, prodserv1 ='$prodserv1', prodserv2 ='$prodserv2', prodserv3 ='$prodserv3', cantserv1 = '$cantserv1', cantserv2 = '$cantserv2', cantserv3 = '$cantserv3', costosserv1 = '$costosserv1', costosserv2 = '$costosserv2', costosserv3 = '$costosserv3', codigoafip = '$codigoafip', actividadafip = '$actividadafip', 
                
            esexportable=$esexportable, deseaexportar=$deseaexportar, mer_ciudad=$mer_ciudad, mer_zonas=$mer_zonas, mer_provincia=$mer_provincia, mer_nacional=$mer_nacional, mer_internacional=$mer_internacional,comer_directo=$comer_directo, comer_cooperativa=$comer_cooperativa, comer_minorista=$comer_minorista, comer_mayorista=$comer_mayorista, 
            dondevende = $dondevende, tipohabilitacion = $tipohabilitacion, 
            pventaserv1='$pventaserv1', pintermediarioserv1='$pintermediarioserv1', pventainteralconsumserv1='$pventainteralconsumserv1', pventaserv2='$pventaserv2', pintermediarioserv2='$pintermediarioserv2', pventainteralconsumserv2='$pventainteralconsumserv2', pventaserv3='$pventaserv3', pintermediarioserv3='$pintermediarioserv3', pventainteralconsumserv3='$pventainteralconsumserv3',
            conoceferia=$conoceferia, nombreferia= '$nombreferia',participoferia=$participoferia, limitanteferias='$limitanteferias', tipocontrolcontable=$tipocontrolcontable, 
            costoemp1 = '$costoemp1', costoemp2 = '$costoemp2', costoemp3 = '$costoemp3',
            tipocontrolcostos=$tipocontrolcostos, tipocontrolinsumos=$tipocontrolinsumos, tipocontrolstock=$tipocontrolstock, tipocontrolproduccion=$tipocontrolproduccion, frases=$frases,
            
            interesfam = $interesfam, interesfcnc = $interesfcnc, interesfcmc = $interesfcmc, interesfdm = $interesfdm, interesfot = $interesfot, otrointeres = '$otrointeres', 
            resultadosfam = $resultadosfam, resultadosfcnc = $resultadosfcnc, resultadosfcmc = $resultadosfcmc, resultadosfdm = $resultadosfdm, resultadosfnor = $resultadosfnor, resultadosfot = $resultadosfot, otroresultado = '$otroresultado', 
            
            pcrecimiento_cp=$pcrecimiento_cp, pcrecimiento_mp=$pcrecimiento_mp, pcrecimiento_pcp=$pcrecimiento_pcp, pcrecimiento_pcv=$pcrecimiento_pcv, pcrecimiento_ci=$pcrecimiento_ci, pcrecimiento_gcc=$pcrecimiento_gcc, pcrecimiento_pap=$pcrecimiento_pap, pcrecimiento_pb=$pcrecimiento_pb, pcrecimiento_op=$pcrecimiento_op, otrocrecimiento='$otrocrecimiento',
            complicainv = $complicainv, complicacion='$complicacion', 
            
            aportepudonm = $aportepudonm, aportepudompm = $aportepudompm, aportepudomec = $aportepudomec, aportepudomrmv = $aportepudomrmv, aportepudovnp = $aportepudovnp, aportepudomea = $aportepudomea, aportepudoch = $aportepudoch, aportepudona = $aportepudona, aportepudoot = $aportepudoot, aportepudootra = '$aportepudootra',             
            
            invirtiomascapital=$invirtiomascapital, 
            
            tipofinandp = $tipofinandp, tipofinandf = $tipofinandf, tipofinanfm = $tipofinanfm, tipofinanfp = $tipofinanfp, tipofinanfn = $tipofinanfn, tipofinanbt = $tipofinanbt, tipofinanot = $tipofinanot,
            otrotipofinanciamiento = '$otrotipofinanciamiento', evaluaciontutor = $evaluaciontutor, recomendaciones = '$recomendaciones',

            trabajaalguienm = $trabajaalguienm, cantsocios = $cantsocios, cantempleados = $cantempleados, cantotros = $cantotros, colaborafami = $colaborafami, colaboranofami = $colaboranofami, 
            
            capacno = $capacno, capacmc = $capacmc, capace = $capace, capacor = $capacor, capaca = $capaca, capacj = $capacj, capacc = $capacc, capacsa = $capacsa, capacmp = $capacmp, capacrs = $capacrs,

            programafinancsub = $programafinancsub, programafinanc = $programafinanc, otroprogramafinanc = '$otroprogramafinanc'
            
            WHERE id_proyecto = $id_proyecto") or die('Ver edicion siguen');
            
        } else {

            $query = "INSERT INTO proaccer_sigue(
            
                id_proyecto, tipoactividad, prodserv1, prodserv2, prodserv3, cantserv1, cantserv2, cantserv3, costosserv1, costosserv2, costosserv3, codigoafip, actividadafip,
                esexportable, deseaexportar, mer_ciudad, mer_zonas, mer_provincia, mer_nacional, mer_internacional, comer_directo, comer_cooperativa, comer_minorista, comer_mayorista, 
                dondevende, tipohabilitacion, 
                pventaserv1, pintermediarioserv1, pventainteralconsumserv1, pventaserv2, pintermediarioserv2, pventainteralconsumserv2, pventaserv3, pintermediarioserv3, pventainteralconsumserv3,
                conoceferia, nombreferia, participoferia, limitanteferias, tipocontrolcontable, 
                costoemp1, costoemp2, costoemp3,
                tipocontrolcostos, tipocontrolinsumos, tipocontrolstock, tipocontrolproduccion, frases,            
                interesfam, interesfcnc, interesfcmc, interesfdm, interesfot, otrointeres, 
                resultadosfam, resultadosfcnc, resultadosfcmc, resultadosfdm, resultadosfnor, resultadosfot, otroresultado, 
                pcrecimiento_cp, pcrecimiento_mp, pcrecimiento_pcp, pcrecimiento_pcv, pcrecimiento_ci, pcrecimiento_gcc, pcrecimiento_pap, pcrecimiento_pb, pcrecimiento_op, otrocrecimiento,
                complicainv, complicacion, invirtiomascapital, 
                
                tipofinandp, tipofinandf, tipofinanfm, tipofinanfp, tipofinanfn, tipofinanbt, tipofinanot,
                otrotipofinanciamiento, evaluaciontutor, recomendaciones,
    
                aportepudonm, aportepudompm, aportepudomec, aportepudomrmv, aportepudovnp, aportepudomea, aportepudoch, aportepudona, aportepudoot, aportepudootra,
                trabajaalguienm, cantsocios, cantempleados, cantotros, colaborafami, colaboranofami,
                capacno, capacmc, capace, capacor, capaca, capacj, capacc, capacsa, capacmp, capacrs, 
                programafinancsub, programafinanc, otroprogramafinanc) VALUES (
                
                $id_proyecto, $tipoactividad, '$prodserv1', '$prodserv2', '$prodserv3', '$cantserv1', '$cantserv2', '$cantserv3', '$costosserv1', '$costosserv2', '$costosserv3', '$codigoafip', '$actividadafip',
                $esexportable, $deseaexportar, $mer_ciudad, $mer_zonas, $mer_provincia, $mer_nacional, $mer_internacional, $comer_directo, $comer_cooperativa, $comer_minorista, $comer_mayorista, 
                $dondevende, $tipohabilitacion, 
                '$pventaserv1', '$pintermediarioserv1', '$pventainteralconsumserv1', '$pventaserv2', '$pintermediarioserv2', '$pventainteralconsumserv2', '$pventaserv3', '$pintermediarioserv3', '$pventainteralconsumserv3',
                $conoceferia, '$nombreferia', $participoferia, '$limitanteferias', $tipocontrolcontable, 
                '$costoemp1', '$costoemp2', '$costoemp3',
                $tipocontrolcostos, $tipocontrolinsumos, $tipocontrolstock, $tipocontrolproduccion, $frases,            
                $interesfam, $interesfcnc, $interesfcmc, $interesfdm, $interesfot, '$otrointeres', 
                $resultadosfam, $resultadosfcnc, $resultadosfcmc, $resultadosfdm, $resultadosfnor, $resultadosfot, '$otroresultado', 
                $pcrecimiento_cp, $pcrecimiento_mp, $pcrecimiento_pcp, $pcrecimiento_pcv, $pcrecimiento_ci, $pcrecimiento_gcc, $pcrecimiento_pap, $pcrecimiento_pb, $pcrecimiento_op, '$otrocrecimiento',
                $complicainv, '$complicacion', $invirtiomascapital, 
                
                $tipofinandp, $tipofinandf, $tipofinanfm, $tipofinanfp, $tipofinanfn, $tipofinanbt, $tipofinanot,
                '$otrotipofinanciamiento', $evaluaciontutor, '$recomendaciones',
    
                $aportepudonm, $aportepudompm, $aportepudomec, $aportepudomrmv, $aportepudovnp, $aportepudomea, $aportepudoch, $aportepudona, $aportepudoot, '$aportepudootra',
                $trabajaalguienm, $cantsocios, $cantempleados, $cantotros, $colaborafami, $colaboranofami,
                $capacno, $capacmc, $capace, $capacor, $capaca, $capacj, $capacc, $capacsa, $capacmp, $capacrs, 
                $programafinancsub, $programafinanc , '$otroprogramafinanc' )";

            mysqli_query($con, $query) or die('Ver inserción Proaceer Siguen');
        }
    }else{
        // RELEVAMIENTOS DE EXPEDIENTES QUE NO SE PUDIERON CONCRETAR
        
        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
        mysqli_query($con, "DELETE FROM proaccer_sigue  WHERE id_proyecto = $id_proyecto") or die('Limpia siguen');
        mysqli_query($con, "DELETE FROM proaccer_desis  WHERE id_proyecto = $id_proyecto") or die('Limpia desisten');
        //
        
    }
}


mysqli_close($con);

header('Location:seguimiento_proaccer.php');

