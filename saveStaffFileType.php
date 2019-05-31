<?php
session_start();
include_once("db.inc.php");
$TypeID = pebkac($_POST['TypeID']);
$SaveArr = array();
$SaveArr['typename'] = pebkac($_POST['typeName'], 50, 'STRING');
if($TypeID == 0)
	addStaffFileType($SaveArr);
else
	saveStaffFileType($TypeID, $SaveArr);
header("Location: stafffiletypes.php");
?>