<?php
session_start();
include_once("db.inc.php");

$CatID = pebkac($_POST['CatID']);
$SaveArr = array();
$SaveArr['categoryname'] = pebkac($_POST['catName'], 50, 'STRING');

if($CatID == 0)
	$CatID = addBOQCategory($SaveArr);
else
	updateBOQCategory($CatID, $SaveArr);
header("Location: boqitems.php");
?>