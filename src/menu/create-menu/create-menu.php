<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if (!isset($_SESSION['company_id'])) {
    // Redirigir al usuario para iniciar sesión si no hay un company_id en la sesión
    header("Location: ../../company/company-login/company-login.html");
    exit;
}

$companyId = $_SESSION['company_id']; // Recupera el company_id de la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="create-menu.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="form-container">
        <h2>Registro de Producto de Menú</h2>
        <form id="menuItemForm" method="POST" action="createMenu.php" enctype="multipart/form-data">
            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($_SESSION['company_id']); ?>">

            <label for="productImage">Imagen del Producto:</label>
            <input type="file" id="productImage" name="productImage" accept="image/*" required>

            <label for="productName">Nombre del Producto:</label>
            <input type="text" id="productName" name="productName" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="categoryName">Nombre de la Categoría:</label>
            <select id="categoryName" name="categoryName" required>
                <option value="">Seleccione...</option>
                <option value="comida">Comida</option>
                <option value="bebida">Bebida</option>
                <option value="extras">Extras</option>
            </select>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" required step="0.01" min="0">

            <button type="submit">Registrar Producto</button>
        </form>
    </div>
</body>

</html>