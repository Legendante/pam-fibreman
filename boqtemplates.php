<?php
include("db.inc.php");
include("header.inc.php");

$Templates = getBOQTemplates();
// $Clients = getClients();
?>
<script>
function openTemplate(TemplID)
{
	$('#templID').val(TemplID);
	$('#templName').val('');
	$('#templClient').val('');
	if(TemplID != 0)
	{
		$('#templName').val($('#temp_' + TemplID).html());
		$('#templClient').val($('#it_client_' + TemplID).val());
	}
	$('#templ-modal').modal("show");
}
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-striped table-sm'>
		<tr class='table-custom-header'><th>Template name</th><th>&nbsp;</th><th><button type='button' class='btn btn-sm btn-outline-custom' onclick='openTemplate(0)'><i class='fa fa-plus'></i></button></th></tr>
<?php
foreach($Templates AS $TempID => $Template)
{
	echo "<tr><td><span id='temp_" . $TempID . "'>" . $Template['template_name'] . "</span></td>";
	echo "<td><a href='boqtemplateitems.php?t=" . $TempID . "' class='btn btn-sm btn-outline-primary'><i class='fa fa-list'></i> Template Items</a></td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openTemplate(" . $TempID . ")'><i class='fa fa-pencil'></i> Edit</button></td>";
	echo "</tr>\n";
}
?>
		</table>
	</div>
</div>
<div class='modal fade' id='templ-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveBOQTemplate.php' id='secForm'>
 	<input type='hidden' name='templID' id='templID' value='0'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'><strong>BOQ Template</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-4'>Template Name:</div><div class='col-md-4'><input type='text' name='templName' id='templName' value='' class='validate[required] form-control form-control-sm'></div>
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