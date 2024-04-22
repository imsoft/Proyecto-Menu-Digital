document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático del formulario

    // Recuperar los valores de los campos y asegurarse de que están completos
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const surname = document.getElementById("surname").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const birthdate = document.getElementById("birthdate").value;
    const gender = document.getElementById("gender").value;
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document
      .getElementById("confirmPassword")
      .value.trim();

    // Verificar que todos los campos están llenos
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
      alert("Por favor, completa todos los campos del formulario.");
      return false;
    }

    // Verificar que las contraseñas coincidan
    if (password !== confirmPassword) {
      alert("Las contraseñas no coinciden.");
      return false;
    }

    // Validaciones adicionales pueden ser añadidas aquí

    const formData = new FormData(this); // Recoge los datos del formulario
    this.submit(); // Descomenta esta línea para enviar el formulario después de la validación
    
    // Envía los datos del formulario usando fetch a 'updateEmployee.php'
    fetch("updateEmployee.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text()) // o .json() si tu backend responde con JSON
      .then((text) => {
        alert(text); // Muestra la respuesta del servidor
        window.location.href = "../read-employee/read-employee.php"; // Asegúrate de que la URL es correcta
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Error al actualizar el registro.");
      });

    // Si todo está correcto, enviar el formulario o realizar otras acciones
    // alert("Formulario enviado correctamente!");
    // window.location.href = "../read-employee/read-employee.php";
  });
