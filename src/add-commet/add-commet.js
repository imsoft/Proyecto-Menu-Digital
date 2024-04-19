document
  .getElementById("commentForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Detiene el envío del formulario

    var comment = document.getElementById("commentBox").value.trim();
    if (comment === "") {
      alert("Por favor, escribe un comentario antes de enviar.");
    } else {
      alert("Comentario enviado con éxito!");
      // Aquí podrías añadir la lógica para enviar el comentario a un servidor
      // Por ejemplo:
      // this.submit();
    }
  });
