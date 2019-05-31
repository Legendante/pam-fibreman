<?php
include_once("db.inc.php");
include("header.inc.php");
$Clients = getClients();
?>
<table class='table table-bordered table-striped table-sm'>
	<tr class='table-custom-header'><th>ID</th><th>Name</th><th>Shortname</th><th>Balance</th><th><a href='editclient.php' class='btn btn-outline-custom btn-sm'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Clients AS $ClientID => $ClientRec)
{
	echo "<tr>";
	echo "<td>" . $ClientID . "</td>";
	echo "<td><a href='editclient.php?cid=" . $ClientID . "'>" . $ClientRec['clientname'] . "</a></td>";
	echo "<td>" . $ClientRec['client_short'] . "</td>";
	echo "<td>" . $ClientRec['client_balance'] . "</td>";
	echo "<td><a href='editclient.php?cid=" . $ClientID . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
</table>
<?php
include("footer.inc.php");
?>