<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$ProjID = pebkac($_POST['secProjID']);
$SectionID = pebkac($_POST['secSectionID']);
$SaveArr['section_name'] = pebkac($_POST['secName'], 50, 'STRING');
$SaveArr['project_id'] = $ProjID;
$SaveArr['planned_start_date'] = (isset($_POST['spstart'])) ? pebkac($_POST['spstart'], 10, 'STRING') : '';
$SaveArr['planned_end_date'] = (isset($_POST['spend'])) ? pebkac($_POST['spend'], 10, 'STRING') : '';
$SaveArr['actual_start_date'] = (isset($_POST['asstart'])) ? pebkac($_POST['asstart'], 10, 'STRING') : '';
$SaveArr['actual_end_date'] = (isset($_POST['asend'])) ? pebkac($_POST['asend'], 10, 'STRING') : '';
if($SectionID == 0)
	$SectionID = addSpliceSection($SaveArr);
else
	saveSpliceSection($SectionID, $SaveArr);
header("Location: editspliceproject.php?pid=" . $ProjID);
?>