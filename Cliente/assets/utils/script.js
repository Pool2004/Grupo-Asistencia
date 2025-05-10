//========================== Manejo sidebar
const hamburguesa  = document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");

hamburguesa.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand")
    toggler.classList.toggle("bxs-chevrons-right");
    toggler.classList.toggle("bxs-chevrons-left");
});


//========================== Graficas chart.js
document.addEventListener('DOMContentLoaded', function() {
  new Chart(document.getElementById("bar-chart-horizontal"), {
    type: 'bar', // Cambio de 'horizontalBar' a 'bar'
    data: {
      labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      indexAxis: 'y', // Esta es la clave para hacerlo horizontal en Chart.js v3+
      plugins: {      // Nueva estructura de options en Chart.js v3+
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
});