<?php
session_start();
include_once("db.inc.php");

$OldVal = pebkac($_GET['o']);
$NewVal = pebkac($_GET['n']);
updateBOQCategorySort($OldVal, $NewVal);
header("Location: boqitems.php");
?>