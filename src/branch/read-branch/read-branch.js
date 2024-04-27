document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach((button) => {
      button.addEventListener("click", function () {
        const branchId = this.getAttribute("data-id");
        if (confirm("¿Estás seguro de que quieres eliminar esta sucursal?")) {
          fetch("deleteBranch.php", {  // Cambiado de deleteClient.php a deleteBranch.php
            method: "POST",
            body: JSON.stringify({ id: branchId }),
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Network response was not ok");
              }
              return response.json();
            })
            .then((data) => {
              if (data.success) {
                this.closest("tr").remove(); // Elimina la fila de la tabla
                alert("Sucursal eliminada correctamente.");
              } else {
                alert("Hubo un error al eliminar la sucursal.");
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("Error al eliminar la sucursal.");
            });
        }
      });
    });
  });
  