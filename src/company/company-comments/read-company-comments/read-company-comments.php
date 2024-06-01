<?php
session_start();
require '../../../db/connection.php';

// Asegúrate de que el ID de la empresa está disponible en la sesión
if (!isset($_SESSION['company_id'])) {
    die("ID de la empresa no proporcionado.");
}

$companyId = $_SESSION['company_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Clientes</title>
    <link rel="stylesheet" href="read-company-comments.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../../company-menubar/company-menubar.css">
    <script src="../../company-menubar/company-menubar.js"></script>
</head>

<body>
    <?php include '../../company-menubar/company-menubar.php'; ?>
    <div class="table-container">
        <h2>Comentarios de Clientes</h2>
        <table id="clientTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Valoración</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchComments.php'; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editComment(id) {
            window.location.href = `../update-company-comments/update-comment.php?id=${id}`;
        }

        function deleteComment(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
                fetch(`deleteComment.php?id=${id}`, {
                        method: 'GET',
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            location.reload();
                        } else {
                            alert('Error al eliminar el comentario.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>

</html>