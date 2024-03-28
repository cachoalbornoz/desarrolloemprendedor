<?php

require_once '../accesorios/accesos_bd.php';
require '../accesorios/mailer.php';
$con = conectar();

$proximo_mes = mes(date('m') + 1);

$apellido     = 'Albornoz';
$nombres      = 'Guillermo';
$email        = 'cachoalbornoz@gmail.com';
$asunto       = 'Programa Jóvenes Emprendedores - Fin período de prórroga';
$destinatario = "$nombres, $apellido";
$mensaje      = "<p> Estimada/o <strong> $nombres, $apellido </strong> </p> <p> Te informamos que el período de prórroga ha finalizado y el próximo mes de <strong> $proximo_mes </strong> comienzan los vencimientos de cuotas de tu Crédito. </p> <p> Saludos </p>";
$logo         = null;

//enviar($email, $asunto, $destinatario, $mensaje, $logo);
