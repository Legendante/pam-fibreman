<?php
include_once("db.inc.php");
$PointID = pebkac($_POST['typeID']);
$SaveArr = array();
$SaveArr['type_name'] = pebkac($_POST['typeName'], 50, 'STRING');
if($PointID == 0)
	addMapPointType($SaveArr);
else
	updateMapPointType($PointID, $SaveArr);
header("Location: mappointtypes.php");
?>