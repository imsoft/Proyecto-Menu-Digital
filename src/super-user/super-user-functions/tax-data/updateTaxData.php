<?php
require '../../../db/connection.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $surname = $_POST['surname'];
    $rfc = $_POST['rfc'];
    $socialName = $_POST['socialName'];
    $tradeName = $_POST['tradeName'];
    $address = $_POST['address'];
    $curp = $_POST['curp'];
    $company_id = $_POST['company_id'];

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE tax_data SET firstName = ?, lastName = ?, surname = ?, rfc = ?, socialName = ?, tradeName = ?, address = ?, curp = ?, company_id = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("ssssssssis", $firstName, $lastName, $surname, $rfc, $socialName, $tradeName, $address, $curp, $company_id, $id);

        // Ejecutar el statement
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../read-tax-data/read-tax-data.php"); // Redirección desde PHP
                exit;
            } else {
                echo "No se realizaron cambios en la información fiscal.";
            }
        } else {
            echo "Error al actualizar la información fiscal: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
