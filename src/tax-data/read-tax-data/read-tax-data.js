document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("#clientTable tbody");
  // Simular datos de ejemplo
  const data = [
      ["Juan", "Pérez", "López", "XEXX010101HDFABC01", "Juan Pérez S.A. de C.V.", "Tienda Juan", "1234 Calle Principal, Ciudad", "PELJ890123HDFLRN01"]
  ];

  data.forEach((client, index) => {
      const row = document.createElement("tr");
      client.forEach((text) => {
          const cell = document.createElement("td");
          cell.textContent = text;
          row.appendChild(cell);
      });

      const actionsCell = document.createElement("td");
      const deleteButton = document.createElement("button");
      deleteButton.textContent = "Eliminar";
      deleteButton.className = "delete-btn";
      deleteButton.onclick = function () { deleteRow(index); };
      actionsCell.appendChild(deleteButton);

      const editButton = document.createElement("button");
      editButton.textContent = "Editar";
      editButton.className = "edit-btn";
      editButton.onclick = function () { alert("Editado"); };
      actionsCell.appendChild(editButton);

      row.appendChild(actionsCell);
      tableBody.appendChild(row);
  });

  function deleteRow(index) {
      document.querySelector("#clientTable tbody").deleteRow(index);
      alert("Eliminado");
  }
});
