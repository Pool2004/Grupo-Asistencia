/**
 * Script de manejo de sidebar y carga dinámica de contenido
 *
 * Este script gestiona las interacciones con un sidebar, permitiendo su expansión
 * o colapso mediante un botón. Además, permite la carga dinámica de contenido
 * dentro de un área principal de la página al hacer clic en los enlaces del sidebar.
 * También incluye la integración de una gráfica utilizando la librería Chart.js,
 * mostrando datos sobre la población mundial proyectada para el año 2050.
 *
 * Funcionalidades principales:
 * - Expansión y colapso del sidebar al hacer clic en el botón correspondiente
 * - Carga dinámica de vistas mediante AJAX al hacer clic en los enlaces del sidebar
 * - Renderizado de contenido HTML en la sección principal
 * - Manejo de errores de carga con notificación mediante SweetAlert2
 * - Creación y visualización de una gráfica horizontal con Chart.js
 *
 * Elementos HTML involucrados:
 * - .toggle-btn → botón para expandir o colapsar el sidebar
 * - #sidebar → contenedor del sidebar que se expande o colapsa
 * - #icon → icono dentro del botón que cambia al hacer clic
 * - .sidebar-link → enlaces del sidebar que cargan contenido dinámico
 * - main.content → área principal donde se renderiza el contenido cargado
 * - #bar-chart-horizontal → elemento de la gráfica de Chart.js
 *
 * Librerías utilizadas:
 * - jQuery
 * - SweetAlert2
 * - Chart.js
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
 */





$(document).ready(function () {

    // ========================== Manejo sidebar
    $(".toggle-btn").on("click", function () {
        $("#sidebar").toggleClass("expand");
        $("#icon").toggleClass("bxs-chevrons-right bxs-chevrons-left");
    });

    // ========================== Carga dinámica de contenido
    $(".sidebar-link[data-page]").on("click", function (e) {
        e.preventDefault();

        const page = $(this).data("page");

        // Cerrar menú colapsado si aplica (Bootstrap)
        const parentCollapse = $(this).closest(".collapse.show");
        if (parentCollapse.length) {
            parentCollapse.collapse('hide');
        }

        // Cargar el contenido dinámicamente
        $.get(`../views/${page}.html`)
            .done(function (html) {
                $("main.content").html(html);
            })
            .fail(function () {
                Swal.fire('Error', 'No se pudo cargar la vista.', 'error');
            });
    });

    // ========================== Gráfica con Chart.js
    const ctx = document.getElementById("bar-chart-horizontal");
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: [2478, 5267, 734, 784, 433]
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Predicted world population (millions) in 2050'
                    }
                }
            }
        });
    }

});