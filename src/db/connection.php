<?php
$host = 'localhost'; // o la IP del servidor de bases de datos
$dbname = 'digital-menu';
$username = 'digital-menu-user';
$password = 'digital-menu-password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el manejo de errores de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión establecida con éxito";
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos $dbname :" . $e->getMessage());
}
