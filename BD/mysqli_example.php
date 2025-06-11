
<?php
//Conexión usando MySQLi
$conexion = new mysqli('localhost', 'root', '@WebTech_2025', 'pokedex');

//verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

//Consultar el ataque de Squirtle
$consulta = $conexion->query("SELECT ataque FROM pokemon WHERE nombre = 'Squirtle'");
$resultado = $consulta->fetch_assoc();
echo "💧 Squirtle tiene un ataque de " . $resultado['ataque'] . "<br>";

//Actualizar el ataque de Bulbasaur
$nuevoAtaque = 65;
$conexion->query("UPDATE pokemon SET ataque = $nuevoAtaque WHERE nombre = 'Bulbasaur'");
echo "🌿 ¡Bulbasaur ha entrenado y ahora tiene un ataque de $nuevoAtaque! 🌿";

//Cerrar la conexión
$conexion->close();
?>