<?php

function getIdsByMessage(string $xml, string $message) : array
{
    $result = simplexml_load_string($xml);

    $resulta = null;

    $id = 0;

    foreach($result->entry as $entry) {

        $id ++; 

        if($entry->message[0] == $message){

            $resulta = $id;
        }
    }
    return  [$resulta];
}

$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<log>
    <entry id="1">
        <message>Application started</message>
    </entry>
    <entry id="2">
        <message>Application ended</message>
    </entry>
</log>
XML;


getIdsByMessage($xml, 'Application ended');


?>