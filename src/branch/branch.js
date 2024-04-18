document.getElementById('branchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene el envío automático

    // Aquí puedes añadir validaciones más específicas si lo necesitas

    alert('Formulario enviado correctamente!');
    // Para enviar el formulario después de la validación, descomenta la siguiente línea:
    // this.submit();
});
