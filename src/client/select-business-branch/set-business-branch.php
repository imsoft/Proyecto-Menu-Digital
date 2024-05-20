<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessId = isset($_POST['business']) ? intval($_POST['business']) : 0;
    $branchId = isset($_POST['branch']) ? intval($_POST['branch']) : 0;

    if ($businessId > 0 && $branchId > 0) {
        $_SESSION['company_id'] = $businessId;
        $_SESSION['branch_id'] = $branchId;
        header("Location: ../client-menu/client-menu.php");
        exit;
    } else {
        echo "Por favor seleccione un negocio y una sucursal válidos.";
    }
}
