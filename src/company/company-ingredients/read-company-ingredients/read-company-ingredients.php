<?php
// Obtén el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// Obtén el nombre del host (dominio)
$host = $_SERVER['HTTP_HOST'];

// Obtén la ruta completa del script actual
$path = $_SERVER['REQUEST_URI'];

// Concatena todo para obtener la URL completa
$currentUrl = $protocol . "://" . $host . $path;

session_start();

if ($currentUrl === "https://menudigital.sbs/src/company/company-ingredients/read-company-ingredients/read-company-ingredients.php") {
    require '../../../db/connection.php';
} else {
    require '../../db/connection.php';
}

$companyId = $_SESSION['company_id'];

$sql = "SELECT id, name, price FROM ingredients WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ingredientes</title>
    <link rel="stylesheet" href="read-company-ingredients.css">
    <link rel="stylesheet" href="../../company-menubar/company-menubar.css">
    <script src="../../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company-menubar/company-menubar.php'; ?>
    <div class="container">
        <h2>Ingredientes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td>
                            <a href="../update-company-ingredients/update-company-ingredients.php?id=<?php echo $row['id']; ?>" class="button edit-btn">Editar</a>
                            <a href="delete-company-ingredients.php?id=<?php echo $row['id']; ?>" class="button delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este ingrediente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>