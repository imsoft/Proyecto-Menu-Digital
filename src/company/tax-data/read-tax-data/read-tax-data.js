document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const taxDataId = this.getAttribute("data-id"); // Cambio de clientId a taxDataId
      if (
        confirm(
          "¿Estás seguro de que quieres eliminar este registro de datos fiscales?"
        )
      ) {
        fetch("deleteTaxData.php", {
          // Cambiado de deleteClient.php a deleteTaxData.php
          method: "POST",
          body: JSON.stringify({ id: taxDataId }),
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
              alert("Datos fiscales eliminados correctamente.");
            } else {
              alert("Hubo un error al eliminar los datos fiscales.");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Error al eliminar los datos fiscales.");
          });
      }
    });
  });
});
