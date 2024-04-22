document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const employeeId = this.getAttribute("data-id");
      if (confirm("¿Estás seguro de que quieres eliminar este registro?")) {
        fetch("deleteEmployee.php", {
          method: "POST",
          body: JSON.stringify({ id: employeeId }),
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
              alert("Registro eliminado correctamente.");
            } else {
              alert("Hubo un error al eliminar el registro.");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Error al eliminar el registro.");
          });
      }
    });
  });
});
