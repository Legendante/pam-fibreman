<?php
session_start();
include_once("db.inc.php");
$ClientID = pebkac($_GET['c']);
$QuoteID = pebkac($_GET['q']);
$SaveArr = array();
$SaveArr['quote_status'] = 99;
saveQuote($QuoteID, $SaveArr);
header("Location: editclient.php?cid=" . $ClientID);
?>