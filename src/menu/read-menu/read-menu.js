document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("#productTable tbody");
  // Simular datos de ejemplo
  const data = [
    [
      "img/product1.png",
      "Producto A",
      "Descripción del Producto A",
      "Categoría A",
      "$10.00",
    ],
  ];

  data.forEach((product, index) => {
    const row = document.createElement("tr");
    product.forEach((text, idx) => {
      const cell = document.createElement("td");
      if (idx === 0) {
        // Asumimos que la imagen es la primera columna
        const img = document.createElement("img");
        img.src = text;
        img.alt = "Imagen del Producto";
        img.style.width = "100px"; // Ajusta el tamaño según necesites
        cell.appendChild(img);
      } else {
        cell.textContent = text;
      }
      row.appendChild(cell);
    });

    const actionsCell = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Eliminar";
    deleteButton.className = "delete-btn";
    deleteButton.onclick = function () {
      deleteRow(index);
    };
    actionsCell.appendChild(deleteButton);

    const editButton = document.createElement("button");
    editButton.textContent = "Editar";
    editButton.className = "edit-btn";
    editButton.onclick = function () {
      alert("Editado");
    };
    actionsCell.appendChild(editButton);

    row.appendChild(actionsCell);
    tableBody.appendChild(row);
  });

  function deleteRow(index) {
    document.querySelector("#productTable tbody").deleteRow(index);
    alert("Eliminado");
  }
});
