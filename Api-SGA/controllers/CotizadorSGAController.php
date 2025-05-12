<?php
/**
 * CotizadorSGAController.php
 * 
 * Controlador encargado de manejar las solicitudes relacionadas con los seguros y redirigirlas a la API externa, métodos:
 * 
 * - Obtener cotizaciones
 * - Crear, actualizar y eliminar planes
 * 
 * Este controlador se comunica con la API externa y responde en formato JSON hacia el cliente.
 * 
 * Autor: Dev Jean Paul Ordoñez
 * Fecha: 10/05/2025
 */

class CotizadorSGAController {

    /**
     * Recibe los datos del cliente, los reenvía a la API externa y retorna la respuesta.
     *
     * @return void
     */
    public function cotizar() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        // Validar que lleguen los campos requeridos
        if (!$input || !isset($input['nombre'], $input['apellidos'], $input['fechaNacimiento'], $input['placa'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos requeridos', 'status' => 400]);
            return;
        }

        // Configurar la petición a la API externa
        $url = 'http://localhost/Entrevista/Api-WS/index.php/cotizar'; 
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

        // Ejecutar la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Manejar errores de conexión
        if ($error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar con la API externa', 'detalle' => $error, 'status' => 500]);
            return;
        }

        // Retornar la respuesta de la API externa al cliente
        http_response_code($httpCode);
        echo $response;
    }


    /**
     * Función para crear un nuevo plan de seguros.
     *
     * @return void
     */
    public function crearPlan() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        // Validar que lleguen los campos requeridos
        if (!$input || !isset($input['nombre'], $input['precio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos requeridos', 'status' => 400]);
            return;
        }

        // Configurar la petición a la API externa
        $url = 'http://localhost/Entrevista/Api-WS/index.php/crear'; 
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

        // Ejecutar la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Manejar errores de conexión
        if ($error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar con la API externa', 'detalle' => $error, 'status' => 500]);
            return;
        }

        // Retornar la respuesta de la API externa al cliente
        http_response_code($httpCode);
        echo $response;
    }


    /**
     * Función para actualizar un plan de seguros existente.
     *
     * @return void
     */
    public function actualizarPlan() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        // Validar que lleguen los campos requeridos
        if (!$input || !isset($input['id'] , $input['nombre'], $input['precio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos requeridos', 'status' => 400]);
            return;
        }

        // Configurar la petición a la API externa
        $url = 'http://localhost/Entrevista/Api-WS/index.php/actualizar'; 
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

        // Ejecutar la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Manejar errores de conexión
        if ($error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar con la API externa', 'detalle' => $error, 'status' => 500]);
            return;
        }

        // Retornar la respuesta de la API externa al cliente
        http_response_code($httpCode);
        echo $response;
    }

    /**
     * Función para eliminar un plan de seguros existente.
     *
     * @return void
     */
    public function eliminarPlan() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        // Validar que lleguen los campos requeridos
        if (!$input || !isset($input['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos requeridos', 'status' => 400]);
            return;
        }

        // Configurar la petición a la API externa
        $url = 'http://localhost/Entrevista/Api-WS/index.php/eliminar'; 
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));

        // Ejecutar la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Manejar errores de conexión
        if ($error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar con la API externa', 'detalle' => $error, 'status' => 500]);
            return;
        }

        // Retornar la respuesta de la API externa al cliente
        http_response_code($httpCode);
        echo $response;
    }


    /**
     * Función para obtener los planes de seguros disponibles.
     *
     * @return void
     */
    public function planes() {
        header('Content-Type: application/json');

        // Configurar la petición a la API externa
        $url = 'http://localhost/Entrevista/Api-WS/index.php/planes'; 
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


        // Ejecutar la petición
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Manejar errores de conexión
        if ($error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al conectar con la API externa', 'detalle' => $error, 'status' => 500]);
            return;
        }

        // Retornar la respuesta de la API externa al cliente
        http_response_code($httpCode);
        echo $response;
    }
}
