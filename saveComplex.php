<?php
session_start();
include_once("db.inc.php");
$ComplexID = pebkac($_POST['ComplexID']);
$SaveArr = array();
$SaveArr['complexname'] = pebkac($_POST['ComplexName'], 100, 'STRING');
$SaveArr['numunits'] = pebkac($_POST['NumUnits'], 5, 'STRING');
$SaveArr['shortcode'] = pebkac($_POST['ShortCode'], 5, 'STRING');
$SaveArr['complexaddress1'] = pebkac($_POST['addie1'], 50, 'STRING');
$SaveArr['complexaddress2'] = pebkac($_POST['addie2'], 50, 'STRING');
$SaveArr['complexaddress3'] = pebkac($_POST['addie3'], 50, 'STRING');
$SaveArr['complexaddress4'] = pebkac($_POST['addie4'], 50, 'STRING');
$SaveArr['complexaddress5'] = pebkac($_POST['addie5'], 50, 'STRING');
$SaveArr['complexstatus'] = 0;
$SaveArr['clientid'] = pebkac($_POST['ClientID']);
$SaveArr['lat'] = pebkac($_POST['complat'], 10, 'STRING');
$SaveArr['lon'] = pebkac($_POST['complon'], 10, 'STRING');
if($ComplexID == 0)
	$ComplexID = addComplex($SaveArr);
else
	updateComplex($ComplexID, $SaveArr);
$SavePath = 'uploads/complexes';
if(isset($_FILES['compfile']))
{
	$UplFileName = pebkac($_FILES['compfile']['name'], 100, 'STRING');
	$FileName = date("d_m_y") . "_" . $UplFileName;
	$FileName = cleanFileName($FileName);
	if(move_uploaded_file($_FILES['compfile']['tmp_name'], $SavePath . "/" . $FileName))
	{
		$SaveArr = array();
		$SaveArr['userid'] = $_SESSION['userid'];
		$SaveArr['complex_id'] = $ComplexID;
		$SaveArr['filename'] = $FileName;
		$SaveArr['filepath'] = $SavePath . "/" . $FileName;
		addComplexFile($SaveArr);
	}
}
header("Location: complexDetails.php?c=" . $ComplexID);
?>