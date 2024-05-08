<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Por favor inicia sesión para ver tu carrito.";
    exit;
}

$user_id = $_SESSION['user_id'];

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
    echo "<h1>Tu Carrito de Compras</h1>";
    echo "<table>";
    echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $total_sum += $total; // Sumar al total general
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' style='width:50px;'> " . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>$" . number_format($row['price'], 2) . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>$" . number_format($total, 2) . "</td>";
        echo "<td><button onclick='removeFromCart(" . $row['cart_item_id'] . ")'>Eliminar</button></td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td colspan='3' style='text-align:right;'><strong>Total:</strong></td>";
    echo "<td>$" . number_format($total_sum, 2) . "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "Tu carrito está vacío.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carrito</title>
    <link rel="stylesheet" href="viewCart.css">
</head>

<body>
    <!-- El contenido HTML se puede agregar aquí, el PHP anterior generará el contenido dinámico del carrito -->

    <!-- Selector de Empresa -->
    <select id="companySelect" onchange="updateBranches()">
        <option value="">Selecciona una empresa</option>
        <!-- Las opciones se llenarán dinámicamente con PHP -->
        <?php
        require '../../db/connection.php';
        $sql = "SELECT id, business_name FROM companies";
        $result = $conn->query($sql);
        if ($result === false) {
            die("Error en la consulta: " . $conn->error);
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['business_name']) . "</option>";
            }
        } else {
            echo "<option>No se encontraron empresas</option>";
        }

        ?>
    </select>

    <!-- Selector de Sucursales -->
    <select id="branchSelect">
        <option value="">Primero selecciona una empresa</option>
    </select>

    <button id='finishOrderButton'>Terminar Pedido</button>

    <script>
        document.getElementById('finishOrderButton').addEventListener('click', function() {
            const companyId = document.getElementById('companySelect').value;
            const branchId = document.getElementById('branchSelect').value;
            const cartId = <?php echo $cart_id; ?>; // Asegúrate de que esta variable esté correctamente definida

            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText.trim() === 'success') {
                    alert('Pedido realizado con éxito');
                    window.location.href = '../../client/preparation-status/preparation-status.php'; // Redireccionar a una página de confirmación
                } else {
                    alert('Error al realizar el pedido: ' + this.responseText);
                }
            };
            xhttp.open("POST", "../processOrder/processOrder.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`cartId=${cartId}&companyId=${companyId}&branchId=${branchId}`);
        });

        function updateBranches() {
            var companyId = document.getElementById('companySelect').value;
            var branchSelect = document.getElementById('branchSelect');

            // Limpia las opciones anteriores
            branchSelect.innerHTML = '';

            // Si no se selecciona una empresa, no hace nada más
            if (!companyId) {
                branchSelect.innerHTML = '<option value="">Primero selecciona una empresa</option>';
                return;
            }

            // Crear una solicitud AJAX para obtener las sucursales
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Parsear la respuesta y llenar el desplegable de sucursales
                    const branches = JSON.parse(this.responseText);
                    branches.forEach(function(branch) {
                        var option = document.createElement('option');
                        option.value = branch.id;
                        option.textContent = branch.branch_name;
                        branchSelect.appendChild(option);
                    });
                }
            };
            xhttp.open("GET", "getBranches.php?company_id=" + companyId, true);
            xhttp.send();
        }


        function removeFromCart(cartItemId) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText.trim() === 'success') {
                    alert('Producto eliminado del carrito');
                    window.location.reload(); // Recargar la página para actualizar la lista del carrito
                } else {
                    alert('Error al eliminar el producto');
                }
            };
            xhttp.open("POST", "../removeFromCart/removeFromCart.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("cartItemId=" + cartItemId);
        }
    </script>
</body>

</html>