<?php
$servername = "digital_menu";
$username = "user";
$password = "password";
$dbname = "digital_menu_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
