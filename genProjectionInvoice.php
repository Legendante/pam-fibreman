<?php
session_start();
include_once("db.inc.php");
define('FPDF_FONTPATH','font/');
require('fpdf.php');

$ClientID = pebkac($_POST['cid']);
$Client = getClientByID($ClientID);
$NextInvNum = getNextInvoiceNumber($ClientID);
$PurchaseOrders = getClientPurchaseOrders($ClientID);
$Tasks = $_POST['task'];
$Templates = getBOQTemplates();
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$BOQItems = getMultiTaskBOQItems($Tasks);
$Tasks = getTasksByIDs($Tasks);
// $Projs = getProjects();
$Depts = getDepartments();
$InvoicedID = getTaskStatusByName("Invoiced");
$InvoicedID = $InvoicedID['id'];
// $Sections = getSections();
class PDF extends FPDF
{
	public function Header()
	{
		$this->SetFont('Arial','',8);
		$this->SetXY(10, 267);
		$this->Cell(180, 5, 'Page ' . $this->page . ' of {nb}', 0, 0, 'C');
	}

	public function Footer()
	{
	}
}
$FileName = 'uploads/accounting/invoices/Company.ProjInvoice.' . $Client['client_short'] . sprintf("%03d", $NextInvNum) . '.' . date("Ymd") . '.pdf';

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
$pdf->Cell(29, 5, "VAT No. 123456789", 0);
$TopY = 16;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Street Number,", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Some Road,", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(40, 5, "Suburb, 1234", 0);
$TopY += 5;
$pdf->SetXY(150, $TopY);
$pdf->Cell(29, 5, "info@example.com", 0);
$TopY += 10;
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(100, $TopY);
$pdf->Cell(100, 8, "TAX INVOICE", 1, 0, 'C');
$TopY += 8;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Invoice Date", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, date("d M Y"), 1, 0, 'C');
$pdf->SetFont('Arial','B',11);
$TopY += 6;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Invoice #", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, $Client['client_short'] . sprintf("%03d", $NextInvNum), 1, 0, 'C');
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
$pdf->SetFont('Arial','',10);
$SubTotal = 0;
$ItemArr = array();
foreach($Tasks AS $TaskID => $Task)
{
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(130, 6, "Task", 1, 0, 'C');
	$pdf->Cell(50, 6, "Department", 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(130, 6, $Task['task_name'], 1, 0, 'L');
	$pdf->Cell(50, 6, $Depts[$Task['department_id']]['departmentname'], 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(90, 6, "Item", 1, 0, 'C');
	$pdf->Cell(20, 6, "PO", 1, 0, 'C');
	$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
	$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
	$pdf->Cell(30, 6, "Total", 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','',8);
	foreach($BOQItems[$TaskID] AS $ItemID => $ItemRec)
	{
		if($ItemRec['completed'] > 0)
		{
			$LineTotal = $ItemRec['completed'] * $BOQLines[$ItemID]['defaultcost'];
			$SubTotal += $LineTotal;
			$ItemArr[$ItemID] = $LineTotal;
			$pdf->SetXY(15, $TopY);
			$pdf->Cell(90, 6, $BOQLines[$ItemID]['item_name'], 1, 0, 'L');
			$pdf->Cell(20, 6, $PurchaseOrders[$Task['po_id']]['po_number'], 1, 0, 'C');
			$pdf->Cell(20, 6, $ItemRec['completed'], 1, 0, 'C');
			$pdf->Cell(20, 6, $BOQLines[$ItemID]['defaultcost'], 1, 0, 'C');
			$pdf->Cell(30, 6, sprintf("R %0.2f", $LineTotal), 1, 0, 'C');
			$TopY += 6;
			if($TopY > 260)
			{
				$pdf->AddPage('P');
				$TopY = 30;
				$pdf->SetFont('Arial','B',9);
				$pdf->SetXY(15, $TopY);
				$pdf->Cell(90, 6, "Item", 1, 0, 'C');
				$pdf->Cell(20, 6, "PO", 1, 0, 'C');
				$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
				$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
				$pdf->Cell(30, 6, "Total", 1, 0, 'C');
				$TopY += 6;
				$pdf->SetFont('Arial','',8);
			}
		}
	}
}
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Bank: Bank", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, "Subtotal", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $SubTotal), 1, 0, 'C');
$WithVat = $SubTotal * VATCALC;
$VatOnly = $WithVat - $SubTotal;
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Account Num: 123456789", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, VATDISP . "% Vat", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $VatOnly), 1, 0, 'C');
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Branch Code: 123456", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, "Total", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $WithVat), 1, 0, 'C');
$OutPutType = 'I';
$pdf->Output($FileName, $OutPutType);
?>