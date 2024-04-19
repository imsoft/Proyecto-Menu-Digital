const dishes = [
    { type: 'food', name: 'Hamburguesa', price: '10.00', description: 'Deliciosa hamburguesa con queso y bacon', img: 'hamburguesa.jpg' },
    { type: 'drink', name: 'Coca Cola', price: '2.50', description: 'Refresco de cola 355ml', img: 'cocacola.jpg' },
    { type: 'extras', name: 'Papas Fritas', price: '3.00', description: 'Papas fritas crujientes', img: 'papas.jpg' }
];

function filterMenu(type) {
    const menuItems = document.getElementById('menuItems');
    menuItems.innerHTML = ''; // Clear previous items
    dishes.filter(dish => dish.type === type).forEach(dish => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('menu-item');
        itemDiv.innerHTML = `
            <img src="${dish.img}" alt="${dish.name}">
            <h3>${dish.name}</h3>
            <p>${dish.description}</p>
            <p>Precio: $${dish.price}</p>
        `;
        menuItems.appendChild(itemDiv);
    });
}

// Initialize menu with food items
filterMenu('food');
