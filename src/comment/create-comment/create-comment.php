<?php
require '../../db/connection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar comentario</title>
    <link rel="stylesheet" href="create-comment.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../client/client-menubar/client-menubar.css">
    <script src="../../client/client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../../client/client-menubar/client-menubar.php'; ?>
    <div class="container">
        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>
        <h2>Deja tu Comentario</h2>
        <form id="commentForm" action="createComment.php" method="POST">
            <div class="form-group">
                <label for="restaurant">Restaurante:</label>
                <select id="restaurant" name="restaurant" required>
                    <option value="">-- Selecciona Restaurante --</option>
                    <!-- Las opciones del restaurante se llenarán desde la base de datos -->
                </select>
            </div>
            <div class="form-group">
                <label for="branch">Sucursal:</label>
                <select id="branch" name="branch">
                    <option value="">-- Selecciona Sucursal --</option>
                    <option value="0">No aplica</option>
                    <!-- Las opciones de sucursal se llenarán dependiendo de la selección del restaurante -->
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Calificación:</label>
                <select id="rating" name="rating" required>
                    <option value="">-- Califica tu experiencia --</option>
                    <option value="bueno">Bueno</option>
                    <option value="regular">Regular</option>
                    <option value="malo">Malo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="commentBox">Comentario:</label>
                <textarea id="commentBox" name="commentBox" placeholder="Escribe tu comentario aquí..." rows="4" required></textarea>
            </div>
            <button type="submit">Enviar Comentario</button>
            <button id="viewComments" type="button">Ver Comentarios</button>
        </form>
    </div>
    <script src="create-comment.js"></script>
</body>

</html>