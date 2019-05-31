<?php
include_once("db.inc.php");
$TemplateID = pebkac($_POST['templateID']);
$SaveVals = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 3) == 'it_')
		$SaveVals[$Val] = $Val;
}
// print_r($_POST);
// print_r($SaveVals);
// exit();
clearBOQTemplateItems($TemplateID);
foreach($SaveVals AS $ID)
{
	$SaveArr = array();
	$SaveArr['templateid'] = $TemplateID;
	$SaveArr['item_id'] = $ID;
	addBOQTemplateItem($SaveArr);
}
header("Location: boqtemplateitems.php?t=" . $TemplateID);
?>