<?php
//Conexiíon usando PDO
$dsn = 'mysql:host=localhost;dbname=pokedex';
$usuario = 'root';
$contraseña = '@WebTech_2025';

try {
    $conexion = new PDO($dsn, $usuario, $contraseña);

    //Consuktar el ataque de Pikachu
    $consulta = $conexion->query("SELECT ataque FROM pokemon WHERE nombre = 'Pikachu'");
    $resultado = $consulta->fetch();
    echo "⚡ Pikachu tiene un ataque de " . $resultado['ataque'] . "<br>";

    //Actualilzar el ataque de Charmander
    $nuevoAtaque = 60;
    $conexion->exec("UPDATE pokemon SET ataque = $nuevoAtaque WHERE nombre = 'Charmander'");
    echo "🔥 ¡Charmander ha entrenado y ahora tiene un ataque de  $nuevoAtaque! 🔥";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>