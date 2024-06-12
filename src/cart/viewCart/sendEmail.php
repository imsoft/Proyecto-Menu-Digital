<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ajusta la ruta según la ubicación de PHPMailer
require '../../db/connection.php';
session_start();

if (!isset($_POST['cartId'])) {
    echo "No se ha proporcionado un ID de carrito.";
    exit;
}

$cart_id = $_POST['cartId'];
$user_id = $_SESSION['user_id'];

// Obtener la información del cliente
$sql_client = "SELECT firstName, lastName, email FROM clients WHERE id = ?";
$stmt_client = $conn->prepare($sql_client);
$stmt_client->bind_param("i", $user_id);
$stmt_client->execute();
$result_client = $stmt_client->get_result();
$client = $result_client->fetch_assoc();

$pdf_path = '../../tickets/ticket_' . $cart_id . '.pdf';

$mail = new PHPMailer(true);
try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'mail.menudigital.sbs'; // Servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'tickets@menudigital.sbs'; // Nombre de usuario SMTP
    $mail->Password = 'ticketsmenu123'; // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encriptación SSL/TLS
    $mail->Port = 465; // Puerto SMTP

    // Destinatarios
    $mail->setFrom('tickets@menudigital.sbs', 'Menu Digital'); // Remitente del correo
    $mail->addAddress($client['email'], $client['firstName'] . ' ' . $client['lastName']); // Destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Ticket de Compra';
    $mail->Body = 'Gracias por tu compra. Adjunto encontrarás tu ticket de compra.';
    $mail->AltBody = 'Gracias por tu compra. Adjunto encontrarás tu ticket de compra.';

    // Adjuntar el PDF del ticket
    $mail->addAttachment($pdf_path);

    $mail->send();
    echo 'El ticket de compra ha sido enviado con éxito.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
