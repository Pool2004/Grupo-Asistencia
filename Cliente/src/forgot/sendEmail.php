<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../config/vendor/autoload.php'; // Cargamos la librería de PHPMailer
include_once '../conexion.php'; // Llamamos al archivo con la clase pdo para el manejo con la base de datos.
header('Content-Type: application/json');

try{
    

    $database = new BaseDatos(); // Instancia de la clase BaseDatos
    
    $email = $_POST['email'] ?? '';
    
    if ($email == '') {
        echo json_encode(['status' => 'error', 'message' => 'El correo no puede estar vacío.']);
        die();
    }

    // Verificamos si el existe el correo en la base de datos

    $user = $database->read('users', [], "email = '$email'");

    if (count($user) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no está registrado']);
        die();
    }

    // Configuramos el envio de correo
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        $mail = new PHPMailer(true); // Configuramos el objeto PHPMailer que gestionará el envio de correo

        try{
            
            $mail->SMTPDebug = 0; // 0: Apagamos la depuración de SMTP
            $mail->isSMTP(); // Usamos SMTP
            $mail->Host = 'smtp.gmail.com'; // Servidor de correo saliente
            $mail->SMTPAuth = true; // Habilitamos la autenticación SMTP
            $mail->Username = 'neologic.sas@gmail.com'; // Correo de Gmaill
            $mail->Password = "bwqm nnug kowi ribp"; // Contraseña de Gmail
            $mail->SMTPSecure = 'tls'; // Habilitamos el cifrado TLS
            $mail->Port = 587; // Puerto TCP para conectarse al servidor SMTP
            $mail->CharSet = 'UTF-8'; // Establece UTF-8 como codificación de caracteres
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 

            // Configuramos el correo

            $mail->setFrom('no-reply@neologic.com.co', 'NeoLogic S.A.S.'); // Remitente
            $mail->addAddress($email); // Destinatario
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
                  background: #368d5b; /* Morado principal */
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
                  background:#368d5b; /* Morado principal */
                  color: #ffffff;
                  text-decoration: none;
                  border-radius: 5px;
                  font-weight: bold;
                }
                .button:hover {
                  background:#368d5b; /* Morado más oscuro */
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
                  color:#368d5b; /* Morado para resaltar Neologic */
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
                  <p>Recibimos una solicitud para restablecer tu contraseña en nuestro sistema <b>HV Tecno-Lujo</b></b>
                  <p>Haz clic en el botón de abajo para establecer una nueva contraseña:</p>
                  <a href='https://hvtecnolujo.com/nueva__contrasena.html?email=" . urlencode($email) . "' class='button'>Restablecer Contraseña</a>
                  <p>Si no solicitaste este cambio, ignora este mensaje.</p>
                </div>
                <div class='footer'>
                  <p>© 2025 <span class='neologic'>Neologic de ❤️</span>. Todos los derechos reservados.</p>
                </div>
              </div>
            </body>
            </html>
            ";


            // Enviar el correo
            if($mail->send()){
                echo json_encode(['status' => 'ok', 'message' => 'Se ha enviado el correo con éxito.']);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo de verificación: '.$mail->ErrorInfo]);
            }
            
            
            
        }catch(Exception $error){
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo de verificación: '.$mail->ErrorInfo]);
        }
        
    }else{
       echo json_encode(['status' => 'error', 'message' => 'El correo contiene caracteres no permitidos.']); 
    }
    
}catch(PDOException $e){
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}


?>