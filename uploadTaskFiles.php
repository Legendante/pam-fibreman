<?php
session_start();
include("db.inc.php");
$TaskID = pebkac($_POST['TaskID']);
$TypeID = pebkac($_POST['TypeID']);
$FileNote = (isset($_POST['filenote'])) ? pebkac($_POST['filenote'], 1000, 'STRING') : '';
$FileTypes = getTaskFileTypes();
$HasThumbnail = $FileTypes[$TypeID]['has_thumbnail'];
$SaveArr = array();
$SaveArr['userid'] = $_SESSION['userid'];
$SaveArr['task_id'] = $TaskID;
$SaveArr['type_id'] = $TypeID;
$SavePath = 'uploads/task';
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
$SavePath = 'uploads/task/' . $TaskID;
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
$SavePath = 'uploads/task/' . $TaskID . '/' . $TypeID;
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
foreach($_FILES AS $FileN => $FileRec)
{
	$Ind = substr($FileN, 9);
	$UplFileName = pebkac($FileRec['name'], 100, 'STRING');
	if($UplFileName != '')
	{
		$FileName = date("d_m_y") . "_" . $UplFileName;
		$FileName = cleanFileName($FileName);
		$SaveArr['filepath'] = $SavePath . "/" . $FileName;
		if($HasThumbnail == 1)
			$SaveArr['thumbnail'] = $SavePath . "/sml_" . $FileName;
		$CheckID = (isset($_POST['checkid_' . $Ind])) ? pebkac($_POST['checkid_' . $Ind]) : 0;
		$SaveArr['check_id'] = $CheckID;
		// echo $SavePath . "/" . $FileName . "<br>";
		if(move_uploaded_file($FileRec['tmp_name'], $SavePath . "/" . $FileName))
		{	
			if($HasThumbnail == 1)
			{
				$thumb = new Imagick($SavePath . "/" . $FileName);
				$thumb->resizeImage(320,240,Imagick::FILTER_LANCZOS,1);
				$thumb->writeImage($SaveArr['thumbnail']);
			}
			// print_r($SaveArr);
			$FileID = addTaskFile($SaveArr);
			if($FileNote != '')
			{
				$NoteArr = array();
				$NoteArr['fileid'] = $FileID;
				$NoteArr['noteval'] = $FileNote;
				addTaskFileNote($NoteArr);
			}
		}
	}
}
header("Location: editTask.php?t=" . $TaskID);
?>