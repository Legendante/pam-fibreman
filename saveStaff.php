<?php
include_once("db.inc.php");
$StaffID = pebkac($_POST['sid']);
$SaveArr = array();
$SaveArr['firstname'] = pebkac($_POST['firstname'], 100, 'STRING');
$SaveArr['surname'] = pebkac($_POST['surname'], 100, 'STRING');
$SaveArr['knownas'] = pebkac($_POST['knownas'], 100, 'STRING');
$SaveArr['cellnumber'] = pebkac($_POST['cellnumber'], 30, 'STRING');
$SaveArr['email'] = pebkac($_POST['email'], 100, 'STRING');
$SaveArr['homenumber'] = pebkac($_POST['homenumber'], 30, 'STRING');
$SaveArr['birthday'] = pebkac($_POST['birthday'], 10, 'STRING');
$SaveArr['idnumber'] = pebkac($_POST['idnumber'], 50, 'STRING');
$SaveArr['passportnum'] = pebkac($_POST['passportnum'], 50, 'STRING');
$SaveArr['salary'] = pebkac($_POST['salary'], 9, 'STRING');
$SaveArr['startdate'] = pebkac($_POST['startdate'], 10, 'STRING');
$SaveArr['taxnumber'] = pebkac($_POST['taxnumber'], 30, 'STRING');
$SaveArr['address1'] = pebkac($_POST['address1'], 100, 'STRING');
$SaveArr['address2'] = pebkac($_POST['address2'], 100, 'STRING');
$SaveArr['address3'] = pebkac($_POST['address3'], 100, 'STRING');
$SaveArr['address4'] = pebkac($_POST['address4'], 100, 'STRING');
$SaveArr['address5'] = pebkac($_POST['address5'], 100, 'STRING');
$SaveArr['bankname'] = pebkac($_POST['bankname'], 30, 'STRING');
$SaveArr['bankaccnum'] = pebkac($_POST['bankaccnum'], 30, 'STRING');
$SaveArr['bankbranchcode'] = pebkac($_POST['bankbranchcode'], 10, 'STRING');
$SaveArr['bankbranch'] = pebkac($_POST['bankbranch'], 30, 'STRING');
$SaveArr['shoesize'] = pebkac($_POST['shoesize'], 4, 'STRING');
$SaveArr['shirtsize'] = pebkac($_POST['shirtsize'], 4, 'STRING');
$SaveArr['pantsize'] = pebkac($_POST['pantsize'], 4, 'STRING');

if($StaffID == 0)
	addStaffMember($SaveArr);
else
	saveStaffMember($StaffID, $SaveArr);
header("Location: editstaff.php?sid=" . $StaffID);
?>