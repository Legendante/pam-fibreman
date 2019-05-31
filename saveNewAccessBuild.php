<?php
session_start();
include_once("db.inc.php");
$ClientID = pebkac($_POST['ClientID']);
$Client = pebkac($_POST['clientN'], 100, 'STRING');
$CellNum = pebkac($_POST['cellN'], 100, 'STRING');
$TicketNum = pebkac($_POST['ticketNum'], 100, 'STRING');
$UnitNum = pebkac($_POST['unitNum'], 100, 'STRING');
$ComplexName = pebkac($_POST['compName'], 100, 'STRING');
$Problem = pebkac($_POST['problem'], 100, 'STRING');
$FirstN = "";
$LastN = "";
$NameBD = explode(" ", $Client);
$cnt = 0;
foreach($NameBD AS $TheN)
{
	if($cnt == 0)
		$FirstN = $TheN;
	else
		$LastN .= $TheN . " ";
	$cnt++;
}
$FirstN = trim($FirstN);
$LastN = trim($LastN);

$Complex = getComplexByName($ComplexName);
if(count($Complex) == 0)
{
	$SaveArr = array();
	$SaveArr['clientid'] = $ClientID;
	$SaveArr['complexname'] = $ComplexName;
	$ComplexID = addComplex($SaveArr);
}
else
	$ComplexID = $Complex['complexid'];
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

$SaveArr = array();
$SaveArr['firstname'] = $FirstN;
$SaveArr['lastname'] = $LastN;
$SaveArr['cell'] = $CellNum;
$SaveArr['fsannum'] = pebkac($_POST['fsan'], 30, 'STRING');
updateComplexUnit($UnitID, $SaveArr);

$Dept = getDepartmentByName("Access Builds");
$DeptID = $Dept['departmentid'];

$SaveArr = array();
$SaveArr['task_name'] = $UnitNum . " " . $ComplexName;
$SaveArr['client_id'] = $ClientID;
$SaveArr['department_id'] = $DeptID;
$SaveArr['project_id'] = 0;
$SaveArr['section_id'] = 0;
$SaveArr['task_status'] = 1;
$TaskID = addTask($SaveArr);

$SaveArr = array();
$SaveArr['unitid'] = $UnitID;
$SaveArr['taskid'] = $TaskID;
$SaveArr['ticketnumber'] = $TicketNum;
$SaveArr['faultdesc'] = $Problem;
$MaintID = addAccessBuild($SaveArr);

header("Location: accessbuilds.php");

?>