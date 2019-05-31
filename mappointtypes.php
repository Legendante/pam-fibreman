<?php
include("db.inc.php");
include("header.inc.php");
$MapPoints = getMapPointTypes();
$MaxOrder = 0;
foreach($MapPoints AS $ID => $PointRec)
{
	if($PointRec['sort_order'] > $MaxOrder)
		$MaxOrder = $PointRec['sort_order'];
}
?>
<script>
function openItem(ItemID)
{
	$('#typeID').val(ItemID);
	$('#typeName').val('');
	if(ItemID != 0)
	{
		$('#typeName').val($('#p_' + ItemID).data("pointname"));
	}
	$('#item-modal').modal("show");
}
</script>
<table class='table table-bordered table-striped table-sm'>
	<tr class='table-custom-header'><th>ID</th><th>Name</th><th>Order</th><th><button type='button' onclick='openItem(0);' class='btn btn-outline-custom btn-sm'><i class='fa fa-plus'></i></button></th></tr>
<?php
foreach($MapPoints AS $ID => $PointRec)
{
	echo "<tr>";
	echo "<td>" . $ID . "</td>";
	echo "<td><a href='#' onclick='openItem(" . $ID . ");' id='p_" . $ID . "' data-pointname='" . $PointRec['type_name'] . "'>" . $PointRec['type_name'] . "</a></td>";
	echo "<td><div class='btn-group' style='margin-right: 10px;'>";
	if($PointRec['sort_order'] > 1)
		echo "<a href='MapPointTypeSort.php?o=" . $PointRec['sort_order'] . "&n=" . ($PointRec['sort_order'] - 1) . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-arrow-circle-up'></i></a>\n";
	else
		echo "<a class='btn btn-sm btn-outline-custom disabled'><i class='fa fa-arrow-circle-up'></i></a>\n";
	if($PointRec['sort_order'] < $MaxOrder)
		echo "<a href='MapPointTypeSort.php?o=" . $PointRec['sort_order'] . "&n=" . ($PointRec['sort_order'] + 1) . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-arrow-circle-down'></i></a>\n";
	else
		echo "<a class='btn btn-sm btn-outline-custom disabled'><i class='fa fa-arrow-circle-down'></i></a>\n";
	echo "</div>" . $PointRec['sort_order'] . "</td>";
	echo "<td><div class='btn-group'>";
	echo "<button type='button' onclick='openItem(" . $ID . ");' class='btn btn-outline-primary btn-sm'><i class='fa fa-pencil'></i></button>";
	echo "<a href='mappointtypequestions.php?t=" . $ID . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-question'></i> Point Type Questions</a>";
	echo "</div></td>";
	echo "</tr>";
}
?>
</table>
<div class='modal fade' id='item-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveMapPointType.php' id='secForm'>
 	<input type='hidden' name='typeID' id='typeID' value=''>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Point Type</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'><div class='col-md-3'>Type Name:</div><div class='col-md-4'><input type='text' name='typeName' id='typeName' value='' class='validate[required] form-control form-control-sm'></div></div>
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