<?php
session_start();
include_once("db.inc.php");
$PrjID = pebkac($_POST['prjID']);
$SaveArr = array();
$SaveArr['project_name'] = pebkac($_POST['prjName'], 50, 'STRING');
$SaveArr['client_id'] = pebkac($_POST['prjClient']);
$SaveArr['actual_start_date'] = pebkac($_POST['prjstart'], 10, 'STRING');
$SaveArr['actual_end_date'] = pebkac($_POST['prjend'], 10, 'STRING');

if($PrjID == 0)
	addProject($SaveArr);
else
	updateProject($PrjID, $SaveArr);
$SavePath = 'uploads/projects/' . $PrjID;
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
		$SaveArr['project_id'] = $PrjID;
		$SaveArr['filename'] = $FileName;
		$SaveArr['filepath'] = $SavePath . "/" . $FileName;
		addProjectFile($SaveArr);
	}
}
header("Location: projects.php");
?>