<?php
session_start();
require '../../../db/connection.php';

$companyId = $_SESSION['company_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Ingrediente</title>
    <link rel="stylesheet" href="create-company-ingredients.css">
    <link rel="stylesheet" href="../../../arrow/arrow.css" />
    <link rel="stylesheet" href="../../company-menubar/company-menubar.css">
    <script src="../../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Agregar Ingrediente</h2>
        <form action="CreateCompanyIngredients.php" method="POST">
            <label for="name">Nombre del Ingrediente:</label>
            <input type="text" id="name" name="name" required placeholder="Ingrese el nombre del ingrediente">
            <div class="form-note">Proporcione el nombre completo del ingrediente.</div>

            <label for="price">Precio:</label>
            <input type="number" step="0.01" id="price" name="price" required placeholder="Ingrese el precio del ingrediente">
            <div class="form-note">Ingrese el precio del ingrediente en formato decimal.</div>

            <button type="submit">Agregar</button>
        </form>
    </div>
</body>

</html>
