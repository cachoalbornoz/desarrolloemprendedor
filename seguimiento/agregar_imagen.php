<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}

require_once "../accesorios/accesos_bd.php";

$con=conectar(); 

$id_usuario = $_SESSION['id_usuario'];

$id_expediente  = $_POST['id_expediente'];
$resena         = sanear_campo($_POST['resena']);
$archivo        = $_FILES['archivo_foto']['name'];

if(strlen($_POST['resena']) > 0){
   mysqli_query($con,"UPDATE seguimiento_expedientes SET resena = '$resena'WHERE id_expediente = $id_expediente") or die ('Ver ingreso de Reseña');   
}

if($_FILES['archivo_foto']['size'] > 0){

    // BORRAR IMAGEN VIEJA SI HABIA             

    $registro   = mysqli_query($con,"SELECT archivo FROM seguimiento_expedientes WHERE id_expediente = $id_expediente") or die ('Ver seleccion foto vieja'); 
    $fila = mysqli_fetch_array($registro, MYSQLI_BOTH);

    if(strlen($fila['archivo']) > 0){
        $imagenVieja  = $fila['archivo'];

        if (file_exists("images/".$imagenVieja)) {
            unlink("images/".$imagenVieja); 
        }

    } 

    if(move_uploaded_file($_FILES['archivo_foto']['tmp_name'],"images/".$archivo)){            
        chmod("images/".$_FILES['archivo_foto']['name'],0777);          
        mysqli_query($con,"UPDATE seguimiento_expedientes SET archivo = '$archivo' WHERE id_expediente = $id_expediente") or die ('Ver ingreso de Foto ');             

    }

}

// BORRAR ARCHIVO DE POSICIONES

$nombre_marcador = 'marcadores.xml'; 

if (file_exists($nombre_marcador)) {
    unlink($nombre_marcador); 
}

// CARGAR LAS POSICIONES AL ARCHIVOS MARCADORES

$marcadores = mysqli_query($con, "select exp.id_expediente,emp.apellido,emp.nombres, seg.latitud, seg.longitud, seg.funciona, rub.rubro,if(seg.resena = '','Sin datos',seg.resena) as resena,
if(seg.archivo = '',0,seg.archivo) as archivo
from expedientes as exp 
inner join rel_expedientes_emprendedores as ree on exp.id_expediente = ree.id_expediente 
inner join emprendedores as emp on ree.id_emprendedor = emp.id_emprendedor 
inner join seguimiento_expedientes as seg on exp.id_expediente = seg.id_expediente
left join tipo_rubro_productivos as rub on exp.id_rubro = rub.id_rubro where emp.id_responsabilidad = 1 and round(seg.latitud) < 0
order by emp.apellido,emp.nombres asc") or die('Revisar Lectura de Posiciones');

if(mysqli_num_rows($marcadores) > 0){

    $ar=fopen($nombre_marcador,'w+');

    $detalle = '<?xml version="1.0" encoding="utf-8" ?>';
    fputs($ar, $detalle);
    fputs($ar,"\r\n");
    $detalle = '<marcadores>';
    fputs($ar, $detalle);
    fputs($ar,"\r\n");

    while($registro = mysqli_fetch_array($marcadores)){
        $detalle = "\t" .'<marcador>'; fputs($ar, $detalle);fputs($ar,"\r\n");

        $detalle = "\t \t" .'<id_expediente>'.$registro['id_expediente'].'</id_expediente>';	fputs($ar, $detalle); fputs($ar,"\r\n");
        $detalle = "\t \t" .'<propietario>'.trim($registro['apellido']).', '.trim($registro['nombres']).'</propietario>'; fputs($ar, $detalle); fputs($ar,"\r\n");
        $detalle = "\t \t" .'<latitud>'.round($registro['latitud'],8).'</latitud>';	fputs($ar, $detalle); fputs($ar,"\r\n");
        $detalle = "\t \t" .'<longitud>'.round($registro['longitud'],8).'</longitud>';fputs($ar, $detalle); fputs($ar,"\r\n");
        if($registro['funciona'] == 1){$color="green";}else{$color="red";};            
        $detalle = "\t \t" .'<color>'.$color.'</color>';fputs($ar, $detalle); fputs($ar,"\r\n");
        $detalle = "\t \t" .'<funciona>'.$registro['funciona'].'</funciona>';fputs($ar, $detalle); fputs($ar,"\r\n");                    
        $detalle = "\t \t" .'<rubro>'.$registro['rubro'].'</rubro>';fputs($ar, $detalle); fputs($ar,"\r\n"); 
        $detalle = "\t \t" .'<resena>'.$registro['resena'].'</resena>';fputs($ar, $detalle); fputs($ar,"\r\n"); 
        $detalle = "\t \t" .'<archivo>'.$registro['archivo'].'</archivo>';fputs($ar, $detalle); fputs($ar,"\r\n");             

        $detalle = "\t" .'</marcador>'; fputs($ar, $detalle);	fputs($ar,"\r\n");	
    }

    $detalle = '</marcadores>';
    fputs($ar, $detalle);
    fputs($ar,"\r\n");

    fclose($ar);
} 

   
mysqli_close($con);  

header('location:sesion_usuario_carga_imagenes.php?id_carga='.base64_encode(time()));