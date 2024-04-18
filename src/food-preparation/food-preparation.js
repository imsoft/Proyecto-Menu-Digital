document.addEventListener('DOMContentLoaded', function() {
    const preparationData = [
        { state: 'ready', table: 'Mesa 5', dish: 'Paella', folio: 'F1234' },
        { state: 'inPreparation', table: 'Mesa 3', dish: 'Ensalada César', folio: 'F1235' },
        { state: 'waiting', table: 'Mesa 8', dish: 'Pizza Margarita', folio: 'F1236' }
    ];

    preparationData.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.dish} - ${item.table} - Folio: ${item.folio}`;
        document.querySelector(`#${item.state} ul`).appendChild(listItem);
    });
});
