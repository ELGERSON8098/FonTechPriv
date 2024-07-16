<?php
require_once('../../libraries/fpdf185/fpdf.php');

class Report extends FPDF
{
    const CLIENT_URL = 'http://localhost/fontechpriv/views/admin/';
    private $title = null;
    private $clientName = null;
    private $invoiceDate = null;
    private $invoiceNumber = null;

    public function startReport($title, $clientName, $invoiceDate, $invoiceNumber)
    {
        session_start();
        if (isset($_SESSION['idAdministrador'])) {
            $this->title = $title;
            $this->clientName = $clientName;
            $this->invoiceDate = $invoiceDate;
            $this->invoiceNumber = $invoiceNumber;
            $this->SetTitle('Fontech - Factura', true);
            $this->SetMargins(15, 15, 15);
            $this->AddPage('P', 'letter');
            $this->AliasNbPages();
        } else {
            header('location:' . self::CLIENT_URL);
            exit; // Ensure script stops executing after redirection
        }
    }

    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }

    public function Header()
    {
        // Logo
        $this->Image('../../images/image 67.png', 15, 10, 60);

        // Invoice Title
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, $this->encodeString('Factura'), 0, 1, 'R');

        // Invoice Info
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Fecha: ' . $this->invoiceDate, 0, 1, 'R');
        $this->Cell(0, 10, 'No. Factura: ' . $this->invoiceNumber, 0, 1, 'R');

        // Client Info
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Cliente: ' . $this->encodeString($this->clientName), 0, 1, 'L');

        // Decorative line
        $this->SetDrawColor(0, 0, 0); // Black line color
        $this->SetLineWidth(0.5);
        $this->Line(15, 50, $this->GetPageWidth() - 15, 50);

        // Space after header
        $this->Ln(10);
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0); // Black text color
        $this->Cell(0, 10, $this->encodeString('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function InvoiceTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(0, 255, 255); // Light cyan for header
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('Arial', 'B', 12);
        
        // Column widths
        $w = array(70, 30, 30, 30);
        
        // Headers
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $this->encodeString($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Restoring colors and fonts
        $this->SetFillColor(224, 255, 255); // Light cyan for rows
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 12);
        
        // Data rows
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $this->encodeString($row[0]), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $this->encodeString($row[1]), 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $this->encodeString($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $this->encodeString($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Example usage:

$pdf = new Report;
if (isset($_GET['idReserva'])) {
    require_once('../../models/data/reserva_data.php');
    require_once('../../models/data/pedido_data.php');
    $reserva = new reservaData;
    $pedido = new PedidoData;
    if ($reserva->setIdReserva($_GET['idReserva']) && $pedido->setIdDetalle($_GET['idReserva'])) {
        if ($rowReserva = $reserva->readOne()) {
            $pdf->startReport(
                'Producto reservado del cliente ' . $rowReserva['nombre_usuario'], 
                $rowReserva['nombre_usuario'], 
                date('d-m-Y'), 
                $_GET['idReserva']
            );
            if ($dataPedido = $pedido->readDetail()) {
                $header = array('Nombre producto', 'Cantidad', 'Precio (US$)', 'Estado reserva');
                $data = array();
                foreach ($dataPedido as $rowDetalle) {
                    $estado = $rowDetalle['estado_reserva'] ? 'Aceptado' : 'Pendiente';
                    $data[] = array(
                        $rowDetalle['nombre_producto'], 
                        $rowDetalle['cantidad'], 
                        $rowDetalle['precio_unitario'], 
                        $estado
                    );
                }
                $pdf->InvoiceTable($header, $data);
            } else {
                $pdf->Cell(0, 10, $pdf->encodeString('No hay productos'), 1, 1);
            }
            $pdf->Output('I', 'Factura.pdf');
        } else {
            print('Reserva inexistente');
        }
    } else {
        print('Reserva incorrecta');
    }
} else {
    print('Debe seleccionar una Reserva');
}
?>
