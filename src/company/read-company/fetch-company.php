<?php
session_start();
require '../../db/connection.php';

if (!isset($_SESSION['company_id'])) {
    // Si no hay sesión con company_id, redirigir al login
    header("Location: ../../company/company-login/company-login.html");
    exit;
}

$companyId = $_SESSION['company_id'];

$sql = "SELECT id, logo_path, associated_name, business_name, address, email, cellphone, food_type, has_rfc, consistent_menu FROM companies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row['logo_path']) . "' alt='Logo' style='width:50px;'></td>";
        echo "<td>" . htmlspecialchars($row['associated_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['business_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cellphone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['food_type']) . "</td>";
        echo "<td>" . ($row['has_rfc'] ? 'Sí' : 'No') . "</td>";
        echo "<td>" . ($row['consistent_menu'] ? 'Sí' : 'No') . "</td>";
        echo '<td><button class="edit-btn" onclick="location.href=\'../update-company/update-company.php?id=' . $row['id'] . '\'">Editar</button>';
        echo '<button class="delete-btn" data-id=' . $row['id'] . '">Eliminar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No se encontraron datos de la empresa.</td></tr>";
}

$stmt->close();
$conn->close();
