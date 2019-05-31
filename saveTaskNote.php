<?php
session_start();
include_once("db.inc.php");
$TaskID = pebkac($_POST['NoteTaskID']);

$SaveArr = array();
$SaveArr['taskid'] = $TaskID;
$SaveArr['noteval'] = pebkac($_POST['TaskNote'], 1000, 'STRING');
$SaveArr['userid'] = $_SESSION['userid'];
addTaskNote($SaveArr);

header("Location: editTask.php?t=" . $TaskID);
?>