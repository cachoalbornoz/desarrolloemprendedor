<?php

require_once("../accesorios/accesos_bd.php");

$con=conectar();

$id_solicitante = $_POST['id'];

mysqli_query($con, "DELETE t1, t2, t5, t6, t7, t8, t9, t10
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
LEFT JOIN rel_proyectos_solicitantes t5 ON t1.id_solicitante = t5.id_solicitante
LEFT JOIN habilitaciones t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN proyectos t7 ON t7.id_proyecto = t5.id_proyecto
LEFT JOIN seguimiento_proyectos t8 ON t1.id_solicitante = t8.id_solicitante
LEFT JOIN proaccer_inscripcion t9 ON t1.id_solicitante = t9.id_solicitante
LEFT JOIN proaccer_seguimientos t10 ON t9.id = t10.id_proyecto
WHERE t1.id_solicitante = $id_solicitante");

echo '1';

?>