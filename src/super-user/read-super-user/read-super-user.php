<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Superusuarios</title>
    <link rel="stylesheet" href="read-super-user.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../super-user-menubar/super-user-menubar.css">
    <script src="../super-user-menubar/super-user-menubar.js"></script>
</head>

<body>
    <?php include '../super-user-menubar/super-user-menubar.php'; ?>
    <div class="table-container">
        <h2>Datos de los Superusuarios</h2>
        <table id="superuserTable">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchSuperusers.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-super-user.js"></script>
</body>

</html>