<?php
session_start();
include("db.inc.php");
$StaffID = (isset($_POST['sid'])) ? pebkac($_POST['sid']) : 0;
if($StaffID > 0)
{
	$SavePath = 'uploads/staff/' . $StaffID;
	if(!file_exists($SavePath))
	{
		if(!mkdir($SavePath))
		{
			logDBError("Failed to create staff file directory", $SavePath, __FILE__, __FUNCTION__, __LINE__);
			return FALSE;
		}
		else
			file_put_contents($SavePath . "/index.html", "");
	}
	foreach($_FILES AS $FileN => $FileRec)
	{
		$SaveArr = array();
		$UplFileName = pebkac($FileRec['name'], 100, 'STRING');
		$FileName = date("d_m_y") . "_" . $UplFileName;
		$FileName = cleanFileName($FileName);
		$SaveArr['filename'] = $FileName;
		$SaveArr['filepath'] = $SavePath . "/" . $FileName;
		$FileType = substr($FileN, 10);
		$SaveArr['filetype_id'] = $FileType;
		$SaveArr['staff_id'] = $StaffID;
		$SaveArr['expiry_date'] = pebkac($_POST['staffFile_exp_' . $FileType], 10, 'STRING');
		if(move_uploaded_file($FileRec['tmp_name'], $SavePath . "/" . $FileName))
		{	
			addStaffMemberFile($SaveArr);
		}
	}
}
header("Location: editstaff.php?sid=" . $StaffID);
?>