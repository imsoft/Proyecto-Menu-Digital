document
  .getElementById("menuItemForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático

    // Obtener los valores de los campos
    const productImage = document.getElementById("productImage").files.length; // Verifica si se ha seleccionado un archivo
    const productName = document.getElementById("productName").value.trim();
    const description = document.getElementById("description").value.trim();
    const categoryName = document.getElementById("categoryName").value.trim();
    const price = document.getElementById("price").value.trim();

    // Verificar si todos los campos requeridos están llenos
    if (
      !productImage ||
      !productName ||
      !description ||
      !categoryName ||
      !price
    ) {
      alert("Todos los campos son obligatorios. Asegúrate de completar todos.");
      return false; // Detiene la función si algún campo está vacío
    }

    // Verificar si el precio es un número válido y positivo
    if (isNaN(price) || Number(price) <= 0) {
      alert("Por favor, ingresa un precio válido mayor a 0.");
      return false;
    }

    // Verificaciones adicionales como la validación del archivo de imagen podrían realizarse aquí

    // Si todo está correcto, enviar el formulario o realizar otras acciones
    alert("Formulario enviado correctamente!");
    window.location.href = "../read-menu/read-menu.html";
    // this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
  });
