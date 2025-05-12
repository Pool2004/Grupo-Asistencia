/**
 * Script de recuperación de contraseña (envío de correo)
 *
 * Este script se activa cuando el usuario hace clic en el botón de recuperación de contraseña.
 * Recoge el correo electrónico ingresado en el formulario, muestra un loader visual,
 * y envía una solicitud AJAX al backend (`sendEmail.php`) para procesar el envío del correo.
 *
 * Funciones principales:
 * - Captura del correo desde el input #userEmail
 * - Visualización de loaders (animación de carga)
 * - Envío de datos vía POST a un endpoint PHP
 * - Manejo de respuestas exitosas o con error usando SweetAlert
 * - Redirección a la página principal si el proceso es exitoso
 *
 * Elementos HTML utilizados:
 * - #userEmail → campo de entrada del correo
 * - #sendButton → botón que dispara el evento
 * - .loader-container y .loader-background → elementos visuales del loader
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */



$(document).ready(function() {

    // Recoger loader
    var loader = $('.loader-container');
    var loaderBack = $('.loader-background');

    // Variable bandera
    var bandera = false;

    $('#sendButton').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        loader.show(); // Mostrar el loader
        loaderBack.show(); // Mostrar el fondo del loader
        bandera = true; // Cambiar la bandera a true

        // Recoger los datos del formulario
        var correo = $('#userEmail').val();

        // Enviar los datos con AJAX
        $.ajax({
            url: '../src/forgot/sendEmail.php', // Ruta a tu archivo PHP
            type: 'POST',
            data: {
                correo: correo
            },
            success: function(response, textStatus, jqXHR) {
                // Procesar la respuesta del servidor (status code, mensaje, etc.)
                if (jqXHR.status === 200) {
                    // Código exitoso
                    Swal.fire({
                        title: 'Éxito',
                        text: 'El correo de recuperación ha sido enviado exitosamente, revisa tu bandeja de entrada',
                        icon: 'info',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a la página principal
                            window.location.href = '../../index.html'; // Cambia esto a la URL de tu página principal
                        }
                    });
                } else {
                    // Error al procesar el login
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al enviar el correo, intenta nuevamente',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejo de error en caso de que la solicitud no se haya realizado correctamente
                // Código exitoso
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en el servidor: ' + errorThrown,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
            },
            complete: function() {
                // Ocultar el loader después de la respuesta
                if (bandera) {
                    loader.hide(); // Ocultar el loader
                    loaderBack.hide(); // Mostrar el fondo del loader
                    bandera = false; // Cambiar la bandera a false
                }
            }
        });
    });
});
