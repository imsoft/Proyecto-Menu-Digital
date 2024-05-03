<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar comentario</title>
    <link rel="stylesheet" href="create-comment.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h2>Deja tu Comentario</h2>
        <form id="commentForm" action="createComment.php" method="POST">
            <select id="restaurant" name="restaurant" required>
                <option value="">-- Selecciona Restaurante --</option>
                <!-- Las opciones del restaurante se llenarán desde la base de datos -->
            </select>

            <select id="branch" name="branch" required>
                <option value="">-- Selecciona Sucursal --</option>
                <option value="">No aplica</option>
                <!-- Las opciones de sucursal se llenarán dependiendo de la selección del restaurante -->
            </select>

            <select id="rating" name="rating" required>
                <option value="">-- Califica tu experiencia --</option>
                <option value="bueno">Bueno</option>
                <option value="regular">Regular</option>
                <option value="malo">Malo</option>
            </select>

            <textarea id="commentBox" name="commentBox" placeholder="Escribe tu comentario aquí..." rows="4" required></textarea>
            <button type="submit">Enviar Comentario</button>
            <button id="viewComments">Ver Comentarios</button>
        </form>
    </div>
    <script src="create-comment.js"></script>
</body>

</html>