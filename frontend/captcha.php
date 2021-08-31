<?php
session_start();

$texto      = rand (10000,99999);
$_SESSION ["vercode"] = $texto ;

$image              = imagecreatetruecolor (200, 30);
$background_color   = imagecolorallocate($image, 255, 255, 255);  
imagefilledrectangle($image,0,0,200,25,$background_color);
$line_color         = imagecolorallocate($image, 2,117,216);
$number_of_lines    = rand(3,6);

for($i=0;$i<$number_of_lines;$i++){
    imageline($image,0,rand()%50,250,rand()%50,$line_color);
}

$pixel = imagecolorallocate($image,2,117,216);

for($i=0;$i<500;$i++){
    imagesetpixel($image,rand()%200,rand()%50,$pixel);
}

$gris       = imagecolorallocate($image, 128, 128, 128);
$negro      = imagecolorallocate($image, 0, 0, 0);
$blanco     = imagecolorallocate($image, 255, 255, 255);
$primary    = imagecolorallocate($image, 2, 117, 216);
$textcolors = [$negro, $blanco];
 
$text_color = imagecolorallocate($image, 0,0,0);
$fuente     = $_SERVER['DOCUMENT_ROOT']."/desarrolloemprendedor/public/font/Avenir_95_Black.ttf";

$cadena = str_split($texto);

for($i = 0; $i < 5; $i++) {

    $espacio  = 200/5;
    $initial  = 20;

    imagettftext($image, 20, rand(-10, 30), $initial + $i*$espacio, 25, $primary, $fuente, $cadena[$i]);
}



imagejpeg ( $image , null, 80);

?>