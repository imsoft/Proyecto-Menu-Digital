document.getElementById('tableButton').addEventListener('click', function() {
    alert('Información de la Mesa');
});

document.getElementById('menuButton').addEventListener('click', function() {
    window.location.href = 'menu.html'; // Suponiendo que tienes una página específica para el menú
});

document.getElementById('statusButton').addEventListener('click', function() {
    alert('Estatus de tu pedido');
});

document.getElementById('commentsButton').addEventListener('click', function() {
    window.location.href = 'comments.html'; // Suponiendo una página para comentarios
});
