$(document).ready(function () {
    console.log("Document ready");
    $.ajax({
        url: "../src/planes/consultarPlanes.php", // Ajusta según tu ruta real
        type: "POST",
        contentType: "application/json",
        success: function (res) {
            if (!res.planes || res.planes.length === 0) {
                Swal.fire("Atención", "No hay planes registrados.", "warning");
                return;
            }

            let html = "";
            res.planes.forEach((plan) => {
                html += `
            <tr data-id="${plan.id}">
                <td>${plan.nombre}</td>
                <td>${parseInt(plan.precio).toFixed(0)}</td>
                <td><i class='bx bx-edit-alt'></i><i class='bx bx-trash-alt' ></i></td>
            </tr>
                    `;
            });

            $("#bodyOfertas").html(html);
            $("#tablaOfertas").show();
        },
        error: function (xhr) {
            console.log(xhr);
            let errorMsg = xhr.responseJSON || "No hay planes registrados";
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMsg = xhr.responseJSON.error;
            }
            Swal.fire("Error", errorMsg, "error");
        },
    });


    $(document).on("click", ".bx-trash-alt", function (e) {
        console.log("click");
        e.preventDefault();
        const id = $(this).closest("tr").data("id");
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir esto.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "http://localhost/Entrevista/Api-SGA/index.php/eliminar", // Ajusta según tu ruta real
                    type: "DELETE",
                    contentType: "application/json",
                    data: JSON.stringify({ id }),

                    success: function (res) {

                        if (typeof res === 'string') {
                            res = JSON.parse(res);
                        }

                        if (res.status == 200) {
                            Swal.fire("Eliminado!", res.message, "success").then(() => location.reload());
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },

                    error: function (xhr) {
                        let errorMsg = "Error inesperado al conectar con el servidor";
                        console.log(xhr);
                        try {
                            const res = JSON.parse(xhr.responseText);
                            if (res.status === 'error' && res.message) {
                                errorMsg = res.message;
                            }
                        } catch (e) {
                            // Por si no es JSON, no hacer nada y usar mensaje genérico
                        }

                        Swal.fire("Error", errorMsg, "error");
                    }
                });
            }
        });
    });


    $(document).on("click", ".bx-edit-alt", function (e) {


        const id = $(this).closest("tr").data("id");

        $('#modalActualizarPlan').modal('show');

        $('#formActualizarPlan').on('submit', function (e) {
            e.preventDefault();

            const nombre = $('#nombrePlan').val().trim();
            const precio = $('#precioPlan').val().trim();

            if (nombre.length < 5) {
                Swal.fire("Error", "El nombre debe tener mínimo 5 caracteres.", "error");
                return;
            }

            if (isNaN(precio) || Number(precio) <= 0) {
                Swal.fire("Error", "El precio debe ser mayor a 0.", "error");
                return;
            }

            // Aquí va tu llamada AJAX
            $.ajax({
                url: 'http://localhost/Entrevista/Api-SGA/index.php/actualizar', // Ajusta según tu ruta real
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({ id: id, nombre: nombre, precio: precio }),
                success: function (res) {
                    if (typeof res === 'string') res = JSON.parse(res);
                    if (res.status == 200) {
                        Swal.fire("Actualizado", res.message, "success").then(() => location.reload());
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                },
                error: function (xhr) {
                    let msg = "Error inesperado";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        msg = res.message || msg;
                    } catch { }
                    Swal.fire("Error", msg, "error");
                }
            });
        });
    });
});

