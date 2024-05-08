document.addEventListener("DOMContentLoaded", function () {
  var contador = 1;
  var intervalo = setInterval(function () {
    contador--;
    if (contador >= 0) {
      document.getElementById("contador").innerText = contador;
    }
    if (contador === 0) {
      clearInterval(intervalo);
      window.location.href = "../user-options/user-options.html";
    }
  }, 5000);
});
