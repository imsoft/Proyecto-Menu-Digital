<?php
session_start();
require '../../db/connection.php';

// Obtener la lista de negocios
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
</head>

<body>
    <div class="form-container">
        <h2>Seleccionar Negocio y Sucursal</h2>
        <form id="businessBranchForm" action="set-business-branch.php" method="POST">
            <label for="business">Negocio:</label>
            <select id="business" name="business" required>
                <option value="">Seleccione un negocio...</option>
                <?php foreach ($companies as $company) { ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['business_name']); ?></option>
                <?php } ?>
            </select>

            <label for="branch">Sucursal:</label>
            <select id="branch" name="branch" required>
                <option value="">Seleccione un negocio primero...</option>
            </select>

            <button type="submit">Seleccionar</button>
        </form>
    </div>

    <script>
        document.getElementById('business').addEventListener('change', function() {
            const businessId = this.value;
            const branchSelect = document.getElementById('branch');
            branchSelect.innerHTML = '<option value="">Cargando sucursales...</option>';

            if (businessId) {
                fetch('get-branches.php?business_id=' + businessId)
                    .then(response => response.json())
                    .then(data => {
                        branchSelect.innerHTML = '<option value="">Seleccione una sucursal...</option>';
                        data.forEach(branch => {
                            branchSelect.innerHTML += `<option value="${branch.id}">${branch.branch_name}</option>`;
                        });
                    });
            } else {
                branchSelect.innerHTML = '<option value="">Seleccione un negocio primero...</option>';
            }
        });
    </script>
</body>

</html>