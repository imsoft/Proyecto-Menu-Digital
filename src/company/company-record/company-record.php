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
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <script src="../company-menubar/company-menubar.js"></script>
    <style>
        .required-field {
            color: red;
        }

        .form-note {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <?php include '../company-menubar/company-menubar.php'; ?>
    <div class="container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h1>Historial de Pedidos</h1>

        <form id="filterForm" onsubmit="return validateFilterDates()">
            <label for="startDate">Desde:<span class="required-field">*</span></label>
            <input type="date" id="startDate" name="startDate" placeholder="Seleccione una fecha de inicio" required>
            
            <label for="endDate">Hasta:<span class="required-field">*</span></label>
            <input type="date" id="endDate" name="endDate" placeholder="Seleccione una fecha de fin" required>
            
            <label for="dish">Platillo:</label>
            <select id="dish" name="dish">
                <option value="">-- Selecciona Platillo --</option>
                <?php foreach ($dishes as $dish) : ?>
                    <option value="<?php echo htmlspecialchars($dish); ?>"><?php echo htmlspecialchars($dish); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" onclick="filterOrders()">Filtrar</button>

            <div class="form-note">
                Los campos marcados con <span class="required-field">*</span> son obligatorios.
            </div>
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

            <div id="totalSales">
                <h2>Total de Ventas</h2>
                <p id="totalDay">Total del Día: $0.00</p>
                <p id="totalMonth">Total del Mes: $0.00</p>
                <p id="totalYear">Total del Año: $0.00</p>
            </div>
        </div>
    </div>

    <script src="company-record.js"></script>
    <script>
        function validateFilterDates() {
            const startDateInput = document.getElementById('startDate').value;
            const endDateInput = document.getElementById('endDate').value;

            const startDate = new Date(startDateInput);
            const endDate = new Date(endDateInput);
            const today = new Date();

            // Restricciones de fecha
            if (startDate > today || endDate > today) {
                alert("Las fechas no pueden ser futuras.");
                return false;
            }

            if (startDate.getFullYear() < 1900 || endDate.getFullYear() < 1900) {
                alert("No se aceptan fechas de años muy lejanos en el pasado.");
                return false;
            }

            if (endDate < startDate) {
                alert("La fecha de fin no puede ser anterior a la fecha de inicio.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
