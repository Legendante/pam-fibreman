<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$ProjID = pebkac($_POST['dmProjID']);
$SectionID = pebkac($_POST['dmSectionID']);
$JoinID = pebkac($_POST['dmJoinID']);
$SaveArr['join_name'] = pebkac($_POST['joinName'], 50, 'STRING');
$SaveArr['num_splices'] = pebkac($_POST['joinNumSplices'], 10);
$SaveArr['num_domes'] = pebkac($_POST['joinNumDomes'], 10);
// $SaveArr['po_number'] = pebkac($_POST['joinPONum'], 15);
$SaveArr['po_id'] = pebkac($_POST['joinPOID']);
$SaveArr['project_id'] = $ProjID;
$SaveArr['section_id'] = $SectionID;
$SaveArr['manhole_number'] = pebkac($_POST['joinManhole'], 50, 'STRING');
$SaveArr['address'] = pebkac($_POST['joinAddress'], 100, 'STRING');
// $SaveArr['planned_start_date'] = pebkac($_POST['jnpstart'], 10, 'STRING');
// $SaveArr['planned_end_date'] = pebkac($_POST['jnpend'], 10, 'STRING');
$SaveArr['actual_start_date'] = pebkac($_POST['jnastart'], 10, 'STRING');
$SaveArr['actual_end_date'] = pebkac($_POST['jnaend'], 10, 'STRING');

$JoinUsrs = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 5) == 'tech_')
	{
		$JoinUsrs[] = $Val;
	}
}

if($JoinID == 0)
	$JoinID = addSpliceSectionJoin($SaveArr);
else
	saveSpliceSectionJoin($JoinID, $SaveArr);

clearJoinUsers($JoinID);
foreach($JoinUsrs AS $ind => $UsrID)
{
	addJoinUser($UsrID, $JoinID);
}
header("Location: editspliceproject.php?pid=" . $ProjID);
?>