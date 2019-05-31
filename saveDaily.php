<?php
session_start();
include_once("db.inc.php");
$ProjID = pebkac($_POST['proj_id']);
$SectionID = pebkac($_POST['section_id']);
$JoinID = pebkac($_POST['join_id']);
$NumSplices = pebkac($_POST['numspliced']);
$NumDomes = pebkac($_POST['numdomes']);

$insQry = 'UPDATE core_splice_diary SET join_id = join_id * -1 WHERE theday = "' . date("Y-m-d") . '" AND userid = ' . $_SESSION['userid'] . ' AND join_id = ' . $JoinID;
$insRes = mysqli_query($dbCon, $insQry) or logDBError(mysqli_error($dbCon), $insQry, __FILE__, __FUNCTION__, __LINE__);

$insQry = 'INSERT INTO core_splice_diary(theday, userid, project_id, section_id, join_id, num_splices_completed, num_domes_completed) VALUES ';
$insQry .= '("' . date("Y-m-d") . '", "' . $_SESSION['userid'] . '", "' . $ProjID . '", "' . $SectionID . '", "' . $JoinID . '", "' . $NumSplices . '", "' . $NumDomes . '")';
$insRes = mysqli_query($dbCon, $insQry) or logDBError(mysqli_error($dbCon), $insQry, __FILE__, __FUNCTION__, __LINE__);
header("Location: infield.php");
?>