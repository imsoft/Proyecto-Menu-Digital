document.addEventListener("DOMContentLoaded", function () {
  const orderHistoryContainer = document.getElementById("orderHistory");
  const orders = [
    {
      date: "2023-04-14",
      items: [
        { name: "Hamburguesa", price: "5.99" },
        { name: "Papas Fritas", price: "2.50" },
      ],
    },
    {
      date: "2023-04-15",
      items: [
        { name: "Pizza", price: "12.00" },
        { name: "Ensalada", price: "4.00" },
      ],
    },
  ];

  orders.forEach((order) => {
    const dateDiv = document.createElement("div");
    dateDiv.classList.add("order-date");
    dateDiv.textContent = `Fecha: ${order.date}`;
    orderHistoryContainer.appendChild(dateDiv);

    order.items.forEach((item) => {
      const itemDiv = document.createElement("div");
      itemDiv.classList.add("order-item");
      itemDiv.innerHTML = `<span>${item.name}</span><span>$${item.price}</span>`;
      orderHistoryContainer.appendChild(itemDiv);
    });
  });
});
