<?php
include_once("db.inc.php");
include("header.inc.php");
$Accounts = getAccounts();
$AccTypes = getAccountTypes();
?>
<table class='table table-bordered table-condensed'>
<tr><th>ID</th><th>Account</th><th>Balance <a href='accounttransfer.php' class='pull-right'><i class='fa fa-exchange'></i> Transfer</a></th><th>Type</th></tr>
<?php
foreach($Accounts AS $AccID => $AccRec)
{
	$RowHi = '';
	if($AccRec['accountbalance'] < 0)
		$RowHi = ' class="bg-danger"';
	if($AccRec['accountbalance'] > 0)
		$RowHi = ' class="bg-info"';
	echo "<tr" . $RowHi . ">";
	echo "<td>" . $AccID . "</td>";
	echo "<td>" . $AccRec['accountname'] . "</td>";
	echo "<td>" . $AccRec['accountbalance'] . "</td>";
	echo "<td>" . $AccTypes[$AccRec['accounttype']]['typename'] . "</td>";
	echo "</tr>";
}
?>
</table>
<?php
include("footer.inc.php");
?>