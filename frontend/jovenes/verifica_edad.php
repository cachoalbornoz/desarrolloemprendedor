<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar(); 

$id_proyecto	= $_SESSION['id_proyecto'] ;

$tabla_sol = mysqli_query($con,"SELECT sol.fecha_nac 
    FROM solicitantes sol 
    INNER JOIN rel_proyectos_solicitantes rel on rel.id_solicitante = sol.id_solicitante 
    WHERE rel.id_proyecto = $id_proyecto");

// REVISAR QUE LA FECHA NAC DE LOS SOLICITANTES NO SUPERE LOS 41 AÑOS

$mayor = false;

while($registro_sol = mysqli_fetch_array($tabla_sol)){

    $fechaNac   = $registro_sol['fecha_nac'];

    list($Y,$m,$d) = explode("-",$fechaNac);
    $edad = date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y ;

    if($edad >= 41 ){
        $mayor = true;
        break;
    }    
}


if($mayor){
    echo '1';
}else {
    echo '0';
}

mysqli_close($con); 