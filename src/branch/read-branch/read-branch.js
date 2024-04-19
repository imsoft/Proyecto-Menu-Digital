document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("#branchTable tbody");
  // Simular datos de ejemplo
  const data = [
      ["Sucursal Centro", "María López", "1234 Calle Central", "28001", "9876543210", "www.sucursalcentro.com"]
  ];

  data.forEach((branch, index) => {
      const row = document.createElement("tr");
      branch.forEach((text, idx) => {
          const cell = document.createElement("td");
          if (idx === 5) { // Si es el sitio web, hacemos un enlace clickable
              const link = document.createElement("a");
              link.href = text;
              link.textContent = text;
              link.target = "_blank"; // Abre en nueva pestaña
              cell.appendChild(link);
          } else {
              cell.textContent = text;
          }
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
      document.querySelector("#branchTable tbody").deleteRow(index);
      alert("Eliminado");
  }
});
