<?php
include("db.inc.php");
include("header.inc.php");
$ComplexID = (isset($_GET['c'])) ? pebkac($_GET['c']) : 0;
$Complex = getComplexByID($ComplexID);
$Clients = getClients();
$Files = getComplexFiles($ComplexID);
?>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
});
</script>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<form method='POST' action='saveComplex.php' id='projForm' enctype="multipart/form-data">
		<input type='hidden' name='ComplexID' id='ComplexID' value='<?php echo $ComplexID; ?>'>
		<div class='row'>
			<div class='col-md-2'>Complex Name:</div><div class='col-md-4'><input type='text' name='ComplexName' id='ComplexName' value='<?php echo $Complex['complexname']; ?>' class='validate[required] form-control form-control-sm'></div>
			<div class='col-md-2'>Client:</div><div class='col-md-4'>
			<select name='ClientID' id='ClientID' class='validate[required] form-control form-control-sm'>
			<option value=''>-- Select --</option>
<?php
foreach($Clients AS $ClientID => $Client)
{
	echo "<option value='" . $ClientID . "'";
	if($Complex['clientid'] == $ClientID)
		echo " selected='selected'";
	echo ">" . $Client['clientname'] . "</option>\n";
}
?>
			</select>
			</div>
			<div class='col-md-1'>Created:</div><div class='col-md-2'><?php echo $Complex['dateregistered']; ?></div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Num Units:</div><div class='col-md-2'><input type='text' name='NumUnits' id='NumUnits' value='<?php echo $Complex['numunits']; ?>' class='form-control form-control-sm'></div>
			<div class='col-md-2'>Short Code:</div><div class='col-md-2'><input type='text' name='ShortCode' id='ShortCode' value='<?php echo $Complex['shortcode']; ?>' class='form-control form-control-sm'></div>
			<div class='col-md-1'>File:</div><div class='col-md-2'><input type='file' name='compfile' id='compfile' class='form-control form-control-sm'></div>
		</div>
		<div class='row'><div class='col-md-2'>Address:</div><div class='col-md-3'>
			<div class='row'><div class='col-md-12'><input type='text' name='addie1' id='addie1' value='<?php echo $Complex['complexaddress1']; ?>' class='form-control form-control-sm'></div></div>
			<div class='row'><div class='col-md-12'><input type='text' name='addie2' id='addie2' value='<?php echo $Complex['complexaddress2']; ?>' class='form-control form-control-sm'></div></div>
			<div class='row'><div class='col-md-12'><input type='text' name='addie3' id='addie3' value='<?php echo $Complex['complexaddress3']; ?>' class='form-control form-control-sm'></div></div>
			<div class='row'><div class='col-md-12'><input type='text' name='addie4' id='addie4' value='<?php echo $Complex['complexaddress4']; ?>' class='form-control form-control-sm'></div></div>
			<div class='row'><div class='col-md-12'><input type='text' name='addie5' id='addie5' value='<?php echo $Complex['complexaddress5']; ?>' class='form-control form-control-sm'></div></div>
			</div><div class='col-md-1'></div><div class='col-md-6'>
<?php
foreach($Files AS $FileID => $FileRec)
{
	echo "<div class='row'>";
	echo "<div class='col-md-12'><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></div>";
	echo "</div>";
}
?>
			
			</div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Lat:</div><div class='col-md-3'><input type='text' name='complat' id='complat' value='<?php echo $Complex['lat']; ?>' class='form-control form-control-sm'></div>
			<div class='col-md-2'>Lon:</div><div class='col-md-3'><input type='text' name='complon' id='complon' value='<?php echo $Complex['lon']; ?>' class='form-control form-control-sm'></div>
		</div>
		<div class='row'><div class='col-md-12'><button type='submit' class='btn btn-sm btn-outline-success float-right'><span class='fa fa-save'></span> Save</button></div></div>
		</form>
	</div>
</div>
<?php
include("footer.inc.php");
?>