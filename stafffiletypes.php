<?php
include_once("db.inc.php");
include("header.inc.php");
$FileTypes = getStaffFileTypes();
$HiOrder = 0;
foreach($FileTypes AS $ID => $TypeRec)
{
	if($TypeRec['sortorder'] > $HiOrder)
		$HiOrder = $TypeRec['sortorder'];
}
?>
<script>
function openItem(ItemID)
{
	$('#TypeID').val(ItemID);
	$('#typeName').val('');
	if(ItemID != 0)
	{
		$('#typeName').val($('#typename_' + ItemID).html());
	}
	$('#item-modal').modal("show");
}
</script>
<table class='table table-bordered table-striped table-sm'>
<tr class='table-custom-header'><th>ID</th><th>Type</th><th><button type='button' class='btn btn-sm btn-outline-custom float-right' onclick='openItem(0);'><i class='fa fa-plus'></i></button></th></tr>
<?php
foreach($FileTypes AS $ID => $TypeRec)
{
	echo "<tr>";
	echo "<td>" . $ID . "</td>";
	echo "<td><a href='#' onclick='openItem(" . $ID . ");' id='typename_" . $ID . "'>" . $TypeRec['typename'] . "</a></td>";
	echo "<td>";
	echo "<button type='button' class='btn btn-sm btn-outline-custom float-right' style='margin-left: 10px;' onclick='openItem(" . $ID . ");'><i class='fa fa-pencil'></i></button>\n";
	if($TypeRec['sortorder'] > 1)
		echo "<a href='StaffFileTypeSort.php?o=" . $TypeRec['sortorder'] . "&n=" . ($TypeRec['sortorder'] - 1) . "' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-up'></i></a>\n";
	else
		echo "<button disabled='disabled' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-up'></i></button>\n";
	if($TypeRec['sortorder'] < $HiOrder)
		echo "<a href='StaffFileTypeSort.php?o=" . $TypeRec['sortorder'] . "&n=" . ($TypeRec['sortorder'] + 1) . "' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-down'></i></a></th>\n";
	else
		echo "<button disabled='disabled' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-arrow-circle-down'></i></button>\n";
	
	echo "</td>";
	echo "</tr>\n";
}
?>
</table>
<div class='modal fade' id='item-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveStaffFileType.php' id='secForm'>
 	<input type='hidden' name='TypeID' id='TypeID' value=''>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>File Type Details</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-3'>Type Name:</div><div class='col-md-4'><input type='text' name='typeName' id='typeName' value='' class='validate[required] form-control'></div>
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