<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_solicitante = $_POST['id_solicitante'];
$id_proyecto	= $_POST['id_proyecto'] ;

// OBTENER EDAD 

$tabla_sol      = mysqli_query($con, "SELECT fecha_nac FROM solicitantes WHERE id_solicitante = $id_solicitante");
$registro_sol   = mysqli_fetch_array($tabla_sol);
$fechaNac       = $registro_sol['fecha_nac'];

list($Y,$m,$d) = explode("-",$fechaNac);
$edad = date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y ;

// VERIFICO SI ESTA EN OTRO PROYECTO Y/O EXPEDIENTE

$estaproyecto = false;

// BUSCA SI DNI TIENE UN PROYECTO RELACIONADO
$tabla_solicitantes = mysqli_query($con, "SELECT t1.id_solicitante 
    FROM solicitantes t1
    INNER JOIN rel_proyectos_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    INNER JOIN proyectos t3 ON t2.id_proyecto = t3.id_proyecto
    WHERE t3.id_estado <> 25 AND t1.id_solicitante = $id_solicitante" );

if(mysqli_affected_rows($con) > 0){
    $estaproyecto = true;
}else{

    if($edad < 41 ){

        mysqli_query($con, "INSERT INTO rel_proyectos_solicitantes (id_proyecto, id_solicitante) VALUES ($id_proyecto, $id_solicitante)") or die ("Revisar insercion relacion solicitantes-proyectos");
        mysqli_query($con, "UPDATE solicitantes SET id_responsabilidad = 0 WHERE id_solicitante = $id_solicitante ") or die ("Revisar actualizacion solicitantes");
    } 
}

mysqli_close($con);

if($estaproyecto){
    echo '3';
}else{
    if($edad >= 41){
        echo '2';
    }else{        
        echo '1'   ;
    }
}

?>