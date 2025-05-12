/**
 * Script de registro de usuario
 *
 * Este script maneja la validación de los datos de un formulario de registro de usuario,
 * asegurando que todos los campos sean completados correctamente antes de enviar la información
 * a un servidor mediante una solicitud AJAX. El proceso incluye validación de contraseña, correo,
 * teléfono y campos vacíos. En caso de éxito o error, se muestra una notificación al usuario
 * utilizando SweetAlert2.
 *
 * Funcionalidades principales:
 * - Validación de contraseña (mínimo 8 caracteres, una mayúscula, una minúscula, y un número)
 * - Verificación de campos vacíos
 * - Validación del formato del correo electrónico
 * - Validación del formato del teléfono (opcional, mínimo 10 dígitos)
 * - Envío de los datos al servidor mediante AJAX
 * - Notificación de éxito o error usando SweetAlert2
 * 
 * Elementos HTML involucrados:
 * - #registerButton → botón para enviar el formulario de registro
 * - #userName → campo de entrada para el nombre
 * - #userLastName → campo de entrada para los apellidos
 * - #userPhone → campo de entrada para el teléfono
 * - #userEmail → campo de entrada para el correo electrónico
 * - #userPass → campo de entrada para la contraseña
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */




$(document).ready(function() {
    $('#registerButton').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Recoger los datos del formulario
        var nombres = $('#userName').val();
        var apellidos = $('#userLastName').val();
        var telefono = $('#userPhone').val();
        var correo = $('#userEmail').val();
        var contrasena = $('#userPass').val();

        // Validar contraseña

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordRegex.test(contrasena)) {
            Swal.fire('Error', 'La contraseña debe tener [Una minúscula, Una mayúscula, Min. 8 Carácteres, Min. 1 número]', 'error');
            return;
        }

        // Validar campos vacíos

        if(nombres === '' || apellidos === '' || telefono === '' || correo === '' || contrasena === '') {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, completa todos los campos.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        // Validar formato de correo electrónico

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, ingresa un correo electrónico válido.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        // Validar formato de teléfono (opcional)

        const phoneRegex = /^\d{10}$/; // Cambia la expresión regular según el formato que necesites
        if (!phoneRegex.test(telefono)) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, ingresa un número de teléfono válido. [Min. 10 dígitos]',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

    
        // Enviar los datos con AJAX
        $.ajax({
            url: '../src/register/register.php', // Ruta a tu archivo PHP
            type: 'POST',
            data: {
                nombres: nombres,
                apellidos: apellidos,
                telefono: telefono,
                correo: correo,
                contrasena: contrasena
            },
            success: function(response, textStatus, jqXHR) {
                // Procesar la respuesta del servidor (status code, mensaje, etc.)
                if (jqXHR.status === 200) {
                    // Código exitoso
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Usuario registrado exitosamente',
                        icon: 'success'
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
                        text: 'Hubo un error al iniciar sesión',
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
            }
        });
    });
});
