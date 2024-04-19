document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#companyTable tbody");
    // Simular datos de ejemplo para el nuevo formato
    const data = [
        ["img/logo.png", "Juan Pérez", "Restaurante El Buen Sabor", "1234 Calle Principal", "contacto@elbuensabor.com", "1234567890", "Restaurante", "Sí", "No"]
    ];

    data.forEach((client, index) => {
        const row = document.createElement("tr");
        client.forEach((text, idx) => {
            const cell = document.createElement("td");
            if (idx === 0) { // Asumiendo que el logo es la primera columna
                const img = document.createElement("img");
                img.src = text;
                img.alt = "Logo del Negocio";
                img.style.width = "50px"; // Ajusta el tamaño según necesites
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
        document.querySelector("#companyTable tbody").deleteRow(index);
        alert("Eliminado");
    }
});
