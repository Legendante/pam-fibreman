<?php
session_start();
include_once("db.inc.php");
define('FPDF_FONTPATH','font/');
require('fpdf.php');

if(isset($_GET['t']))
{
	$TaskID = pebkac($_GET['t']);
	$Task = getTaskByID($TaskID);
	$ClientID = $Task['client_id'];
	$Tasks = array($TaskID);
	$QuoteName = $Task['task_name'];
}
else
{
	$ClientID = pebkac($_POST['cid']);
	$Tasks = $_POST['task'];
	$QuoteName = pebkac($_POST['quotename'], 100, 'STRING');
}
$Client = getClientByID($ClientID);
$NextInvNum = getNextQuoteNumber($ClientID);
$Templates = getBOQTemplates();
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$BOQItems = getMultiTaskBOQItems($Tasks);
$Tasks = getTasksByIDs($Tasks);
$Projs = getProjects();
$Depts = getDepartments();
$Sections = getSections();
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
$FileName = 'uploads/accounting/quotes/Company.Quote.' . $Client['client_short'] . "-Q-" . sprintf("%03d", $NextInvNum) . '.' . date("Ymd") . '.pdf';

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$TopY = 30;
$PonLogo = "images/Logo.jpg";
$pdf->Image($PonLogo, 15, 8, 80);
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
$pdf->Cell(40, 5, "Street number,", 0);
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
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(100, $TopY);
$pdf->Cell(80, 8, "Quote", 1, 0, 'C');
$TopY += 8;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40, 6, "Quote Date", 1, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, $TopY);
$pdf->Cell(40, 6, date("d M Y"), 1, 0, 'C');
$TopY += 6;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40, 6, "Quote #", 1, 0, 'R');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, $TopY);
$pdf->Cell(40, 6, $Client['client_short'] . "-Q-" . sprintf("%03d", $NextInvNum), 1, 0, 'C');

$TopY = 40;
$pdf->SetXY(15, $TopY);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50, 5, "Client:");
$pdf->SetFont('Arial','',8);
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 5, $Client['clientname']);

$Address = explode(";", $Client['client_address']);
$TopY += 5;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, trim($Address[0]), 0, 0);
$TopY += 5;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, trim($Address[1]), 0, 0);
$TopY += 5;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, trim($Address[2]), 0, 0);
$TopY += 5;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, "Reg No. " . $Client['client_reg'], 0, 0);
$TopY += 5;
$pdf->SetXY(15, $TopY);
$pdf->Cell(50, 6, "VAT No. " . $Client['client_vat'], 0, 0);
$TopY += 10;
$SubTotal = 0;
$ItemArr = array();
foreach($Tasks AS $TaskID => $Task)
{
	// $Proj = ($Task['project_id'] > 0) ? $Projs[$Task['project_id']]['project_name'] : "";
	// $Sect = ($Task['section_id'] > 0) ? $Sections[$Task['section_id']]['section_name'] : "";
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(130, 6, "Task", 1, 0, 'C');
	$pdf->Cell(50, 6, "Department", 1, 0, 'C');
	// $pdf->Cell(20, 6, "Project", 1, 0, 'C');
	// $pdf->Cell(30, 6, "Section", 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(130, 6, $Task['task_name'], 1, 0, 'L');
	$pdf->Cell(50, 6, $Depts[$Task['department_id']]['departmentname'], 1, 0, 'C');
	// $pdf->Cell(20, 6, $Proj, 1, 0, 'C');
	// $pdf->Cell(30, 6, $Sect, 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(15, $TopY);
	$pdf->Cell(110, 6, "Item", 1, 0, 'C');
	$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
	$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
	$pdf->Cell(30, 6, "Total", 1, 0, 'C');
	$TopY += 6;
	$pdf->SetFont('Arial','',8);
	foreach($BOQItems[$TaskID] AS $ItemID => $ItemRec)
	{
		if($ItemRec['estimated'] > 0)
		{
			$ItemArr[$ItemID] = $ItemID;
			$LineTotal = $ItemRec['estimated'] * $BOQLines[$ItemID]['defaultcost'];
			$SubTotal += $LineTotal;
			$pdf->SetXY(15, $TopY);
			$pdf->Cell(110, 6, $BOQLines[$ItemID]['item_name'], 1, 0, 'L');
			$pdf->Cell(20, 6, $ItemRec['estimated'], 1, 0, 'C');
			$pdf->Cell(20, 6, $BOQLines[$ItemID]['defaultcost'], 1, 0, 'C');
			$pdf->Cell(30, 6, sprintf("R %0.2f", $LineTotal), 1, 0, 'C');
			$TopY += 6;
			if($TopY > 260)
			{
				$pdf->AddPage('P');
				$TopY = 30;
				$pdf->SetFont('Arial','B',9);
				$pdf->SetXY(15, $TopY);
				$pdf->Cell(110, 6, "Item", 1, 0, 'C');
				$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
				$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
				$pdf->Cell(30, 6, "Total", 1, 0, 'C');
				$TopY += 6;
				$pdf->SetFont('Arial','',8);
			}
		}
	}
}
$pdf->SetFont('Arial','',8);
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Bank: Bank", 0, 0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20, 6, "Subtotal", 1, 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30, 6, sprintf("R %0.2f", $SubTotal), 1, 0, 'C');
$WithVat = $SubTotal * VATCALC;
$VatOnly = $WithVat - $SubTotal;
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Account Num: 123456789", 0, 0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20, 6, VATDISP . "% Vat", 1, 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30, 6, sprintf("R %0.2f", $VatOnly), 1, 0, 'C');
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(130, 6, "Branch Code: 123456", 0, 0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20, 6, "Total", 1, 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30, 6, sprintf("R %0.2f", $WithVat), 1, 0, 'C');

$OutPutType = 'F';
// $OutPutType = 'I';
$pdf->Output($FileName, $OutPutType);

$SaveArr = array();
$SaveArr['client_id'] = $ClientID;
$SaveArr['quote_number'] = $NextInvNum;
$SaveArr['quote_subtotal'] = $SubTotal;
$SaveArr['quote_vattotal'] = $VatOnly;
$SaveArr['quote_total'] = $WithVat;
$SaveArr['file_path'] = $FileName;
$SaveArr['quote_name'] = $QuoteName;
$QuoteID = addQuote($SaveArr);
unset($pdf);
// header("Location: editclient.php?cid=" . $ClientID);
header("Location: " . $FileName);
?>