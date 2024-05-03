<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: ../../company-login/company-login.php');
}

$companyId = $_SESSION['company_id']; // Obtener el company_id de la sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Clientes</title>
    <link rel="stylesheet" href="read-company-comments.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Comentarios de Clientes</h2>
        <table id="clientTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Valoración</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchComments.php'; ?>
            </tbody>

        </table>
    </div>
</body>

</html>