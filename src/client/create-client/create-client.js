document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático del formulario

    // Recuperar los valores de los campos
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const surname = document.getElementById("surname").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const birthdate = document.getElementById("birthdate").value.trim();
    const gender = document.getElementById("gender").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document
      .getElementById("confirmPassword")
      .value.trim();

    // Verificar si algún campo está vacío
    if (
      !firstName ||
      !lastName ||
      !surname ||
      !email ||
      !phone ||
      !birthdate ||
      !gender ||
      !password ||
      !confirmPassword
    ) {
      alert("Todos los campos deben ser completados.");
      return false; // Detener la función aquí si algún campo está vacío
    }

    // Verificar que las contraseñas coincidan
    if (password !== confirmPassword) {
      alert("Las contraseñas no coinciden.");
      return false; // Detener la función aquí si las contraseñas no coinciden
    }

    // Si todo está correcto, enviar el formulario o realizar otras acciones
    alert("Formulario enviado correctamente!");
    window.location.href = "../client-options/client-options.html";
    this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
  });
