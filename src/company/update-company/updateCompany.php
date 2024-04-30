<?php
session_start();
require '../../db/connection.php';

$companyId = $_POST['companyId'];  // Asegúrate de que este campo está en tu formulario como un campo oculto

// Manejo del archivo de imagen (Logo del negocio)
if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
    $fileTmpPath = $_FILES['logo']['tmp_name'];
    $fileName = $_FILES['logo']['name'];
    $fileSize = $_FILES['productImage']['size'];
    $fileType = $_FILES['productImage']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Directorios para almacenar la imagen
    $uploadFileDir = '../../../public/images/uploaded_images/';
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $dest_path = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $logoPath = $dest_path;
    } else {
        echo 'Error al mover el archivo subido.';
        exit;
    }
} else {
    // Mantener el logo actual si no se sube una nueva imagen
    $logoPath = $_POST['currentLogoPath'];  // Asegúrate de incluir un campo oculto en el formulario con la ruta actual del logo si no se sube uno nuevo
}

// Asumiendo que todos los datos necesarios son recibidos
$associatedName = $_POST['associatedName'];
$businessName = $_POST['businessName'];
$address = $_POST['address'];
$email = $_POST['email'];
$cellphone = $_POST['cellphone'];
$foodType = $_POST['foodType'];
$hasRFC = ($_POST['hasRFC'] === 'yes') ? 1 : 0;
$consistentMenu = ($_POST['consistentMenu'] === 'yes') ? 1 : 0;

$stmt = $conn->prepare("UPDATE companies SET logo_path = ?, associated_name = ?, business_name = ?, address = ?, email = ?, cellphone = ?, food_type = ?, has_rfc = ?, consistent_menu = ? WHERE id = ?");
$stmt->bind_param("sssssisiis", $logoPath, $associatedName, $businessName, $address, $email, $cellphone, $foodType, $hasRFC, $consistentMenu, $companyId);

if ($stmt->execute()) {
    header("Location: ../read-company/read-company.php");  // Asegúrate de que la URL es correcta
    exit;
} else {
    echo "Error al actualizar la información de la empresa: " . $stmt->error;
}

$stmt->close();
$conn->close();
