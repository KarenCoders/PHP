<?php

$persona = array(
    "nombre" => "Juan",
    "edad" => 30,
    "ciudad" => "Miahuayork"
);

echo $persona["nombre"];

//Recorrer el array asociativo
foreach ($persona as $clave => $valor) {
    echo "$clave: $valor <br>";
}
?>