<?php
include_once("db.inc.php");
include("header.inc.php");
$TaskID = pebkac($_GET['t']);
$TypeID = pebkac($_GET['i']);
$Task = getTaskByID($TaskID);
$DeptID = $Task['department_id'];
$ChkGroups = getTaskCheckGroups($TypeID, $DeptID);
$Checks = getTaskChecks();
$FileTypes = getTaskFileTypes();
$TypeName = $FileTypes[$TypeID]['type_name'];
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_2'>
		<form action="uploadTaskFiles.php" method="POST" enctype="multipart/form-data">
		<input type='hidden' name='TaskID' id='TaskID' value='<?php echo $TaskID; ?>'>
		<input type='hidden' name='TypeID' id='TypeID' value='<?php echo $TypeID; ?>'>
		<div class='row'><div class='col-md-12 col-sm-12 col-xs-12'><h3>Upload <?php echo $TypeName; ?></h3></div></div>
<?php
for($i = 1; $i <= 30; $i += 2)
{
?>
		<div class='row'>
			<div class='col-md-2 col-sm-2 col-xs-2'><?php echo $TypeName . " " . $i; ?></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><input type="file" name="taskfile_<?php echo $i; ?>" id="taskfile_<?php echo $i; ?>" class='form-control form-control-sm'></div>
<?php
	if(count($ChkGroups) > 0)
	{
		echo "<div class='col-md-2 col-sm-3 col-xs-3'><select name='checkid_" . $i . "' id='checkid_" . $i . "' class='form-control form-control-sm'>";
		foreach($ChkGroups AS $GroupID => $GroupRec)
		{
			echo "<option disabled='disabled'>" . $GroupRec['group_name'] . "</option>\n";
			foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
			{
				echo "<option value='" . $CheckID . "'>" . $CheckRec['check_name'] . "</option>\n";
			}
			echo "<option disabled='disabled'>──────────</option>\n\n";
		}
		echo "</select></div>";
	}
	if(count($ChkGroups) == 0)
		echo "<div class='col-md-1 col-sm-1 col-xs-1'></div>";
?>
			
			<div class='col-md-2 col-sm-2 col-xs-2'><?php echo $TypeName . " " . ($i + 1); ?></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><input type="file" name="taskfile_<?php echo $i + 1; ?>" id="taskfile_<?php echo $i + 1; ?>" class='form-control form-control-sm'></div>
<?php
	if(count($ChkGroups) > 0)
	{
		echo "<div class='col-md-2 col-sm-3 col-xs-3'><select name='checkid_" . ($i + 1) . "' id='checkid_" . ($i + 1) . "' class='form-control form-control-sm'>";
		foreach($ChkGroups AS $GroupID => $GroupRec)
		{
			echo "<option disabled='disabled'>" . $GroupRec['group_name'] . "</option>\n";
			foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
			{
				echo "<option value='" . $CheckID . "'>" . $CheckRec['check_name'] . "</option>\n";
			}
			echo "<option disabled='disabled'>──────────</option>\n\n";
		}
		echo "</select></div>";
	}
?>
		</div>
<?php
}
?>
		<div class='row'><div class='col-md-1 col-sm-1 col-xs-1'></div><div class='col-md-4 col-sm-10 col-xs-10'><strong>Comments</strong></div></div>
		<div class='row'><div class='col-md-1 col-sm-1 col-xs-1'></div><div class='col-md-4 col-sm-10 col-xs-10'><textarea class='form-control form-control-sm' name='filenote' id='filenote'></textarea></div></div>
		<div class='row'><div class='col-md-4 col-sm-10 col-xs-10'><button type="submit" class='btn btn-outline-primary btn-sm'>Upload <?php echo $TypeName; ?></button></div></div>
		</form>
	</div>
</div>
<?php
include("footer.inc.php");
?>