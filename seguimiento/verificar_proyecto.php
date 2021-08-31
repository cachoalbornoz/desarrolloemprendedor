<?php
require_once("../accesorios/accesos_bd.php");
$con=conectar();

$id = $_POST['id'];

$tabla_solicitantes = mysqli_query($con,"SELECT dni FROM solicitantes WHERE id_solicitante = $id");

$registro_sol = mysqli_fetch_array($tabla_solicitantes);

$dni = $registro_sol['dni'];


$tabla_proyectos = mysqli_query($con,"SELECT te.estado,rp.rubro,exp.id_expediente,te.icono
FROM expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp 
WHERE exp.id_expediente = ree.id_expediente AND ree.id_emprendedor = emp.id_emprendedor AND emp.dni = $dni
AND exp.estado = te.id_estado AND exp.id_rubro = rp.id_rubro 
order by emp.apellido,emp.nombres asc");

$registro = mysqli_fetch_array($tabla_proyectos);

if($registro){
    echo $registro['icono'].' - Rubro: '.$registro['rubro'].' // Nro_expediente: '.$registro['id_expediente'];
}else{
    echo "0" ;
}

mysqli_close($con); 

