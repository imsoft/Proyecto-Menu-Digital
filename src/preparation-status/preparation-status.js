document.addEventListener('DOMContentLoaded', function() {
    // Simulación de datos del pedido, en un caso real estos datos vendrían de una base de datos
    const orderData = {
        tableNumber: '12',
        dishName: 'Paella Valenciana',
        folioNumber: 'F1023',
        orderStatus: 'En Preparación' // Los posibles estados son "Listo para Servir", "En Preparación", "En Espera de Preparación"
    };

    // Actualizar el DOM con los datos del pedido
    document.getElementById('tableNumber').textContent = orderData.tableNumber;
    document.getElementById('dishName').textContent = orderData.dishName;
    document.getElementById('folioNumber').textContent = orderData.folioNumber;
    document.getElementById('orderStatus').textContent = orderData.orderStatus;

    // Aquí podrías añadir lógica para actualizar automáticamente los estados, por ejemplo, consultando a un servidor cada cierto tiempo
});
