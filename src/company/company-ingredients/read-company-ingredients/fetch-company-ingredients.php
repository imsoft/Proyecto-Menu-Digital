<?php
session_start();
require '../../../db/connection.php';

if (!isset($_SESSION['company_id'])) {
    // Si no hay sesión con company_id, redirigir al login
    header("Location: ../../company/company-login/company-login.html");
    exit;
}

$companyId = $_SESSION['company_id'];

$sql = "SELECT id, name, price FROM ingredients WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $companyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        echo "<td>";
        echo "<a href='../update-company-ingredients/update-company-ingredients.php?id=" . $row['id'] . "' class='button edit-btn'>Editar</a>";
        echo "<a href='delete-company-ingredients.php?id=" . $row['id'] . "' class='button delete-btn' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este ingrediente?\");'>Eliminar</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No se encontraron ingredientes.</td></tr>";
}

$stmt->close();
$conn->close();
