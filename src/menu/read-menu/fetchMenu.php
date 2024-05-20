<?php
session_start(); // Asegura que la sesión esté iniciada

require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión

$sql = "SELECT id, product_image, product_name, description, category_name, price FROM menu_items WHERE company_id = ? ORDER BY category_name, product_name";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

$menuItems = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuItems[$row['category_name']][] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<?php foreach ($menuItems as $category => $items) { ?>
    <tr>
        <td colspan="6" class="category-header"><?php echo htmlspecialchars($category); ?></td>
    </tr>
    <?php foreach ($items as $item) { ?>
        <tr>
            <td><img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Imagen del Producto" style="width:100px; height:auto;"></td>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td><?php echo htmlspecialchars($item['description']); ?></td>
            <td><?php echo htmlspecialchars($item['category_name']); ?></td>
            <td><?php echo htmlspecialchars($item['price']); ?></td>
            <td>
                <button class="edit-btn" onclick="location.href='../update-menu/update-menu.php?id=<?php echo $item['id']; ?>'">Editar</button>
                <button class="delete-btn" data-id="<?php echo $item['id']; ?>">Eliminar</button>
            </td>
        </tr>
    <?php } ?>
<?php } ?>