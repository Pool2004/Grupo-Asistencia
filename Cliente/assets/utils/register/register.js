$(document).ready(function() {
    $('#registerButton').click(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Recoger los datos del formulario
        var nombres = $('#userName').val();
        var apellidos = $('#userLastName').val();
        var telefono = $('#userPhone').val();
        var correo = $('#userEmail').val();
        var contrasena = $('#userPass').val();

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
