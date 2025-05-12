/**
 * Script de cotización de planes
 *
 * Este script maneja la validación y el envío de un formulario para crear un nuevo plan
 * de cotización mediante una solicitud AJAX a la API. Al enviar el formulario, se valida
 * que el precio sea un número válido y mayor a 0. Si la validación es exitosa, se envía
 * el nombre y el precio del plan a la API para ser almacenado. En caso de éxito o error,
 * se muestra una notificación utilizando SweetAlert2.
 *
 * Funcionalidades principales:
 * - Validación del precio: debe ser un número válido y mayor a 0
 * - Envío del formulario a la API mediante POST
 * - Notificación de éxito o error usando SweetAlert2
 *
 * Elementos HTML involucrados:
 * - #formCotizar → formulario para cotizar el plan
 * - #nombre → campo de entrada para el nombre del plan
 * - #precio → campo de entrada para el precio del plan
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */




$(document).ready(function () {
    $('#formCotizar').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('#nombre').val().trim();
        const precio = $('#precio').val().trim();

        // Validar precio
        if (precio === '' || isNaN(precio) || Number(precio) <= 0) {
            Swal.fire('Error', 'El precio es obligatorio, debe ser un número válido y mayor a 0.', 'error');
            return;
        }

        $.ajax({
            url: 'http://localhost/Entrevista/Api-SGA/index.php/crear', // Endpoint para crear un nuevo plan API-SGA
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                nombre: nombre,
                precio: precio

            }),
            success: function (res) {
                
                Swal.fire('Éxito', 'Plan agregado exitosamente.', 'success');
            },
            error: function (xhr) {
                let errorMsg = 'Error inesperado al conectar con el servidor';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    
});

