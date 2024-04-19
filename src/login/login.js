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
      if (username === "a" && password === "a") {
        alert("Bienvenido!");
        window.location.href = "home.html";
      } else {
        alert("Usuario o contraseña incorrectos.");
      }
    }
  });
