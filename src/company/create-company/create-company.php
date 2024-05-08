<?php
require '../../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la imagen del producto
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $fileTmpPath = $_FILES['logo']['tmp_name'];
        $fileName = $_FILES['logo']['name'];
        $fileSize = $_FILES['logo']['size'];
        $fileType = $_FILES['logo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Directorios para almacenar la imagen
        $uploadFileDir = '../../../public/images/uploaded_images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        // Verificar si el directorio existe y tiene permisos de escritura
        if (!is_dir($uploadFileDir) || !is_writable($uploadFileDir)) {
            echo 'El directorio de destino no existe o no tiene permisos de escritura. Verifica la ruta y los permisos del directorio.';
            exit;
        }

        // Intentar mover el archivo al directorio de destino
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

    // Procesar el resto de la información del formulario
    $associatedName = $_POST['associatedName'];
    $businessName = $_POST['businessName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $cellphone = $_POST['cellphone'];
    $foodType = $_POST['foodType'];
    $hasRFC = $_POST['hasRFC'] === 'yes' ? 1 : 0;
    $consistentMenu = $_POST['consistentMenu'] === 'yes' ? 1 : 0;
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validar que las contraseñas coinciden
    if ($password !== $confirmPassword) {
        die("Las contraseñas no coinciden.");
    }

    // Validar la contraseña
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/';
    if (!preg_match($passwordRegex, $password)) {
        die("La contraseña debe tener entre 12 y 16 caracteres, e incluir letras mayúsculas, minúsculas, números y caracteres especiales.");
    }

    // Encriptar la contraseña antes de almacenarla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $sql = "INSERT INTO companies (logo_path, associated_name, business_name, address, email, cellphone, food_type, has_rfc, consistent_menu, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $userType = 'negocio';  // Asigna el tipo de usuario "negocio" de manera predeterminada
        $stmt->bind_param("sssssssiiss", $logoPath, $associatedName, $businessName, $address, $email, $cellphone, $foodType, $hasRFC, $consistentMenu, $hashedPassword, $userType);
        if ($stmt->execute()) {
            header("Location: ../company-options/company-options.html");
            exit;
        } else {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        error_log("Error preparando la consulta: " . $conn->error);
        echo "Error preparando la consulta: " . $conn->error;
    }

    $conn->close();
}
