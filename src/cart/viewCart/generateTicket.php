<?php
require('../../fpdf/fpdf.php'); // Ajusta la ruta según la ubicación de FPDF
require '../../db/connection.php';
session_start();

if (!isset($_POST['cartId'])) {
    echo "No se ha proporcionado un ID de carrito.";
    exit;
}

$cart_id = $_POST['cartId'];
$user_id = $_SESSION['user_id'];

// Obtener los detalles del carrito
$sql = "SELECT mi.product_name, mi.price, ci.quantity, (mi.price * ci.quantity) as total
        FROM cart_items ci
        JOIN menu_items mi ON ci.menu_item_id = mi.id
        WHERE ci.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No se encontraron productos en el carrito.";
    exit;
}

// Obtener la información del cliente
$sql_client = "SELECT firstName, lastName, email FROM clients WHERE id = ?";
$stmt_client = $conn->prepare($sql_client);
$stmt_client->bind_param("i", $user_id);
$stmt_client->execute();
$result_client = $stmt_client->get_result();
$client = $result_client->fetch_assoc();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'Ticket de Compra', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Cliente: ' . $client['firstName'] . ' ' . $client['lastName'], 0, 1);
$pdf->Cell(0, 10, 'Email: ' . $client['email'], 0, 1);
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$total_sum = 0;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(80, 10, $row['product_name'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['price'], 2), 1);
    $pdf->Cell(20, 10, $row['quantity'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['total'], 2), 1);
    $pdf->Ln(10);
    $total_sum += $row['total'];
}

$pdf->Cell(80, 10, '', 0);
$pdf->Cell(30, 10, '', 0);
$pdf->Cell(20, 10, 'Total:', 1);
$pdf->Cell(30, 10, '$' . number_format($total_sum, 2), 1);
$pdf->Output('F', '../../tickets/ticket_' . $cart_id . '.pdf');

echo 'ticket_' . $cart_id . '.pdf';
