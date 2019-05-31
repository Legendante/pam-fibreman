<?php
include_once("db.inc.php");
include("header.inc.php");
$Expenses = getExpenses();
$Suppliers = getSuppliers();
$CostCs = getCostCentres();
$CostExp = array();
$CostTot = array();
foreach($CostCs AS $CostID => $CostC)
{
	$CostTot[$CostID] = 0;
}
?>
<ul class='nav nav-tabs'>
	<li class='active'><a href='#Proj_1' data-toggle='tab'><strong>Expenses</strong></a></li>
	<li><a href='#Proj_2' data-toggle='tab'><strong>Cost Centre Breakdown</strong></a></li>
	<!-- <li class='pull-right'><a href='editproject.php'><i class='fa fa-plus'></i> Add Project</a></li> -->
</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>Supplier</th><th>Sub total</th><th>VAT</th><th>Total</th><th>Date</th><th>Status</th><th>Cost Centre <a href='addexpense.php' class='pull-right'><i class='fa fa-plus'></i> Log expense</a></th></tr>
<?php
$SubTot = 0;
$VATTot = 0;
$TotTot = 0;
$Mnt = 0;
$ExpMnts = array();
foreach($Expenses AS $ExpID => $ExpRec)
{
	$ExpMnt = date("m", strtotime($ExpRec['transdate']));
	$ExpMnts[$ExpMnt] = $ExpMnt;
	if($Mnt != $ExpMnt)
	{
		$Mnt = $ExpMnt;
		echo "<tr><th colspan='8'>" . date("M Y", strtotime($ExpRec['transdate'])) . "</th></tr>";
	}
	echo "<tr>";
	echo "<td>" . $ExpID . "</td>";
	echo "<td>" . $Suppliers[$ExpRec['supplier_id']]['suppliername'] . "</td>";
	echo "<td>" . $ExpRec['expensesubtotal'] . "</td>";
	echo "<td>" . $ExpRec['expensevattotal'] . "</td>";
	echo "<td>" . $ExpRec['expensetotal'] . "</td>";
	echo "<td>" . $ExpRec['transdate'] . "</td>";
	echo "<td>" . $ExpRec['exp_status'] . "</td>";
	echo "<td>" . $CostCs[$ExpRec['cost_centre_id']]['centrename'] . "</td>";
	echo "</tr>";
	$SubTot += $ExpRec['expensesubtotal'];
	$VATTot += $ExpRec['expensevattotal'];
	$TotTot += $ExpRec['expensetotal'];
	if(!isset($CostExp[$ExpMnt][$ExpRec['cost_centre_id']]))
		$CostExp[$ExpMnt][$ExpRec['cost_centre_id']] = 0;
	$CostExp[$ExpMnt][$ExpRec['cost_centre_id']] += $ExpRec['expensetotal'];
	$CostTot[$ExpRec['cost_centre_id']] += $ExpRec['expensetotal'];
}
echo "<tr>";
echo "<th colspan='2'>Totals</th>";
echo "<td>" . $SubTot . "</td>";
echo "<td>" . $VATTot . "</td>";
echo "<td>" . $TotTot . "</td>";
echo "<td colspan='3'></td>";
echo "</tr>";
?>
		</table>
	</div>
	<div class='tab-pane' id='Proj_2'>
		<table class='table table-bordered table-condensed'>
<?php
echo "<tr><th></th>";
foreach($CostCs AS $CostID => $CostC)
{
	echo "<th>" . $CostC['centrename'] . "</th>";
}
echo "</tr>";

foreach($ExpMnts AS $Mnt)
{
	echo "<tr><th>" . $Mnt . "</th>";
	foreach($CostCs AS $CostID => $CostC)
	{
		$CostTxt = (isset($CostExp[$Mnt][$CostID])) ? sprintf("R %0.2f", $CostExp[$Mnt][$CostID]) : "-";
		echo "<td>" . $CostTxt . "</td>";
	}
	echo "</tr>";
}

echo "<tr><th></th>";
foreach($CostCs AS $CostID => $CostC)
{
	echo "<th>" . sprintf("R %0.2f", $CostTot[$CostID]) . "</th>";
}
echo "</tr>";

?>
		</table>
	</div>
</div>
<?php
include("footer.inc.php");
?>