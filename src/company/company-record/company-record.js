function filterOrders() {
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;
  const dish = document.getElementById("dish").value;

  fetch(
    `fetchFilteredOrders.php?startDate=${startDate}&endDate=${endDate}&dish=${encodeURIComponent(
      dish
    )}`
  )
    .then((response) => response.json())
    .then((data) => {
      const orderHistory = document.getElementById("orderHistory");
      orderHistory.innerHTML = "";
      if (data.length > 0) {
        data.forEach((order) => {
          const orderDiv = document.createElement("div");
          orderDiv.className = "order";
          orderDiv.style.backgroundColor = getColorByState(order.state);
          orderDiv.innerHTML = `
                      <img src="${
                        order.product_image
                      }" alt="Imagen del Producto" class="order-image">
                      <p><strong>ID del Pedido:</strong> ${order.id}</p>
                      <p><strong>Producto:</strong> ${order.product_name}</p>
                      <p><strong>Precio:</strong> $${parseFloat(
                        order.price
                      ).toFixed(2)}</p>
                      <p><strong>Sucursal:</strong> ${order.branch_name}</p>
                      <p><strong>Estado:</strong> ${order.state}</p>
                      <p><strong>Fecha de Creación:</strong> ${new Date(
                        order.created_at
                      ).toLocaleString("es-ES")}</p>
                  `;
          orderHistory.appendChild(orderDiv);
        });
      } else {
        orderHistory.innerHTML = "<p>No hay pedidos disponibles.</p>";
      }
    });
}

function getColorByState(state) {
  switch (state) {
    case "esperando":
      return "#f8d7da"; // Rojo claro
    case "preparando":
      return "#fff3cd"; // Amarillo claro
    case "lista":
      return "#d1ecf1"; // Azul claro
    case "entregada":
      return "#d4edda"; // Verde claro
    default:
      return "#ffffff"; // Blanco por defecto
  }
}

function loadStatistics(period) {
  fetch(`fetchStatistics.php?period=${period}`)
    .then((response) => response.json())
    .then((data) => {
      const statisticsResult = document.getElementById("statisticsResult");
      statisticsResult.innerHTML = "";
      let totalSales = 0;
      if (data.length > 0) {
        data.forEach((stat) => {
          totalSales += parseFloat(stat.sales);
          const statDiv = document.createElement("div");
          statDiv.className = "stat";
          statDiv.innerHTML = `
                      <p><strong>Fecha:</strong> ${stat.date}</p>
                      <p><strong>Ventas:</strong> $${parseFloat(
                        stat.sales
                      ).toFixed(2)}</p>
                  `;
          statisticsResult.appendChild(statDiv);
        });
      } else {
        statisticsResult.innerHTML = "<p>No hay datos disponibles.</p>";
      }

      if (period === "day") {
        document.getElementById(
          "totalDay"
        ).innerText = `Total del Día: $${totalSales.toFixed(2)}`;
      } else if (period === "month") {
        document.getElementById(
          "totalMonth"
        ).innerText = `Total del Mes: $${totalSales.toFixed(2)}`;
      } else if (period === "year") {
        document.getElementById(
          "totalYear"
        ).innerText = `Total del Año: $${totalSales.toFixed(2)}`;
      }
    });
}

function loadPopularDishes() {
  fetch(`fetchPopularDishes.php`)
    .then((response) => response.json())
    .then((data) => {
      const statisticsResult = document.getElementById("statisticsResult");
      statisticsResult.innerHTML = "";
      if (data.length > 0) {
        data.forEach((dish) => {
          const dishDiv = document.createElement("div");
          dishDiv.className = "dish";
          dishDiv.innerHTML = `
                      <p><strong>Producto:</strong> ${dish.product_name}</p>
                      <p><strong>Cantidad Vendida:</strong> ${dish.quantity}</p>
                  `;
          statisticsResult.appendChild(dishDiv);
        });
      } else {
        statisticsResult.innerHTML = "<p>No hay datos disponibles.</p>";
      }
    });
}
