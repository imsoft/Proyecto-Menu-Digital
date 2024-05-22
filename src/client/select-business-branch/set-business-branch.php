<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessId = isset($_POST['business']) ? intval($_POST['business']) : 0;
    $branchId = isset($_POST['branch']) ? intval($_POST['branch']) : 0;

    if ($businessId > 0) {
        $_SESSION['company_id'] = $businessId;

        if ($branchId > 0) {
            $_SESSION['branch_id'] = $branchId;
        } else {
            // Si no se selecciona ninguna sucursal, se puede poner un valor por defecto
            $_SESSION['branch_id'] = null;
        }

        header("Location: ../client-menu/client-menu.php");
        exit;
    } else {
        echo "Por favor seleccione un negocio válido.";
    }
}
