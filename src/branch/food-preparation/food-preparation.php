<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparación de alimentos</title>
    <link rel="stylesheet" href="food-preparation.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Estado de Preparación de los Alimentos</h1>
        <div id="preparationStatus"></div>
    </div>

    <script>
        function fetchPreparationStatus() {
            fetch('../../client/preparation-status/getOrderStatusForEmployee.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('preparationStatus');
                    container.innerHTML = '';

                    const statusCategories = {
                        esperando: [],
                        preparando: [],
                        lista: [],
                        entregada: []
                    };

                    data.forEach(order => {
                        statusCategories[order.status].push(order);
                    });

                    const sections = {
                        esperando: 'En espera',
                        preparando: 'Preparando',
                        lista: 'Listos para Servir',
                        entregada: 'Entregadas'
                    };

                    for (const status in sections) {
                        container.innerHTML += `<section id="${status}">
                            <h2>${sections[status]}</h2>
                            <ul>${statusCategories[status].map(order => `
                                <li>
                                    <img src="${order.image}" alt="${order.dish}" style="width:50px;">
                                    ${order.dish} (Orden #${order.folio}, Mesa #${order.table_number})
                                    ${status !== 'entregada' ? `<button onclick="updateOrderStatus(${order.folio}, '${getNextState(status)}')">Mover a ${getNextStateText(status)}</button>` : ''}
                                </li>`).join('')}
                            </ul>
                        </section>`;
                    }
                })
                .catch(error => console.error('Error fetching preparation status:', error));
        }

        function getNextState(currentState) {
            switch (currentState) {
                case 'esperando':
                    return 'preparando';
                case 'preparando':
                    return 'lista';
                case 'lista':
                    return 'entregada';
                default:
                    return '';
            }
        }

        function getNextStateText(currentState) {
            switch (currentState) {
                case 'esperando':
                    return 'Preparación';
                case 'preparando':
                    return 'Listo para Servir';
                case 'lista':
                    return 'Entregado';
                default:
                    return '';
            }
        }

        function updateOrderStatus(folio, newState) {
            fetch('updateOrderStatus.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `orderId=${folio}&newState=${newState}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    fetchPreparationStatus();
                })
                .catch(error => console.error('Error updating order status:', error));
        }

        // Fetch preparation status every 10 seconds
        setInterval(fetchPreparationStatus, 10000);
        // Initial fetch
        fetchPreparationStatus();
    </script>
</body>

</html>