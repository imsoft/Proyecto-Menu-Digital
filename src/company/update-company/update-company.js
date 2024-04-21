document
  .getElementById("businessForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Detiene el envío del formulario para realizar la validación primero

    // Recuperar los valores de los campos y comprobar si están llenos (incluyendo campos select y file)
    const logo = document.getElementById("logo").value;
    const associatedName = document
      .getElementById("associatedName")
      .value.trim();
    const businessName = document.getElementById("businessName").value.trim();
    const address = document.getElementById("address").value.trim();
    const email = document.getElementById("email").value.trim();
    const cellphone = document.getElementById("cellphone").value.trim();
    const foodType = document.getElementById("foodType").value;
    const hasRFC = document.querySelector('input[name="hasRFC"]:checked');
    const consistentMenu = document.querySelector(
      'input[name="consistentMenu"]:checked'
    );

    // Comprobar campos vacíos
    if (
      !logo ||
      !associatedName ||
      !businessName ||
      !address ||
      !email ||
      !cellphone ||
      !foodType ||
      !hasRFC ||
      !consistentMenu
    ) {
      alert("Por favor completa todos los campos del formulario.");
      return; // Detiene la función si algún campo está vacío
    }

    // Redireccionar si el usuario indica que cuenta con RFC
    if (hasRFC.value === "yes") {
      window.location.href = "../tax-data/tax-data.html";
      return; // Termina la ejecución después de la redirección
    }

    // Aquí se podría añadir más validación o realizar una acción como enviar el formulario.
    alert("Formulario enviado correctamente!");
    window.location.href = "../read-company/read-company.html";
    // this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
  });
