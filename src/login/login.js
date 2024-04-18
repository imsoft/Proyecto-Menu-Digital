document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Aquí puedes añadir la validación o la lógica para enviar los datos
    if (username === "a" && password === "a") {
      alert("Bienvenido!");
      window.location.href = 'home.html';
    } else {
      alert("Usuario o contraseña incorrectos.");
    }
  });
