<?php
require('../../fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Monthly Transaction Report', 0, 1, 'C');
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF('L', 'mm', 'A4'); // Set to landscape orientation
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'This report includes the monthly transactions in the barangay.', 0, 1);

$margin = 10; // Margin in mm
$imgWidth = $pdf->GetPageWidth() - 2 * $margin;
$imgHeight = $pdf->GetPageHeight() - 2 * $margin - 20; // Adjust height considering header and footer

$pdf->Image('chart.png', $margin, 30, $imgWidth, $imgHeight, 'PNG');

$pdf->Output('D', 'monthly_transaction_report.pdf');
?>
