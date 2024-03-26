<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/public/vendor/autoload.php';

function enviar($email, $titulo, $nombres, $mensaje, $logo, $programa = 1)
{

    $body = '
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			</head>
			<body>
				<table width="648" border="0" cellpadding="0" cellspacing="15" style="font-family:arial,helvetica,sans-serif; font-size:15px; color:#717271;">
					<tr>
						<td><img src="cid:logo" alt="MPIyS" /></td>
					</tr>
					<tr>
						<td>' . $mensaje . '</td>
					</tr>
					<tr>
						<td><hr style="color:#00A8E1; background-color:#00A8E1; height:1px; border:0; margin:0;"><span style="font-size:11px; color:#00A8E1;">Este mensaje se envió desde el sitio oficial del MPIyS | ' . date('Y/m/d') . ' ' . date('H:i:s') . '</span></td>
					</tr>
				</table>
			</body>
		</html>
	';


    $mail = new PHPMailer();

    try {

        // LOCALHOST
        if($_SERVER['HTTP_HOST'] == 'localhost' or $_SERVER['HTTP_HOST'] == '127.0.0.1' or $_SERVER['HTTP_HOST'] == '192.168.0.29') {

            $mail->isSMTP();
            $mail->SMTPDebug  = 0;
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cachoalbornoz@gmail.com';
            $mail->Password   = 'CachoAlbornoz1973';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

        } else {

            $mail->isSMTP();
            $mail->SMTPDebug    = 0;
            $mail->Host         = 'smtpinterno.entrerios.gov.ar';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'pedrogebhart@entrerios.gov.ar';
            $mail->Password     = 'cervantes69';
            $mail->IsHTML(true);
            $mail->SMTPSecure   = 'tls';
            $mail->Port         = 587;
            $mail->SMTPOptions  = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

        }

        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cachoalbornoz@gmail.com';
        $mail->Password   = 'CachoAlbornoz1973';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet = 'utf-8';
        $mail->setFrom('cachoalbornoz@gmail.com', 'Secretaria de Desarrollo Emprendedor');
        $mail->addAddress($email, $nombres);

        $mail->Subject = $titulo;

        if(isset($logo)) {
            $mail->AddEmbeddedImage($logo, 'logo');
            $mail->Body = '<br>' . $mensaje . '<br> <img alt="Desarrollo Emprendedor" src="cid:logo">';
        } else {
            $mail->Body = '<br>' . $mensaje;
        }

        return $mail->send();
        

    } catch (Exception $e) {

        $mail->ErrorInfo;

    }

}
