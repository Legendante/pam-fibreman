<?php
session_start();
include_once("db.inc.php");
$TypeID = pebkac($_GET['t']);
$OldVal = pebkac($_GET['o']);
$NewVal = pebkac($_GET['n']);
updateMapPointQuestionSort($TypeID, $OldVal, $NewVal);
header("Location: mappointtypequestions.php?t=" . $TypeID);
?>