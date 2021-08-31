<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once("../accesorios/accesos_bd.php");
$con = conectar();

$id_usuario     = $_SESSION['id_usuario'];
$id_expediente  = $_POST['id_expediente'];
$latitud        = 0;
$longitud       = 0;
$estado         = $_POST['estado'];


// ACTUALIZA EL ESTADO DEL RELEVAMIENTO
$seleccion = mysqli_query($con, "SELECT id_expediente FROM seguimiento_expedientes_ext WHERE id_expediente = $id_expediente") or die('Ver seleccion exped');
$registro = mysqli_fetch_array($seleccion);
if ($registro) {
    mysqli_query($con, "UPDATE seguimiento_expedientes_ext SET latitud=$latitud, longitud=$longitud, id_usuario=$id_usuario, estado=$estado WHERE id_expediente = $id_expediente") or die('Ver edicion desisten');
} else {
    mysqli_query($con, "INSERT INTO seguimiento_expedientes_ext  (id_expediente, latitud, longitud, id_usuario, estado) VALUES ($id_expediente, $latitud,$longitud,$id_usuario,$estado)") or die('Ver inserción nuevos');
}


if ($estado == 3) { // DESISTIO DEL PROYECTO
    
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
    $porqueabandono     = $_POST['porqueabandono'];
    $vuelvefuncionar    = $_POST['volverafuncionar'];
    $necesita           = $_POST['necesita'];
    $programafinancd    = $_POST['programafinancd'];
    

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

    $seleccion = mysqli_query($con, "SELECT id_expediente FROM expedientes_ext_desis WHERE id_expediente = $id_expediente") or die('Ver seleccion desisten');
    $registro = mysqli_fetch_array($seleccion);

    if ($registro) {
        
        $update = "UPDATE expedientes_ext_desis SET norentable = $norentable, faltacapital=$faltacapital, surgiomejor = $surgiomejor, fuerzamayor=$fuerzamayor,
        sintiempo=$sintiempo, problemasinternos=$problemasinternos, problemasexternos=$problemasexternos, otros=$otros, porqueabandono='$porqueabandono', 
        vuelvefuncionar=$vuelvefuncionar, necesita='$necesita', programafinanc=$programafinancd 
        WHERE id_expediente = $id_expediente";

        mysqli_query($con, $update) or die($update);
        
    } else {
        
        $inserta = "INSERT INTO expedientes_ext_desis (id_expediente, norentable, faltacapital, surgiomejor, fuerzamayor, sintiempo, problemasinternos, problemasexternos, otros, porqueabandono, vuelvefuncionar, necesita, programafinanc) 
        VALUES ($id_expediente, $norentable, $faltacapital, $surgiomejor, $fuerzamayor, $sintiempo, $problemasinternos, $problemasexternos, $otros, '$porqueabandono', $vuelvefuncionar, '$necesita', $programafinancd)";
        
        mysqli_query($con, $inserta) or die($inserta);
    }
    
}else{
    

    if ($estado == 1 or $estado == 2) { // EXPEDIENTE FUNCIONANDO O EN VIAS DE FUNCIONAR
        
        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
        mysqli_query($con, "DELETE FROM expedientes_ext_desis  WHERE id_expediente = $id_expediente") or die('Limpia siguen');
        mysqli_query($con, "DELETE FROM expedientes_ext_inicia WHERE id_expediente = $id_expediente") or die('Limpia inician');
        //
        
        if ($estado == 2) { // EN VIAS DE FUNCIONAR     
            
            
            $emplazamiento  = $_POST['emplazamiento'];
            $contacto       = $_POST['contacto'];
            $metodo         = $_POST['metodo'];
            $marketing      = $_POST['marketing'];
            $costosp        = $_POST['costosp'];
            $canalesventa   = $_POST['canalesventa'];

            $seleccion = mysqli_query($con, "SELECT id_expediente 
            FROM expedientes_ext_inicia 
            WHERE id_expediente = $id_expediente") or die('Ver seleccion inician');
            
            $registro = mysqli_fetch_array($seleccion);
            
            if ($registro) {

                mysqli_query($con, "UPDATE expedientes_ext_inicia 
                SET emplazamiento = $emplazamiento, contacto = $contacto, metodo = $metodo, marketing=$marketing, costosp=$costosp, canalesventa=$canalesventa
                WHERE id_expediente = $id_expediente") or die('Ver edicion inician');
                
            } else {

                mysqli_query($con, "INSERT INTO expedientes_ext_inicia
                (id_expediente, emplazamiento, contacto, metodo, marketing, costosp, canalesventa) 
                VALUES ($id_expediente, $emplazamiento, $contacto, $metodo, $marketing, $costosp, $canalesventa)") or die('Ver inserción inician');
            }
        }
        
        // EXPEDIENTE FUNCIONANDO

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
        $codigoafip     = $_POST['codigoafip'];
        $esexportable   = $_POST['esexportable'];
        $deseaexportar  = $_POST['deseaexportar'];   
        
        $mer_ciudad     = 0;
        $mer_zonas      = 0;
        $mer_provincia  = 0;
        $mer_nacional   = 0;
        
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

        $dondevende             = $_POST['dondevende'];
        $tipohabilitacion       = $_POST['tipohabilitacion'];
        
        $pventaserv1            = $_POST['pventaserv1'];
        $pintermediarioserv1    = $_POST['pintermediarioserv1'];
        $pventainteralconsumserv1 = $_POST['pventainteralconsumserv1'];
        $pventaserv2            = $_POST['pventaserv2'];
        $pintermediarioserv2    = $_POST['pintermediarioserv2'];
        $pventainteralconsumserv2 = $_POST['pventainteralconsumserv2'];
        $pventaserv3            = $_POST['pventaserv3'];
        $pintermediarioserv3    = $_POST['pintermediarioserv3'];
        $pventainteralconsumserv3 = $_POST['pventainteralconsumserv3'];
        $conoceferia            = $_POST['conoceferia'];
        $participoferia         = $_POST['participoferia'];
        $interesparticipar      = $_POST['interesparticipar'];
        $limitanteferias        = $_POST['limitanteferias'];

        $costoemp1              = $_POST['costoemp1'];
        $costoemp2              = $_POST['costoemp2'];
        $costoemp3              = $_POST['costoemp3'];

        $tipocontrolcontable    = $_POST['tipocontrolcontable'];
        $tipocontrolcostos      = $_POST['tipocontrolcostos'];
        $tipocontrolinsumos     = $_POST['tipocontrolinsumos'];
        $tipocontrolstock       = $_POST['tipocontrolstock'];
        $tipocontrolproduccion  = $_POST['tipocontrolproduccion'];
        $frases                 = $_POST['frases'];
        
        $pcrecimiento_cp        = 0;
        $pcrecimiento_mp        = 0;
        $pcrecimiento_pcp       = 0;
        $pcrecimiento_pcv       = 0;
        $pcrecimiento_ci        = 0;
        $pcrecimiento_gcc       = 0;
        $pcrecimiento_pap       = 0;
        $pcrecimiento_pb        = 0;
        $pcrecimiento_op        = 0;
        $otrocrecimiento        = $_POST['otrocrecimiento'];
        
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
        
        $invirtiomascapital = $_POST['invirtiomascapital'];

        $tipofinan_dp   = 0;
        $tipofinan_of   = 0;
        $tipofinan_bt   = 0;
        
        for ($i = 0; $i < count($_POST['tipofinanciamiento']); $i++) {

            switch ($_POST['tipofinanciamiento'][$i]) {
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
        
        $trabajaalguienm= $_POST['trabajaalguienm'];
        $cantsocios     = $_POST['cantsocios'];
        $cantempleados  = $_POST['cantempleados'];
        $colaborafami   = $_POST['colaborafami'];
        $colaboranofami = $_POST['colaboranofami'];
        $cantotros      = $_POST['cantotros'];
 
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

        for ($i = 0; $i < count($_POST['capacitacion']); $i++) {

            switch ($_POST['capacitacion'][$i]) {
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
        
        $programafinanc = $_POST['programafinanc'];
        $sugerencia     = $_POST['sugerencia'];
        $semaforo       = $_POST['semaforo'];
        

        $seleccion = mysqli_query($con, "SELECT id_expediente 
            FROM expedientes_ext_sigue 
            WHERE id_expediente = $id_expediente") or die('Ver seleccion siguen');
        
        $registro = mysqli_fetch_array($seleccion);
        
        // ACTUALIZA EXPEDIENTE
        
        $actualiza = "UPDATE expedientes_ext_sigue SET 
            tipoactividad = $tipoactividad, prodserv1 ='$prodserv1', prodserv2 ='$prodserv2', prodserv3 ='$prodserv3', cantserv1 = '$cantserv1', cantserv2 = '$cantserv2', cantserv3 = '$cantserv3', costosserv1 = '$costosserv1', costosserv2 = '$costosserv2', costosserv3 = '$costosserv3', codigoafip = '$codigoafip',
                
            esexportable=$esexportable, deseaexportar=$deseaexportar, mer_ciudad=$mer_ciudad, mer_zonas=$mer_zonas, mer_provincia=$mer_provincia, mer_nacional=$mer_nacional, comer_directo=$comer_directo, comer_cooperativa=$comer_cooperativa, comer_minorista=$comer_minorista, comer_mayorista=$comer_mayorista, 
            dondevende = $dondevende, tipohabilitacion = $tipohabilitacion, 
            pventaserv1='$pventaserv1', pintermediarioserv1='$pintermediarioserv1', pventainteralconsumserv1='$pventainteralconsumserv1', pventaserv2='$pventaserv2', pintermediarioserv2='$pintermediarioserv2', pventainteralconsumserv2='$pventainteralconsumserv2', pventaserv3='$pventaserv3', pintermediarioserv3='$pintermediarioserv3', pventainteralconsumserv3='$pventainteralconsumserv3',
            conoceferia=$conoceferia, participoferia=$participoferia, interesparticipar=$interesparticipar, limitanteferias='$limitanteferias', tipocontrolcontable=$tipocontrolcontable, tipocontrolcostos=$tipocontrolcostos, tipocontrolinsumos=$tipocontrolinsumos, tipocontrolstock=$tipocontrolstock, tipocontrolproduccion=$tipocontrolproduccion, frases=$frases,
            costoemp1 = '$costoemp1', costoemp2 = '$costoemp2', costoemp3 = '$costoemp3',
            pcrecimiento_cp=$pcrecimiento_cp, pcrecimiento_mp=$pcrecimiento_mp, pcrecimiento_pcp=$pcrecimiento_pcp, pcrecimiento_pcv=$pcrecimiento_pcv, pcrecimiento_ci=$pcrecimiento_ci, pcrecimiento_gcc=$pcrecimiento_gcc, pcrecimiento_pap=$pcrecimiento_pap, pcrecimiento_pb=$pcrecimiento_pb, pcrecimiento_op=$pcrecimiento_op, otrocrecimiento='$otrocrecimiento',
            invirtiomascapital=$invirtiomascapital, tipofinan_dp=$tipofinan_dp, tipofinan_of=$tipofinan_of, tipofinan_bt=$tipofinan_bt, trabajaalguienm=$trabajaalguienm, cantsocios=$cantsocios, cantempleados=$cantempleados, cantotros=$cantotros, 
            colaborafami = $colaborafami, colaboranofami = $colaboranofami, 
            capac_no=$capac_no, capac_mc=$capac_mc, capac_e=$capac_e, capac_or=$capac_or, capac_a=$capac_a,capac_j=$capac_j, capac_c=$capac_c, capac_sa=$capac_sa, capac_mp=$capac_mp, capac_rs = $capac_rs,
            programafinanc = $programafinanc, 
            sugerencia = '$sugerencia', semaforo = $semaforo
            
            WHERE id_expediente = $id_expediente";
            
            
        
        if ($registro) {           
            
            mysqli_query($con, $actualiza) or die($actualiza.' Linea 373');
            
        } else {
            
            $inserta = "INSERT INTO expedientes_ext_sigue (id_expediente) VALUES ($id_expediente)";

            mysqli_query($con, $inserta) or die($inserta.' Linea 379');
            mysqli_query($con, $actualiza) or die($actualiza.' Linea 380');
            
        }
    }else{
        // RELEVAMIENTOS DE EXPEDIENTES QUE NO SE PUDIERON CONCRETAR
        
        // QUITAR RELEVAMIENTOS ANTERIORES CON OTROS ESTADOS
        mysqli_query($con, "DELETE FROM expedientes_ext_sigue  WHERE id_expediente = $id_expediente") or die('Limpia siguen');
        mysqli_query($con, "DELETE FROM expedientes_ext_inicia WHERE id_expediente = $id_expediente") or die('Limpia inician');
        mysqli_query($con, "DELETE FROM expedientes_ext_desis  WHERE id_expediente = $id_expediente") or die('Limpia desisten');
        //
        
    }
}


mysqli_close($con);

header('Location:seguimiento_ol.php');

