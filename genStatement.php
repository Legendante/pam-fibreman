<?php
session_start();
include_once("db.inc.php");
define('FPDF_FONTPATH','font/');
require('fpdf.php');

$ClientID = pebkac($_POST['state_cid']);
$StartDate = pebkac($_POST['state_start'], 10, 'STRING');
$EndDate = pebkac($_POST['state_end'], 10, 'STRING');
$Client = getClientByID($ClientID);
$NextSNum = getNextStatementNumber($ClientID);
$OpenBalance = getClientBalanceForDate($ClientID, $StartDate);
$Invoices = getClientInvoices($ClientID, $StartDate, $EndDate);
$InvoicesDets = getClientInvoices($ClientID);
$Payments = getClientPayments($ClientID, $StartDate, $EndDate);
$InvArr = array();
$cnt = 0;
foreach($Invoices AS $InvoiceID => $InvRec)
{
	$InvArr[$cnt]['total'] = $InvRec['invoicetotal'];
	$InvArr[$cnt]['date'] = substr($InvRec['logtime'], 0, 10);
	$InvArr[$cnt]['id'] = $InvoiceID;
	$InvArr[$cnt]['status'] = $InvRec['inv_status'];
	$InvArr[$cnt]['type'] = 'i';
	$InvArr[$cnt]['desc'] = "Invoice";
	$cnt++;
}
$PayArr = array();
$cnt = 0;
foreach($Payments AS $LogTime => $PayRec)
{
	$PayArr[$cnt]['total'] = $PayRec['amount'];
	$PayArr[$cnt]['date'] = substr($PayRec['transdate'], 0, 10);
	$PayArr[$cnt]['id'] = $PayRec['invoice_id'];
	$PayArr[$cnt]['status'] = 0;
	$PayArr[$cnt]['type'] = 'p';
	$PayArr[$cnt]['desc'] = $PayRec['description'];
	$cnt++;
}
$StatementArr = array_merge($InvArr, $PayArr);
// print_r($StatementArr);
// echo "<br>";
// print_r($Invoices);
// exit();
function dateSort($a,$b)
{
	$retVal = 0;
	if ($a['date'] == $b['date']) 
        $retVal = 0;
	else
		$retVal = (strtotime($a['date']) < strtotime($b['date'])) ? -1 : 1;
	return $retVal;
}
usort($StatementArr, 'dateSort');
class PDF extends FPDF
{
	public function Header()
	{
		$this->SetFont('Arial','',8);
		$this->SetXY(10, 270);
		$this->Cell(180, 5, 'Page ' . $this->page . ' of {nb}', 0, 0, 'C');
	}

	public function Footer()
	{
	}
}

$FileName = 'uploads/accounting/statements/Company.Statement.' . $Client['client_short'] . "-" . $NextSNum . "." . date("Ymd") . '.pdf';

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$TopY = 30;
$PonLogo = "images/Logo.jpg";
$pdf->Image($PonLogo, 15, 8, 80);
$pdf->SetFont('Arial','',8);
$TopY = 16;
$pdf->SetFont('Arial','',10);
$pdf->SetXY(100, $TopY);
$pdf->Cell(35, 5, "Company (PTY) Ltd.", 0);
$TopY += 5;
$pdf->SetXY(100, $TopY);
$pdf->Cell(29, 5, "Reg No. 1234/123456/07", 0);
$TopY += 5;
$pdf->SetXY(100, $TopY);
$pdf->Cell(29, 5, "VAT No. 123456798", 0);
$TopY = 16;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Street Number,", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Road name,", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Suburb, 1234", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(29, 5, "info@example.com", 0);
$TopY += 10;
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(100, $TopY);
$pdf->Cell(100, 8, "Statement", 1, 0, 'C');
$TopY += 8;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Statement Date", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, date("d M Y"), 1, 0, 'C');
$pdf->SetFont('Arial','B',11);
$TopY += 6;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Statement #", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, $Client['client_short'] . "-S-" . sprintf("%03d", $NextSNum), 1, 0, 'C');
$TopY += 10;
$pdf->SetXY(100, $TopY);
$pdf->Cell(100, 6, "Statement Start Date: " . $StartDate, 0, 0, 'L'); // JKS 
$TopY += 6;
$pdf->SetXY(100, $TopY);
$pdf->Cell(100, 6, "Statement End Date: " . $EndDate, 0, 0, 'L'); // JKS
$TopY = 40;
$pdf->SetXY(15, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 5, "Client:");
$pdf->SetFont('Arial','',11);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 5, $Client['clientname']);

$Address = explode(";", $Client['client_address']);

$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, $Address[0], 0, 0);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, $Address[1], 0, 0);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, $Address[2], 0, 0);

$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, "Reg No. " . $Client['client_reg'], 0, 0);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, "VAT No. " . $Client['client_vat'], 0, 0);

$pdf->SetFont('Arial','B',10);
$TopY += 10;
$pdf->SetXY(15, $TopY);
$pdf->Cell(20, 6, "Date", 1, 0, 'C');
$pdf->Cell(20, 6, "Reference", 1, 0, 'C');
$pdf->Cell(40, 6, "Description", 1, 0, 'C');
$pdf->Cell(30, 6, "Allocated To", 1, 0, 'C');
$pdf->Cell(25, 6, "Debit", 1, 0, 'C');
$pdf->Cell(25, 6, "Credit", 1, 0, 'C');
$pdf->Cell(25, 6, "Balance", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
foreach($StatementArr AS $ind => $StateRec)
{
	$TopY += 6;
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(20, 6, $StateRec['date'], 1, 0, 'L');
	if($StateRec['type'] == 'p')
	{
		$pdf->Cell(20, 6, "Payment", 1, 0, 'L');
		$pdf->Cell(40, 6, $StateRec['desc'], 1, 0, 'L');
		$pdf->Cell(30, 6, $Client['client_short'] . sprintf("%03d", $InvoicesDets[$StateRec['id']]['inv_number']), 1, 0, 'L');
		$pdf->Cell(25, 6, "-", 1, 0, 'R');
		$pdf->Cell(25, 6, sprintf("R %0.2f", $StateRec['total']), 1, 0, 'R');
		$pdf->Cell(25, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'R');
		$OpenBalance -= $StateRec['total'];
	}
	else
	{
		if($StateRec['status'] == 99)
		{
			$pdf->Cell(20, 6, $Client['client_short'] . sprintf("%03d", $InvoicesDets[$StateRec['id']]['inv_number']), 1, 0, 'L');
			$pdf->Cell(40, 6, $StateRec['desc'], 1, 0, 'L');
			$pdf->Cell(30, 6, "", 1, 0, 'L');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $StateRec['total']), 1, 0, 'R');
			$pdf->Cell(25, 6, "-", 1, 0, 'C');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'R');
			$OpenBalance += $StateRec['total'];
			$TopY += 6;
			$pdf->SetXY(15, $TopY);
			$pdf->Cell(20, 6, $StateRec['date'], 1, 0, 'L');
			$pdf->Cell(20, 6, $Client['client_short'] . sprintf("%03d", $InvoicesDets[$StateRec['id']]['inv_number']), 1, 0, 'L');
			$pdf->Cell(40, 6, "Voided", 1, 0, 'L');
			$pdf->Cell(30, 6, "Voided", 1, 0, 'L');
			$pdf->Cell(25, 6, "-", 1, 0, 'C');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $StateRec['total']), 1, 0, 'R');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'R');
			$OpenBalance -= $StateRec['total'];
		}
		else
		{
			$pdf->Cell(20, 6, $Client['client_short'] . sprintf("%03d", $InvoicesDets[$StateRec['id']]['inv_number']), 1, 0, 'L');
			$pdf->Cell(40, 6, $StateRec['desc'], 1, 0, 'L');
			$pdf->Cell(30, 6, "", 1, 0, 'L');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $StateRec['total']), 1, 0, 'R');
			$pdf->Cell(25, 6, "-", 1, 0, 'C');
			$pdf->Cell(25, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'R');
			$OpenBalance += $StateRec['total'];
		}
	}
	if($TopY > 240)
	{
		$pdf->AddPage('P');
		$TopY = 30;
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(15, $TopY);
		$pdf->Cell(20, 6, "Date", 1, 0, 'C');
		$pdf->Cell(20, 6, "Reference", 1, 0, 'C');
		$pdf->Cell(40, 6, "Description", 1, 0, 'C');
		$pdf->Cell(30, 6, "Allocated To", 1, 0, 'C');
		$pdf->Cell(25, 6, "Debit", 1, 0, 'C');
		$pdf->Cell(25, 6, "Credit", 1, 0, 'C');
		$pdf->Cell(25, 6, "Balance", 1, 0, 'C');
		$pdf->SetFont('Arial','',10);
		// $TopY += 6;
	}
}
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(20, 6, $EndDate, 1, 0, 'L');
$pdf->Cell(20, 6, "", 1, 0, 'L');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(30, 6, "", 1, 0, 'L');
$pdf->Cell(25, 6, "", 1, 0, 'R');
$pdf->Cell(25, 6, "", 1, 0, 'C');
$pdf->Cell(25, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'R');
$TopY = 250;
$pdf->SetXY(15, $TopY);
$pdf->Cell(26, 6, "150 Days", 1, 0, 'C');
$pdf->Cell(26, 6, "120 Days", 1, 0, 'C');
$pdf->Cell(26, 6, "90 Days", 1, 0, 'C');
$pdf->Cell(26, 6, "60 Days", 1, 0, 'C');
$pdf->Cell(26, 6, "30 Days", 1, 0, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26, 6, "Current", 1, 0, 'C');
$pdf->Cell(29, 6, "Amount Due", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(26, 6, "R 0.00", 1, 0, 'C');
$pdf->Cell(26, 6, "R 0.00", 1, 0, 'C');
$pdf->Cell(26, 6, "R 0.00", 1, 0, 'C');
$pdf->Cell(26, 6, "R 0.00", 1, 0, 'C');
$pdf->Cell(26, 6, "R 0.00", 1, 0, 'C');
$pdf->Cell(26, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'C');
$pdf->Cell(29, 6, sprintf("R %0.2f", $OpenBalance), 1, 0, 'C');
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(150, 6, "Payments after statement date will not appear on this statement.", 0, 0, 'L');

$OutPutType = 'F';
// $OutPutType = 'I';
$pdf->Output($FileName, $OutPutType);
$SaveArr = array();
$SaveArr['client_id'] = $ClientID;
$SaveArr['statement_number'] = $NextSNum;
$SaveArr['file_path'] = $FileName;
$SaveArr['startdate'] = $StartDate;
$SaveArr['enddate'] = $EndDate;

$StatementID = addStatement($SaveArr);
unset($pdf);
header("Location: editclient.php?cid=" . $ClientID);
?>