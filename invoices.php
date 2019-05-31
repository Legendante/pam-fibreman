<?php
include_once("db.inc.php");
include("header.inc.php");
$CCentres = getCostCentres();
$Clients = getClients();
$Invs = getInvoices();
?>
<table class='table table-bordered table-condensed'>
<tr><th>ID</th><th>Client</th><th>Total</th><th>Invoice Date</th><th>Status</th><th><a href='addInvoice.php'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Invs AS $InvID => $InvRec)
{
	echo "<tr>";
	echo "<td>" . $InvID . "</td>";
	echo "<td>" . $Clients[$InvRec['client_id']]['clientname'] . "</td>";
	echo "<td>" . $InvRec['invoicetotal'] . "</td>";
	echo "<td>" . $InvRec['logtime'] . "</td>";
	echo "<td>" . $InvRec['inv_status'] . "</td>";
	echo "</tr>";
}
?>
</table>
<?php
include("footer.inc.php");
?>