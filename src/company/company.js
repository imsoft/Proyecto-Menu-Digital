document
  .getElementById("businessForm")
  .addEventListener("submit", function (event) {
    const hasRFC = document.querySelector('input[name="hasRFC"]:checked');
    const consistentMenu = document.querySelector(
      'input[name="consistentMenu"]:checked'
    );

    if (!hasRFC || !consistentMenu) {
      event.preventDefault();
      alert("Por favor completa todos los campos del formulario.");
    } else {
      // Aquí puedes añadir más validación o procesar el formulario.
      alert("Formulario enviado correctamente!");
    }
  });
