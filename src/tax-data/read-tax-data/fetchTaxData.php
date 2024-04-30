<?php
session_start(); // Asegura que la sesión esté iniciada

require '../../db/connection.php'; // Incluye tu archivo de conexión a la base de datos

if (!isset($_SESSION['company_id'])) {
    echo "No se encontró company_id en la sesión.";
    exit;
}

$companyId = $_SESSION['company_id']; // Obtén el company_id de la sesión

// Consulta SQL que incluye un filtro por company_id
$sql = "SELECT id, firstName, lastName, surname, rfc, socialName, tradeName, address, curp FROM tax_data WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rfc']) . "</td>";
        echo "<td>" . htmlspecialchars($row['socialName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tradeName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['curp']) . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-tax-data/update-tax-data.php?id=' . $row['id'] . '\'">Editar</button><button class="delete-btn" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay datos fiscales registrados.</td></tr>";
}
$conn->close();
