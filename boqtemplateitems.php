<?php
include("db.inc.php");
include("header.inc.php");

$TemplateID = pebkac($_GET['t']);
$Template = getBOQTemplateByID($TemplateID);
// $Client = getClientByID($Template['client_id']);
$Items = getBOQTemplateItems($TemplateID);
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$ItemShow = array();
$TemplateItems = array();
foreach($BOQCats AS $CatID => $Cat)
{
	foreach($BOQLines AS $LineID => $Line)
	{
		if(($Line['categoryid'] == $CatID) && (isset($Items[$LineID])))
		{
			$TemplateItems[$LineID] = $LineID;
			$ItemShow[$CatID][$LineID] = 1;
		}
	}
}

?>
<script>
function openTemplateItems()
{
	$('#items-modal').modal("show");
}
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-sm'>
		<tr><td><strong>Template:</strong> <?php echo $Template['template_name']; ?></td><!-- <td><strong>Client:</strong> <?php echo $Client['clientname']; ?></td> -->
		<th colspan='2'><button type='button' class='btn btn-sm btn-outline-primary float-right' onclick='openTemplateItems(0)'><i class='fa fa-plus'></i> Edit Items</button></th></tr>
<?php
$OldCat = 0;
foreach($ItemShow AS $CatID => $Lines)
{
	if($OldCat != $CatID)
	{
		echo "<tr><th colspan='4'>" . $BOQCats[$CatID]['categoryname'] . "</th></tr>\n";
		echo "<tr><th>Item name</th><th>Unit</th><th>Default Cost</th></tr>\n";
		foreach($Lines AS $LineID => $One)
		{
			echo "<tr><td>" . $BOQLines[$LineID]['item_name'] . "</td>";
			echo "<td>" . $BOQUnits[$BOQLines[$LineID]['unitid']]['unitname'] . "</td>";
			echo "<td>" . $BOQLines[$LineID]['defaultcost'] . "</td>";
			echo "</tr>\n";
		}
		$OldCat = $CatID;
	}
}
?>			
		</table>
	</div>
</div>
<div class='modal fade' id='items-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveBOQTemplateItems.php' id='secForm'>
 	<input type='hidden' name='templateID' id='templateID' value='<?php echo $TemplateID; ?>'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>BOQ Item</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
		<table class='table table-bordered table-sm'>
<?php
foreach($BOQCats AS $CatID => $Cat)
{
	echo "<tr><th colspan='4'>" . $Cat['categoryname'] . "</th></tr>\n";
	echo "<tr><th></th><th>Item name</th><th>Unit</th><th>Default Cost</th></tr>\n";
	foreach($BOQLines AS $LineID => $Line)
	{
		if($Line['categoryid'] == $CatID)
		{
			echo "<tr><td><input type='checkbox' name='it_" . $LineID . "' id='it_" . $LineID . "' value='" . $LineID . "'";
			if(isset($TemplateItems[$LineID]))
				echo " checked='checked'";
			echo "></td>";
			echo "<td><label for='it_" . $LineID . "'>" . $Line['item_name'] . "</label></td>";
			echo "<td>" . $BOQUnits[$Line['unitid']]['unitname'] . "</td>";
			echo "<td>" . $Line['defaultcost'] . "</td>";
			echo "</tr>\n";
		}
	}
}
?>
		</table>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
include("footer.inc.php");
?>