<?php
session_start();
require '../../db/connection.php';

$employeeId = $_SESSION['user_id'] ?? null;
$companyId = $_SESSION['user_company'] ?? null;
$branchId = $_SESSION['user_branch'] ?? null;

if (!$employeeId || !$companyId) {
    echo 'No se encontró la información del empleado o de la empresa.';
    exit;
}
?>

<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Preparación de alimentos</title>
    <link rel='stylesheet' href='food-preparation.css'>
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel='shortcut icon' href='../../../public/images/favicon/logo.png' />
    <link rel='stylesheet' href='../../employee/employee-menubar/employee-menubar.css'>
    <script src='../../employee/employee-menubar/employee-menubar.js'></script>
</head>

<body>
    <?php include '../../employee/employee-menubar/employee-menubar.php'; ?>
    <!-- Flecha de regreso -->
    <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
    <div class='container'>
        <h1>Estado de Preparación de los Alimentos</h1>
        <div id='preparationStatus'></div>
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
                        const sectionElement = document.createElement('section');
                        sectionElement.id = status;

                        const header = document.createElement('h2');
                        header.textContent = sections[status];
                        sectionElement.appendChild(header);

                        statusCategories[status].forEach(order => {
                            const orderElement = document.createElement('div');
                            orderElement.className = 'order';

                            const orderInfo = document.createElement('div');
                            orderInfo.className = 'order-info';

                            const img = document.createElement('img');
                            img.src = order.image;
                            img.alt = order.dish;

                            const orderDetails = document.createElement('div');
                            orderDetails.className = 'order-details';
                            orderDetails.innerHTML = `<p><strong>${order.dish}</strong></p><p>Orden #${order.folio}, Mesa #${order.table_number}</p>`;

                            orderInfo.appendChild(img);
                            orderInfo.appendChild(orderDetails);
                            orderElement.appendChild(orderInfo);

                            if (status !== 'entregada') {
                                const button = document.createElement('button');
                                button.className = 'action-button';
                                button.textContent = `Mover a ${getNextStateText(status)}`;
                                button.onclick = () => updateOrderStatus(order.folio, getNextState(status));
                                orderElement.appendChild(button);
                            }

                            sectionElement.appendChild(orderElement);
                        });

                        container.appendChild(sectionElement);
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

        setInterval(fetchPreparationStatus, 10000);
        fetchPreparationStatus();
    </script>
</body>

</html>