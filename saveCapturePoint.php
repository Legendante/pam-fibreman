<?php
session_start();
include_once("db.inc.php");
$MFields = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 4) == 'ans_')
	{
		$ID = substr($Key, 4);
		if(is_array($Val))
			$MFields[$ID] = implode("_", $Val);
		else
			$MFields[$ID] = $Val;
	}
}
$PointID = pebkac($_POST['PointID']);
$MapID = pebkac($_POST['MapID']);
$SaveArr = array();
$SaveArr['point_name'] = pebkac($_POST['pointName'], 50, 'STRING');
$SaveArr['type_id'] = pebkac($_POST['TypeID']);
$SaveArr['map_id'] = pebkac($_POST['MapID']);
$SaveArr['lat'] = pebkac($_POST['lat'], 11, 'STRING');
$SaveArr['lon'] = pebkac($_POST['lon'], 11, 'STRING');
$SaveArr['acc'] = pebkac($_POST['acc']);
if($PointID == 0)
	$PointID = addMapPoint($SaveArr);
else
	updateMapPoint($PointID, $SaveArr);

$SaveArr = array();
$SaveArr['point_id'] = $PointID;
foreach($MFields AS $FieldID => $FieldVal)
{
	$SaveArr['question_id'] = $FieldID;
	$SaveArr['question_val'] = $FieldVal;
	addMapPointValue($SaveArr);
}
header("Location: mappoints.php?m=" . $MapID);
?>