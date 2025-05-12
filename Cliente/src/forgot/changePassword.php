<?php
// Incluir archivos de conexión a la base de datos y autenticación
include_once '../models/conexion.php'; // Llamamos al archivo con la clase pdo para el manejo con la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Instanciamos la clase BaseDatos
    $db = new BaseDatos();

    // Obtener las contraseñas desde la solicitud AJAX
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $correo = $_POST['correo'] ?? '';

    // Validar si las contraseñas no están vacías
    if (empty($oldPassword) || empty($newPassword)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Las contraseñas no pueden estar vacías.']);
        exit();
    }

    $user = $db->read('usuarios', [], "correo = '$correo'", 'correo, contrasena, id');

    if (!$user) {
        http_response_code(401); // Unauthorized
        // Si la contraseña antigua no coincide, devolver un error
        echo json_encode(['status' => 'error', 'message' => 'La contraseña antigua es incorrecta.']);
        exit();
    }

    
    // Hashear la nueva contraseña
    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    
    

    if ($db->update('usuarios', ['contrasena' => $passwordHash], ['correo' => $correo])) {
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'La contraseña ha sido cambiada exitosamente.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Hubo un error al actualizar la contraseña, intenta nuevamente.']);
    }
} else {
    // Si no es una solicitud POST, devolver un error
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>
