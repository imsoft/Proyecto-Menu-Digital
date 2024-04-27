document
  .getElementById("fiscalForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático del formulario

    // Obtener los valores de los campos
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const surname = document.getElementById("surname").value.trim();
    const rfc = document.getElementById("rfc").value.trim();
    const socialName = document.getElementById("socialName").value.trim();
    const tradeName = document.getElementById("tradeName").value.trim();
    const address = document.getElementById("address").value.trim();
    const curp = document.getElementById("curp").value.trim();

    // Verificar que todos los campos requeridos están llenos
    if (
      !firstName ||
      !lastName ||
      !surname ||
      !rfc ||
      !socialName ||
      !tradeName ||
      !address ||
      !curp
    ) {
      alert("Todos los campos son obligatorios. Asegúrate de completar todos.");
      return; // Detiene la función si algún campo está vacío
    }

    // Validaciones adicionales para patrones de RFC y CURP
    const rfcPattern = /^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/;
    const curpPattern = /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;

    if (!rfcPattern.test(rfc)) {
      alert("Por favor, introduce un RFC válido.");
      return;
    }

    if (!curpPattern.test(curp)) {
      alert("Por favor, introduce una CURP válida.");
      return;
    }

    // Si todo está correcto, realizar acciones adicionales o enviar el formulario
    alert("Formulario enviado correctamente!");
    window.location.href = "../read-tax-data/read-tax-data.html";
    // this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
  });
