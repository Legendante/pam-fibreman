<?php
include_once("db.inc.php");
$ClientID = pebkac($_POST['cid']);
$SaveArr = array();
$SaveArr['clientname'] = pebkac($_POST['clientname'], 50, 'STRING');
$SaveArr['client_short'] = pebkac($_POST['client_short'], 10, 'STRING');
$SaveArr['client_reg'] = pebkac($_POST['client_reg'], 20, 'STRING');
$SaveArr['client_vat'] = pebkac($_POST['client_vat'], 20, 'STRING');
$SaveArr['client_tel'] = pebkac($_POST['client_tel'], 30, 'STRING');
$SaveArr['client_email'] = pebkac($_POST['client_email'], 100, 'STRING');
$SaveArr['client_address'] = pebkac($_POST['client_address'], 200, 'STRING');

if($ClientID == 0)
	$ClientID = addClient($SaveArr);
else
	saveClient($ClientID, $SaveArr);
header("Location: editclient.php?cid=" . $ClientID);
?>