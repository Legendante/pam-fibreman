<?php
include_once("db.inc.php");
include_once("header.inc.php");
$ClientID = (isset($_POST['ClientID'])) ? pebkac($_POST['ClientID']) : 0;
$Clients = getClients();
$TicketNum = "";
$Client = "";
$UnitNum = "";
$Complex = "";
$CellNum = "";
$Problem = "";
$Appointment = "";
$Paste = "";
if(isset($_POST['bulkPaste']))
{
	$Paste = trim($_POST['bulkPaste']);
	$Lines = explode("\n", $Paste);
	$TicketNum = '';
	$Client = '';
	foreach($Lines AS $Ind => $Line)
	{
		$Cols = explode("\t", $Line);
		if(count($Cols) == 1)
			$TicketNum = trim($Cols[0]);
		elseif(count($Cols) == 6)
		{
			$Client = trim($Cols[0]);
			$UnitNum = trim($Cols[1]);
			$Complex = trim($Cols[2]);
			$CellNum = trim($Cols[3]);
			$Problem = trim($Cols[4]);
			$Appointment = trim($Cols[5]);
		}
	}
}
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
	<form method='POST' action='saveNewAccessBuild.php' id='projForm'>
		<input type='hidden' name='ClientID' id='ClientID' value='<?php echo $ClientID; ?>'>
		<div class='row'>
			<div class='col-md-1'>Client:</div><div class='col-md-3'><input type='text' name='clientN' id='clientN' value='<?php echo $Client; ?>' class='validate[required] form-control'></div>
			<div class='col-md-1'>Cellnum:</div><div class='col-md-2'><input type='text' name='cellN' id='cellN' value='<?php echo $CellNum; ?>' class='validate[required] form-control'></div>
		</div>
		<div class='row'>
			<div class='col-md-1'>Ticket #:</div><div class='col-md-3'><input type='text' name='ticketNum' id='ticketNum' value='<?php echo $TicketNum; ?>' class='validate[required] form-control'></div>
			<div class='col-md-1'>Unit Num:</div><div class='col-md-2'><input type='text' name='unitNum' id='unitNum' value='<?php echo $UnitNum; ?>' class='validate[required] form-control'></div>
			<div class='col-md-1'>Complex:</div><div class='col-md-4'><input type='text' name='compName' id='compName' value='<?php echo $Complex; ?>' class='validate[required] form-control'></div>
		</div>
		<div class='row'>
			<div class='col-md-1'>FSAN:</div><div class='col-md-2'><input type='text' name='fsan' id='fsan' value='' class='form-control'></div>
		</div>
		<div class='row'>
			<div class='col-md-1'>Problem:</div><div class='col-md-10'><input type='text' name='problem' id='problem' value='<?php echo $Problem; ?>' class='validate[required] form-control'></div>
		</div>
<?php
if($UnitNum != '')
{
?>
	<div class='row'><div class='col-md-12'><button type='submit' class='btn btn-success pull-right'><span class='fa fa-save'></span> Save</button></div></div>
<?php
}
?>
	</form>
	</div>
</div>
<div class='row'><div class='col-md-12'><h3>Log Fault</h3></div></div>
<form method='POST' action='logAccessBuild.php'>
<div class='row'>
	<div class='col-md-3'>Client</div><div class='col-md-4'>
			<select name='ClientID' id='ClientID' class='validate[required] form-control' onchange='getClientElements();'>
			<option value=''>-- Select --</option>
<?php
foreach($Clients AS $ClID => $Client)
{
	echo "<option value='" . $ClID . "'";
	if($ClID == $ClientID)
		echo " selected='selected'";
	echo ">" . $Client['clientname'] . "</option>\n";
}
?>
			</select>
			</div>
	<div class='col-md-12'><textarea id='bulkPaste' name='bulkPaste' class='form-control'><?php echo $Paste; ?></textarea></div>
	<div class='col-md-12'><button type='submit' class='btn btn-success pull-right'><i class='fa fa-forward'></i> Load</button></div>
</div>
</form>
<?php
include("footer.inc.php");
?>