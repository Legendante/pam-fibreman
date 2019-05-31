<?php
session_start();
include("db.inc.php");
$JoinID = (isset($_POST['jid'])) ? pebkac($_POST['jid']) : 0;
$CheckID = (isset($_POST['cid'])) ? pebkac($_POST['cid']) : 0;
$PhotoNote = (isset($_POST['photonote'])) ? pebkac($_POST['photonote'], 1000, 'STRING') : '';
$UplFileName = pebkac($_FILES['phonePhoto']['name'], 100, 'STRING');

$Lat = (isset($_POST['lat'])) ? pebkac($_POST['lat']) : 0;
$Lon = (isset($_POST['lon'])) ? pebkac($_POST['lon']) : 0;
$Acc = (isset($_POST['acc'])) ? pebkac($_POST['acc']) : 0;

$SaveArr = array();
$SaveArr['userid'] = $_SESSION['userid'];
$SaveArr['join_id'] = $JoinID;
$SaveArr['check_id'] = $CheckID;
$SaveArr['lat'] = $Lat;
$SaveArr['lon'] = $Lon;
$SaveArr['acc'] = $Acc;
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
$FileName = date("d_m_y") . "_" . $UplFileName;
$FileName = cleanFileName($FileName);
$SaveArr['photopath'] = $SavePath . "/" . $FileName;
$SaveArr['thumbnail'] = $SavePath . "/sml_" . $FileName;
//ImageResize(250, 100, $_FILES['phonePhoto'], $SaveArr['thumbnail']);
$PhotoID = 0;
if(move_uploaded_file($_FILES['phonePhoto']['tmp_name'], $SavePath . "/" . $FileName))
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
header("Location: infield.php");
// header("Location: infield.php" . $_SESSION['photofrom']);
?>