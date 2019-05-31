<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$UserID = pebkac($_POST['uid']);
$ClientID = pebkac($_POST['cid']);
$SaveArr['customerid'] = $ClientID;
$SaveArr['firstname'] = pebkac($_POST['fname'], 50, 'STRING');
$SaveArr['surname'] = pebkac($_POST['sname'], 50, 'STRING');
$Username = pebkac($_POST['email'], 50, 'STRING');
$Pass = pebkac($_POST['usrpass'], 50, 'STRING');
$SaveArr['cellnumber'] = pebkac($_POST['celln'], 50, 'STRING');
$SaveArr['telnumber'] = pebkac($_POST['teln'], 50, 'STRING');

$UsrDepts = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 5) == 'priv_')
	{
		$UsrDepts[] = $Val;
	}
}
if($UserID == 0)
{
	$SaveArr['username'] = $Username;
	$SaveArr['userpass'] = hashPassword($Username, $Pass);
	$UserID = addClientUser($SaveArr);
}
else
{
	if($Pass != '')
	{
		$SaveArr['username'] = $Username;
		$SaveArr['userpass'] = hashPassword($Username, $Pass);
	}
	saveClientUser($UserID, $SaveArr);
}
clearClientUserDepartments($UserID);
foreach($UsrDepts AS $ind => $PrivID)
{
	addClientUserDepartment($UserID, $PrivID);
}
header("Location: editClientUser.php?c=" . $ClientID . "&u=" . $UserID);
?>