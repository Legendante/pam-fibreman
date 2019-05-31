<?php
session_start();
include_once("db.inc.php");

$ClientID = pebkac($_POST['pay_cid']);
$InvID = pebkac($_POST['pay_iid']);
$InvRec = getClientInvoiceByID($InvID);
$Paid = getInvoicePaymentsTotal($InvID);
$ToAcc = pebkac($_POST['payAcc']);
$Total = pebkac($_POST['pay_total'], 10, 'STRING');
$PayDate = pebkac($_POST['pay_date'], 10, 'STRING');
$PayDesc = pebkac($_POST['pay_desc'], 100, 'STRING');
doAccountTransfer(0, $Total, $PayDate, $PayDesc, $_SESSION['userid'], $ToAcc, $InvID);
$TotalPaid = $Paid + $Total;
if($TotalPaid >= $InvRec['invoicetotal'])
{
	$SaveArr = array();
	$SaveArr['inv_status'] = 1;
	saveInvoice($InvID, $SaveArr);
}
else
{
	$SaveArr = array();
	$SaveArr['inv_status'] = 2;
	saveInvoice($InvID, $SaveArr);
}
decreaseClientBalance($ClientID, $Total);
header("Location: editclient.php?cid=" . $ClientID);
?>