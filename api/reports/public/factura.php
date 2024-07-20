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
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'Factura Electronica', 0, 1, 'C');
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
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla con encabezado y datos
    function InvoiceTable($header, $data)
    {
        $w = array(70, 30, 30, 30);
        $totalWidth = array_sum($w);
        $x = ($this->GetPageWidth() - $totalWidth) / 2;

        $this->SetXY($x, $this->GetY());
        $this->SetFillColor(200, 220, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 128, 128);
        $this->SetLineWidth(.3);
        $this->SetFont('Times', 'B', 12);
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFont('Times', '', 10);
        $fill = false;
        foreach ($data as $row) {
            $nombre_producto = $this->encodeString($row['nombre_producto']);
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
            $this->Ln();

            $fill = !$fill;
        }
        $this->SetX($x);
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Codifica caracteres especiales
    function encodeString($str)
    {
        return iconv('UTF-8', 'ISO-8859-1//IGNORE', $str);
    }
}

// Crear objeto PDF
$pdf = new PDF();
$pdf->AddPage();

// Conectar a tu base de datos
$pedido = new PedidoData;

if (isset($_SESSION['idUsuario'])) {
    if ($dataPedido = $pedido->readHistorials('%%')) {
        $title = 'Datos de la empresa';
        $pdf->SetFont('Times', 'B', 16);
        $titleWidth = $pdf->GetStringWidth($title);
        $pageWidth = $pdf->GetPageWidth();
        $xCenter = ($pageWidth - $titleWidth) / 2;
        $shiftLeft = 75;
        $xCenter -= $shiftLeft;
        $pdf->SetXY($xCenter, $pdf->GetY() + 10);
        $pdf->Cell(0, 10, $title, 0, 1, 'C');

        $pdf->SetFont('Times', '', 14);
        $pdf->SetXY($xCenter, $pdf->GetY() + 5);
        $pdf->Cell(0, 10, 'Fontech', 0, 1, 'C');
        $pdf->Cell(0, 10, 'San Salvador, El Salvador', 0, 1, 'C');
        $pdf->Cell(0, 10, 'FontechSv@gmail.com', 0, 1, 'C');
        $pdf->Cell(0, 10, '(503) 6305-8048', 0, 1, 'C');

        $pdf->SetXY(10, $pdf->GetY() + 20);
        $pdf->SetFont('Times', 'B', 12);
        $header = array('DESCRIPCION', 'CANTIDAD', 'PRECIO', 'DESCUENTO');
        $pdf->InvoiceTable($header, $dataPedido);

        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->SetFont('Times', '', 11);

        // Resumir totales
        $subtotal = array_sum(array_map(function ($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        }, $dataPedido));
        $descuentos = array_sum(array_map(function ($item) {
            return $item['valor_oferta'] > 0 ? ($item['cantidad'] * $item['precio_unitario']) * ($item['valor_oferta'] / 100) : 0;
        }, $dataPedido));
        $total = $subtotal - $descuentos;

        $pdf->Cell(130, 10, 'SUBTOTAL', 0, 0, 'R');
        $pdf->Cell(30, 10, '$' . number_format($subtotal, 2, '.', ','), 0, 1, 'R');
        if ($descuentos > 0) {
            $pdf->Cell(130, 10, 'DESCUENTO', 0, 0, 'R');
            $pdf->Cell(30, 10, '$' . number_format($descuentos, 2, '.', ','), 0, 1, 'R');
        } else {
            $pdf->Cell(0, 10, 'No contiene descuento', 0, 1);
        }
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(130, 10, 'TOTAL', 0, 0, 'R');
        $pdf->Cell(30, 10, '$' . number_format($total, 2, '.', ','), 0, 1, 'R');
    } else {
        $pdf->Cell(0, 10, 'No hay productos reservados', 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'Usuario no autenticado', 0, 1);
}

$pdf->Output('I', 'factura.pdf');
?>
