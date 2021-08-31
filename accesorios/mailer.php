<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/public/vendor/autoload.php');

function enviar($email, $titulo, $nombres, $mensaje, $logo, $programa = 1){

    $mail = new PHPMailer;   
    
    try {
        
        // LOCALHOST
        if($_SERVER["HTTP_HOST"] == 'localhost' or $_SERVER["HTTP_HOST"] == '127.0.0.1' or $_SERVER["HTTP_HOST"] == '192.168.0.29'){

            $mail->isSMTP();
            $mail->SMTPDebug = 0;                                         
            $mail->Host       = 'smtp.gmail.com';         
            $mail->SMTPAuth   = true;                    
            $mail->Username   = 'cachoalbornoz@gmail.com';
            $mail->Password   = 'CachoAlbornoz1973';  
            $mail->SMTPSecure = 'tls';        
            $mail->Port       = 587; 

        }else{

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
        
        $mail->CharSet = 'utf-8';
        $mail->setFrom('pedrogebhart@entrerios.gov.ar', 'Secretaria de Desarrollo Emprendedor');
        $mail->addAddress($email, $nombres);  

        if($programa == 1){
            $mail->addAddress('desarrolloemprendedor@entrerios.gov.ar', 'Programa Jovenes Emprendedores');  
        }else{
            if($programa == 4){
                $mail->addAddress('dir.formacionemprendedora@gmail.com', 'Programa Competencias Emprendedoras');
            }
        }
        
        $mail->Subject  = $titulo;

        if(isset($logo)){
            $mail->AddEmbeddedImage($logo, 'logo'); 
            $mail->Body     = '<br>'.$mensaje.'<br> <img alt="Desarrollo Emprendedor" src="cid:logo">';
        }else{
            $mail->Body     = '<br>'.$mensaje;
        }

        $mail->send();

    } catch (Exception $e) {

        $mail->ErrorInfo;

    }    

}

?>