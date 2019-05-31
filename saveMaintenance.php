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
$AppDate = pebkac($_POST['appdate'], 10, 'STRING');
$AppHour = pebkac($_POST['apphour']);
$AppMins = pebkac($_POST['appmins']);
$AppTime = $AppDate . " " . $AppHour . ":" . $AppMins . ":00";
$TaskID = pebkac($_POST['TaskID']);
$SaveArr = array();
$SaveArr['task_name'] = pebkac($_POST['taskName'], 50, 'STRING');
$SaveArr['client_id'] = pebkac($_POST['ClientID']);
$SaveArr['department_id'] = pebkac($_POST['DeptID']);
$SaveArr['project_id'] = (isset($_POST['ProjID'])) ? pebkac($_POST['ProjID']) : 0;
$SaveArr['section_id'] = (isset($_POST['SectionID'])) ? pebkac($_POST['SectionID']) : 0;
$SaveArr['actual_start_date'] = pebkac($_POST['taskstart'], 20, 'STRING');
$SaveArr['actual_end_date'] = pebkac($_POST['taskend'], 20, 'STRING');
$SaveArr['task_status'] = pebkac($_POST['StatusID']);
$SaveArr['po_id'] = pebkac($_POST['POID']);

if($TaskID == 0)
	$TaskID = addTask($SaveArr);
else
	updateTask($TaskID, $SaveArr);

foreach($BOQVals AS $ItemID => $ItemVals)
{
	addTaskBOQItem($TaskID, $ItemID, $ItemVals['est'], $ItemVals['act'], $_SESSION['userid']);
}
$ComplexID = pebkac($_POST['CompID']);
$UnitNum = pebkac($_POST['unitNum'], 10, 'STRING');
$Unit = getComplexeUnitByUnitName($ComplexID, $UnitNum);
if(count($Unit) == 0)
{
	$SaveArr = array();
	$SaveArr['complexid'] = $ComplexID;
	$SaveArr['unitname'] = $UnitNum;
	$UnitID = addComplexUnit($SaveArr);
}
else
	$UnitID = $Unit['unitid'];


$MainID = pebkac($_POST['MaintID']);
$SaveArr = array();
$SaveArr['ticketnumber'] = pebkac($_POST['ticketNum'], 50, 'STRING');
$SaveArr['tplocationid'] = pebkac($_POST['TPLocation']);
$SaveArr['infrastuctid'] = pebkac($_POST['IFMethod']);
$SaveArr['taskid'] = $TaskID;
$SaveArr['unitid'] = $UnitID;
$SaveArr['timeonsite'] = pebkac($_POST['timeonsite'], 10, 'STRING');
$SaveArr['faultdesc'] = pebkac($_POST['problem'], 1000, 'STRING');
$SaveArr['solutiondesc'] = pebkac($_POST['solution'], 1000, 'STRING');
$SaveArr['wascustomerneglect'] = pebkac($_POST['Negligence']);
$SaveArr['custonsite'] = pebkac($_POST['custonsite'], 100, 'STRING');
$SaveArr['maintnote'] = pebkac($_POST['maintnote'], 1000, 'STRING');
$SaveArr['apptime'] = $AppTime;
if(($MainID == 0) || ($MainID == ''))
	$MainID = addMaintenance($SaveArr);
else
	updateMaintenance($MainID, $SaveArr);


$SaveArr = array();
$SaveArr['firstname'] = pebkac($_POST['clientFN'], 50, 'STRING');
$SaveArr['lastname'] = pebkac($_POST['clientSN'], 50, 'STRING');
$SaveArr['cell'] = pebkac($_POST['cellN'], 50, 'STRING');
$SaveArr['fsannum'] = pebkac($_POST['fsan'], 30, 'STRING');

updateComplexUnit($UnitID, $SaveArr);
header("Location: editMaintenance.php?t=" . $TaskID);
?>