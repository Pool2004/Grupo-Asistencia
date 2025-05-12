<?php
/**
 * sendEmail.php
 *
 * Este archivo gestiona el envío de correos electrónicos para la recuperación de contraseña.
 * Recibe una dirección de correo por método POST, genera un enlace y un html con instrucciones
 * para el usuario, y envía un correo electrónico con un enlace para restablecer la contraseña.
 *
 * Funcionalidades comunes que puede incluir:
 * - Validación del correo recibido
 * - Verificación de que el correo esté registrado
 * - Generación de token único o hash temporal
 * - Envío de correo usando mail(), PHPMailer o librería SMTP
 *
 * Retorna una respuesta JSON con el estado de la operación (éxito o error).
 *
 * @method POST
 * @param string correo   Dirección de correo electrónico del usuario
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */


 // Configuración para permitir que el archivo sea accesible por AJAX
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../config/vendor/autoload.php'; // Cargamos la librería de PHPMailer
include_once '../models/conexion.php'; // Llamamos al archivo con la clase pdo para el manejo con la base de datos.
// Configuramos la cabecera para que el archivo sea accesible por AJAX
header('Content-Type: application/json');

try{
    

    $database = new BaseDatos(); // Instancia de la clase BaseDatos
    
    $correo = $_POST['correo'] ?? '';
    
    if ($correo == '') {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'El correo no puede estar vacío.']);
        die();
    }

    // Verificamos si el existe el correo en la base de datos

    $user = $database->read('usuarios', [], "correo = '$correo'");

    if (count($user) === 0) {
        http_response_code(403); // No autorizado
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no está registrado']);
        die();
    }

    // Configuramos el envio de correo
    
    if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
        
        $mail = new PHPMailer(true); // Configuramos el objeto PHPMailer que gestionará el envio de correo

        try{
            
            $mail->SMTPDebug = 0; // 0: Apagamos la depuración de SMTP
            $mail->isSMTP(); // Usamos SMTP
            $mail->Host = 'smtp.gmail.com'; // Servidor de correo saliente
            $mail->SMTPAuth = true; // Habilitamos la autenticación SMTP
            $mail->Username = 'jeandeveloper04@gmail.com'; // Correo de Gmaill
            $mail->Password = "nmwe kdef zysw jcwi"; // Contraseña de Gmail
            $mail->SMTPSecure = 'tls'; // Habilitamos el cifrado TLS
            $mail->Port = 587; // Puerto TCP para conectarse al servidor SMTP
            $mail->CharSet = 'UTF-8'; // Establece UTF-8 como codificación de caracteres
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 

            // Configuramos el correo

            $mail->setFrom('no-reply@neologic.com.co', 'Grupo Asistencia'); // Remitente
            $mail->addAddress($correo); // Destinatario
            $mail->isHTML(true); // Habilitamos el formato HTML
            $mail->Subject = 'Recuperación de Contraseña'; // Asunto

            $mail->Body = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  background-color: #f9f9f9;
                  color: #333;
                  margin: 0;
                  padding: 0;
                }
                .container {
                  max-width: 600px;
                  margin: 20px auto;
                  background: #ffffff;
                  padding: 20px;
                  border-radius: 8px;
                  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                  text-align: center;
                  background:rgb(0, 174, 255); /* Morado principal */
                  color: #ffffff;
                  padding: 15px;
                  border-radius: 8px 8px 0 0;
                }
                .header h1 {
                  margin: 0;
                  font-size: 24px;
                }
                .content {
                  margin: 20px 0;
                  text-align: center;
                  font-size: 16px;
                }
                .button {
                  display: inline-block;
                  padding: 12px 20px;
                  margin-top: 20px;
                  background:rgb(56, 232, 255); /* Morado principal */
                  color: #ffffff;
                  text-decoration: none;
                  border-radius: 5px;
                  font-weight: bold;
                }
                .button:hover {
                  background:rgb(17, 206, 231); /* Morado más oscuro */
                  color: black;
                  transition: background 0.3s, color 0.3s;
                }
                .footer {
                  text-align: center;
                  font-size: 12px;
                  color: #777;
                  margin-top: 20px;
                }
                .footer p {
                  margin: 0;
                }
                .footer .neologic {
                  color:rgb(0, 174, 255); /* Morado para resaltar Neologic */
                  font-weight: bold;
                }
              </style>
            </head>
            <body>
              <div class='container'>
                
                <div class='header'>
                  <h1>Restablece tu Contraseña</h1>
                </div>
                <div class='content'>
                    
                  <p>Hola,</p>
                  <p>Recibimos una solicitud para restablecer tu contraseña en el sistema <b>Grupo Asistencia</b></b>
                  <p>Haz clic en el botón de abajo para establecer una nueva contraseña:</p>
                  <a href='http://localhost/Entrevista/Cliente/views/new_password.html?correo=" . urlencode($correo) . "' class='button'>Restablecer Contraseña</a>
                  <p>Si no solicitaste este cambio, ignora este mensaje.</p>
                </div>
                <div class='footer'>
                  <p>© 2025 <span class='neologic'>Grupo Asistencia de ❤️</span>. Todos los derechos reservados.</p>
                </div>
              </div>
            </body>
            </html>
            ";


            // Enviar el correo
            if($mail->send()){
                http_response_code(200); // OK
                echo json_encode(['status' => 'ok', 'message' => 'Se ha enviado el correo con éxito.']);
            }else{
                http_response_code(500); // Error interno en el servidor
                echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo de verificación: '.$mail->ErrorInfo]);
            }
            
            
            
        }catch(Exception $error){
            http_response_code(500); // Error interno en el servidor
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo de verificación: '.$mail->ErrorInfo]);
        }
        
    }else{
        http_response_code(400); // Bad Request
        // Si el correo no es válido, devolver un error
       echo json_encode(['status' => 'error', 'message' => 'El correo contiene caracteres no permitidos.']); 
    }
    
}catch(PDOException $e){
    // Si hay un error en la conexión, devolver error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}


?>