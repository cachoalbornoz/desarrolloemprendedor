<?php 
include ('dumper.php');

$port = $_SERVER['SERVER_PORT'];	
if($port == 8085){$servidor = 'localhost';}else{$servidor = 'gualeguay';}

if(isset($_GET['comprimido'])){
	
	$archivo = 'jovenes.sql.gz';
	
}else{
	
	$archivo = 'jovenes.sql';
}


try {
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $servidor,
		'username' => 'galbornoz',
		'password' => 'albz8649',
		'db_name' => 'jovenes',
	));

	// dump the database to gzipped file
	$world_dumper->dump($archivo);

	// dump the database to plain text file
	$world_dumper->dump($archivo);	
	
	header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $archivo . "\"");
    echo $content;
    exit;


} catch(Shuttle_Exception $e) {
	echo "Couldn't dump database: " . $e->getMessage();
}