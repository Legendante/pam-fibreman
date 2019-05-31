<?php
session_start();
include("db.inc.php");
$TaskID = pebkac($_GET['t']);
$FileID = pebkac($_GET['f']);
$File = getTaskFileByID($FileID);

$NewBatch = $File['batch'] + 1;
$SaveArr = array();
$SaveArr['batch'] = $NewBatch;
updateTaskFile($FileID, $SaveArr);
header("Location: editTask.php?t=" . $TaskID);
?>