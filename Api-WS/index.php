<?php
/**
 * index.php
 * 
 * Punto de entrada para la API de planes de seguro (API Aseguradora Ficticia).
 * Encargado de enrutar las solicitudes HTTP hacia los métodos correctos del controlador.
 * 
 * Métodos soportados:
 * - POST: /cotizar, /crear
 * - PUT: /actualizar
 * - DELETE: /eliminar
 * 
 * Autor: Dev Jean Paul Ordoñez
 * Fecha: 10/05/2025
 */

require_once '../Api-WS/controllers/PlanController.php';

// Obtener el método y la ruta solicitada
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Instanciar el controlador principal
$controller = new PlanController();

// Definir las rutas válidas por método HTTP
$routes = [
    'POST' => [
        '/cotizar'  => 'obtenerPlanes',
        '/crear'    => 'crearPlan'
    ],
    'PUT' => [
        '/actualizar' => 'actualizarPlan'
    ],
    'DELETE' => [
        '/eliminar' => 'eliminarPlan'
    ]
];

// Buscar si la ruta y el método son válidos
if (isset($routes[$method])) {
    foreach ($routes[$method] as $route => $action) {
        if (strpos($uri, $route) !== false) {
            // Ejecutar el método correspondiente del controlador
            $controller->$action();
            exit;
        }
    }
}

// Si no se encuentra una ruta válida, retornar error 404
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Endpoint no encontrado']);
