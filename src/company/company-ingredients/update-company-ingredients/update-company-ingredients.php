<?php
session_start();
require '../../../db/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $companyId = $_SESSION['company_id'];

    $sql = "SELECT name, price FROM ingredients WHERE id = ? AND company_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $companyId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $ingredient = $result->fetch_assoc();
    } else {
        echo "Ingrediente no encontrado.";
        exit;
    }
} else {
    header("Location: ../read-company-ingredients/read-company-ingredients.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ingrediente</title>
    <link rel="stylesheet" href="update-company-ingredients.css">
    <link rel="stylesheet" href="../../company-menubar/company-menubar.css">
    <script src="../../company-menubar/company-menubar.js"></script>
</head>

<body>
<?php include '../../company-menubar/company-menubar.php'; ?>
    <div class="form-container">
        <h2>Editar Ingrediente</h2>
        <form action="UpdateCompanyIngredients.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="name">Nombre del Ingrediente:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($ingredient['name']); ?>" required>

            <label for="price">Precio:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($ingredient['price']); ?>" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>

</html>
