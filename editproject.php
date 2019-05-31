<?php
include("db.inc.php");
include("header.inc.php");
$ProjectID = (isset($_GET['p'])) ? pebkac($_GET['p']) : 0;
$Proj = getProjectByID($ProjectID);
$Clients = getClients();
$Files = getProjectFiles($ProjectID);
?>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
	$('#prjstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#prjend').datepicker({"dateFormat": "yy-mm-dd"});
});
</script>
<div class='row'><div class='col-md-2'><strong>Project Details</strong></a></div></div>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
	<form method='POST' action='saveProject.php' id='projForm' enctype="multipart/form-data">
 	<input type='hidden' name='prjID' id='prjID' value='<?php echo $ProjectID; ?>'>
				<div class='row'>
					<div class='col-md-2'>Project Name:</div><div class='col-md-4'><input type='text' name='prjName' id='prjName' value='<?php echo $Proj['project_name']; ?>' class='validate[required] form-control form-control-sm'></div>
					<div class='col-md-2'>Client:</div><div class='col-md-4'><select name='prjClient' id='prjClient' class='validate[required] form-control form-control-sm'>
					<option value=''>-- Select --</option>
<?php
foreach($Clients AS $ClientID => $Client)
{
	echo "<option value='" . $ClientID . "'";
	if($Proj['client_id'] == $ClientID)
		echo " selected='selected'";
	echo ">" . $Client['clientname'] . "</option>\n";
}
?>
					</select>
					</div>
				</div>
				<div class='row'><div class='col-md-2'>Start Date</div><div class='col-md-4'><input type='text' name='prjstart' id='prjstart' value='<?php echo $Proj['actual_start_date']; ?>' class='form-control form-control-sm'></div>
					<div class='col-md-2'>End Date</div><div class='col-md-4'><input type='text' name='prjend' id='prjend' value='<?php echo $Proj['actual_end_date']; ?>' class='form-control form-control-sm'></div></div>
				<div class='row'><div class='col-md-1'>File:</div><div class='col-md-2'><input type='file' name='prjfile' id='prjfile' class='form-control form-control-sm'></div></div>
<?php
foreach($Files AS $FileID => $FileRec)
{
	echo "<div class='row'>";
	echo "<div class='col-md-12'><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></div>";
	echo "</div>";
}
?>
				<div class='row'><div class='col-md-2'><button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button></div></div>
		</div>
	</div>
	</form>
	</div>
</div>
<?php
include("footer.inc.php");
?>