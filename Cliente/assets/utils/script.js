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