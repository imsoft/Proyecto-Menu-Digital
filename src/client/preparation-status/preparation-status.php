<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatus de preparación</title>
    <link rel="stylesheet" href="preparation-status.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h1>Estado del Pedido</h1>
        <div id="orderStatusContainer"></div>
    </div>

    <script>
        function fetchOrderStatus() {
            fetch('../../branch/food-preparation/getOrdetStatus.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const container = document.getElementById('orderStatusContainer');
                    container.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(order => {
                            let friendly_status, status_class, progress;

                            switch (order.status) {
                                case 'esperando':
                                    friendly_status = 'En espera';
                                    status_class = 'status-waiting';
                                    progress = 25;
                                    break;
                                case 'preparando':
                                    friendly_status = 'Preparando';
                                    status_class = 'status-preparing';
                                    progress = 50;
                                    break;
                                case 'lista':
                                    friendly_status = 'Lista';
                                    status_class = 'status-ready';
                                    progress = 75;
                                    break;
                                case 'entregada':
                                    friendly_status = 'Entregada';
                                    status_class = 'status-delivered';
                                    progress = 100;
                                    break;
                                default:
                                    friendly_status = order.status;
                                    status_class = '';
                                    progress = 0;
                                    break;
                            }

                            container.innerHTML += `
                                <div class='orderDetails ${status_class}'>
                                    <p><strong>Mesa:</strong> ${order.table_number}</p>
                                    <p><strong>Platillo:</strong> ${order.dish}</p>
                                    <p><img src='${order.image}' alt='${order.dish}' style='width:100px;'></p>
                                    <p><strong>Folio:</strong> ${order.folio}</p>
                                    <p><strong>Estado:</strong> ${friendly_status}</p>
                                    <div class='progress-bar'><div class='progress' style='width: ${progress}%;'><div class='progress-dot'></div></div></div>
                                </div>`;
                        });
                    } else {
                        container.innerHTML = '<p>No se encontraron pedidos.</p>';
                    }
                })
                .catch(error => console.error('Error fetching order status:', error));
        }

        // Fetch order status every 10 seconds
        setInterval(fetchOrderStatus, 10000);
        // Initial fetch
        fetchOrderStatus();
    </script>
</body>

</html>
