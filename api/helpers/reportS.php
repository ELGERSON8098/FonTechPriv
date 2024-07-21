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
        // Add background image
        
        // Draw the border
        $this->SetDrawColor(0, 0, 0); // Black color
        $this->Rect(5, 5, $this->GetPageWidth() - 10, $this->GetPageHeight() - 10);
        
        // Company Logo
        $this->Image('../../images/image 67.png', $this->GetPageWidth() / 2 - 25, 10, 60);

        // Title
        $this->SetFont('Arial', 'B', 18);
        $this->Ln(25); // Space after logo
        $this->Cell(0, 10, $this->encodeString($this->title), 0, 1, 'C');

        // Date and time
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Fecha/Hora: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        
        // Company details
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $this->encodeString('Nombre de la Empresa'), 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, $this->encodeString('Dirección: Calle Ejemplo, Ciudad, País'), 0, 1, 'L');
        $this->Cell(0, 10, $this->encodeString('Teléfono: +1234567890'), 0, 1, 'L');
        
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
        $this->SetFillColor(0, 153, 153); // Light cyan for header
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('Arial', 'B', 12);
        
        // Column widths
        $w = array(40, 60, 30, 20, 30);
        
        // Headers
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $this->encodeString($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Restoring colors and fonts
        $this->SetFillColor(224, 153, 153); // Light cyan for rows
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 12);
        
        // Data rows
        $fill = false;
        foreach ($data as $row) {
            // Ensure the row has enough elements before accessing them
            $cell0 = isset($row[0]) ? $this->encodeString($row[0]) : '';
            $cell1 = isset($row[1]) ? $this->encodeString($row[1]) : '';
            $cell2 = isset($row[2]) ? $this->encodeString($row[2]) : '';
            $cell3 = isset($row[3]) ? $this->encodeString($row[3]) : '';
            $cell4 = isset($row[4]) ? $this->encodeString($row[4]) : '';
        
            $this->Cell($w[0], 6, $cell0, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $cell1, 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $cell2, 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $cell3, 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $cell4, 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
