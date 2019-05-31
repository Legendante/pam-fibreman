<?php
include("db.inc.php");
include("header.inc.php");

$Depts = getDepartments();
?>
<script>
function openItem(ItemID)
{
	$('#deptID').val(ItemID);
	$('#deptName').val('');
	if(ItemID != 0)
	{
		$('#deptName').val($('#dep_' + ItemID).html());
	}
	$('#item-modal').modal("show");
}
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-sm'>
		<tr class='table-custom-header'><th>ID</th><th>Name <button type='button' class='btn btn-sm btn-outline-custom float-right' onclick='openItem(0);'><i class='fa fa-plus'></i></button></th></tr>
<?php
foreach($Depts AS $ID => $DepArr)
{
	echo "<tr><td>" . $ID . "</td><td><span id='dep_" . $ID . "'>" . $DepArr['departmentname'] . "</span></td>";
//	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openItem(" . $ID . ");'><i class='fa fa-pencil'></i> Edit</button></td>";
	echo "</tr>\n";
}
?>
		</table>
	</div>
</div>
<div class='modal fade' id='item-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveDepartment.php' id='secForm'>
 	<input type='hidden' name='deptID' id='deptID' value=''>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Department Details</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-3'>Department Name:</div><div class='col-md-4'><input type='text' name='deptName' id='deptName' value='' class='validate[required] form-control'></div>
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