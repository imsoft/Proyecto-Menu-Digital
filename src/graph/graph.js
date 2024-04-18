document.addEventListener("DOMContentLoaded", function () {
  const topDishesData = {
    labels: ["Hamburguesa", "Pizza", "Tacos"],
    datasets: [
      {
        label: "Platillos Más Vendidos",
        data: [50, 35, 15],
        backgroundColor: ["red", "blue", "green"],
        hoverOffset: 4,
      },
    ],
  };

  const leastDishesData = {
    labels: ["Ensalada", "Sopa", "Jugo"],
    datasets: [
      {
        label: "Platillos Menos Vendidos",
        data: [5, 3, 2],
        backgroundColor: ["purple", "orange", "yellow"],
        hoverOffset: 4,
      },
    ],
  };

  const options = {
    responsive: true,
    maintainAspectRatio: false, // Esto permite controlar el tamaño mediante CSS
    plugins: {
      legend: {
        position: "top",
      },
      tooltip: {
        callbacks: {
          label: function (tooltipItem) {
            const sum = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
            const value = tooltipItem.raw;
            const percentage = ((value / sum) * 100).toFixed(2); // Redondeo a dos decimales
            return `${tooltipItem.label}: ${percentage}%`;
          },
        },
      },
    },
  };

  new Chart(document.getElementById("topDishesChart"), {
    type: "pie",
    data: topDishesData,
    options: options,
  });

  new Chart(document.getElementById("leastDishesChart"), {
    type: "pie",
    data: leastDishesData,
    options: options,
  });
});
