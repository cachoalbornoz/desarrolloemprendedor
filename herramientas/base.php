<?php

$usuario= 'galbornoz';
$passwd = 'albz8649';
$host	= 'gualeguay';
$bd		= 'jovenes';
$archivo= 'backup.sql'; 

/* Determina si la tabla será vaciada (si existe) cuando restauremos la tabla. */
$drop	= true;
$tablas = false; //tablas de la bd

  $mysqli      = new mysqli($host, $usuario, $passwd, $db);
    $mysqli->select_db($db);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row         = $queryTables->fetch_row())
    {
        $target_tables[] = $row[0];
    }
    if ($tables !== false)
    {
        $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--Database: `" . $db . "`\r\n\r\n\r\n";
    foreach ($target_tables as $table)
    {
        $result        = $mysqli->query('SELECT * FROM ' . $table);
        $fields_amount = $result->field_count;
        $rows_num      = $mysqli->affected_rows;
        $res           = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine    = $res->fetch_row();
        $content .= "\n\n" . $TableMLine[1] . ";\n\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0)
        {
            while ($row = $result->fetch_row())
            { //when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0)
                {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++)
                {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j]))
                    {
                        $content .= '"' . $row[$j] . '"';
                    }
                    else
                    {
                        $content .= '""';
                    } if ($j < ($fields_amount - 1))
                    {
                        $content.= ',';
                    }
                }
                $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num)
                {
                    $content .= ";";
                }
                else
                {
                    $content .= ",";
                } $st_counter = $st_counter + 1;
            }
        } $content .="\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $archivo = $archivo ? $archivo : $db . "___(" . date('H-i-s') . "_" . date('d-m-Y') . ")__rand" . rand(1, 11111111) . ".sql";
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $archivo . "\"");
    echo $content;
    exit;

