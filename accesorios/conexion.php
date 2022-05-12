<?php

function conectar(){
    
    $servidor   = ($_SERVER["HTTP_HOST"] == 'localhost' or $_SERVER["HTTP_HOST"] == '127.0.0.1' or $_SERVER["HTTP_HOST"] == '192.168.0.29')?'localhost':'10.88.0.1';
    $usuario    = 'galbornoz'; 
    $password   = 'albz8649';
    $database   = 'db_sgeer';

    $mysqli = new mysqli($servidor, $usuario, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	
    $mysqli->set_charset('utf8');

    return $mysqli;
}
?>