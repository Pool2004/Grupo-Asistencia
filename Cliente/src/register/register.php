
<?php
/**
 * registro.php
 *
 * Archivo encargado de registrar un nuevo usuario (agente) en el sistema.
 * Recibe datos por método POST mediante una solicitud AJAX y realiza:
 * - Validación de campos obligatorios
 * - Validación de formato de correo
 * - Verificación de duplicado en la base de datos
 * - Hash de la contraseña
 * - Inserción del nuevo usuario en la tabla `usuarios`
 *
 * Si el registro es exitoso, retorna un JSON con estado `success`. Si ocurre algún
 * error de validación, duplicado o conexión, retorna un JSON con estado `error`
 * y un código HTTP adecuado (400, 409, 500, etc.).
 *
 * @method POST
 * @param string nombres       Nombres del usuario
 * @param string apellidos     Apellidos del usuario
 * @param string telefono      Número de teléfono
 * @param string correo        Correo electrónico (validado)
 * @param string contrasena    Contraseña en texto plano (se hashea con SHA-256)         Respuesta estructurada con estado y mensaje
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
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $email = isset($_POST['correo']) ? $_POST['correo'] : null;
    $password = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

    // Validar si los datos han sido proporcionados
    if (empty($email) || empty($password) || empty($nombres) || empty($apellidos) || empty($telefono)) {
        // Si falta alguno de los campos, devolver un error
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Por favor, ingresa todos los campos.']);
        exit();
    }

    // Validamos los campos

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si el email no es válido, devolver un error
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Email inválido.']);
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

    $data = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'telefono' => $telefono,
        'correo' => $email,
        'contrasena' => password_hash($password, PASSWORD_DEFAULT), // Hasheamos la contraseña
        'rol' => 'agente'
    ];

    
    // Verificar si se encontró un usuario que coincida
    $usuarios = $db->read('usuarios', [], "correo = '$email'", 'correo, contrasena, nombres, rol, id');
    if (!empty($usuarios)) {
        // Si el correo ya existe, devolver un error
        http_response_code(409); // Conflict
        echo json_encode(['status' => 'error', 'message' => 'El correo ya está registrado.']);
        exit();
    }


    if ($db->create('usuarios', $data)) {
        // Devolver respuesta exitosa
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
        
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
