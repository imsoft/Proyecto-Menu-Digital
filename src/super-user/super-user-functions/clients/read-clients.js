document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const clientId = this.getAttribute("data-id");
      if (confirm("¿Estás seguro de que quieres eliminar este cliente?")) {
        fetch("deleteClient.php", {
          method: "POST",
          body: JSON.stringify({ id: clientId }),
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
              alert("Cliente eliminado correctamente.");
            } else {
              alert("Hubo un error al eliminar el cliente.");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Error al eliminar el cliente.");
          });
      }
    });
  });
});
