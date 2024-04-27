<?php
require '../../db/connection.php';

// Manejo del archivo de imagen
if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
    // Procesar la carga del archivo
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
        echo 'Error al mover el archivo subido.';
        exit;
    }
} else {
    // Mantener la imagen actual si no se sube una nueva
    $uploadFileDir = '../../../public/images/uploaded_images/';
    $productImage = $uploadFileDir . $_POST['productImage'];
}

// Asumiendo que todos los datos necesarios son recibidos
$id = $_POST['id'];
$productName = $_POST['productName'];
$description = $_POST['description'];
$categoryName = $_POST['categoryName'];
$price = $_POST['price'];

$stmt = $conn->prepare("UPDATE menu_items SET product_name = ?, description = ?, category_name = ?, price = ?, product_image = ? WHERE id = ?");
$stmt->bind_param("sssdss", $productName, $description, $categoryName, $price, $productImage, $id);

error_log("Recibidos: " . print_r($_POST, true));
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../read-menu/read-menu.php"); // Asegúrate de que la URL es correcta
        exit;
    } else {
        echo $uploadFileDir;
        echo $newFileName;
        echo $dest_path;
        echo "No se realizaron cambios en el producto.";
    }
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

$stmt->close();
$conn->close();
