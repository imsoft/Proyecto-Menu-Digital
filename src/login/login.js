document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    // Verificar si alguno de los campos está vacío
    if (!username || !password) {
      alert("Por favor, complete todos los campos.");
    } else {
      // Continúa con la validación si ambos campos están llenos
      if (username === "client" && password === "client") {
        window.location.href = "../client/client-options/client-options.html";
      } else if (username === "company" && password === "company") {
        window.location.href = "../company/company-options/company-options.html";
      } else if (username === "employee" && password === "employee") {
        window.location.href = "../employee/employee-options/employee-options.html";
      } else {
        alert("Usuario o contraseña incorrectos.");
      }
    }
  });
