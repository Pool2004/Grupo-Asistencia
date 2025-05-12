/**
 * Script de gestión de planes de seguros
 *
 * Este script maneja la visualización, eliminación y actualización de planes de seguros
 * desde el frontend utilizando llamadas AJAX hacia la API intermedia (SGA).
 * Al cargar la página, obtiene los planes disponibles. También permite eliminar
 * y actualizar registros mediante interacción directa con botones en la tabla.
 *
 * Funcionalidades principales:
 * - Consulta de planes mediante GET a /planes
 * - Renderizado dinámico de los resultados en una tabla
 * - Eliminación de un plan mediante DELETE a /eliminar con confirmación
 * - Actualización de un plan mediante PUT a /actualizar usando modal Bootstrap
 *
 * Elementos HTML involucrados:
 * - #bodyOfertas → cuerpo de la tabla donde se insertan los planes
 * - .bx-edit-alt → ícono para actualizar un plan (muestra modal)
 * - .bx-trash-alt → ícono para eliminar un plan
 * - #modalActualizarPlan → modal Bootstrap para editar
 * - #formActualizarPlan → formulario dentro del modal
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 * - Bootstrap (modal)
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */



$(document).ready(function () {

    $.ajax({
        url: "http://localhost/Entrevista/Api-SGA/index.php/planes", // Endpoint para obtener los planes en la API-SGA
        type: "GET",
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
            
            let errorMsg = xhr.responseJSON || "No hay planes registrados";
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMsg = xhr.responseJSON.error;
            }
            Swal.fire("Error", errorMsg, "error");
        },
    });


    $(document).on("click", ".bx-trash-alt", function (e) {
    
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

