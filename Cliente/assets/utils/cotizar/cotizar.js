$(document).ready(function () {
    $('#formCotizar').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('#nombre').val().trim();
        const apellidos = $('#apellidos').val().trim();
        const fechaNacimiento = $('#fechaNacimiento').val();
        const placa = $('#placa').val().toUpperCase().trim();

        // Validar placa
        const placaRegex = /^[A-Z]{3}[0-9]{3}$/;
        if (!placaRegex.test(placa)) {
            Swal.fire('Error', 'La placa debe tener el formato ABC123', 'error');
            return;
        }

        $.ajax({
            url: 'http://localhost/Entrevista/Api-SGA/index.php/cotizar', // Ajusta según tu ruta real
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                nombre: nombre,
                apellidos: apellidos,
                fechaNacimiento: fechaNacimiento,
                placa: placa
            }),
            success: function (res) {
                if (!res.planes || res.planes.length === 0) {
                    Swal.fire('Atención', 'No se recibieron ofertas.', 'warning');
                    return;
                }

                let html = '';
                res.planes.forEach(plan => {
                    html += `
                        <tr>
                            <td>${plan.noCotizacion}</td>
                            <td>${plan.placa}</td>
                            <td>${plan.nombreProducto}</td>
                            <td>${plan.valor}</td>
                        </tr>
                    `;
                });

                $('#bodyOfertas').html(html);
                $('#tablaOfertas').show();
                Swal.fire('Éxito', 'Cotización recibida exitosamente.', 'success');
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

