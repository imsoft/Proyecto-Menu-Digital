<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de empleados</title>
    <link rel="stylesheet" href="read-employee.css">
    <link rel="shortcut icon" href="../../../public/images/favicon/logo.png" />
</head>

<body>
    <div class="table-container">
        <h2>Datos del Cliente</h2>
        <table id="employeeTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono Celular</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'fetchEmployees.php'; ?>
            </tbody>
        </table>
    </div>
    <script src="read-employee.js"></script>
</body>

</html>