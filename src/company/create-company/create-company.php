<?php
session_start();
require '../../db/connection.php'; // Asegúrate de que la ruta es correcta.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el logo del negocio
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $fileTmpPath = $_FILES['logo']['tmp_name'];
        $fileName = $_FILES['logo']['name'];
        $fileType = $_FILES['logo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Directorios para almacenar el logo
        $uploadFileDir = '../../../public/images/uploaded_images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $logoPath = $dest_path; // Esta es la ruta que se guardará en la base de datos
        } else {
            echo 'Error al mover el archivo subido. Verifica los permisos del directorio.';
            exit;
        }
    } else {
        echo 'Error en la carga del archivo. Error Code: ' . $_FILES['logo']['error'];
        exit;
    }

    // Capturar otros campos del formulario
    $associatedName = $_POST['associatedName'];
    $businessName = $_POST['businessName'];
    $address = $_POST['address'];
    $email = $_POST['email']; // Captura del correo electrónico
    $cellphone = $_POST['cellphone'];
    $foodType = $_POST['foodType'];
    $hasRFC = $_POST['hasRFC'] === 'yes' ? 1 : 0;
    $consistentMenu = $_POST['consistentMenu'] === 'yes' ? 1 : 0;
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO companies (logo_path, associated_name, business_name, address, email, cellphone, food_type, has_rfc, consistent_menu, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssiis", $logoPath, $associatedName, $businessName, $address, $email, $cellphone, $foodType, $hasRFC, $consistentMenu, $password);

        if ($stmt->execute()) {
            header("Location: ../read-company/read-company.php"); // Asumiendo que existe esta redirección
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
?>
