<?php
include_once("db.inc.php");
include("header.inc.php");
$StaffID = (isset($_GET['sid'])) ? pebkac($_GET['sid']) : 0;
$Staff = getStaffMemberByID($StaffID);
$FileTypes = getStaffFileTypes();
$Files = getStaffMemberFilesByID($StaffID);
?>
<script>
$(document).ready(function()
{
	$("#staffFrm").validationEngine();
	$('#birthday').datepicker({"dateFormat": "yy-mm-dd"});
	$('#startdate').datepicker({"dateFormat": "yy-mm-dd"});
<?php
foreach($FileTypes AS $TypeID => $TypeRec)
{
	echo "$('#staffFile_exp_" . $TypeID . "').datepicker({'dateFormat': 'yy-mm-dd'});";
}
?>
});
</script>
<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#Proj_1' data-toggle='tab' class='nav-link active'>Staff Member Details</a></li>
<?php
if($StaffID != 0)
	echo "<li class='nav-item'><a href='#Proj_2' data-toggle='tab' class='nav-link'>Staff Member Files</a></li>";
?>
</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<form method='POST' action='saveStaff.php' id='staffFrm'>
		<input type='hidden' name='sid' value='<?php echo $StaffID; ?>'>
		<table class='table table-bordered table-sm'>
			<tr><th>ID</th><td><?php echo $StaffID; ?></td></tr>
			<tr><th>Name</th><td><input type='text' name='firstname' id='firstname' value='<?php echo $Staff['firstname']; ?>' maxlength='100' class='form-control form-control-sm'></td>
				<th>Surname</th><td><input type='text' name='surname' id='surname' value='<?php echo $Staff['surname']; ?>' maxlength='100' class='form-control form-control-sm'></td>
				<th>Known As</th><td><input type='text' name='knownas' id='knownas' value='<?php echo $Staff['knownas']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			<tr><th>Cell</th><td><input type='text' name='cellnumber' id='cellnumber' value='<?php echo $Staff['cellnumber']; ?>' maxlength='30' class='form-control form-control-sm'></td>
			<th>Email</th><td><input type='text' name='email' id='email' value='<?php echo $Staff['email']; ?>' maxlength='100' class='form-control form-control-sm'></td>
			<th>Home Num</th><td><input type='text' name='homenumber' id='homenumber' value='<?php echo $Staff['homenumber']; ?>' maxlength='30' class='form-control form-control-sm'></td></tr>
			
			<tr><th>Birthday</th><td><input type='text' name='birthday' id='birthday' value='<?php echo $Staff['birthday']; ?>' class='form-control form-control-sm'></td>
			<th>ID Number</th><td><input type='text' name='idnumber' id='idnumber' value='<?php echo $Staff['idnumber']; ?>' maxlength='50' class='form-control form-control-sm'></td>
			<th>Passport Num</th><td><input type='text' name='passportnum' id='passportnum' value='<?php echo $Staff['passportnum']; ?>' maxlength='50' class='form-control form-control-sm'></td></tr>
			
			<tr><th>Salary</th><td><input type='text' name='salary' id='salary' value='<?php echo $Staff['salary']; ?>' maxlength='9' class='form-control form-control-sm'></td>
			<th>Start date</th><td><input type='text' name='startdate' id='startdate' value='<?php echo $Staff['startdate']; ?>' class='form-control form-control-sm'></td>
			<th>Tax Num</th><td><input type='text' name='taxnumber' id='taxnumber' value='<?php echo $Staff['taxnumber']; ?>' maxlength='30' class='form-control form-control-sm'></td></tr>
			
			<tr><th>Shoe size:</th><td><input type='text' name='shoesize' id='shoesize' value='<?php echo $Staff['shoesize']; ?>' maxlength='4' class='form-control form-control-sm'></td>
			<th>Shirt size:</th><td><input type='text' name='shirtsize' id='shirtsize' value='<?php echo $Staff['shirtsize']; ?>' maxlength='4' class='form-control form-control-sm'></td>
			<th>Pants size:</th><td><input type='text' name='pantsize' id='pantsize' value='<?php echo $Staff['pantsize']; ?>' maxlength='4' class='form-control form-control-sm'></td></tr>
			
			<tr><td colspan='3'>
			<table class='table table-sm'>
			<tr><th>Address</th><td><input type='text' name='address1' id='address1' value='<?php echo $Staff['address1']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			<tr><th>&nbsp;</th><td><input type='text' name='address2' id='address2' value='<?php echo $Staff['address2']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			<tr><th>&nbsp;</th><td><input type='text' name='address3' id='address3' value='<?php echo $Staff['address3']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			<tr><th>&nbsp;</th><td><input type='text' name='address4' id='address4' value='<?php echo $Staff['address4']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			<tr><th>&nbsp;</th><td><input type='text' name='address5' id='address5' value='<?php echo $Staff['address5']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			</table>
			</td><td colspan='3'>
			<table class='table table-sm'>
			<tr><th>Bank</th><td><input type='text' name='bankname' id='bankname' value='<?php echo $Staff['bankname']; ?>' maxlength='30' class='form-control form-control-sm'></td></tr>
			<tr><th>Acc Num</th><td><input type='text' name='bankaccnum' id='bankaccnum' value='<?php echo $Staff['bankaccnum']; ?>' maxlength='30' class='form-control form-control-sm'></td></tr>
			<tr><th>Branch Code</th><td><input type='text' name='bankbranchcode' id='bankbranchcode' value='<?php echo $Staff['bankbranchcode']; ?>' maxlength='10' class='form-control form-control-sm'></td></tr>
			<tr><th>Branch</th><td><input type='text' name='bankbranch' id='bankbranch' value='<?php echo $Staff['bankbranch']; ?>' maxlength='30' class='form-control form-control-sm'></td></tr>
			</table>
			</td></tr>
			<tr><td colspan='6'><button type='submit' class='btn btn-outline-success btn-sm float-right'><i class='fa fa-save'></i> Save</button></td></tr>
		</table>
		</form>
	</div>
<?php
if($StaffID != 0)
{
?>
	<div class='tab-pane' id='Proj_2'>
	<form method='POST' action='saveStaffFiles.php' id='staffFileFrm' enctype="multipart/form-data">
	<input type='hidden' name='sid' value='<?php echo $StaffID; ?>'>
	<table class='table table-bordered table-sm'>
	<tr><th>Type</th><th>File</th><th>Expires?</th></tr>
<?php
foreach($Files AS $FileID => $FileRec)
{
	$Expires = ($FileRec['expiry_date'] != '0000-00-00') ? $FileRec['expiry_date'] : '';
	echo "<tr><td>" . $FileTypes[$FileRec['filetype_id']]['typename'] . "</td>";
	echo "<td><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></td><td>" . $Expires . "</td></tr>";
}
?>
	
	<tr><th colspan='3'><h3>Upload files</h3></th></tr>
	<tr><th>Type</th><th>File</th><th>Expires?</th></tr>
<?php
foreach($FileTypes AS $TypeID => $TypeRec)
{
	echo "<tr><td>" . $TypeRec['typename'] . "</td><td><input type='file' name='staffFile_" . $TypeID . "' id='staffFile_" . $TypeID . "' class='form-control form-control-sm'></td>";
	echo "<td><input type='text' name='staffFile_exp_" . $TypeID . "' id='staffFile_exp_" . $TypeID . "' class='form-control form-control-sm'></td></tr>";
}
?>
	<tr><td colspan='3'><button type='submit' class='btn btn-outline-success btn-sm float-right'><i class='fa fa-save'></i> Save</button></td></tr>
	</table>
	</form>
	</div>
<?php
}
?>
</div>
<?php
include("footer.inc.php");
?>