<?php
require '../../../db/connection.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario
    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $branch_id = $_POST['branch_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $company_id = $_POST['company_id'];

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE comments SET client_id = ?, branch_id = ?, rating = ?, comment = ?, company_id = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los valores como parámetros al statement preparado
        $stmt->bind_param("iisssi", $client_id, $branch_id, $rating, $comment, $company_id, $id);

        // Ejecutar el statement
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: ../read-comments/read-comments.php"); // Redirección desde PHP
                exit;
            } else {
                echo "No se realizaron cambios en el comentario.";
            }
        } else {
            echo "Error al actualizar el comentario: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
