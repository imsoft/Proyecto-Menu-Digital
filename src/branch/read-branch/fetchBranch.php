<?php
session_start(); // Asegura que la sesión esté iniciada

require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión

// Consulta SQL que incluye un filtro por company_id
$sql = "SELECT id, branch_name, branch_manager, address, postal_code, cellphone, website FROM branches WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['branch_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['branch_manager']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['postal_code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cellphone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['website']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-branch/update-branch.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No hay sucursales registradas para esta empresa.</td></tr>";
}
$stmt->close();
$conn->close();
