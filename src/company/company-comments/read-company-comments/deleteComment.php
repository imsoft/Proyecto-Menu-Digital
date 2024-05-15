<?php
require '../../../db/connection.php'; // Incluye el archivo de conexión a la base de datos

if (isset($_GET['id'])) {
    $commentId = $_GET['id'];

    // Preparar y ejecutar la consulta SQL para eliminar el comentario
    $sql = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param("i", $commentId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
