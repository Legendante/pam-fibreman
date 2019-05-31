<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$ProjID = pebkac($_GET['p']);
$SectionID = pebkac($_GET['s']);
$SaveArr['id'] = $SectionID * -1;
saveSpliceSection($SectionID, $SaveArr);
header("Location: editspliceproject.php?pid=" . $ProjID);
?>