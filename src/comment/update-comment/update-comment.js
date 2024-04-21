document.getElementById("commentForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Detiene el envío del formulario

  var comment = document.getElementById("commentBox").value.trim();
  var rating = document.getElementById("rating").value;

  if (comment === "") {
      alert("Por favor, escribe un comentario antes de enviar.");
  } else if (rating === "") {
      alert("Por favor, selecciona una calificación antes de enviar.");
  } else {
      alert("Comentario y calificación enviados con éxito!");
      windows.location.href = "../read-comment/read-comment.html";
      // Aquí podrías añadir la lógica para enviar el comentario y la calificación a un servidor
      // Por ejemplo:
      // this.submit();
  }
});
