<?php
/**
 * login.php
 *
 * Este archivo procesa el inicio de sesión de usuarios en el sistema.
 * Recibe por método POST el correo y la contraseña, valida los datos,
 * verifica si existe el usuario en la base de datos y si las credenciales son correctas.
 * Si la autenticación es exitosa, inicia una sesión PHP y devuelve una respuesta JSON.
 *
 * Funciones clave:
 * - Validación de campos requeridos
 * - Verificación del usuario por correo
 * - Comparación de la contraseña
 * - Inicio de sesión y almacenamiento en $_SESSION
 * - Respuesta en formato JSON con códigos HTTP apropiados
 *
 * @method POST
 * @param string email     Correo del usuario
 * @param string password  Contraseña en texto plano         
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */



// Configuración para permitir que el archivo sea accesible por AJAX
header('Content-Type: application/json'); // Establece la respuesta como JSON
header('Access-Control-Allow-Origin: *'); // Permite todas las solicitudes de origen cruzado

include_once '../models/conexion.php'; // Archivo para la conexión a la base de datos

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recoger los datos enviados por AJAX
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Validar si los datos han sido proporcionados
    if (empty($email) || empty($password)) {
        // Si falta alguno de los campos, devolver un error
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Por favor, ingresa todos los campos.']);
        exit();
    }

    // Crear una instancia de la clase BaseDatos
    $db = new BaseDatos();

    // Verificar conexión
    if (!$db->pdo) {
        // Si hay un error en la conexión, devolver error
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
        exit();
    }

    $usuarios = $db->read('usuarios', [], "correo = '$email'", 'correo, contrasena, nombres, rol, id');

    // Verificar si se encontró un usuario que coincida
    if (!empty($usuarios)) {

        // Verificamos la contraseña

        if(password_verify($password, $usuarios[0]['contrasena'])) {
            // Si la contraseña es correcta, iniciar sesión
            session_start();
            $_SESSION['correo'] = $usuarios[0]['correo']; // Guardar el email en la sesión
            $_SESSION['nombres'] = $usuarios[0]['nombres']; // Guardar el nombre en la sesión
            $_SESSION['rol'] = $usuarios[0]['rol']; // Guardar el rol en la sesión
            $_SESSION['id'] = $usuarios[0]['id']; // Guardar el id en la sesión
            $_SESSION['loggedin'] = true; // Marcar la sesión como iniciada

            // Devolver respuesta exitosa
            http_response_code(200); // OK
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
        } else {
            // Si la contraseña no coincide, error
            http_response_code(401); // Unauthorized
            echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
        }
        

    } else {
        // Si no hay coincidencia, error
        http_response_code(401); // Unauthorized
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
    }

} else {
    // Si no es una solicitud POST, devolver error
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
