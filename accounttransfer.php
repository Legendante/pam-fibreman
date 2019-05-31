<?php
include_once("db.inc.php");
include("header.inc.php");
$Accounts = getAccounts();
?>
<script>
$(document).ready(function()
{
	$("#transForm").validationEngine();
	$('#transDate').datepicker({"dateFormat": "yy-mm-dd"});
});
</script>
<form method='POST' action='saveTransfer.php' id='transForm'>
<table class='table table-bordered table-condensed'>
<tr><th>From Account</th><td><select name='frmAcc' class='validate[required] form-control'>
<option value=''>-- Select FROM account --</option>
<?php
foreach($Accounts AS $AccID => $AccRec)
{
	echo "<option value='" . $AccID . "'>" . $AccRec['accountname'] . "</option>";
}
?>
</select></td><th>To Account</th><td><select name='toAcc' class='validate[required] form-control'>
<option value=''>-- Select TO account --</option>
<?php
foreach($Accounts AS $AccID => $AccRec)
{
	echo "<option value='" . $AccID . "'>" . $AccRec['accountname'] . "</option>";
}
?>
</select></td></tr>
<tr><th>Amount</th><td><input type='text' name='transAm' id='transAm' class='validate[required] form-control'></td>
<th>Date</th><td><input type='text' name='transDate' id='transDate' class='form-control'></td>
</tr>
<tr><th colspan='4'>Description<br><textarea name='transDesc' id='transDesc' class='form-control'></textarea></th></tr>
<tr><td colspan='4'><button type='submit' class='btn btn-success pull-right'><i class='fa fa-exchange'></i> Transfer</button></td></tr>
</table>
</form>
<?php
include("footer.inc.php");
?>