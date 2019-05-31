<?php
session_start();
include_once("db.inc.php");
$SecID = pebkac($_POST['secID']);
$PrjID = pebkac($_POST['prjID']);
$SaveArr = array();
$SaveArr['section_name'] = pebkac($_POST['secName'], 50, 'STRING');
$SaveArr['project_id'] = $PrjID;
if($SecID == 0)
	addProjectSection($SaveArr);
else
	updateProjectSection($SecID, $SaveArr);
$SavePath = 'uploads/sections/' . $SecID;
if(!file_exists($SavePath))
{
	if(!mkdir($SavePath))
	{
		logDBError("Failed to create file directory", $SavePath, __FILE__, __FUNCTION__, __LINE__);
		return FALSE;
	}
	else
		file_put_contents($SavePath . "/index.html", "");
}
if(isset($_FILES['prjfile']))
{
	$UplFileName = pebkac($_FILES['prjfile']['name'], 100, 'STRING');
	$FileName = date("d_m_y") . "_" . $UplFileName;
	$FileName = cleanFileName($FileName);
	if(move_uploaded_file($_FILES['prjfile']['tmp_name'], $SavePath . "/" . $FileName))
	{
		$SaveArr = array();
		$SaveArr['userid'] = $_SESSION['userid'];
		$SaveArr['section_id'] = $SecID;
		$SaveArr['filename'] = $FileName;
		$SaveArr['filepath'] = $SavePath . "/" . $FileName;
		addSectionFile($SaveArr);
	}
}
header("Location: project_sections.php?p=" . $PrjID);
?>