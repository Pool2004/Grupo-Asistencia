<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Por favor, ingresa todos los campos.']);
        exit();
    }

    $db = new BaseDatos();

    if (!$db->pdo) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
        exit();
    }

    $query = "SELECT correo, contrasena, nombres, rol, id FROM usuarios WHERE correo = :email";
    $stmt = $db->pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarios) {
        if (true) {
            session_start();
            $_SESSION['correo'] = $usuarios['correo'];
            $_SESSION['nombres'] = $usuarios['nombres'];
            $_SESSION['rol'] = $usuarios['rol'];
            $_SESSION['id'] = $usuarios['id'];
            $_SESSION['loggedin'] = true;

            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
        } else {
            http_response_code(402);
            echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
    }

} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
