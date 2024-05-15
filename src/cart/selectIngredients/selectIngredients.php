<?php
session_start();
require '../../db/connection.php';

if (!isset($_GET['menuItemId']) || !isset($_SESSION['company_id'])) {
    die('ID del menú o ID de la empresa no proporcionado.');
}

$menuItemId = intval($_GET['menuItemId']);
$companyId = intval($_SESSION['company_id']);

// Obtener la información del platillo seleccionado
$sql = "SELECT product_name, product_image, description, price FROM menu_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $menuItemId);
$stmt->execute();
$result = $stmt->get_result();
$menuItem = $result->fetch_assoc();

if (!$menuItem) {
    die('Platillo no encontrado.');
}

// Obtener los ingredientes del negocio
$sql = "SELECT name, price FROM ingredients WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

$ingredients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ingredients[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Ingredientes</title>
    <link rel="stylesheet" href="selectIngredients.css">
    <script>
        function updateTotal() {
            const checkboxes = document.querySelectorAll('input[name="ingredients[]"]:checked');
            let total = parseFloat(document.getElementById('basePrice').value);

            checkboxes.forEach((checkbox) => {
                total += parseFloat(checkbox.dataset.price);
            });

            document.getElementById('totalPrice').textContent = 'Total: $' + total.toFixed(2);
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Seleccionar Ingredientes</h1>
        <div class="menu-item">
            <img src="<?php echo htmlspecialchars($menuItem['product_image']); ?>" alt="Imagen del Producto">
            <h3><?php echo htmlspecialchars($menuItem['product_name']); ?></h3>
            <p><?php echo htmlspecialchars($menuItem['description']); ?></p>
            <p>Precio Base: $<?php echo number_format($menuItem['price'], 2); ?></p>
        </div>
        <form id="ingredientsForm" action="../addToCart/addToCart.php" method="POST">
            <input type="hidden" name="menuItemId" value="<?php echo htmlspecialchars($menuItemId); ?>">
            <input type="hidden" id="basePrice" value="<?php echo htmlspecialchars($menuItem['price']); ?>">
            <?php if (!empty($ingredients)) : ?>
                <?php foreach ($ingredients as $ingredient) : ?>
                    <div class="ingredient">
                        <label>
                            <input type="checkbox" name="ingredients[]" value="<?php echo htmlspecialchars($ingredient['name']); ?>" data-price="<?php echo htmlspecialchars($ingredient['price']); ?>" onclick="updateTotal()">
                            <?php echo htmlspecialchars($ingredient['name']); ?> - $<?php echo number_format($ingredient['price'], 2); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay ingredientes disponibles.</p>
            <?php endif; ?>
            <p id="totalPrice">Total: $<?php echo number_format($menuItem['price'], 2); ?></p>
            <button type="submit">Añadir al Carrito</button>
        </form>
    </div>
</body>

</html>