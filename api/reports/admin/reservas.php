<?php
require_once('../../libraries/fpdf185/fpdf.php');

class PDF extends FPDF
{
    // Página de encabezado
    function Header()
    {
        // Título
        $this->SetFont('Times', 'B', 20); // Cambiado a Times para un estilo más formal
        $this->Cell(0, 10, 'Factura Electronica', 0, 1, 'C');
        $this->Ln(10); // Añadir espacio después del título

        // Logo
        $logoWidth = 80; // Ancho del logo
        $pageWidth = $this->GetPageWidth();
        $xCenter = ($pageWidth - $logoWidth) / 2; // Posición centrada para el logo

        $this->Image('C:/xampp/htdocs/FonTechPriv/resources/img/image 67.png', $xCenter, 25, $logoWidth);
        $this->Ln(45); // Añadir espacio después del logo
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8); // Cambiado a Times para consistencia
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla con encabezado y datos
    function InvoiceTable($header, $data)
    {
        // Ajustar el ancho de las columnas
        $w = array(70, 30, 30, 30); // Anchos actualizados: DESCRIPCION, CANTIDAD, PRECIO, DESCUENTO

        // Calcular el ancho total de la tabla
        $totalWidth = array_sum($w);

        // Calcular la posición para centrar la tabla
        $x = ($this->GetPageWidth() - $totalWidth) / 2;

        // Encabezado
        $this->SetXY($x, $this->GetY());
        $this->SetFillColor(200, 220, 255); // Color de fondo para el encabezado
        $this->SetTextColor(0); // Color del texto
        $this->SetDrawColor(128, 128, 128); // Color del borde
        $this->SetLineWidth(.3);
        $this->SetFont('Times', 'B', 12); // Cambiado a Times para un estilo más formal
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        // Datos
        $this->SetFont('Times', '', 10); // Cambiado a Times para un estilo más formal
        $fill = false;
        foreach ($data as $row) {
            $nombre_producto = $this->encodeString($row['nombre_producto']);
            $cantidad = $row['cantidad'];
            $precio_unitario = $row['precio_unitario'];
            $valor_oferta = $row['valor_oferta'];
            $descripcion_oferta = $this->encodeString($row['descripcion_oferta']);

            $subtotal = $cantidad * $precio_unitario;
            $descuento = ($valor_oferta > 0) ? $subtotal * ($valor_oferta / 100) : 0;
            $total = $subtotal - $descuento;

            // Calcular la posición Y para cada fila
            $currentY = $this->GetY();
            $this->SetXY($x, $currentY);
            $this->Cell($w[0], 10, $nombre_producto, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 10, $cantidad, 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 10, '$' . number_format($precio_unitario, 2, '.', ','), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 10, $valor_oferta > 0 ? '$' . number_format($descuento, 2, '.', ',') : '-', 'LR', 0, 'R', $fill);
            $this->Ln();

            $fill = !$fill;
        }
        // Dibujar la línea inferior centrada con la tabla
        $this->SetX($x); // Asegurar que la posición X esté alineada
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
require_once('../../models/data/reserva_data.php');

$reserva = new reservaData;

if (isset($_GET['idReserva']) && $reserva->setIdReserva($_GET['idReserva'])) {
    if ($rowReserva = $reserva->readOne()) {
        // Título y detalles de la empresa centrados
        $title = 'Datos de la empresa';
        $pdf->SetFont('Times', 'B', 16); // Cambiado a Times para un estilo más formal
        $titleWidth = $pdf->GetStringWidth($title);
        $pageWidth = $pdf->GetPageWidth();

        // Calcular posición X para centrar el título
        $xCenter = ($pageWidth - $titleWidth) / 2;

        // Aplicar desplazamiento a la izquierda
        $shiftLeft = 75; // Ajusta este valor según sea necesario
        $xCenter -= $shiftLeft;

        // Título centrado
        $pdf->SetXY($xCenter, $pdf->GetY() + 10); // Ajustar posición para el título
        $pdf->Cell(0, 10, $title, 0, 1, 'C');

        // Detalles de la empresa (aumento de tamaño de fuente)
        $pdf->SetFont('Times', '', 14); // Tamaño de fuente aumentado
        $pdf->SetXY($xCenter, $pdf->GetY() + 5); // Ajustar posición para detalles
        $pdf->Cell(0, 10, 'Fontech', 0, 1, 'C');
        $pdf->Cell(0, 10, 'San Salvador, El Salvador', 0, 1, 'C');
        $pdf->Cell(0, 10, 'FontechSv@gmail.com', 0, 1, 'C');
        $pdf->Cell(0, 10, '(503) 6305-8048', 0, 1, 'C');

        if ($dataReservas = $reserva->readDetails()) {
            $pdf->SetXY(10, $pdf->GetY() + 20); // Espacio aumentado antes de la tabla
            $pdf->SetFont('Times', 'B', 12); // Cambiado a Times para un estilo más formal
            $header = array('DESCRIPCION', 'CANTIDAD', 'PRECIO', 'DESCUENTO');
            $pdf->InvoiceTable($header, $dataReservas);

            $pdf->SetXY(10, $pdf->GetY() + 10);
            $pdf->SetFont('Times', '', 11); // Cambiado a Times para un estilo más formal

            // Resumir totales
            $subtotal = array_sum(array_map(function ($item) {
                return $item['cantidad'] * $item['precio_unitario'];
            }, $dataReservas));
            $descuentos = array_sum(array_map(function ($item) {
                return $item['valor_oferta'] > 0 ? ($item['cantidad'] * $item['precio_unitario']) * ($item['valor_oferta'] / 100) : 0;
            }, $dataReservas));
            $total = $subtotal - $descuentos;

            $pdf->Cell(130, 10, 'SUBTOTAL', 0, 0, 'R');
            $pdf->Cell(30, 10, '$' . number_format($subtotal, 2, '.', ','), 0, 1, 'R');
            if ($descuentos > 0) {
                $pdf->Cell(130, 10, 'DESCUENTO', 0, 0, 'R');
                $pdf->Cell(30, 10, '$' . number_format($descuentos, 2, '.', ','), 0, 1, 'R');
            } else {
                $pdf->Cell(0, 10, 'No contiene descuento', 0, 1);
            }
            $pdf->SetFont('Times', 'B', 12); // Cambiado a Times para un estilo más formal
            $pdf->Cell(130, 10, 'TOTAL', 0, 0, 'R');
            $pdf->Cell(30, 10, '$' . number_format($total, 2, '.', ','), 0, 1, 'R');
        } else {
            $pdf->Cell(0, 10, $pdf->encodeString('No hay productos reservados'), 1, 1);
        }
    } else {
        $pdf->Cell(0, 10, 'Reserva inexistente', 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'Debe seleccionar una reserva', 0, 1);
}

// Enviar el archivo PDF al navegador
$pdf->Output('I', 'Reservas.pdf');
