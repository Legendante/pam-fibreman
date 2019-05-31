<?php
include("db.inc.php");
include("header.inc.php");
$Projs = getProjects();
$PrjID = pebkac($_GET['p']);
$Sects = getProjectSections($PrjID);
?>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
});

function openItem(ItemID)
{
	$('#secID').val(ItemID);
	$('#secName').val('');
	if(ItemID != 0)
	{
		$('#secName').val($('#secname_' + ItemID).html());
		$('#prjClient').val($('#prjclient_' + ItemID).val());
	}
	$('#item-modal').modal("show");
	$('#secName').focus();
}
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-striped table-sm'>
		<tr><td colspan='3'>Sections for <?php echo $Projs[$PrjID]['project_name']; ?></td></tr>
		<tr><th>ID</th><th>Section</th><th><button type='button' class='btn btn-xs btn-outline-primary' onclick='openItem(0)'><i class='fa fa-plus'></i></button></th></tr>
<?php
foreach($Sects AS $ID => $Section)
{
	$Files = getSectionFiles($ID);
	echo "<tr>";
	echo "<td>" . $ID . "</td>";
	echo "<td id='secname_" . $ID . "'>" . $Section['section_name'] . "</td>";
	echo "<td>";
	if(count($Files) > 0)
	{
		echo "<button type='button' class='btn btn-outline-success' title='I have files for this section' data-toggle='collapse' data-target='#sc_" . $ID . "'>";
		echo "<i class='fa fa-file'></i></button>\n";
	}
	echo "<button type='button' class='btn btn-xs btn-outline-primary' onclick='openItem(" . $ID . ")'><i class='fa fa-pencil'></i></button>";
	echo "</td>";
	echo "</tr>\n";
	if(count($Files) > 0)
	{
		echo "<tr id='sc_" . $ID . "' class='collapse'><td colspan='9'>";
		foreach($Files AS $FileID => $FileRec)
		{
			echo "<div class='row'><div class='col-md-12'><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></div></div>\n";
		}
		echo "</td></tr>";
	}
}
?>
		</table>
	</div>
</div>
<div class='modal fade' id='item-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveProjectSection.php' id='projForm' enctype="multipart/form-data">
 	<input type='hidden' name='prjID' id='prjID' value='<?php echo $PrjID; ?>'>
	<input type='hidden' name='secID' id='secID' value='0'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Section Details</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-2'>Section Name:</div><div class='col-md-4'><input type='text' name='secName' id='secName' value='' class='validate[required] form-control form-control-sm'></div>
					<div class='col-md-6'><input type='file' name='prjfile' id='prjfile'></div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-xs' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
include("footer.inc.php");
?>