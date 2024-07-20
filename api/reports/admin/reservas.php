<?php
require_once('../../libraries/fpdf185/fpdf.php');

class PDF extends FPDF
{
    // Página de encabezado
    function Header()
    {
        // Borde alrededor de la página
        $this->Rect(5, 5, $this->GetPageWidth() - 10, $this->GetPageHeight() - 10);
        
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
        $totalGeneral = 0;
        foreach ($data as $row) {
            $nombre_producto = $this->encodeString($row['nombre_producto']);
            $cantidad = $row['cantidad'];
            $precio_unitario = $row['precio_unitario'];
            $valor_oferta = $row['valor_oferta'];
            $descripcion_oferta = $this->encodeString($row['descripcion_oferta']);

            $subtotal = $cantidad * $precio_unitario;
            $descuento = ($valor_oferta > 0) ? $subtotal * ($valor_oferta / 100) : 0;
            $totalProducto = $subtotal - $descuento;
            $totalGeneral += $totalProducto;

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

        // Mostrar total general
        $this->SetXY($x, $this->GetY());
        $this->SetFont('Times', 'B', 12);
        $this->Cell($w[0] + $w[1] + $w[2], 10, 'Total', 1, 0, 'C');
        $this->Cell($w[3], 10, '$' . number_format($totalGeneral, 2, '.', ','), 1, 0, 'R');
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
    if ($dataReservas = $reserva->readDetails()) {
        // Obtener los datos del primer registro (suponiendo que todos los registros tienen la misma información del cliente)
        $firstRecord = $dataReservas[0];
        $nombre_cliente = utf8_decode($firstRecord['nombre']);
        $correo_cliente = utf8_decode($firstRecord['correo']);
        $direccion_cliente = utf8_decode($firstRecord['direccion']);

        // Título y datos del cliente
        $pdf->SetFont('Times', 'B', 16); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Datos del cliente'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 14); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Nombre: ') . $nombre_cliente, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Correo: ' . $correo_cliente, 0, 1, 'L');
        
        // Dirección con MultiCell para manejo de texto largo
        $pdf->SetFont('Times', '', 14); // Usa una fuente integrada
        $pdf->Cell(0, 10, utf8_decode('Dirección: '), 0, 1, 'L');
        $pdf->SetFont('Times', '', 12); // Usa una fuente integrada
        $pdf->MultiCell(0, 10, utf8_decode($direccion_cliente)); // Ajusta el ancho y alto según sea necesario
        $pdf->Ln(10);

        // Tabla de productos
        $pdf->SetXY(10, $pdf->GetY() + 10); // Espacio aumentado antes de la tabla
        $pdf->SetFont('Times', 'B', 12); // Cambiado a Times para un estilo más formal
        $header = array('DESCRIPCION', 'CANTIDAD', 'PRECIO', 'DESCUENTO');
        $pdf->InvoiceTable($header, $dataReservas);

        // Mostrar el PDF
        $pdf->Output();
    } else {
        echo 'No se encontraron datos.';
    }
} else {
    echo 'ID de reserva no válido.';
}
?>
