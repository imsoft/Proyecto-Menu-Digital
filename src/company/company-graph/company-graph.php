<?php
session_start();
require '../../db/connection.php';
$companyId = $_SESSION['company_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficas</title>
    <link rel="stylesheet" href="company-graph.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="company-graph.js" defer></script>
    <link rel="shortcut icon" href="../../public/images/favicon/logo.png" />
    <link rel="stylesheet" href="../company-menubar/company-menubar.css">
    <script src="../company-menubar/company-menubar.js"></script>
</head>

<body>
<?php include '../company-menubar/company-menubar.php'; ?>
    <div class="container">
        <h1>Graficas de Negocio</h1>
        <div>
            <div class="canvas-container">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="canvas-container">
                <canvas id="ratingsChart"></canvas>
            </div>
        </div>
    </div>
</body>

</html>