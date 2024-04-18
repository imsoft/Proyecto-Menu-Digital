document.getElementById('fiscalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío automático del formulario

    // Realizar validaciones adicionales aquí si es necesario

    alert('Formulario enviado correctamente!');
    // Para enviar el formulario después de la validación, descomenta la siguiente línea:
    // this.submit();
});
