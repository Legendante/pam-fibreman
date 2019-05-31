<?php
include_once("db.inc.php");
$ItemID = pebkac($_POST['itemID']);
$SaveArr = array();
$SaveArr['item_name'] = pebkac($_POST['itemName'], 50, 'STRING');
$SaveArr['unitid'] = pebkac($_POST['itemUnit']);
$SaveArr['categoryid'] = pebkac($_POST['itemCat']);
$SaveArr['defaultcost'] = pebkac($_POST['itemCost'], 8, 'STRING');
if($ItemID == 0)
	addBOQLineItem($SaveArr);
else
	updateBOQLineItem($ItemID, $SaveArr);
header("Location: boqitems.php");
?>