<?php
include_once("db.inc.php");
$DeptID = pebkac($_POST['deptID']);
$SaveArr = array();
$SaveArr['departmentname'] = pebkac($_POST['deptName'], 50, 'STRING');
if($DeptID == 0)
	addDepartment($SaveArr);
else
	updateDepartment($DeptID, $SaveArr);
header("Location: departments.php");
?>