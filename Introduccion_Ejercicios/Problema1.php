<?php
//Problema 1: Crear un formulario para registrar estudiantes con nombre, edad y calificación.
// Autor: [Karen Pacheco]

//Iniciamos una sesión
session_start();

//Inicializamos el arreglo estudiantes si no existe
if (!isset($_SESSION['estudiantes'])) {
    $_SESSION['estudiantes'] = array();
}

//Verificamos si se ha enviado el formulario

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recuperamos los datos del formulario
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $calificacion = $_POST['calificacion'];

    //Creamos un arreglo asociativo con los datos del estudiante
    $estudiante = array(
        'nombre' => $nombre,
        'edad' => $edad,
        'calificacion' => $calificacion
    );

    //Agregamos el estudiante al arreglo de estudiantes
    $_SESSION['estudiantes'][] = $estudiante;
}
?>

    <h2>Registrar Estudiante</h2>
    <form method="post">
        Nombre: <input type="text" name="nombre" required><br>
        Edad: <input type="number" name="edad" required><br>
        Calificacion: <input type="number" name="calificacion" min="0" max="10" required><br>
        <input type="submit" value="Registrar Estudiante">
    </form>

    <hr>
    <h2>Lista de Estudiantes</h2>
    <ul>
        <?php
        //Verificamos si hay estudiantes registrados
        if (count($_SESSION['estudiantes']) > 0) {
            foreach ($_SESSION['estudiantes'] as $e) {
                $estado = ($e["calificacion"] >= 6) ? "Aprobado" : "Reprobado";
                echo "<li>";
                echo "Nombre: " . $e["nombre"] . ", Edad: {$e["edad"]}, Calificacion: {$e["calificacion"]} - <strong>$estado</strong>";
                echo "</li>";
            }
        }
    ?>
</ul>

