<?php
session_start();
include_once("db.inc.php");

$ClientID = pebkac($_GET['c']);
$InvID = pebkac($_GET['i']);
$InvItems = getInvoiceItemsByInvoiceID($InvID);
foreach($InvItems AS $JoinID => $InvRec)
{
	$SaveArr = array();
	$SaveArr['join_status'] = 2;
	saveSpliceSectionJoin($JoinID, $SaveArr);
}
$SaveArr = array();
$SaveArr['inv_status'] = 99;
saveInvoice($InvID, $SaveArr);
$InvRec = getClientInvoiceByID($InvID);
decreaseClientBalance($ClientID, $InvRec['invoicetotal']);
header("Location: editclient.php?cid=" . $ClientID);
?>