<?php
session_start();
include_once("db.inc.php");
define('FPDF_FONTPATH','font/');
require('fpdf.php');

$InvID = pebkac($_GET['iid']);
$Invoice = getClientInvoiceByID($InvID);
$ClientID = $Invoice['client_id'];
$Client = getClientByID($ClientID);
$InvNum = $Invoice['inv_number'];
$PurchaseOrders = getClientPurchaseOrders($ClientID);
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

$InvItems = getInvoiceItemsByInvoiceID($InvID);
foreach($InvItems AS $RowID => $RowItem)
{
	$PostJoins[$RowItem['join_id']] = $RowItem['join_id'];
	$ProjRec[$RowItem['project_id']] = $RowItem['project_id'];
	$SecRec[$RowItem['section_id']] = $RowItem['section_id'];
	$InvReadyPrj[$RowItem['join_id']] = getSpliceSectionJoinByJoinID($RowItem['join_id']);
}
$DiaryCnts = getSpliceDiaryJoinTotals(implode(",", $PostJoins));
$Projects = array();
$Sections = array();
$Joins = array();
foreach($ProjRec AS $ProjectID)
{
	$Projects[$ProjectID] = getSpliceProjectByID($ProjectID);
	$Joins[$ProjectID] = getSpliceJoinsByProjectID($ProjectID);
}
foreach($SecRec AS $SectionID)
{
	$Sections[$SectionID] = getSpliceSectionByID($SectionID);
}

$FileName = 'uploads/accounting/invoices/Company.Invoice.Regen.' . $Client['client_short'] . sprintf("%03d", $InvNum) . '.' . date("Ymd", strtotime($Invoice['logtime'])) . '.pdf';

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
$pdf->Cell(100, 8, "TAX INVOICE", 1, 0, 'C');
$TopY += 8;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Invoice Date", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, date("d M Y", strtotime($Invoice['logtime'])), 1, 0, 'C');
$pdf->SetFont('Arial','B',11);
$TopY += 6;
$pdf->SetXY(100, $TopY);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 6, "Invoice #", 1, 0, 'R');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(150, $TopY);
$pdf->Cell(50, 6, $Client['client_short'] . sprintf("%03d", $InvNum), 1, 0, 'C');
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
$pdf->Cell(80, 6, "Item", 1, 0, 'C');
$pdf->Cell(20, 6, "PO Num", 1, 0, 'C');
$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
$pdf->Cell(30, 6, "Total", 1, 0, 'C');
$TopY += 6;
$pdf->SetFont('Arial','',10);
$SubTotal = 0;
$PrevPrj = 0;
$PrevSec = 0;
$ItemArr = array();

foreach($ProjRec AS $ProjID)
{
	foreach($SecRec AS $SecID)
	{
		if($Sections[$SecID]['project_id'] == $ProjID)
		{
			foreach($InvReadyPrj AS $JoinID => $JoinRec)
			{
				if(($JoinRec['project_id'] == $ProjID) && ($JoinRec['section_id'] == $SecID))
				{
					$SpliceComp = ((isset($DiaryCnts[$JoinID])) && ($DiaryCnts[$JoinID]['splice_compl'] > 0)) ? 1 : 0;
					$DomesComp = ((isset($DiaryCnts[$JoinID])) && ($DiaryCnts[$JoinID]['dome_compl'] > 0)) ? 1 : 0;
					if(($SpliceComp > 0) || ($DomesComp > 0))
					{
						if($PrevPrj != $ProjID)
						{
							if(!isset($ItemArr[$ProjID]))
								$ItemArr[$ProjID] = array();
							$PrevPrj = $ProjID;
							$pdf->SetXY(15, $TopY);
							$pdf->Cell(170, 6, $Projects[$ProjID]['project_name'], 1, 0, 'L');
							$TopY += 6;
						}
						if($PrevSec != $SecID)
						{
							if(!isset($ItemArr[$ProjID][$SecID]))
								$ItemArr[$ProjID][$SecID] = array();
							$PrevSec = $SecID;
							$pdf->SetXY(15, $TopY);
							$pdf->Cell(170, 6, $Sections[$SecID]['section_name'], 1, 0, 'L');
							$TopY += 6;
							
						}
						if($TopY > 260)
						{
							$pdf->AddPage('P');
							$TopY = 30;
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(15, $TopY);
							$pdf->Cell(80, 6, "Item", 1, 0, 'C');
							$pdf->Cell(20, 6, "PO Num", 1, 0, 'C');
							$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
							$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
							$pdf->Cell(30, 6, "Total", 1, 0, 'C');
							$TopY += 6;
							$pdf->SetFont('Arial','',10);
						}
					}
					if($SpliceComp > 0)
					{
						if(!isset($ItemArr[$ProjID][$SecID][$JoinID]))
							$ItemArr[$ProjID][$SecID][$JoinID] = $JoinID;
						// $PO_Num = (isset($JoinRec['po_number'])) ? $JoinRec['po_number'] : '';
						$PO_Num = (isset($PurchaseOrders[$JoinRec['po_id']]['po_number'])) ? $PurchaseOrders[$JoinRec['po_id']]['po_number'] : '';
						$pdf->SetXY(15, $TopY);
						$pdf->Cell(80, 6, "  " . $JoinRec['join_name'] . " : Splices", 1, 0, 'L');
						$pdf->Cell(20, 6, $PO_Num, 1, 0, 'L');
						$pdf->Cell(20, 6, $DiaryCnts[$JoinID]['splice_compl'], 1, 0, 'C');
						$pdf->Cell(20, 6, "R 85.00", 1, 0, 'C');
						$pdf->Cell(30, 6, sprintf("R %0.2f", ($DiaryCnts[$JoinID]['splice_compl'] * 85)), 1, 0, 'C');
						$SubTotal += ($DiaryCnts[$JoinID]['splice_compl'] * 85);
						$TopY += 6;
						if($TopY > 260)
						{
							$pdf->AddPage('P');
							$TopY = 30;
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(15, $TopY);
							$pdf->Cell(80, 6, "Item", 1, 0, 'C');
							$pdf->Cell(20, 6, "PO Num", 1, 0, 'C');
							$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
							$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
							$pdf->Cell(30, 6, "Total", 1, 0, 'C');
							$TopY += 6;
							$pdf->SetFont('Arial','',10);
						}
					}
					if($DomesComp > 0)
					{
						if(!isset($ItemArr[$ProjID][$SecID][$JoinID]))
							$ItemArr[$ProjID][$SecID][$JoinID] = $JoinID;
						// $PO_Num = (isset($JoinRec['po_number'])) ? $JoinRec['po_number'] : '';
						$PO_Num = (isset($PurchaseOrders[$JoinRec['po_id']]['po_number'])) ? $PurchaseOrders[$JoinRec['po_id']]['po_number'] : '';
						$pdf->SetXY(15, $TopY);
						$pdf->Cell(80, 6, "  " . $JoinRec['join_name'] . " : Dome Preparation", 1, 0, 'L');
						$pdf->Cell(20, 6, $PO_Num, 1, 0, 'L');
						$pdf->Cell(20, 6, $DiaryCnts[$JoinID]['dome_compl'], 1, 0, 'C');
						$pdf->Cell(20, 6, "R 500.00", 1, 0, 'C');
						$pdf->Cell(30, 6, sprintf("R %0.2f", ($DiaryCnts[$JoinID]['dome_compl'] * 500)), 1, 0, 'C');
						$SubTotal += ($DiaryCnts[$JoinID]['dome_compl'] * 500);
						$TopY += 6;
						if($TopY > 260)
						{
							$pdf->AddPage('P');
							$TopY = 30;
							$pdf->SetFont('Arial','B',10);
							$pdf->SetXY(15, $TopY);
							$pdf->Cell(80, 6, "Item", 1, 0, 'C');
							$pdf->Cell(20, 6, "PO Num", 1, 0, 'C');
							$pdf->Cell(20, 6, "Quantity", 1, 0, 'C');
							$pdf->Cell(20, 6, "Item Cost", 1, 0, 'C');
							$pdf->Cell(30, 6, "Total", 1, 0, 'C');
							$TopY += 6;
							$pdf->SetFont('Arial','',10);
						}
					}
					$SaveArr = array();
					$SaveArr['join_status'] = 3;
					saveSpliceSectionJoin($JoinID, $SaveArr);
				}
			}
		}
	}
}
$pdf->SetXY(15, $TopY);
$pdf->Cell(120, 6, "Bank: Bank", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, "Subtotal", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $SubTotal), 1, 0, 'C');
$WithVat = $SubTotal * 1.14;
$VatOnly = $WithVat - $SubTotal;
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(120, 6, "Account Num: 123456789", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, "14% Vat", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $VatOnly), 1, 0, 'C');
$TopY += 6;
$pdf->SetXY(15, $TopY);
$pdf->Cell(120, 6, "Branch Code: 123456", 0, 0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 6, "Total", 1, 0, 'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30, 6, sprintf("R %0.2f", $WithVat), 1, 0, 'C');

// $OutPutType = 'F';
$OutPutType = 'I';
// $pdf->Output($FileName, $OutPutType);
$pdf->Output($FileName, $OutPutType);
unset($pdf);
?>