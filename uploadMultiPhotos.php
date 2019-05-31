<?php
session_start();
include("db.inc.php");
$ProjID = (isset($_POST['pid'])) ? pebkac($_POST['pid']) : 0;
$SectionID = (isset($_POST['sid'])) ? pebkac($_POST['sid']) : 0;
$JoinID = (isset($_POST['jid'])) ? pebkac($_POST['jid']) : 0;
// $CheckID = (isset($_POST['checkid'])) ? pebkac($_POST['checkid']) : 0;
$PhotoNote = (isset($_POST['photonote'])) ? pebkac($_POST['photonote'], 1000, 'STRING') : '';
$SaveArr = array();
$SaveArr['userid'] = $_SESSION['userid'];
$SaveArr['join_id'] = $JoinID;
$SavePath = 'uploads/joins/' . $JoinID;
if(!file_exists($SavePath))
{
	if(!mkdir($SavePath))
	{
		logDBError("Failed to create photo directory", $SavePath, __FILE__, __FUNCTION__, __LINE__);
		return FALSE;
	}
	else
		file_put_contents($SavePath . "/index.html", "");
}
foreach($_FILES AS $FileN => $FileRec)
{
	$Ind = substr($FileN, 11);
	$UplFileName = pebkac($FileRec['name'], 100, 'STRING');
	if($UplFileName != '')
	{
		$FileName = date("d_m_y") . "_" . $UplFileName;
		$FileName = cleanFileName($FileName);
		$SaveArr['photopath'] = $SavePath . "/" . $FileName;
		$SaveArr['thumbnail'] = $SavePath . "/sml_" . $FileName;
		$CheckID = (isset($_POST['checkid_' . $Ind])) ? pebkac($_POST['checkid_' . $Ind]) : 0;
		$SaveArr['check_id'] = $CheckID;
		if(move_uploaded_file($FileRec['tmp_name'], $SavePath . "/" . $FileName))
		{	
			$thumb = new Imagick($SavePath . "/" . $FileName);
			$thumb->resizeImage(320,240,Imagick::FILTER_LANCZOS,1);
			$thumb->writeImage($SaveArr['thumbnail']);
			$PhotoID = addSpliceJoinPhoto($SaveArr);
			if($PhotoNote != '')
			{
				$NoteArr = array();
				$NoteArr['photoid'] = $PhotoID;
				$NoteArr['noteval'] = $PhotoNote;
				addSpliceJoinPhotoNote($NoteArr);
			}
		}
	}
}
header("Location: joinPhotos.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "");
?>