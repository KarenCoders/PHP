<?php
header('Content-Type: application/json');

// Verificar si se envió el parámetro pokemon
if (!isset($_GET['pokemon'])) {
    echo json_encode(['error' => 'No se especificó un Pokémon']);
    exit;
}

$pokemon = strtolower(trim($_GET['pokemon']));

// Validar que no esté vacío
if (empty($pokemon)) {
    echo json_encode(['error' => 'El nombre del Pokémon no puede estar vacío']);
    exit;
}

// URL de la API de Pokémon
$url = "https://pokeapi.co/api/v2/pokemon/{$pokemon}";

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Ejecutar la petición
$response = curl_exec($ch);

// Verificar errores
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error al conectar con la API']);
    exit;
}

// Obtener código de respuesta
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Cerrar conexión
curl_close($ch);

// Manejar respuesta
if ($httpCode === 404) {
    echo json_encode(['error' => 'Pokémon no encontrado']);
    exit;
} elseif ($httpCode !== 200) {
    echo json_encode(['error' => 'Error en la API']);
    exit;
}

// Devolver los datos del Pokémon
echo $response;
?>