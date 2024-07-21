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
            $this->SetMargins(15, 15, 15); // Margen de 15 mm en todos los lados
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
        // Logo centered
        $this->Image('../../images/image 67.png', $this->GetPageWidth() / 2 - 25, 10, 60);

        // Title
        $this->SetFont('Arial', 'B', 18);
        $this->Ln(25); // Space after logo
        $this->Cell(0, 10, $this->encodeString($this->title), 0, 1, 'C');

        // Decorative line
        $this->SetDrawColor(0, 0, 0); // Black line color
        $this->SetLineWidth(0.5);
        $this->Line(15, 40, $this->GetPageWidth() - 15, 40);

        // Date and time
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Fecha/Hora: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        
        // Space after header
        $this->Ln(5);
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0); // Black text color
        $this->Cell(0, 10, $this->encodeString('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');

        // Draw border around page closer to the bottom
        $this->SetDrawColor(0, 0, 0); // Black border color
        $this->SetLineWidth(0.3);
        $this->Rect(8, 5, $this->GetPageWidth() - 15, $this->GetPageHeight() - 10); // Adjust x, y, width, height
    }

    public function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(0, 153, 153); // Light cyan for header
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('Calibri', 'B', 12);
        
        // Column widths
        $w = array(40, 60, 30, 20, 30);
        
        // Headers
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $this->encodeString($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Restoring colors and fonts
        $this->SetFillColor(0, 153, 153); // Light cyan for rows
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 12);
        
        // Data rows
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $this->encodeString($row[0]), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $this->encodeString($row[1]), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $this->encodeString($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $this->encodeString($row[3]), 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $this->encodeString($row[4]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
?>

