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
            url: 'http://localhost/Entrevista/Api-SGA/index.php/crear', // Ajusta según tu ruta real
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

