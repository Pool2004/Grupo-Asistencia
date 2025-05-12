/**
 * Script de cambio de contraseña
 *
 * Este script se encarga de manejar el proceso de actualización de contraseña desde el frontend.
 * Al hacer clic en el botón con ID `#changePassword`, captura la contraseña actual y la nueva,
 * y realiza una solicitud AJAX al backend (`changePassword.php`) para procesar el cambio.
 *
 * Funciones principales:
 * - Captura de contraseñas desde inputs del formulario
 * - Envío de datos por método POST usando jQuery AJAX
 * - Manejo de respuestas del servidor con SweetAlert (éxito o error)
 *
 * Elementos HTML utilizados:
 * - #userOldPass → input para la contraseña antigua
 * - #userNewPass → input para la nueva contraseña
 * - #changePassword → botón que dispara el evento
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */



$(document).ready(function() {

    $('#changePassword').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Recoger los datos del formulario
        var contraseñaAntigua = $('#userOldPass').val();
        var contraseñaNueva = $('#userNewPass').val();

        // Obtenemos el correo de la url
        const urlParams = new URLSearchParams(window.location.search);
        const correo = urlParams.get('correo');
        if (!correo) {
            Swal.fire('Error', 'No se ha proporcionado un correo electrónico.', 'error');
            return;
        }
        // Validar campos de contraseña
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/; // Patern Regex para establecer los requerimientos de la contraseña
        if (!passwordRegex.test(contraseñaNueva)) { // Validar la nueva contraseña
            Swal.fire('Error', 'La contraseña debe tener [Una minúscula, Una mayúscula, Min. 8 Carácteres, Min. 1 número]', 'error');
            return;
        }

        // Enviar los datos con AJAX
        $.ajax({
            url: '../src/forgot/changePassword.php', 
            type: 'POST',
            data: {
                oldPassword: contraseñaAntigua,
                newPassword: contraseñaNueva,
                correo: correo
            },
            success: function(response, textStatus, jqXHR) {
                // Procesar la respuesta del servidor (status code, mensaje, etc.)
                if (jqXHR.status === 200) {
                    // Código exitoso
                    Swal.fire({
                        title: 'Éxito',
                        text: 'La contraseña ha sido actualizada exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                } else {
                    // Error al procesar el login
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al cambiar la contraseña, intenta nuevamente',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejo de error en caso de que la solicitud no se haya realizado correctamente
           
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en el servidor: ' + errorThrown,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
            },
            
        });
    });
});
