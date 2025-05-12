<?php 
header('Content-Type: application/json');

include_once '../components/conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $db = new BaseDatos();
    if (!$db->pdo) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.', 'code' => 500]);
        exit();
    }

    $planes = $db->read('planes', [], null, 'id, nombre, precio');
    if (empty($planes)) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'No se encontraron planes.', 'code' => 404]);
        exit();
    }

    // Devolver los planes en formato JSON

    http_response_code(200);
    echo json_encode(['status' => 'success', 'planes' => $planes, 'code' => 200]);
}