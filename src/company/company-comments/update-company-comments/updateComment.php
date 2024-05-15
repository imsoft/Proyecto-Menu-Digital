<?php
require '../../../db/connection.php';
session_start();

// Asegúrate de que el formulario fue enviado y que contiene el ID del comentario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $company_id = $_POST['company'];
    $branch_id = $_POST['branch'] ?? NULL;  // Permite que el campo sucursal sea opcional
    $rating = $_POST['rating'];
    $commentText = $_POST['commentBox'];

    // Preparar la consulta SQL para actualizar el comentario
    $sql = "UPDATE comments SET company_id = ?, branch_id = ?, rating = ?, comment = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("iissi", $company_id, $branch_id, $rating, $commentText, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Verificar si la actualización fue exitosa
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = 'Comentario actualizado con éxito.';
            header("Location: ../read-company-comments/read-company-comments.php");
            exit;
        } else {
            echo "No se realizaron cambios en el comentario.";
        }
    } else {
        echo "Error al actualizar el comentario: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirigir o manejar el error cuando el formulario no es enviado correctamente
    header("Location: error.php"); // Puedes redirigir a una página de error personalizada
    exit;
}

$conn->close();
