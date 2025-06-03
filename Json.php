<?php

$persona = array ("Nombre" => "Viridiana", "Edad" => 25, "Ciudad" => "Oaxaca");

echo json_encode($persona);//Convertir el array a JSON

$json = '{"nombre" : "Irving", "edad": 31, "ciudad": "Miahuayork"}';
$persona = json_decode($json, true);//Convertir el JSON a array

echo $persona["nombre"]; //Imprime

?>