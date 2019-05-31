<?php
session_start();
include_once("db.inc.php");
$OldVal = pebkac($_GET['o']);
$NewVal = pebkac($_GET['n']);
updateStaffFileTypeSort($OldVal, $NewVal);
header("Location: stafffiletypes.php");
?>