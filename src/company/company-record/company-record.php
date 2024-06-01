<?php
session_start();
require '../../db/connection.php';  // Asegúrate que la ruta de conexión es correcta

$companyId = $_SESSION['company_id'];  // Tomamos el ID de la compañía desde la sesión

// Obtener todos los platillos
$sqlDishes = "SELECT DISTINCT mi.product_name FROM menu_items mi
              JOIN cart_items ci ON mi.id = ci.menu_item_id
              JOIN orders o ON ci.cart_id = o.cart_id
              WHERE o.company_id = ?";
$stmtDishes = $conn->prepare($sqlDishes);
$stmtDishes->bind_param("i", $companyId);
$stmtDishes->execute();
$resultDishes = $stmtDishes->get_result();
$dishes = [];
if ($resultDishes->num_rows > 0) {
    while ($row = $resultDishes->fetch_assoc()) {
        $dishes[] = $row['product_name'];
    }
}
$stmtDishes->close();

// Función para obtener el color según el estado
function getColorByState($state)
{
    switch ($state) {
        case 'esperando':
            return '#f8d7da'; // Rojo claro
        case 'preparando':
            return '#fff3cd'; // Amarillo claro
        case 'lista':
            return '#d1ecf1'; // Azul claro
        case 'entregada':
            return '#d4edda'; // Verde claro
        default:
            return '#ffffff'; // Blanco por defecto
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link rel="stylesheet" href="company-record.css">
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <script src="../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>
    <div class="container">
        <h1>Historial de Pedidos</h1>

        <form id="filterForm">
            <label for="startDate">Desde:</label>
            <input type="date" id="startDate" name="startDate">

            <label for="endDate">Hasta:</label>
            <input type="date" id="endDate" name="endDate">

            <label for="dish">Platillo:</label>
            <select id="dish" name="dish">
                <option value="">-- Selecciona Platillo --</option>
                <?php foreach ($dishes as $dish) : ?>
                    <option value="<?php echo htmlspecialchars($dish); ?>"><?php echo htmlspecialchars($dish); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="button" onclick="filterOrders()">Filtrar</button>
        </form>

        <div id="orderHistory">
            <!-- Los pedidos se cargarán aquí -->
        </div>

        <div id="statistics">
            <h2>Estadísticas</h2>
            <button type="button" onclick="loadStatistics('day')">Ventas por Día</button>
            <button type="button" onclick="loadStatistics('month')">Ventas por Mes</button>
            <button type="button" onclick="loadStatistics('year')">Ventas por Año</button>
            <button type="button" onclick="loadPopularDishes()">Platillos más Consumidos</button>

            <div id="statisticsResult">
                <!-- Las estadísticas se cargarán aquí -->
            </div>
        </div>
    </div>

    <script src="company-record.js"></script>
</body>

</html>