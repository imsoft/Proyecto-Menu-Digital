<?php
session_start();
require '../../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $fileTmpPath = $_FILES['logo']['tmp_name'];
        $fileName = $_FILES['logo']['name'];
        $fileType = $_FILES['logo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $uploadFileDir = '../../../public/images/uploaded_images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $logoPath = $dest_path;
        } else {
            echo 'Error al mover el archivo subido. Verifica los permisos del directorio.';
            exit;
        }
    } else {
        echo 'Error en la carga del archivo. Error Code: ' . $_FILES['logo']['error'];
        exit;
    }

    $associatedName = $_POST['associatedName'];
    $businessName = $_POST['businessName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];
    $foodType = $_POST['foodType'];
    $hasRFC = $_POST['hasRFC'] === 'yes' ? 1 : 0;
    $consistentMenu = $_POST['consistentMenu'] === 'yes' ? 1 : 0;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $userType = 'negocio';  // Asigna el tipo de usuario "negocio" de manera predeterminada

    $sql = "INSERT INTO companies (logo_path, associated_name, business_name, address, email, cellphone, food_type, has_rfc, consistent_menu, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssiiss", $logoPath, $associatedName, $businessName, $address, $email, $cellphone, $foodType, $hasRFC, $consistentMenu, $password, $userType);

        if ($stmt->execute()) {
            header("Location: ../read-company/read-company.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparando la consulta: " . $conn->error;
    }
    $conn->close();
}
