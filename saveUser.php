<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$UserID = pebkac($_POST['uid']);
$SaveArr['firstname'] = pebkac($_POST['fname'], 50, 'STRING');
$SaveArr['surname'] = pebkac($_POST['sname'], 50, 'STRING');
$Username = pebkac($_POST['email'], 50, 'STRING');
$Pass = pebkac($_POST['usrpass'], 50, 'STRING');
$SaveArr['cellnumber'] = pebkac($_POST['celln'], 50, 'STRING');
$SaveArr['telnumber'] = pebkac($_POST['teln'], 50, 'STRING');
$SaveArr['shoesize'] = pebkac($_POST['shoe'], 50, 'STRING');
$SaveArr['shirtsize'] = pebkac($_POST['shirt'], 50, 'STRING');
$SaveArr['pantsize'] = pebkac($_POST['pants'], 50, 'STRING');

$UsrPrivs = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 5) == 'priv_')
	{
		$UsrPrivs[] = $Val;
	}
}
if($UserID == 0)
{
	$SaveArr['username'] = $Username;
	$SaveArr['userpass'] = hashPassword($Username, $Pass);
	$UserID = addUser($SaveArr);
	include_once("class.phpmailer.php");
	include_once("class.pop3.php");
	include_once("class.smtp.php");
	$mail = new PHPMailer;
	//$mail->SMTPDebug = 3;                               											// Enable verbose debug output
	$mail->isSMTP();                                      											// Set mailer to use SMTP
	$mail->Host = $mailhost;  																		// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               											// Enable SMTP authentication
	$mail->Username = $mailusername;                							 					// SMTP username
	$mail->Password = $mailpassword;                           										// SMTP password
	$mail->SMTPSecure = 'tls';                            											// Enable TLS encryption, `ssl` also accepted
	$mail->Port = $mailport;                                    									// TCP port to connect to
	$mail->setFrom($mailusername, 'Company Management System');
	$mail->addAddress($Username, $SaveArr['firstname'] . ' ' . $SaveArr['surname']);     								// Add a recipient
	$mail->addReplyTo($mailusername, 'Company Management System');
	$mail->isHTML(true);                                  											// Set email format to HTML
	$mail->Subject = 'Company Management System :: User Registration';
	
	$HTMLContents = "Dear " . $SaveArr['firstname'] . "<br>\n";
	$HTMLContents .= "You have been registered on the Company Management System<br>\n";
	$HTMLContents .= "Here are your access details:<br>\n";
	$HTMLContents .= "URL: http://admin.example.com/<br>\n";
	$HTMLContents .= "Username: " . $Username . "<br>\n";
	$HTMLContents .= "Password: " . $Pass . "<br>\n";
	$mail->Body = $HTMLContents;
	$TextContents = "Dear " . $SaveArr['firstname'] . "\n";
	$TextContents .= "You have been registered on the Company Management System\n";
	$TextContents .= "Here are your access details:\n";
	$TextContents .= "URL: http://admin.example.com/\n";
	$TextContents .= "Username: " . $Username . "\n";
	$TextContents .= "Password: " . $Pass . "\n";
	$mail->AltBody = $TextContents;
	if(!$mail->send()) 
		logDBError("Failed to send user registration email", "User registration email send error", __FILE__, __FUNCTION__, __LINE__);
}
else
{
	if($Pass != '')
	{
		$SaveArr['username'] = $Username;
		$SaveArr['userpass'] = hashPassword($Username, $Pass);
	}
	saveUser($UserID, $SaveArr);
}
clearUserPrivileges($UserID);
foreach($UsrPrivs AS $ind => $PrivID)
{
	addUserPrivilege($UserID, $PrivID);
}
header("Location: edituser.php?uid=" . $UserID);
?>