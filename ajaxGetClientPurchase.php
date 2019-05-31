<?php
include("db.inc.php");
$ClientID = pebkac($_POST['c']);
$PurchaseOrders = getClientPurchaseOrders($ClientID);
echo json_encode($PurchaseOrders);
?>

