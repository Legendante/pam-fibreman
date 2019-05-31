<?php
include_once("db.inc.php");
$ClientID = pebkac($_POST['clientID']);
$SaveVals = array();
foreach($_POST AS $Key => $Val)
{
	if((substr($Key, 0, 5) == 'cost_') && (trim($Val) != ''))
	{
		$ID = substr($Key, 5);
		$SaveVals[$ID] = $Val;
	}
}
// print_r($_POST);
// print_r($SaveVals);
// exit();
foreach($SaveVals AS $ItemID => $Cost)
{
	addBOQItemClientCost($ClientID, $ItemID, $Cost);
}
header("Location: boqclientcost.php?c=" . $ClientID);
?>