<?php
include("db.inc.php");
include("header.inc.php");
$Clients = getClients();
?>
<div class='row'><div class='col-md-12'><h3>Log Faults</h3></div></div>
<form method='POST' action='logMaintenance.php'>
<div class='row'>
	<div class='col-md-3'>Client</div><div class='col-md-4'>
			<select name='ClientID' id='ClientID' class='validate[required] form-control' onchange='getClientElements();'>
			<option value=''>-- Select --</option>
<?php
foreach($Clients AS $ClientID => $Client)
{
	echo "<option value='" . $ClientID . "'>" . $Client['clientname'] . "</option>\n";
}
?>
			</select>
			</div>
	<div class='col-md-12'><textarea id='bulkPaste' name='bulkPaste' class='form-control'></textarea></div>
	<div class='col-md-12'><button type='submit' class='btn btn-success pull-right'><i class='fa fa-forward'></i> Load</button></div>
</div>
</form>
