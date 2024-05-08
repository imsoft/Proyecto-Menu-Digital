<?php
require '../../db/connection.php';

// Manejo del archivo de imagen
$productImage = $_POST['existingImage']; // Imagen existente

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
        $productImage = $dest_path; // Actualizar la ruta de la imagen solo si se sube una nueva imagen
    } else {
        echo 'Error al mover el archivo subido.';
        exit;
    }
}

// Asumiendo que todos los datos necesarios son recibidos
$id = $_POST['id'];
$productName = $_POST['productName'];
$description = $_POST['description'];
$categoryName = $_POST['categoryName'];
$price = $_POST['price'];

$stmt = $conn->prepare("UPDATE menu_items SET product_name = ?, description = ?, category_name = ?, price = ?, product_image = ? WHERE id = ?");
$stmt->bind_param("sssdsi", $productName, $description, $categoryName, $price, $productImage, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../read-menu/read-menu.php"); // Asegúrate de que la URL es correcta
        exit;
    } else {
        echo "No se realizaron cambios en el producto.";
    }
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

$stmt->close();
$conn->close();
