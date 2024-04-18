document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting

    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
      alert("Las contraseñas no coinciden.");
      return false;
    }

    // Aquí se podría añadir más validación o realizar una acción como enviar el formulario.
    alert("Formulario enviado correctamente!");
    // Para enviar el formulario después de la validación, descomenta la siguiente línea:
    // this.submit();
  });
