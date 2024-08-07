<?php
require '../../db/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Por favor inicia sesión para ver tu carrito.";
    exit;
}

if (!isset($_SESSION['company_id'])) {
    echo "Por favor selecciona un negocio.";
    exit;
}

$user_id = $_SESSION['user_id'];
$company_id = $_SESSION['company_id'];
$branch_id = isset($_SESSION['branch_id']) ? $_SESSION['branch_id'] : null;

// Obtener el carrito del usuario
$sql = "SELECT c.id FROM carts c WHERE c.client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No tienes ningún carrito activo.";
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
$cart_id = $row['id'];

// Obtener los items del carrito
$sql = "SELECT ci.id AS cart_item_id, mi.product_name, mi.product_image, mi.price, ci.quantity
        FROM cart_items ci
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        WHERE ci.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();

$total_sum = 0; // Variable para almacenar la suma total de los productos en el carrito

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h1>Tu Carrito de Compras</h1>";
    echo "<table>";
    echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th></th></tr>";
    while ($row = $result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $total_sum += $total; // Sumar al total general
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' class='product-image'> " . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>$" . number_format($row['price'], 2) . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>$" . number_format($total, 2) . "</td>";
        echo "<td><button class='remove-btn' onclick='removeFromCart(" . $row['cart_item_id'] . ")'>Eliminar</button></td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan='3' class='total-label'><strong>Total:</strong></td>";
    echo "<td>$" . number_format($total_sum, 2) . "</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";
    echo "<button id='finishOrderButton' class='finish-order-btn'>Terminar Pedido</button>";
    echo "</div>";
} else {
    echo "<div class='container'>Tu carrito está vacío.</div>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carrito</title>
    <link rel="stylesheet" href="viewCart.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="stylesheet" href="../../client/client-menubar/client-menubar.css">
    <script src="../../client/client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../../client/client-menubar/client-menubar.php'; ?>
    <!-- Flecha de regreso -->
    <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
    <!-- Modal de confirmación de pedido -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirmar Pedido</h2>
            <p>Revisa los detalles de tu pedido y confirma para finalizar.</p>
            <div id="orderDetails"></div>
            <button id="confirmOrderButton" class="confirm-order-btn">Confirmar Pedido</button>
            <button id="cancelOrderButton" class="cancel-order-btn">Cancelar</button>
        </div>
    </div>

    <script>
        document.getElementById('finishOrderButton').addEventListener('click', function() {
            const companyId = <?php echo $company_id; ?>;
            const branchId = <?php echo $branch_id ?? 'null'; ?>;
            const cartId = <?php echo $cart_id; ?>;

            // Mostrar el modal con los detalles del pedido
            const modal = document.getElementById('orderModal');
            const orderDetails = document.getElementById('orderDetails');
            modal.style.display = 'block';

            // Obtener los detalles del carrito y mostrarlos en el modal
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                orderDetails.innerHTML = this.responseText;
            };
            xhttp.open("POST", "fetchOrderDetails.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`cartId=${cartId}`);

            // Confirmar el pedido
            document.getElementById('confirmOrderButton').addEventListener('click', function() {
                const companyId = <?php echo $company_id; ?>;
                const branchId = <?php echo $branch_id ?? 'null'; ?>;
                const cartId = <?php echo $cart_id; ?>;

                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    if (this.responseText.trim() === 'success') {
                        alert('Pedido realizado con éxito');

                        // Generar el ticket
                        const ticketRequest = new XMLHttpRequest();
                        ticketRequest.onload = function() {
                            const ticketPath = this.responseText.trim();

                            // Enviar el ticket por correo
                            const emailRequest = new XMLHttpRequest();
                            emailRequest.onload = function() {
                                alert('El ticket de compra ha sido enviado a tu correo.');
                                window.location.href = '../../client/preparation-status/preparation-status.php'; // Redireccionar a una página de confirmación
                            };
                            emailRequest.open("POST", "sendEmail.php");
                            emailRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            emailRequest.send(`cartId=${cartId}`);
                        };
                        ticketRequest.open("POST", "generateTicket.php");
                        ticketRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ticketRequest.send(`cartId=${cartId}`);
                    } else {
                        alert('Error al realizar el pedido: ' + this.responseText);
                    }
                };
                xhttp.open("POST", "../processOrder/processOrder.php");
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(`cartId=${cartId}&companyId=${companyId}&branchId=${branchId}`);
            });



            // Cancelar el pedido
            document.getElementById('cancelOrderButton').addEventListener('click', function() {
                modal.style.display = 'none';
            });
        });

        function removeFromCart(cartItemId) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText.trim() === 'success') {
                    alert('Producto eliminado del carrito');
                    window.location.reload(); // Recargar la página para actualizar la lista del carrito
                } else {
                    alert('Error al eliminar el producto: ' + this.responseText);
                }
            };
            xhttp.open("POST", "../removeFromCart/removeFromCart.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("cartItemId=" + cartItemId);
        }

        // Cerrar el modal cuando se hace clic fuera del contenido del modal
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>