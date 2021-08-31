<?php
require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php';

$con = conectar();

$id_solicitante = $_POST['id_solicitante'];

$categoria      = $_POST['categoria'];
$asesor         = $_POST['asesor'];
$tematica       = $_POST['tematica'];
$usuario        = $_POST['usuario'];
$fecha_ini      = $_POST['fecha_ini'];
$fecha_fin      = $_POST['fecha_fin'];
$minutos        = $_POST['minutos'];

$select = mysqli_query($con, 
    "SELECT id_solicitante 
    FROM asesorar_seguimiento 
    WHERE id_solicitante = $id_solicitante AND categoria = $categoria");

if (mysqli_num_rows($select) > 0) {

    $registro = mysqli_fetch_array($select);

    $actualiza = "UPDATE asesorar_seguimiento 
    SET asesor = '$asesor', tematica = '$tematica', usuario = $usuario, fecha_ini = '$fecha_ini', fecha_fin = '$fecha_fin', minutos = '$minutos'
    WHERE id_solicitante = $id_solicitante AND categoria = $categoria";

    mysqli_query($con, $actualiza) or die($actualiza);

    $estado = 2;

} else {

    $inserta = "INSERT INTO asesorar_seguimiento (id_solicitante, categoria, asesor, tematica, usuario, fecha_ini, fecha_fin, minutos)
    VALUES ($id_solicitante, $categoria, '$asesor', '$tematica', $usuario, '$fecha_ini', '$fecha_fin', '$minutos')";

    mysqli_query($con, $inserta) or die($inserta);

    $estado = 1;
}

echo $estado;