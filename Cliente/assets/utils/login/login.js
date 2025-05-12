/**
 * Script de inicio de sesión
 *
 * Este script gestiona el proceso de autenticación de usuarios.
 * Al hacer clic en el botón con ID `#loginButton`, se recogen los datos del formulario,
 * se valida que no estén vacíos y se realiza una solicitud AJAX al backend (`login.php`)
 * para verificar las credenciales del usuario.
 *
 * Funciones principales:
 * - Captura del email y contraseña desde los inputs
 * - Validación de campos vacíos antes de enviar
 * - Envío de datos vía POST al servidor
 * - Procesamiento de la respuesta con SweetAlert
 * - Redirección al dashboard si el inicio es exitoso
 *
 * Elementos HTML involucrados:
 * - #userEmail → campo del correo electrónico
 * - #password → campo de la contraseña
 * - #loginButton → botón que ejecuta el evento
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */



$(document).ready(function() {
    $('#loginButton').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Recoger los datos del formulario
        var email = $('#userEmail').val();
        var password = $('#password').val();

        // Validar campos vacíos

        if(email === '' || password === '') {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, completa todos los campos.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }



        // Enviar los datos con AJAX
        $.ajax({
            url: './Cliente/src/login/login.php', 
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response, textStatus, jqXHR) {
                // Procesar la respuesta del servidor (status code, mensaje, etc.)
                if (jqXHR.status === 200) {
                    // Código exitoso
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Inicio de sesión exitoso',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a la página principal
                            window.location.href = './Cliente/views/dashboard.php'; 
                        }
                    });
                } else {
                    // Error al procesar el login
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al iniciar sesión',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejo de error en caso de que la solicitud no se haya realizado correctamente
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en el servidor: ' + jqXHR.status + ' - ' + errorThrown,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
            }
        });
    });
});
