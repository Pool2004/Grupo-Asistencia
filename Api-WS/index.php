<?php 
// Importamos el controllador con la lógica de negocio para los planes.
require_once '../Api-WS/controllers/PlanController.php';

    // Endpoint para obtener los planes
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/planes') !== false) {

        // Instanciamos el controlador con el método para obtener los planes

        $controller = new PlanController();

        $controller->obtenerPlanes();
    } 

    // Endpoint para crear un nuevo plan

    if($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/crear') !== false) {
        
        // Instanciamos el controlador con el método para obtener los planes
        $controller = new PlanController();

        $controller->crearPlan();
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE' && strpos($_SERVER['REQUEST_URI'], '/eliminar') !== false) {
        
        // Instanciamos el controlador con el método para obtener los planes
        $controller = new PlanController();

        $controller->eliminarPlan();
    }

    if($_SERVER['REQUEST_METHOD'] === 'PUT' && strpos($_SERVER['REQUEST_URI'], '/actualizar') !== false) {
        
        // Instanciamos el controlador con el método para obtener los planes
        $controller = new PlanController();

        $controller->actualizarPlan();
    }


?>