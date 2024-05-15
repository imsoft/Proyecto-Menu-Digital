<?php
require '../../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

session_start();
$companyId = $_SESSION['company_id']; // Obtener el company_id de la sesión

// Preparar y ejecutar la consulta SQL para obtener los comentarios
$sql = "SELECT co.id, cl.firstName, cl.email, co.rating, co.comment
        FROM comments co
        JOIN clients cl ON co.client_id = cl.id
        JOIN branches br ON co.branch_id = br.id
        WHERE br.company_id = ? OR co.branch_id IS NULL AND co.company_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param("ii", $companyId, $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
        echo "<td>
                <button class='edit-btn' onclick='editComment(" . $row['id'] . ")'>Editar</button>
                <button class='delete-btn' onclick='deleteComment(" . $row['id'] . ")'>Eliminar</button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay comentarios disponibles.</td></tr>";
}
$conn->close();
