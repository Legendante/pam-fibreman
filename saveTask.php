<?php
session_start();
include_once("db.inc.php");
$BOQVals = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 8) == 'boq_est_')
	{
		$ID = substr($Key, 8);
		$BOQVals[$ID]['est'] = $Val;
	}
	if(substr($Key, 0, 8) == 'boq_act_')
	{
		$ID = substr($Key, 8);
		$BOQVals[$ID]['act'] = $Val;
	}
}
$TaskID = pebkac($_POST['TaskID']);
$SaveArr = array();
$SaveArr['task_name'] = pebkac($_POST['taskName'], 50, 'STRING');
$SaveArr['client_id'] = pebkac($_POST['ClientID']);
$SaveArr['department_id'] = pebkac($_POST['DeptID']);
$SaveArr['project_id'] = (isset($_POST['ProjID'])) ? pebkac($_POST['ProjID']) : 0;
$SaveArr['section_id'] = (isset($_POST['SectionID'])) ? pebkac($_POST['SectionID']) : 0;
$SaveArr['actual_start_date'] = pebkac($_POST['taskstart'], 10, 'STRING');
$SaveArr['actual_end_date'] = pebkac($_POST['taskend'], 10, 'STRING');
$SaveArr['task_status'] = pebkac($_POST['StatusID']);
$SaveArr['po_id'] = pebkac($_POST['POID']);
$SaveArr['pvc_num'] = pebkac($_POST['pvclock']);
$SaveArr['cable_num'] = pebkac($_POST['cablelock']);

if($TaskID == 0)
	$TaskID = addTask($SaveArr);
else
	updateTask($TaskID, $SaveArr);

foreach($BOQVals AS $ItemID => $ItemVals)
{
	addTaskBOQItem($TaskID, $ItemID, $ItemVals['est'], $ItemVals['act'], $_SESSION['userid']);
}
header("Location: editTask.php?t=" . $TaskID);
?>