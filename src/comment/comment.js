document.addEventListener("DOMContentLoaded", function () {
  const reviewsTableBody = document.querySelector("#reviewsTable tbody");
  const reviews = [
    {
      name: "Ana Gómez",
      email: "ana@example.com",
      rating: "Bueno",
      comment: "Excelente servicio y atención.",
    },
    {
      name: "Juan Pérez",
      email: "juan@example.com",
      rating: "Regular",
      comment: "Buen ambiente pero la comida llegó fría.",
    },
    {
      name: "Sara Molina",
      email: "sara@example.com",
      rating: "Malo",
      comment: "No me gustó el servicio.",
    },
  ];

  reviews.forEach((review) => {
    const row = document.createElement("tr");
    row.innerHTML = `
            <td>${review.name}</td>
            <td>${review.email}</td>
            <td>${review.rating}</td>
            <td>${review.comment}</td>
        `;
    reviewsTableBody.appendChild(row);
  });
});
