$(document).ready(function() {

    $('#changePassword').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Recoger los datos del formulario
        var contraseñaAntigua = $('#userOldPass').val();
        var contraseñaNueva = $('#userNewPass').val();

        // Enviar los datos con AJAX
        $.ajax({
            url: '../src/forgot/changePassword.php', // Ruta a tu archivo PHP
            type: 'POST',
            data: {
                oldPassword: contraseñaAntigua,
                newPassword: contraseñaNueva
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
                    })
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
