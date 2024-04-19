document
  .getElementById("branchForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático

    // Recuperar los valores de los campos
    const branchName = document.getElementById("branchName").value.trim();
    const branchManager = document.getElementById("branchManager").value.trim();
    const address = document.getElementById("address").value.trim();
    const postalCode = document.getElementById("postalCode").value.trim();
    const cellphone = document.getElementById("cellphone").value.trim();
    const website = document.getElementById("website").value.trim();

    // Comprobar si algún campo requerido está vacío
    if (
      !branchName ||
      !branchManager ||
      !address ||
      !postalCode ||
      !cellphone
    ) {
      alert("Por favor, completa todos los campos requeridos.");
      return; // Detiene la función si algún campo requerido está vacío
    }

    // Validaciones adicionales para el formato de postalCode y cellphone
    const postalCodePattern = /^[0-9]{5}$/;
    const cellphonePattern = /^[0-9]{10}$/;

    if (!postalCodePattern.test(postalCode)) {
      alert("El código postal debe contener exactamente 5 dígitos.");
      return;
    }

    if (!cellphonePattern.test(cellphone)) {
      alert("El teléfono celular debe contener exactamente 10 dígitos.");
      return;
    }

    // Comprobación opcional para el campo de website
    if (website && !isValidUrl(website)) {
      alert("Por favor, introduce una URL válida para el sitio web.");
      return;
    }

    // Si todo está correcto, enviar el formulario o realizar otras acciones
    alert("Formulario enviado correctamente!");
    // this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
  });

function isValidUrl(string) {
  try {
    new URL(string);
    return true;
  } catch (_) {
    return false;
  }
}
