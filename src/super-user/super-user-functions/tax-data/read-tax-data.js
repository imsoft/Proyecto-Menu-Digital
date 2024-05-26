document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const taxDataId = this.getAttribute("data-id");
      if (
        confirm(
          "¿Estás seguro de que quieres eliminar esta información fiscal?"
        )
      ) {
        fetch("deleteTaxData.php", {
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
              alert("Información fiscal eliminada correctamente.");
            } else {
              alert("Hubo un error al eliminar la información fiscal.");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Error al eliminar la información fiscal.");
          });
      }
    });
  });
});
