<?php
session_start();
require '../../db/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$folio = isset($_GET['folio']) ? intval($_GET['folio']) : 0;

if ($folio <= 0) {
    echo json_encode(['success' => false, 'message' => 'Folio inválido']);
    exit;
}

$sql = "SELECT o.id AS folio, o.created_at, mi.product_name AS dish, mi.price, c.table_number, cl.email
        FROM orders o
        JOIN cart_items ci ON o.cart_id = ci.cart_id
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        JOIN clients c ON o.client_id = c.id
        JOIN clients cl ON o.client_id = cl.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $folio);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
    exit;
}

$order = $result->fetch_assoc();
$stmt->close();

// Crear el contenido del correo electrónico
$body = "<h1>Ticket del Pedido</h1>
         <p><strong>Folio:</strong> {$order['folio']}</p>
         <p><strong>Fecha:</strong> {$order['created_at']}</p>
         <p><strong>Mesa:</strong> {$order['table_number']}</p>
         <p><strong>Platillo:</strong> {$order['dish']}</p>
         <p><strong>Precio:</strong> \${$order['price']}</p>";

// Configurar y enviar el correo electrónico
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.menudigital.sbs'; // Servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'tickets@menudigital.sbs'; // Nombre de usuario SMTP
    $mail->Password = 'ticketsmenu123'; // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encriptación SSL/TLS
    $mail->Port = 465; // Puerto SMTP

    $mail->setFrom('tickets@menudigital.sbs', 'Menu Digital'); // Remitente del correo
    $mail->addAddress($order['email']);

    $mail->isHTML(true);
    $mail->Subject = 'Ticket de tu Pedido';
    $mail->Body    = $body;

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Ticket enviado con éxito']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Error al enviar el ticket: {$mail->ErrorInfo}"]);
}

$conn->close();
