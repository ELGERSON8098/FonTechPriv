<?php
require_once('../../libraries/fpdf185/fpdf.php');

class Report extends FPDF
{
    const CLIENT_URL = 'http://localhost/fontechpriv/views/admin/';
    private $title = null;

    public function startReport($title)
    {
        session_start();
        if (isset($_SESSION['idAdministrador'])) {
            $this->title = $title;
            $this->SetTitle('Fontech - Reporte', true);
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
        $this->Image('../../images/image 67.png', 10, 10, 50);
        
        // Empresa info
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 5, $this->encodeString('Sistema Web S.A. de C.V.'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('234/90, New York Street'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('United States'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('Web: www.sistemaweb.la'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('E-mail: info@sistemaweb.la'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('Tel: +456-905-559'), 0, 1, 'R');
        $this->Cell(0, 5, $this->encodeString('Twitter: @sistemaweb'), 0, 1, 'R');

        // Line
        $this->Ln(10);
        $this->SetLineWidth(0.5);
        $this->Line(15, 50, $this->GetPageWidth() - 15, 50);
        $this->Ln(10);

        // Factura title
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 10, 'Factura', 0, 1, 'L');
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0); // Black text color
        $this->Cell(0, 10, $this->encodeString('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function InvoiceDetails($clientInfo, $invoiceInfo, $items)
    {
        // Facturar a
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 10, 'Facturar a', 0, 0, 'L');
        $this->Cell(0, 10, 'Enviar a', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(100, 5, $this->encodeString($clientInfo['name']), 0, 0, 'L');
        $this->Cell(0, 5, $this->encodeString($invoiceInfo['name']), 0, 1, 'L');
        $this->Cell(100, 5, $this->encodeString($clientInfo['company']), 0, 0, 'L');
        $this->Cell(0, 5, $this->encodeString($invoiceInfo['company']), 0, 1, 'L');
        $this->Cell(100, 5, $this->encodeString($clientInfo['address']), 0, 0, 'L');
        $this->Cell(0, 5, $this->encodeString($invoiceInfo['address']), 0, 1, 'L');
        $this->Cell(100, 5, $this->encodeString($clientInfo['phone']), 0, 0, 'L');
        $this->Cell(0, 5, $this->encodeString($invoiceInfo['phone']), 0, 1, 'L');

        // Vendedor, Orden de compra, Enviar por, Términos y condiciones
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 7, 'Vendedor', 1, 0, 'C');
        $this->Cell(50, 7, 'Orden de compra', 1, 0, 'C');
        $this->Cell(50, 7, 'Enviar por', 1, 0, 'C');
        $this->Cell(50, 7, 'Términos y condiciones', 1, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, $this->encodeString('John Doe'), 1, 0, 'C');
        $this->Cell(50, 7, $this->encodeString('#PO-2020'), 1, 0, 'C');
        $this->Cell(50, 7, $this->encodeString('DHL'), 1, 0, 'C');
        $this->Cell(50, 7, $this->encodeString('Pago al contado'), 1, 1, 'C');

        // Items table
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40, 7, 'Código', 1, 0, 'C');
        $this->Cell(60, 7, 'Descripción', 1, 0, 'C');
        $this->Cell(30, 7, 'Cant.', 1, 0, 'C');
        $this->Cell(30, 7, 'Precio', 1, 0, 'C');
        $this->Cell(30, 7, 'Total', 1, 1, 'C');
        
        $this->SetFont('Arial', '', 12);
        foreach ($items as $item) {
            $this->Cell(40, 7, $this->encodeString($item['codigo']), 1, 0, 'C');
            $this->Cell(60, 7, $this->encodeString($item['descripcion']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['cantidad']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['precio']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['total']), 1, 1, 'C');
        }

        // Totals
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(160, 7, 'IVA:', 1, 0, 'R');
        $this->Cell(30, 7, $this->encodeString('$' . number_format($invoiceInfo['iva'], 2)), 1, 1, 'C');
        $this->Cell(160, 7, 'Total:', 1, 0, 'R');
        $this->Cell(30, 7, $this->encodeString('$' . number_format($invoiceInfo['total'], 2)), 1, 1, 'C');
    }
}

// Datos de ejemplo
$clientInfo = [
    'name' => 'John Doe',
    'company' => 'Empresa Ejemplo S.A.',
    'address' => '1234 Calle Falsa, Ciudad',
    'phone' => '+123-456-7890'
];

$invoiceInfo = [
    'name' => 'Jane Smith',
    'company' => 'Otra Empresa S.A.',
    'address' => '5678 Avenida Siempre Viva, Ciudad',
    'phone' => '+098-765-4321',
    'iva' => 11.39,
    'total' => 99.00
];

$items = [
    ['codigo' => '12345', 'descripcion' => 'Descripción del producto', 'cantidad' => '1', 'precio' => '99', 'total' => '99']
];

// Crear PDF
$pdf = new Report();
$pdf->startReport('Factura');
$pdf->InvoiceDetails($clientInfo, $invoiceInfo, $items);
$pdf->Output();
?>
        foreach ($items as $item) {
            $this->Cell(40, 7, $this->encodeString($item['codigo']), 1, 0, 'C');
            $this->Cell(60, 7, $this->encodeString($item['descripcion']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['cantidad']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['precio']), 1, 0, 'C');
            $this->Cell(30, 7, $this->encodeString($item['total']), 1, 1, 'C');
        }

        // Totals
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(160, 7, 'IVA:', 1, 0, 'R');
        $this->Cell(30, 7, $this->encodeString('$' . number_format($invoiceInfo['iva'], 2)), 1, 1, 'C');
        $this->Cell(160, 7, 'Total:', 1, 0, 'R');
        $this->Cell(30, 7, $this->encodeString('$' . number_format($invoiceInfo['total'], 2)), 1, 1, 'C');
    }
}

// Datos de ejemplo
$clientInfo = [
    'name' => 'John Doe',
    'company' => 'Empresa Ejemplo S.A.',
    'address' => '1234 Calle Falsa, Ciudad',
    'phone' => '+123-456-7890'
];

$invoiceInfo = [
    'name' => 'Jane Smith',
    'company' => 'Otra Empresa S.A.',
    'address' => '5678 Avenida Siempre Viva, Ciudad',
    'phone' => '+098-765-4321',
    'iva' => 11.39,
    'total' => 99.00
];

$items = [
    ['codigo' => '12345', 'descripcion' => 'Descripción del producto', 'cantidad' => '1', 'precio' => '99', 'total' => '99']
];

// Crear PDF
$pdf = new Report();
$pdf->startReport('Factura');
$pdf->InvoiceDetails($clientInfo, $invoiceInfo, $items);
$pdf->Output();
?>
