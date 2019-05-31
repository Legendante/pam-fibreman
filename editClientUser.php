<?php
include("db.inc.php");
include("header.inc.php");
$ClientID = pebkac($_GET['c']);
$UserID = (isset($_GET['u'])) ? pebkac($_GET['u']) : 0;
$User = getClientUserDetailsByUserID($UserID);
$Depts = getDepartments();
$UsrDepts = getClientUserDepartments($UserID);
?>
<script>
$(document).ready(function()
{
	$("#userForm").validationEngine();
});

function getPass()
{
	var adate = new Date().getTime();
	$.ajax({async: false, type: "POST", url: "ajaxGetPassword.php", dataType: "html",
		data: "dc=" + adate,
		success: function (feedback)
		{
			$('#usrpass').val(feedback);
		},
		error: function(request, feedback, error)
		{
			alert("Request failed\n" + feedback + "\n" + error);
			return false;
		}
	});
}
</script>
<form method='POST' action='saveClientUser.php' id='userForm'>
	<input type='hidden' name='cid' id='cid' value='<?php echo $ClientID; ?>'>
	<input type='hidden' name='uid' id='uid' value='<?php echo $UserID; ?>'>
	<div class='row'><div class='col-md-12'><strong>User Details</strong></div></div>
	<div class='row'>
		<div class='col-md-2'>First name:</div><div class='col-md-4'><input type='text' name='fname' id='fname' value='<?php echo $User['firstname']; ?>' class='validate[required] form-control'></div>
		<div class='col-md-2'>Created:</div><div class='col-md-4'><?php echo $User['dateregistered']; ?></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Surname:</div><div class='col-md-4'><input type='text' name='sname' id='sname' value='<?php echo $User['surname']; ?>' class='validate[required] form-control'></div>
		<div class='col-md-2'>Last login:</div><div class='col-md-4'><?php echo $User['lastlogin']; ?></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Email:</div><div class='col-md-4'><input type='text' name='email' id='email' value='<?php echo $User['username']; ?>' class='validate[required, custom[email]] form-control'></div>
		<div class='col-md-2'>Password:</div><div class='col-md-3'>
<?php
if($UserID == 0)
	echo "<input type='text' name='usrpass' id='usrpass' value='' class='validate[required] form-control'>";
else
	echo "<input type='text' name='usrpass' id='usrpass' value='' class='form-control'>";
?>
		</div>
		<div class='col-md-1'><button type='button' class='btn btn-success' onclick='getPass();' title='Generate Password'><i class='fa fa-refresh'></i></button></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Cell number:</div><div class='col-md-4'><input type='text' name='celln' id='celln' value='<?php echo $User['cellnumber']; ?>' class='validate[required] form-control'></div>
		<div class='col-md-2'>Tel number:</div><div class='col-md-4'><input type='text' name='teln' id='teln' value='<?php echo $User['telnumber']; ?>' class='form-control'></div>
	</div>
	<div class='row'>
		<div class='col-md-12'><button type='submit' class='btn btn-success'><i class='fa fa-save'></i> Save</button></div>
	</div>
	<div class='row'><div class='col-md-12'><strong>Departments</strong></div></div>
<?php
$cnt = 0;
foreach($Depts AS $DeptID => $Dept)
{
	if($cnt == 0)
		echo "<div class='row'>";
	echo "<div class='col-md-3'><input type='checkbox' name='priv_" . $DeptID . "' id='priv_" . $DeptID . "' value='" . $DeptID . "'";
	if(isset($UsrDepts[$DeptID]))
		echo " checked='checked'";
	echo "> <label for='priv_" . $DeptID . "'>" . $Dept['departmentname'] . "</label></div>";
	if($cnt == 3)
	{
		echo "</div>";
		$cnt = 0;
	}
	else
		$cnt++;
}
?>
	</div>
</form>
<?php
include("footer.inc.php");
?>