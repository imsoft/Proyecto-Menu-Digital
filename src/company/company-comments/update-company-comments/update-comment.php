<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require '../../../db/connection.php';
session_start();

$id = $_GET['id'] ?? ''; // Asegúrate de validar y limpiar este ID antes de usarlo en una consulta

if (!$id) {
    die('ID no proporcionado.');
}

$stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();
if (!$comment) {
    die('Comentario no encontrado.');
}

// Obtener lista de empresas
$companies = $conn->query("SELECT id, business_name FROM companies");

// Obtener lista de sucursales si hay un company_id seleccionado
$branches = [];
if ($comment['company_id']) {
    $branchStmt = $conn->prepare("SELECT id, branch_name FROM branches WHERE company_id = ?");
    $branchStmt->bind_param("i", $comment['company_id']);
    $branchStmt->execute();
    $branchResult = $branchStmt->get_result();
    while ($branch = $branchResult->fetch_assoc()) {
        $branches[] = $branch;
    }
    $branchStmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentario</title>
    <link rel="stylesheet" href="update-comment.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="container">
        <h2>Editar Comentario</h2>
        <form id="commentForm" action="updateComment.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($comment['id']); ?>">

            <label for="company">Negocio:</label>
            <select id="company" name="company" required onchange="updateBranches(this.value)">
                <option value="">-- Selecciona Negocio --</option>
                <?php while ($company = $companies->fetch_assoc()) : ?>
                    <option value="<?php echo $company['id']; ?>" <?php echo ($company['id'] == $comment['company_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($company['business_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="branch">Sucursal:</label>
            <select id="branch" name="branch">
                <option value="">-- Selecciona Sucursal --</option>
                <?php foreach ($branches as $branch) : ?>
                    <option value="<?php echo $branch['id']; ?>" <?php echo ($branch['id'] == $comment['branch_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($branch['branch_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="rating">Valoración:</label>
            <select id="rating" name="rating" required>
                <option value="bueno" <?php echo ($comment['rating'] == 'bueno') ? 'selected' : ''; ?>>Bueno</option>
                <option value="regular" <?php echo ($comment['rating'] == 'regular') ? 'selected' : ''; ?>>Regular</option>
                <option value="malo" <?php echo ($comment['rating'] == 'malo') ? 'selected' : ''; ?>>Malo</option>
            </select>

            <label for="commentBox">Comentario:</label>
            <textarea id="commentBox" name="commentBox" rows="4" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>

            <button type="submit">Actualizar Comentario</button>
        </form>
    </div>
    <script src="update-comment.js"></script>
</body>

</html>