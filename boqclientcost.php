<?php
include("db.inc.php");
include("header.inc.php");

$ClientID = pebkac($_GET['c']);

$ItemCosts = getBOQItemsClientCost($ClientID);
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
?>
<form method='POST' action='saveBOQItemClientCost.php' id='secForm'>
 	<input type='hidden' name='clientID' id='clientID' value='<?php echo $ClientID; ?>'>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-sm'>
<?php
foreach($BOQCats AS $CatID => $Cat)
{
	echo "<tr><th colspan='3'>" . $Cat['categoryname'] . "</th></tr>\n";
	echo "<tr><th>Item name</th><th>Unit</th><th>Default Cost</th><th>Client Cost<button type='submit' class='btn btn-success btn-sm pull-right'><span class='fa fa-save'></span> Save</button></th></tr>\n";
	foreach($BOQLines AS $LineID => $Line)
	{
		if($Line['categoryid'] == $CatID)
		{
			echo "<tr><td>" . $Line['item_name'] . "</td>";
			echo "<td>" . $BOQUnits[$Line['unitid']]['unitname'] . "</td>";
			echo "<td>" . $Line['defaultcost'] . "</td>";
			$Cost = (isset($ItemCosts[$LineID])) ? $ItemCosts[$LineID] : "";
			echo "<td><input type='text' name='cost_" . $LineID . "' value='" . $Cost . "' class='form-control form-control-sm'/></td>";
			echo "</tr>\n";
		}
	}
}
?>
		</table>
	</div>
</div>
</form>
<?php
include("footer.inc.php");
?>