<?php
session_start();
require '../../db/connection.php';

$sql = "SELECT id, business_name FROM companies";
$result = $conn->query($sql);

$companies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Negocio y Sucursal</title>
    <link rel="stylesheet" href="select-business-branch.css">
    <link rel="stylesheet" href="../../arrow/arrow.css" />
    <link rel="stylesheet" href="../client-menubar/client-menubar.css">
    <script src="../client-menubar/client-menubar.js"></script>
</head>

<body>
    <?php include '../client-menubar/client-menubar.php'; ?>
    <div class="form-container">

        <!-- Flecha de regreso -->
        <a href="javascript:history.back()" class="back-arrow">&#8592;</a>

        <h2>Seleccionar Negocio y Sucursal</h2>
        <form id="businessBranchForm" action="set-business-branch.php" method="POST">
            <div class="form-group">
                <label for="business">Negocio:</label>
                <select id="business" name="business" required>
                    <option value="">Seleccione un negocio...</option>
                    <?php foreach ($companies as $company) { ?>
                        <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['business_name']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branch">Sucursal:</label>
                <select id="branch" name="branch">
                    <option value="">Seleccione un negocio primero...</option>
                </select>
            </div>
            <button type="submit">Seleccionar</button>
        </form>
    </div>

    <script>
        document.getElementById('business').addEventListener('change', function() {
            const businessId = this.value;
            const branchSelect = document.getElementById('branch');
            branchSelect.innerHTML = '<option value="">Cargando sucursales...</option>';
            branchSelect.required = false;

            if (businessId) {
                fetch('get-branches.php?business_id=' + businessId)
                    .then(response => response.json())
                    .then(data => {
                        branchSelect.innerHTML = '<option value="">Seleccione una sucursal...</option>';
                        if (data.length > 0) {
                            data.forEach(branch => {
                                branchSelect.innerHTML += `<option value="${branch.id}">${branch.branch_name}</option>`;
                            });
                            branchSelect.required = true;
                        } else {
                            branchSelect.innerHTML = '<option value="">Este negocio no tiene sucursales</option>';
                        }
                    });
            } else {
                branchSelect.innerHTML = '<option value="">Seleccione un negocio primero...</option>';
            }
        });
    </script>
</body>

</html>