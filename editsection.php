<?php
include("db.inc.php");
include("header.inc.php");
$SectionID = (isset($_GET['s'])) ? pebkac($_GET['s']) : 0;
$Section = getSectionByID($SectionID);
$Sections = getSections();
$Tasks = getTasksBySection($SectionID);
$SectFiles = getSectionFiles($SectionID);
?>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
	$('#prjstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#prjend').datepicker({"dateFormat": "yy-mm-dd"});
});
</script>
<div class='row'><div class='col-md-2'><strong>Section Details</strong></a></div></div>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
	<form method='POST' action='saveProjectSection.php' id='projForm' enctype="multipart/form-data">
 	<input type='hidden' name='prjID' id='prjID' value='<?php echo $PrjID; ?>'>
	<input type='hidden' name='secID' id='secID' value='0'>
		<div class='row'>
			<div class='col-md-2'>Section Name:</div><div class='col-md-4'><input type='text' name='secName' id='secName' value='<?php echo $Section['section_name']; ?>' class='validate[required] form-control form-control-sm'></div>
			<div class='col-md-6'><input type='file' name='prjfile' id='prjfile'></div>
		</div>
		<div class='row'><div class='col-md-12'><button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button></div></div>
	</form>
	</div>
</div>
<div class='row'><div class='col-md-6'>Section Tasks</div><div class='col-md-6'>Section Files</div></div>
<div class='row'><div class='col-md-6'>
<?php
if(count($Tasks) > 0)
{
	foreach($Tasks AS $TaskID => $Task)
	{
		echo "<div class='row'><div class='col-md-12'>" . $TaskID . " - " . $Task['task_name'] . " in " . $Sections[$Task['section_id']]['section_name'] . "</div></div>";
	}
}
else
	echo "<div class='row'><div class='col-md-12'>No linked tasks</div></div>";
?>
</div><div class='col-md-6'>
<?php
if(count($SectFiles) > 0)
{
	foreach($SectFiles AS $TaskID => $Task)
	{
		echo "<div class='row'><div class='col-md-12'><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></div></div>\n";
	}
}
else
	echo "<div class='row'><div class='col-md-12'>No files for this section</div></div>";
?>
</div></div>
<?php
include("footer.inc.php");
?>
