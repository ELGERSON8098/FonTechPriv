<?php
session_start(); // Asegúrate de iniciar la sesión

require_once('../../libraries/fpdf185/fpdf.php');
require_once('../../models/data/pedido_data.php');

class PDF extends FPDF
{
    // Página de encabezado
    function Header()
    {
        $this->Rect(5, 5, $this->GetPageWidth() - 10, $this->GetPageHeight() - 10);
        $this->SetFont('Times', 'B', 20); // Usa una fuente integrada
        $this->Cell(0, 10, utf8_decode('Factura Electrónica'), 0, 1, 'C');
        $this->Ln(10);
        $logoWidth = 80;
        $pageWidth = $this->GetPageWidth();
        $xCenter = ($pageWidth - $logoWidth) / 2;
        $this->Image('C:/xampp/htdocs/FonTechPriv/resources/img/image 67.png', $xCenter, 25, $logoWidth);
        $this->Ln(30); // Reducido el espacio entre el logo y la información de la empresa
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8); // Usa una fuente integrada
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla con encabezado y datos
    function InvoiceTable($header, $data)
    {
        $w = array(50, 25, 25, 40, 30); // Ajuste de anchos de columna: DESCRIPCION, CANTIDAD, PRECIO, DESCUENTO, TOTAL
        $totalWidth = array_sum($w);
        $x = ($this->GetPageWidth() - $totalWidth) / 2;

        $this->SetXY($x, $this->GetY());
        $this->SetFillColor(200, 220, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 128, 128);
        $this->SetLineWidth(.3);
        $this->SetFont('Times', 'B', 12); // Usa una fuente integrada
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 10, utf8_decode($col), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFont('Times', '', 10); // Usa una fuente integrada
        $fill = false;
        foreach ($data as $row) {
            $nombre_producto = utf8_decode($row['nombre_producto']);
            $cantidad = $row['cantidad'];
            $precio_unitario = $row['precio_unitario'];
            $valor_oferta = $row['valor_oferta'];

            $subtotal = $cantidad * $precio_unitario;
            $descuento = ($valor_oferta > 0) ? $subtotal * ($valor_oferta / 100) : 0;
            $total = $subtotal - $descuento;

            $currentY = $this->GetY();
            $this->SetXY($x, $currentY);
            $this->Cell($w[0], 10, $nombre_producto, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 10, $cantidad, 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 10, '$' . number_format($precio_unitario, 2, '.', ','), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 10, $valor_oferta > 0 ? '$' . number_format($descuento, 2, '.', ',') : '-', 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 10, '$' . number_format($total, 2, '.', ','), 'LR', 0, 'R', $fill);
            $this->Ln();

            $fill = !$fill;
        }
        $this->SetX($x);
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Crear objeto PDF
$pdf = new PDF();
$pdf->AddPage();

// Conectar a tu base de datos
$pedido = new PedidoData();

if (isset($_SESSION['idUsuario'])) {
    $dataPedido = $pedido->readHistorials('%%');

    if ($dataPedido) {
        // Obtener los datos del primer registro (suponiendo que todos los registros tienen la misma información del usuario)
        $firstRecord = $dataPedido[0];
        $nombre_cliente = utf8_decode($firstRecord['nombre_usuario']);
        $usuario_cliente = utf8_decode($firstRecord['usuario']);
        $correo_cliente = utf8_decode($firstRecord['correo']);
        $direccion_cliente = utf8_decode($firstRecord['direccion']);

        // Título y datos del cliente
        $pdf->SetFont('Times', 'B', 16); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Datos del cliente'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 14); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Nombre: ') . $nombre_cliente, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Usuario: ' . $usuario_cliente, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Correo: ' . $correo_cliente, 0, 1, 'L');

        // Dirección con MultiCell para manejo de texto largo
        $pdf->SetFont('Times', '', 14); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Dirección: '), 0, 1, 'L');
        $pdf->SetFont('Times', '', 12); // Usa una fuente integrada
        $pdf->MultiCell(0, 10, utf8_decode($direccion_cliente)); // Ajusta el ancho y alto según sea necesario
        $pdf->Ln(10);

        // Tabla de productos
        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->SetFont('Times', 'B', 12); // Usa una fuente integrada
        $header = array('DESCRIPCION', 'CANTIDAD', 'PRECIO', 'DESCUENTO', 'TOTAL');
        $pdf->InvoiceTable($header, $dataPedido);

        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->SetFont('Times', '', 11); // Usa una fuente integrada

        // Resumir totales
        $subtotal = array_sum(array_map(function ($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        }, $dataPedido));
        $descuentos = array_sum(array_map(function ($item) {
            return $item['valor_oferta'] > 0 ? ($item['cantidad'] * $item['precio_unitario']) * ($item['valor_oferta'] / 100) : 0;
        }, $dataPedido));
        $total = $subtotal - $descuentos;

        $pdf->Cell(130, 10, utf8_decode('SUBTOTAL'), 0, 0, 'R');
        $pdf->Cell(30, 10, '$' . number_format($subtotal, 2, '.', ','), 0, 1, 'R');
        if ($descuentos > 0) {
            $pdf->Cell(130, 10, utf8_decode('DESCUENTO'), 0, 0, 'R');
            $pdf->Cell(30, 10, '$' . number_format($descuentos, 2, '.', ','), 0, 1, 'R');
        } else {
            $pdf->Cell(0, 10, utf8_decode('No contiene descuento'), 0, 1);
        }
        $pdf->SetFont('Times', 'B', 12); // Usa una fuente integrada
        $pdf->Cell(130, 10, utf8_decode('TOTAL'), 0, 0, 'R');
        $pdf->Cell(30, 10, '$' . number_format($total, 2, '.', ','), 0, 1, 'R');
    } else {
        $pdf->Cell(0, 10, utf8_decode('No hay productos reservados'), 0, 1);
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('Usuario no autenticado'), 0, 1);
}

$pdf->Output('I', 'factura.pdf');
?>
