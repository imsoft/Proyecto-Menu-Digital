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
</head>

<body>
    <div class="form-container">
        <h2>Agregar Ingrediente</h2>
        <form action="CreateCompanyIngredients.php" method="POST">
            <label for="name">Nombre del Ingrediente:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Precio:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <button type="submit">Agregar</button>
        </form>
    </div>
</body>

</html>