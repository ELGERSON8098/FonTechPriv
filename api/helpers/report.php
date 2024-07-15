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
        }
    }

    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }

    public function Header()
    {
        // Fondo degradado
        $this->SetFillColor(200); // Color inicial del degradado
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F'); // Rectángulo para fondo degradado

        // Logo y título
        $this->Image('../../images/image 67.png', 15, 15, 20);
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(255); // Color de texto blanco
        $this->Cell(0, 10, $this->encodeString($this->title), 0, 1, 'C');

        // Línea decorativa
        $this->SetDrawColor(255); // Color de línea blanco
        $this->Line(15, 35, $this->GetPageWidth() - 15, 35);

        // Fecha y hora
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Fecha/Hora: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        
        // Espacio después del encabezado
        $this->Ln(10);
    }

    public function Footer()
    {
        // Posición en el pie de página a 15 mm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0); // Color de texto negro
        $this->Cell(0, 10, $this->encodeString('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
?>
