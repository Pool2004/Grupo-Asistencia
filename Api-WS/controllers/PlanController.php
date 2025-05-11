<?php 

/**
 * PlanController.php
 * 
 * Controlador encargado de manejar las operaciones relacionadas con los planes de seguros:
 * - Obtener cotizaciones
 * - Crear, actualizar y eliminar planes
 * 
 * Este controlador se comunica con el modelo PlanModel y responde en formato JSON.
 * 
 * Autor: Dev Jean Paul Ordoñez
 * Fecha: 10/05/2025
 */


// Importamos la clase de los planes
require_once __DIR__ . '/../models/PlanModel.php';

class PlanController {


    /** Info funcion obtenerPlanes
     * 
     * Función: Obtiene los planes disponibles para cotización.
     * 
     * Valida la entrada del cliente y devuelve 3 ofertas simuladas con ID único.
     *
     * @return void 
     */

    public function obtenerPlanes(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['nombre'], $data['apellidos'], $data['fechaNacimiento'], $data['placa'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Verifique los datos enviados y su estructura.', 'status' => 400]);
            return;
        }

        $model = new PlanModel();
        $planes = $model->obtenerPlanesVehiculo();

        if (!$planes) {
            http_response_code(500);
            echo json_encode(['error' => 'No hay planes registrados.', 'status' => 500]);
            return;
        }

        $ofertas = [];
        foreach ($planes as $plan) {
            $ofertas[] = [
                'noCotizacion'   => strtoupper(bin2hex(random_bytes(3))),
                'placa'          => strtoupper($data['placa']),
                'valor'          => '$' . number_format($plan['precio'], 0, ',', '.'),
                'nombreProducto' => $plan['nombre']
            ];
        }


        http_response_code(200);
        echo json_encode(['message' => 'Planes obtenidos correctamente', 'planes' => $ofertas, 'status' => 200]);
    }


    /** 
     * Info función crearPlan
     * 
     * Función: Crea un nuevo plan de seguros si no existe previamente.
     * 
     * Valida que el nombre y precio estén presentes y sean correctos.
     * Verifica duplicados por nombre antes de insertar.
     *
     * @return void 
     */

    public function crearPlan(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['nombre'], $data['precio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Verifique los datos enviados y su estructura.', 'status' => 400]);
            return;
        }

        // Verificar que el precio sea un número y mayor a 0
        if (!is_numeric($data['precio']) || $data['precio'] <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'El precio debe ser un número mayor a 0.', 'status' => 400]);
            return;
        }

        // Verificar que el nombre no esté vacío

        if (empty(trim($data['nombre']))) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre no puede estar vacío.', 'status' => 400]);
            return;
        }

        // Instanciamos el modelo
        $model = new PlanModel();
        // Obtenemos los planes y evaluamos si existe el plan previamente
        $planes = $model->obtenerPlanesVehiculo();

        foreach ($planes as $plan) {
            if (strtolower($plan['nombre']) === strtolower($data['nombre'])) {
                http_response_code(409);
                echo json_encode(['error' => 'El plan con dicho nombre ya existe.', 'status' => 409]);
                return;
            }
        }

        $result = $model->crearPlan($data);

        if (!$result) {
            http_response_code(500);
            echo json_encode(['error' => 'Ha ocurrido un error al crear el plan.', 'status' => 500]);
            return;
        }

        http_response_code(201);
        echo json_encode(['message' => 'Plan creado correctamente', 'status' => 201]);
    }




    /** 
     * Info función eliminarPlan
     * 
     * Función: Elimina un plan de seguros existente por ID.
     * 
     * Valida que el ID exista en la base de datos antes de eliminar.
     *
     * @return void 
     */
    public function eliminarPlan(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Verifique los datos enviados y su estructura.', 'status' => 400]);
            return;
        }

        // Instanciamos el modelo
        $model = new PlanModel();
        // Obtenemos los planes y evaluamos si existe el plan previamente
        $planes = $model->obtenerPlanesVehiculo();

        foreach ($planes as $plan) {
            if ($plan['id'] === $data['id']) {
                $result = $model->eliminarPlan($data['id']);
                if (!$result) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Ha ocurrido un error al eliminar el plan.', 'status' => 500]);
                    return;
                }
                http_response_code(200);
                echo json_encode(['message' => 'Plan eliminado correctamente', 'status' => 200]);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'El plan no existe.', 'status' => 404]);
    }


    /** 
     * Info función actualizarPlan
     * 
     * Función: Actualiza los datos de un plan de seguros existente.
     * 
     * Valida que el ID, nombre y precio sean válidos.
     * Verifica la existencia del plan antes de actualizarlo.
     *
     * @return void 
     */
    
    public function actualizarPlan(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id'], $data['nombre'], $data['precio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Verifique los datos enviados y su estructura.', 'status' => 400]);
            return;
        }

        // Verificar que el precio sea un número y mayor a 0
        if (!is_numeric($data['precio']) || $data['precio'] <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'El precio debe ser un número mayor a 0.', 'status' => 400]);
            return;
        }

        // Verificar que el nombre no esté vacío
        if (empty(trim($data['nombre']))) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre no puede estar vacío.', 'status' => 400]);
            return;
        }

        // Instanciamos el modelo
        $model = new PlanModel();
        // Obtenemos los planes y evaluamos si existe el plan previamente
        $planes = $model->obtenerPlanesVehiculo();

        foreach ($planes as $plan) {
            if ($plan['id'] === $data['id']) {
                $result = $model->actualizarPlan($data['id'], $data);
                if (!$result) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Ha ocurrido un error al actualizar el plan.', 'status' => 500]);
                    return;
                }
                http_response_code(200);
                echo json_encode(['message' => 'Plan actualizado correctamente', 'status' => 200]);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'El plan no existe.', 'status' => 404]);
    }
}



?>