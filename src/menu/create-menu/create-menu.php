<?php
require '../../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la imagen del producto
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $fileTmpPath = $_FILES['productImage']['tmp_name'];
        $fileName = $_FILES['productImage']['name'];
        $fileSize = $_FILES['productImage']['size'];
        $fileType = $_FILES['productImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Directorios para almacenar la imagen
        $uploadFileDir = '../../../public/images/uploaded_images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $productImage = $dest_path;
        } else {
            echo 'Error al mover el archivo subido. Verifica los permisos del directorio.';
            exit;
        }
    } else {
        echo 'Error en la carga del archivo. Error Code: ' . $_FILES['productImage']['error'];
        exit;
    }

    // Otros campos del formulario
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $categoryName = $_POST['categoryName'];
    $price = $_POST['price'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO `menu_items` (`product_image`, `product_name`, `description`, `category_name`, `price`) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssd", $productImage, $productName, $description, $categoryName, $price);

        if ($stmt->execute()) {
            header("Location: ../read-menu/read-menu.php");
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
