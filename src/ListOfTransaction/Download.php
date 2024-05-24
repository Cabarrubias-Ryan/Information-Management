<?php
require_once('../../TCPDF/tcpdf.php');
require_once('../../Connection/Connection.php');

class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($sql, $connection) {
        $result = $connection->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = array(
                    date('F j, Y', strtotime($row['date'])),
                    $row['check_number'],
                    $row['disbursement_no'],
                    $row['payee'],
                    $row['purpose'],
                    number_format($row['amount'], 2)
                );
            }
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(25, 18, 27, 60, 30, 19);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            foreach ($row as $i => $cell) {
                $this->Cell($w[$i], 6, $cell, 'LR', 0, $i > 5 ? 'R' : 'L', $fill);
            }
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    public function Header() {
        // Logo
        $logo = '../../img/logo.jfif'; // specify the path to your logo image
        $this->Image($logo, 44, 4,18); // Adjust the 90 to center the logo, 10 is the Y position, 30 is the width
        $this->Ln(8);
        // Set font
        $this->SetFont('helvetica', 'B', 12);

        // Title
        $this->Cell(0, 15, 'Check Transactions', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(5); // Line break
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 15, 'Barangay Mahayahay Malitbog Southern Leyte', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(5); // Move to the next line after the header

        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY() + 1, $this->getPageWidth() - 10, $this->GetY() + 1);
        
        $this->Ln(5); // Move to the next line after the header
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Transaction Report');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 6);
$pdf->AddPage();

$header = array('Date', 'Check Number', 'Disbursement Voucher', 'Payee', 'Purpose', 'Amount');
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT c.date, c.check_number, dv.disbursement_no, PB.pb_number, c.payee, c.purpose, c.amount FROM fms.Check c LEFT JOIN Disbursement_Voucher dv ON c.dv = dv.dv_id LEFT JOIN PB_Certification PB ON PB.id = PB_Certification WHERE c.check_number LIKE '%$search%' OR c.payee LIKE '%$search%' OR c.purpose LIKE '%$search%' OR c.date LIKE '%$search%'";
} else {
    $sql = "SELECT c.date, c.check_number, dv.disbursement_no, PB.pb_number, c.payee, c.purpose, c.amount FROM fms.Check c LEFT JOIN Disbursement_Voucher dv ON c.dv = dv.dv_id LEFT JOIN PB_Certification PB ON PB.id = PB_Certification";
}
$data = $pdf->LoadData($sql, $connection);

$pdf->ColoredTable($header, $data);

$pdf->Output('transaction_report.pdf', 'I');
?>
