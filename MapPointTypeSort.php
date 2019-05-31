<?php
session_start();
include_once("db.inc.php");

$OldVal = pebkac($_GET['o']);
$NewVal = pebkac($_GET['n']);
updateMapPointTypeSort($OldVal, $NewVal);
header("Location: mappointtypes.php");
?>