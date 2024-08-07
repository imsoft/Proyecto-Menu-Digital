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
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company/company-menubar/company-menubar.css">
    <script src="../../company/company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company/company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Registro de Producto de Menú</h2>
        <form id="menuItemForm" method="POST" action="createMenu.php" enctype="multipart/form-data">
            <input type="hidden" id="companyId" name="companyId" value="<?php echo htmlspecialchars($_SESSION['company_id']); ?>">

            <label for="productImage">Imagen del Producto:</label>
            <input type="file" id="productImage" name="productImage" accept="image/*" required>
            <div class="form-note">Sube una imagen clara y atractiva del producto.</div>

            <label for="productName">Nombre del Producto:</label>
            <input type="text" id="productName" name="productName" required placeholder="Ingrese el nombre del producto">
            <div class="form-note">Nombre del producto que aparecerá en el menú.</div>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required placeholder="Ingrese una descripción del producto"></textarea>
            <div class="form-note">Proporcione una descripción breve y atractiva del producto.</div>

            <label for="categoryName">Nombre de la Categoría:</label>
            <select id="categoryName" name="categoryName" required>
                <option value="">Seleccione...</option>
                <option value="comida">Comida</option>
                <option value="bebida">Bebida</option>
                <option value="extras">Extras</option>
            </select>
            <div class="form-note">Seleccione la categoría a la que pertenece el producto.</div>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" required step="0.01" min="0" placeholder="0.00">
            <div class="form-note">Ingrese el precio del producto en formato decimal (ej. 9.99).</div>


            <button type="submit">Registrar Producto</button>
        </form>
    </div>
</body>

</html>