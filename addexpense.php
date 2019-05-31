<?php
include_once("db.inc.php");
include("header.inc.php");
$Accounts = getAccounts();
$Suppliers = getSuppliers();
$CostCs = getCostCentres();
?>
<script>
$(document).ready(function()
{
	$("#expForm").validationEngine();
	$('#expDate').datepicker({"dateFormat": "yy-mm-dd"});
});

function calcVAT()
{
	var Sub = parseFloat($("#expSub").val());
	var VAT = parseFloat($("#expVAT").val());
	var Tot = parseFloat($("#expTotal").val());
	if(isNaN(Sub))
	{
		$("#expSub").val(Tot - VAT);
	}
	else
	{
		$("#expTotal").val(Sub + VAT);
	}
}
// $("#expTotal").change(function() 
// {
	
// });
</script>
<form method='POST' action='saveExpense.php' id='expForm' enctype="multipart/form-data">
<table class='table table-bordered table-condensed'>
<tr><th>From Account</th><td><select name='frmAcc' class='validate[required] form-control'>
<option value=''>-- Select FROM account --</option>
<?php
foreach($Accounts AS $AccID => $AccRec)
{
	echo "<option value='" . $AccID . "'>" . $AccRec['accountname'] . "</option>";
}
?>
</select></td><th>Supplier</th><td><select name='expSupp' class='validate[required] form-control'>
<option value=''>-- Select SUPPLIER --</option>
<?php
foreach($Suppliers AS $SuppID => $SuppRec)
{
	echo "<option value='" . $SuppID . "'>" . $SuppRec['suppliername'] . "</option>";
}
?>
</select></td><th>Cost Centre</th><td><select name='expCostC' class='validate[required] form-control'>
<option value=''>-- Select SUPPLIER --</option>
<?php
foreach($CostCs AS $CcID => $CCRec)
{
	echo "<option value='" . $CcID . "'>" . $CCRec['centrename'] . "</option>";
}
?>
</select></td></tr>
<tr><th>Sub Total</th><td><input type='text' name='expSub' id='expSub' class='validate[required] form-control'></td>
<th>VAT <button type='button' onclick='calcVAT();' class='btn btn-xs pull-right'><i class='fa fa-arrows-h'></i></button></th><td><input type='text' name='expVAT' id='expVAT' class='validate[required] form-control'></td>
<th>Total</th><td><input type='text' name='expTotal' id='expTotal' class='validate[required] form-control'></td></tr>
<tr><th>Date</th><td><input type='text' name='expDate' id='expDate' class='form-control'></td><th>File</th><td><input type='file' name='exp_file' id='exp_file' class='form-control'></td></tr>
<tr><th colspan='4'>Description<br><textarea name='expDesc' id='expDesc' class='form-control'></textarea></th></tr>
<tr><td colspan='4'><button type='submit' class='btn btn-success pull-right'><i class='fa fa-exchange'></i> Log Expense</button></td></tr>
</table>
</form>
<?php
include("footer.inc.php");
?>