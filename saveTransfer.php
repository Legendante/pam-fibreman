<?php
session_start();
include_once("db.inc.php");
$FromAcc = pebkac($_POST['frmAcc']);
$ToAcc = pebkac($_POST['toAcc']);
$Amount = pebkac($_POST['transAm'], 10, 'STRING');
$Date = ((isset($_POST['transDate'])) && ($_POST['transDate'] != '')) ? pebkac($_POST['transDate'], 10, 'STRING') : date("Y-m-d");
$Descr = pebkac($_POST['transDesc'], 255, 'STRING');
doAccountTransfer($FromAcc, $Amount, $Date, $Descr, $_SESSION['userid'], $ToAcc);
header("Location: accounts.php");
?>