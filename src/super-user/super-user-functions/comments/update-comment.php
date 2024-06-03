<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();
require '../../../db/connection.php';

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    if (!$comment) {
        die('Comentario no encontrado.');
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
    <title>Editar Comentario</title>
    <link rel="stylesheet" href="update-comment.css">
    <link rel="shortcut icon" href="../../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../super-user-menubar/super-user-menubar.css">
    <script src="../../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../../super-user-menubar/super-user-menubar.php'; ?>
    <div class="form-container">
        <h2>Editar Comentario</h2>
        <form id="updateForm" action="updateComment.php" method="POST">
            <!-- Añade un input oculto para el ID del comentario -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($comment['id']); ?>">

            <label for="client_id">ID del Cliente:</label>
            <input type="text" id="client_id" name="client_id" value="<?php echo htmlspecialchars($comment['client_id']); ?>" required>

            <label for="branch_id">ID de la Sucursal:</label>
            <input type="text" id="branch_id" name="branch_id" value="<?php echo htmlspecialchars($comment['branch_id']); ?>" required>

            <label for="rating">Calificación:</label>
            <select id="rating" name="rating" required>
                <option value="">Seleccione...</option>
                <option value="bueno" <?php echo ($comment['rating'] == 'bueno') ? 'selected' : ''; ?>>Bueno</option>
                <option value="regular" <?php echo ($comment['rating'] == 'regular') ? 'selected' : ''; ?>>Regular</option>
                <option value="malo" <?php echo ($comment['rating'] == 'malo') ? 'selected' : ''; ?>>Malo</option>
            </select>

            <label for="comment">Comentario:</label>
            <textarea id="comment" name="comment" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>

            <label for="company_id">ID de la Empresa:</label>
            <input type="text" id="company_id" name="company_id" value="<?php echo htmlspecialchars($comment['company_id']); ?>" required>

            <button type="submit">Editar</button>
        </form>
    </div>
</body>

</html>