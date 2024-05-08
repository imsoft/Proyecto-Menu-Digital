<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menuItem = $result->fetch_assoc();
    if (!$menuItem) {
        die('Producto no encontrado.');
    }
} else {
    die('ID no proporcionado.');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="update-menu.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Editar Producto del Menú</h2>
        <form id="menuItemForm" action="updateMenu.php" method="POST" enctype="multipart/form-data">
            <!-- Añade un input oculto para el ID del producto -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($menuItem['id']); ?>">
            <input type="hidden" name="existingImage" value="<?php echo htmlspecialchars($menuItem['product_image']); ?>">

            <label for="productImage">Imagen del Producto:</label>
            <input type="file" id="productImage" name="productImage" accept="image/*">
            <img src="<?php echo htmlspecialchars($menuItem['product_image']); ?>" alt="Current Image" style="width:100px;">

            <label for="productName">Nombre del Producto:</label>
            <input type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($menuItem['product_name']); ?>" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($menuItem['description']); ?></textarea>

            <label for="categoryName">Categoría:</label>
            <select id="categoryName" name="categoryName" required>
                <option value="">Seleccione...</option>
                <option value="comida" <?php echo ($menuItem['category_name'] == 'comida') ? 'selected' : ''; ?>>Comida</option>
                <option value="bebida" <?php echo ($menuItem['category_name'] == 'bebida') ? 'selected' : ''; ?>>Bebida</option>
                <option value="extras" <?php echo ($menuItem['category_name'] == 'extras') ? 'selected' : ''; ?>>Extras</option>
            </select>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($menuItem['price']); ?>" required step="0.01" min="0">

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>