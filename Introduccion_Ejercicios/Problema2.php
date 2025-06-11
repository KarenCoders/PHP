<?php
session_start();

// Inicializamos productos y ticket si no existen
if (!isset($_SESSION['productos'])) $_SESSION['productos'] = array();
if (!isset($_SESSION['ticket'])) $_SESSION['ticket'] = array();

$mensaje = '';
$ticketHtml = '';

// Registrar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    $_SESSION['productos'][] = array(
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    );

    $mensaje = "Producto '$nombre' registrado correctamente.";
}

// Comprar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $nombreComprar = $_POST['nombre_comprar'];
    $cantidadComprar = intval($_POST['cantidad_comprar']);
    $compraExitosa = false;

    foreach ($_SESSION['productos'] as $key => $producto) {
        if ($producto['nombre'] === $nombreComprar) {
            if ($producto['cantidad'] >= $cantidadComprar) {
                $_SESSION['productos'][$key]['cantidad'] -= $cantidadComprar;

                $_SESSION['ticket'][] = array(
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidadComprar,
                    'total' => $producto['precio'] * $cantidadComprar
                );

                $compraExitosa = true;
                $mensaje = "Compra exitosa de $cantidadComprar unidad(es) de '$nombreComprar'.";
            } else {
                $mensaje = "No hay suficiente cantidad de '$nombreComprar'.";
            }
            break;
        }
    }

    if (!$compraExitosa && $mensaje === '') {
        $mensaje = "Producto '$nombreComprar' no encontrado.";
    }
}

// Pagar: mostrar ticket completo y limpiar la sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pagar'])) {
    if (count($_SESSION['ticket']) > 0) {
        $ticketHtml .= "<h2>Ticket de Compra</h2><ul>";
        $totalFinal = 0;

        foreach ($_SESSION['ticket'] as $item) {
            $ticketHtml .= "<li>{$item['cantidad']} x {$item['nombre']} @ {$item['precio']} = $" . number_format($item['total'], 2) . "</li>";
            $totalFinal += $item['total'];
        }

        $ticketHtml .= "</ul><strong>Total a pagar: $" . number_format($totalFinal, 2) . "</strong>";

        // Limpiar sesión
        session_unset();  // Borra todas las variables de sesión
        session_destroy();  // Destruye la sesión
    } else {
        $mensaje = "No hay productos en el ticket.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tienda en Línea</title>
</head>
<body>

<h2>Registrar Producto</h2>
<form method="post">
    Nombre: <input type="text" name="nombre" required><br>
    Precio: <input type="number" name="precio" step="0.01" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    <input type="submit" name="registrar" value="Registrar Producto">
</form>

<?php if ($mensaje): ?>
    <p><strong><?php echo $mensaje; ?></strong></p>
<?php endif; ?>

<hr>

<h2>Lista de Productos</h2>
<ul>
    <?php
    if (isset($_SESSION['productos']) && count($_SESSION['productos']) > 0) {
        foreach ($_SESSION['productos'] as $p) {
            echo "<li>Nombre: {$p['nombre']}, Precio: {$p['precio']}, Cantidad: {$p['cantidad']}</li>";
        }
    } else {
        echo "<li>No hay productos registrados.</li>";
    }
    ?>
</ul>

<hr>

<h2>Comprar Producto</h2>
<form method="post">
    Nombre del producto a comprar: <input type="text" name="nombre_comprar" required><br>
    Cantidad: <input type="number" name="cantidad_comprar" min="1" required><br>
    <input type="submit" name="comprar" value="Comprar Producto">
</form>

<hr>

<h2>Pagar</h2>
<form method="post">
    <input type="submit" name="pagar" value="Pagar">
</form>

<hr>

<?php
// Mostrar ticket si fue generado
if (!empty($ticketHtml)) {
    echo $ticketHtml;
}
?>

</body>
</html>
