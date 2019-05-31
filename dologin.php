<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
session_start();
include("db.inc.php");
$Username = pebkac($_POST['usrname'], 100, 'STRING');
$Password = pebkac($_POST['usrpass'], 100, 'STRING');
$UsrRec = getUsersDetailsByUsername($Username);
if(count($UsrRec) == 0)
	echo "Username not found";
else
{
	if($UsrRec['userpass'] != "")
	{
		$HashPassw = saltAndPepper($Username, $Password);
		if(password_verify($HashPassw, $UsrRec['userpass']))
		{
			$_SESSION['userid'] = $UsrRec['userid'];
			$_SESSION['firstname'] = $UsrRec['firstname'];
			$_SESSION['surname'] = $UsrRec['surname'];
			$_SESSION['email'] = $UsrRec['username'];
			updateLastLogin($UsrRec['userid']);
			header("Location: engineering.php");
			exit();
		}
	}
}
$_SESSION['errmsg'] = 'Login failed. Please check the details';
header("Location: index.php");
?>