<?php
session_start();
include_once("db.inc.php");
$MapID = pebkac($_POST['MapID']);
$SaveArr = array();
$SaveArr['map_name'] = pebkac($_POST['mapName'], 50, 'STRING');

if($MapID == 0)
	$MapID = addMapDetails($SaveArr);
else
	updateMapDetails($MapID, $SaveArr);
header("Location: maps.php");
?>