<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$ProjID = pebkac($_GET['p']);
$SectionID = pebkac($_GET['s']);
$JoinID = pebkac($_GET['j']);

$SaveArr['join_status'] = 2;
saveSpliceSectionJoin($JoinID, $SaveArr);
header("Location: editspliceproject.php?pid=" . $ProjID);
?>