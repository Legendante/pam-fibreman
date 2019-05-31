<?php
include("db.inc.php");

$TaskID = (isset($_GET['t'])) ? pebkac($_GET['t']) : 0;
$Task = getTaskByID($TaskID);
$Maint = getAccessBuildByTaskID($TaskID);
$TPLocations = getTPLocations();
$IFMethods = getInfrastructureMethods();
$UnitID = $Maint['unitid'];
$Unit = getComplexeUnitByUnitID($UnitID);
$ComplexID = $Unit['complexid'];
$Complex = getComplexByID($ComplexID);
$Templates = getBOQTemplates();
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$BOQItems = getTaskBOQItems($TaskID);
$TaskStatusses = getTaskStatusses();
$FileTypes = getTaskFileTypes();
$TaskFiles = getTaskFiles($TaskID);
$ChkGrp = getTaskCheckGroupByName("Access Builds");
$TPType = getTaskCheckTypeByName($ChkGrp['id'], "TP");
$PMType = getTaskCheckTypeByName($ChkGrp['id'], "Power Meter Reading");
$DBType = getTaskCheckTypeByName($ChkGrp['id'], "Dome/Coiling/CC - Before");
$DAType = getTaskCheckTypeByName($ChkGrp['id'], "Dome/Coiling/CC - After");
$SBType = getTaskCheckTypeByName($ChkGrp['id'], "Dome Splice/Tray/Label - Before");
$SAType = getTaskCheckTypeByName($ChkGrp['id'], "Dome Splice/Tray/Label - After");
$CBType = getTaskCheckTypeByName($ChkGrp['id'], "Distribution Cabinet - Before");
$CAType = getTaskCheckTypeByName($ChkGrp['id'], "Distribution Cabinet - After");

$TPPath = "";
$PMPath = "";
$DBPath = "";
$DAPath = "";
$SBPath = "";
$SAPath = "";
$CBPath = "";
$CAPath = "";
foreach($TaskFiles AS $FileID => $File)
{
	if($File['check_id'] == $TPType['id'])
		$TPPath = $File['filepath'];
	if($File['check_id'] == $PMType['id'])
		$PMPath = $File['filepath'];
	if($File['check_id'] == $DBType['id'])
		$DBPath = $File['filepath'];
	if($File['check_id'] == $DAType['id'])
		$DAPath = $File['filepath'];
	if($File['check_id'] == $SBType['id'])
		$SBPath = $File['filepath'];
	if($File['check_id'] == $SAType['id'])
		$SAPath = $File['filepath'];
	if($File['check_id'] == $CBType['id'])
		$CBPath = $File['filepath'];
	if($File['check_id'] == $CAType['id'])
		$CAPath = $File['filepath'];
}
$FileName = $Task['task_name'] . '.MBA.' . date("Ymd") . '.xlsx';
require_once('PHPExcel.php');
$styleThinBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FF000000'),),),);
$styleThickBrownBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK,	'color' => array('argb' => 'FF993300'),),),);
$styleThickBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK,	'color' => array('argb' => 'FF000000'),),),);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Company");
$objPHPExcel->getProperties()->setLastModifiedBy("Company");
$objPHPExcel->getProperties()->setTitle($Task['task_name'] . " - MBA");
$objPHPExcel->getProperties()->setSubject($Task['task_name'] . " - MBA");
$objPHPExcel->getProperties()->setDescription("Access build approval for " . $Task['task_name'] . ". Generated by Company");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPActiveSheet = $objPHPExcel->getActiveSheet();
$objPHPActiveSheet->setTitle(substr($Task['task_name'] . " - MBA", 0, 31));
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Metrofibre logo');
$objDrawing->setDescription('Metrofibre logo');
$objDrawing->setPath('images/metrofibre.png');
// $newSize = resizeImage($objDrawing->getWidth(), $objDrawing->getHeight(), 150, 70);
$objDrawing->setWidth(100);
$objDrawing->setHeight(60);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPActiveSheet);
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Company logo');
$objDrawing->setDescription('Company logo');
$objDrawing->setPath('images/Logo.jpg');
// $newSize = resizeImage($objDrawing->getWidth(), $objDrawing->getHeight(), 150, 70);
$objDrawing->setWidth(120);
$objDrawing->setHeight(60);
$objDrawing->setCoordinates('G1');
$objDrawing->setWorksheet($objPHPActiveSheet);
unset($objDrawing);
// $objPHPActiveSheet->getRowDimension(6)->setRowHeight(30);
$objPHPActiveSheet->mergeCells('A4:I4');
$objPHPActiveSheet->getStyle('A4:I4')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPActiveSheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A4')->getFont()->setSize(14);
$objPHPActiveSheet->getStyle('A4')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A4', 'Access Build Approval');
$objPHPActiveSheet->mergeCells('A5:B5');
$objPHPActiveSheet->getStyle('A5:B5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPActiveSheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A5')->getFont()->setSize(14);
$objPHPActiveSheet->getStyle('A5')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A5', "Ticket");
$objPHPActiveSheet->mergeCells('C5:D5');
$objPHPActiveSheet->getStyle('C5:D5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('C5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPActiveSheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('C5')->getFont()->setSize(14);
$objPHPActiveSheet->getStyle('C5')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('C5', $Maint['ticketnumber']);
$objPHPActiveSheet->mergeCells('E5:I5');
$objPHPActiveSheet->getStyle('E5:I5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('E5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPActiveSheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('E5')->getFont()->setSize(14);
$objPHPActiveSheet->getStyle('E5')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('E5', $Task['task_name']);
$objPHPActiveSheet->getStyle('A6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A6')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A6', "Unit No:");
$objPHPActiveSheet->mergeCells('B6:C6');
$objPHPActiveSheet->getStyle('B6:C6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('B6', $Unit['unitname']);
$objPHPActiveSheet->getStyle('D6')->getFont()->setBold(true);
$objPHPActiveSheet->getStyle('D6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('D6', "Estate:");
$objPHPActiveSheet->mergeCells('E6:I6');
$objPHPActiveSheet->getStyle('E6:I6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('E6', $Complex['complexname']);
$objPHPActiveSheet->getStyle('A7')->getFont()->setBold(true);
$objPHPActiveSheet->getStyle('A7')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('A7', "Resident:");
$objPHPActiveSheet->mergeCells('B7:E7');
$objPHPActiveSheet->getStyle('B7:E7')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('B7', $Unit['firstname'] . " " . $Unit['lastname']);
$objPHPActiveSheet->getStyle('F7')->getFont()->setBold(true);
$objPHPActiveSheet->getStyle('F7')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('F7', "Number:");
$objPHPActiveSheet->mergeCells('G7:I7');
$objPHPActiveSheet->getStyle('G7:I7')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('G7', $Unit['cell']);
$objPHPActiveSheet->mergeCells('A9:C9');
$objPHPActiveSheet->getStyle('A9:C9')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A9')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A9', "Contractor:");
$objPHPActiveSheet->mergeCells('D9:F9');
$objPHPActiveSheet->getStyle('D9:F9')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('D9', "Company");
$objPHPActiveSheet->getStyle('G9')->getFont()->setBold(true);
$objPHPActiveSheet->getStyle('G9')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('G9', "Date:");
$objPHPActiveSheet->mergeCells('H9:I9');
$objPHPActiveSheet->getStyle('H9:I9')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('H9', date("d M Y", strtotime($Task['actual_start_date'])));
$objPHPActiveSheet->mergeCells('A10:C10');
$objPHPActiveSheet->getStyle('A10:C10')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A10')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A10', "Repair resolved?");
$objPHPActiveSheet->mergeCells('D10:F10');
$objPHPActiveSheet->getStyle('D10:F10')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('D10')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('D10', "Location Of Termination Box");
$objPHPActiveSheet->mergeCells('G10:I10');
$objPHPActiveSheet->getStyle('G10:I10')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('G10')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('G10', "Infrastructure method");
$objPHPActiveSheet->mergeCells('A11:C11');
$objPHPActiveSheet->getStyle('A11:C11')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('A11', "Yes/No");
$objPHPActiveSheet->mergeCells('D11:F11');
$objPHPActiveSheet->getStyle('D11:F11')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$TPLoc = (isset($TPLocations[$Maint['tplocationid']]['location'])) ? $TPLocations[$Maint['tplocationid']]['location'] : "-";
$objPHPActiveSheet->setCellValue('D11', $TPLoc);
$objPHPActiveSheet->mergeCells('G11:I11');
$objPHPActiveSheet->getStyle('G11:I11')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$IFMeth = (isset($IFMethods[$Maint['infrastuctid']]['method'])) ? $IFMethods[$Maint['infrastuctid']]['method'] : "-";
$objPHPActiveSheet->setCellValue('G11', $IFMeth);
$objPHPActiveSheet->mergeCells('A13:B13');
$objPHPActiveSheet->getStyle('A13:B13')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A13')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A13', "Time on site");
$objPHPActiveSheet->mergeCells('C13:D13');
$objPHPActiveSheet->getStyle('C13:D13')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('C13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->setCellValue('C13', $Maint['timeonsite']);
$objPHPActiveSheet->mergeCells('E13:G13');
$objPHPActiveSheet->getStyle('E13:G13')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('E13')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('E13', "Customer Negligence");
$objPHPActiveSheet->mergeCells('H13:I13');
$objPHPActiveSheet->getStyle('H13:I13')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('H13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
if($Maint['wascustomerneglect'] == 1)
	$objPHPActiveSheet->setCellValue('H13', "Yes");
else
	$objPHPActiveSheet->setCellValue('H13', "No");
$objPHPActiveSheet->mergeCells('A14:B14');
$objPHPActiveSheet->getStyle('A14:B14')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A14')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A14', "Fault:");
$objPHPActiveSheet->mergeCells('C14:I14');
$objPHPActiveSheet->getStyle('C14:I14')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('C14', $Maint['faultdesc']);
$objPHPActiveSheet->mergeCells('A15:B15');
$objPHPActiveSheet->getStyle('A15:B15')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A15')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A15', "Solution:");
$objPHPActiveSheet->mergeCells('C15:I15');
$objPHPActiveSheet->getStyle('C15:I15')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->setCellValue('C15', $Maint['solutiondesc']);

$objPHPActiveSheet->mergeCells('A17:I17');
$objPHPActiveSheet->getStyle('A17:I17')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A17')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A17', "PHOTOS");

$objPHPActiveSheet->mergeCells('A18:D18');
$objPHPActiveSheet->getStyle('A18:D18')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A18')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A18', "Termination Point");

$objPHPActiveSheet->mergeCells('F18:I18');
$objPHPActiveSheet->getStyle('F18:I18')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('F18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('F18')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('F18', "Power Meter Reading");

$objPHPActiveSheet->mergeCells('A19:D35');
$objPHPActiveSheet->getStyle('A19:D35')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->mergeCells('F19:I35');
$objPHPActiveSheet->getStyle('F19:I35')->applyFromArray($styleThinBlackBorderOutline);

$objPHPActiveSheet->mergeCells('A37:D37');
$objPHPActiveSheet->getStyle('A37:D37')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A37')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A37')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A37', "Dome/Coiling/CC - Before");

$objPHPActiveSheet->mergeCells('F37:I37');
$objPHPActiveSheet->getStyle('F37:I37')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('F37')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('F37')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('F37', "Dome/Coiling/CC - After");

$objPHPActiveSheet->mergeCells('A38:D54');
$objPHPActiveSheet->getStyle('A38:D54')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->mergeCells('F38:I54');
$objPHPActiveSheet->getStyle('F38:I54')->applyFromArray($styleThinBlackBorderOutline);

$objPHPActiveSheet->mergeCells('A56:D56');
$objPHPActiveSheet->getStyle('A56:D56')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A56')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A56', "Dome Splice/Tray/Label - Before");

$objPHPActiveSheet->mergeCells('F56:I56');
$objPHPActiveSheet->getStyle('F56:I56')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('F56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('F56')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('F56', "Dome Splice/Tray/Label - After");

$objPHPActiveSheet->mergeCells('A57:D73');
$objPHPActiveSheet->getStyle('A57:D73')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->mergeCells('F57:I73');
$objPHPActiveSheet->getStyle('F57:I73')->applyFromArray($styleThinBlackBorderOutline);

$objPHPActiveSheet->mergeCells('A75:D75');
$objPHPActiveSheet->getStyle('A75:D75')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('A75')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('A75')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('A75', "Distribution Cabinet - Before");

$objPHPActiveSheet->mergeCells('F75:I75');
$objPHPActiveSheet->getStyle('F75:I75')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->getStyle('F75')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPActiveSheet->getStyle('F75')->getFont()->setBold(true);
$objPHPActiveSheet->setCellValue('F75', "Distribution Cabinet - After");

$objPHPActiveSheet->mergeCells('A76:D92');
$objPHPActiveSheet->getStyle('A76:D92')->applyFromArray($styleThinBlackBorderOutline);
$objPHPActiveSheet->mergeCells('F76:I92');
$objPHPActiveSheet->getStyle('F76:I92')->applyFromArray($styleThinBlackBorderOutline);

if($TPPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('TP Photo');
	$objDrawing->setDescription('TP Photo');
	$objDrawing->setPath($TPPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('A19');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($PMPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Power Meter Photo');
	$objDrawing->setDescription('Power Meter Photo');
	$objDrawing->setPath($PMPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('F19');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($DBPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($DBPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('A38');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($DAPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($DAPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('F38');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($SBPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($SBPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('A57');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($SAPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($SAPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('F57');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($CBPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($CBPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('A76');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
if($CAPath != "")
{
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Photo');
	$objDrawing->setDescription('Photo');
	$objDrawing->setPath($CAPath);
	$objDrawing->setWidth(255);
	$objDrawing->setCoordinates('F76');
	$objDrawing->setWorksheet($objPHPActiveSheet);
	unset($objDrawing);
}
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $FileName . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
$objPHPExcel->disconnectWorksheets(); // Disconnect before you unset to properly clear the memory
unset($objPHPExcel);
unset($objWriter);
?>