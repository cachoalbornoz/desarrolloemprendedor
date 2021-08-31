<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar(); 

$dni = $_GET['dni'];

// REVISAR QUE EL DNI NO ESTE REGISTRADO
$tabla_solicitantes = mysqli_query($con,"SELECT id_solicitante FROM solicitantes WHERE dni = $dni" );

if(mysqli_affected_rows($con) > 0){

    echo "1" ;

}else{
    
    // REVISO QUE EL DNI ESTE EN LOS EXPEDIENTES SIN FINALIZAR EL PROYECTO. ESTADO = 3
    $tabla_emprendedores = mysqli_query($con,"SELECT exp.id_expediente 
        FROM expedientes AS exp, rel_expedientes_emprendedores AS ree, emprendedores AS emp
        WHERE exp.id_expediente = ree.id_expediente AND ree.id_emprendedor = emp.id_emprendedor AND exp.estado <> 3 AND emp.dni = $dni ;" );
    
    if(mysqli_affected_rows($con) > 0){
        echo "1" ;
    }else{
        echo "0" ;
    }
}
mysqli_close($con); 
