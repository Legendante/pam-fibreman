<?php
include("db.inc.php");
include("header.inc.php");

$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$HiOrder = 0;
foreach($BOQCats AS $CatID => $Cat)
{
	if($Cat['sortorder'] > $HiOrder)
		$HiOrder = $Cat['sortorder'];
}
?>
<script>
function openItem(ItemID)
{
	$('#itemID').val(ItemID);
	$('#itemName').val('');
	$('#itemUnit').val('');
	$('#itemCat').val('');
	$('#itemCost').val('');
	if(ItemID != 0)
	{
		$('#itemName').val($('#it_name_' + ItemID).html());
		$('#itemUnit').val($('#it_unit_' + ItemID).val());
		$('#itemCat').val($('#it_cat_' + ItemID).val());
		$('#itemCost').val($('#it_cost_' + ItemID).val());
	}
	$('#item-modal').modal("show");
}

function openCategory(CatID)
{
	$('#CatID').val(CatID);
	$('#catName').val('');
	if(CatID != 0)
	{
		$('#catName').val($('#catname_' + CatID).data("catname"));
	}
	$('#cat-modal').modal("show");
}
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-sm'>
<?php
foreach($BOQCats AS $CatID => $Cat)
{
	echo "<tr class='table-custom-header'><th colspan='4' id='catname_" . $CatID . "' data-catname='" . $Cat['categoryname'] . "'>" . $Cat['categoryname'];
	echo "<button type='button' class='btn btn-sm btn-outline-custom float-right' onclick='openCategory(" . $CatID . ")'><i class='fa fa-pencil'></i> Edit Category</button>\n";
	if($Cat['sortorder'] > 1)
		echo "<a href='BOQCatSort.php?o=" . $Cat['sortorder'] . "&n=" . ($Cat['sortorder'] - 1) . "' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-up'></i></a>\n";
	if($Cat['sortorder'] < $HiOrder)
		echo "<a href='BOQCatSort.php?o=" . $Cat['sortorder'] . "&n=" . ($Cat['sortorder'] + 1) . "' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-down'></i></a></th>\n";
	echo "<td>";
	echo "<button type='button' class='btn btn-sm btn-outline-custom' onclick='openItem(0)'><i class='fa fa-plus'></i> Add Item</button>";
	echo "<button type='button' class='btn btn-sm btn-outline-custom float-right' onclick='openCategory(0)'><i class='fa fa-plus'></i> Add Category</button>";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr><th>ID</th><th>Item name</th><th>Unit</th><th>Default Cost</th><th></th></tr>\n";
	foreach($BOQLines AS $LineID => $Line)
	{
		if($Line['categoryid'] == $CatID)
		{
			echo "<tr><td>" . $LineID . "</td><td><span id='it_name_" . $LineID . "'>" . $Line['item_name'] . "</span><input type='hidden' id='it_cat_" . $LineID . "' value='" . $CatID . "'/></td>";
			echo "<td><input type='hidden' id='it_unit_" . $LineID . "' value='" . $Line['unitid'] . "'/>" . $BOQUnits[$Line['unitid']]['unitname'] . "</td>";
			echo "<td><input type='hidden' id='it_cost_" . $LineID . "' value='" . $Line['defaultcost'] . "'/>" . $Line['defaultcost'] . "</td>";
			echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openItem(" . $LineID . ")'><i class='fa fa-pencil'></i></button></td>";
			echo "</tr>\n";
		}
	}
}
?>
		</table>
	</div>
</div>
<div class='modal fade' id='item-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveBOQItem.php' id='secForm'>
 	<input type='hidden' name='itemID' id='itemID' value='0'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>BOQ Item</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-2'>Item Name:</div><div class='col-md-4'><input type='text' name='itemName' id='itemName' value='' class='validate[required] form-control form-control-sm'></div>
					<div class='col-md-2'>Unit:</div><div class='col-md-4'><select name='itemUnit' id='itemUnit' class='validate[required] form-control form-control-sm'>
					<option value=''>-- Select --</option>
<?php
foreach($BOQUnits AS $UnitID => $Unit)
{
	echo "<option value='" . $UnitID . "'>" . $Unit['unitname'] . "</option>\n";
}
?>
					</select>
					
					
					</div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Item Category</div><div class='col-md-4'><select name='itemCat' id='itemCat' class='validate[required] form-control form-control-sm'>
					<option value=''>-- Select --</option>
<?php
foreach($BOQCats AS $CatID => $Cat)
{
	echo "<option value='" . $CatID . "'>" . $Cat['categoryname'] . "</option>\n";
}
?>
					</select></div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Default Cost:</div><div class='col-md-4'><input type='text' name='itemCost' id='itemCost' value='' class='validate[required] form-control form-control-sm'></div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
<div class='modal fade' id='cat-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveBOQCategory.php' id='catForm'>
 	<input type='hidden' name='CatID' id='CatID' value='0'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Category</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-3'>Category Name:</div><div class='col-md-4'><input type='text' name='catName' id='catName' value='' class='validate[required] form-control form-control-sm'></div>
				</div>
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