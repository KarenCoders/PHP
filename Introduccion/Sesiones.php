<?php
//Iniciar sesión
session_start();

//Asignar el valor de la variable de sesión
$_SESSION["usuario"] = "Juan";

//Acceder al valor de la sesión
echo "Usuario: " . $_SESSION["usuario"];

//Cerrar sesión
session_destroy();
?>