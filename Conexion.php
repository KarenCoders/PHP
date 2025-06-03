<?php

$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "mi_base_datos";

//crear conexion
$conn = new mysqli($servername, $username, $password, $dbname);

//verificar la conexion
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//Consulta a la base de datos
$sql = "SELECT id,nombre FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //salida de datos por cada fila
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nombre: " . $row["nombre"]. "<br>";
    }
} else {
    echo "0 resultados";
}
$conn->close();
?>