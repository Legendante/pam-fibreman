<?php
include("db.inc.php");
$TaskID = pebkac($_POST['t']);
$LineID = pebkac($_POST['l']);
deleteTaskBOQItem($TaskID, $LineID, $_SESSION['userid']);
?>