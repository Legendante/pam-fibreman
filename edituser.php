<?php
include("db.inc.php");
include("header.inc.php");
$UserID = (isset($_GET['uid'])) ? pebkac($_GET['uid']) : 0;
$User = getUserDetailsByUserID($UserID);
$SysPrivileges = getSystemPrivileges();
$UsrPrivileges = getUserPrivileges($UserID);
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
<form method='POST' action='saveUser.php' id='userForm'>
	<input type='hidden' name='uid' id='uid' value='<?php echo $UserID; ?>'>
	<div class='row'><div class='col-md-12'><strong>User Details</strong></div></div>
	<div class='row'>
		<div class='col-md-2'>First name:</div><div class='col-md-4'><input type='text' name='fname' id='fname' value='<?php echo $User['firstname']; ?>' class='validate[required] form-control form-control-sm'></div>
		<div class='col-md-2'>Created:</div><div class='col-md-4'><?php echo $User['dateregistered']; ?></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Surname:</div><div class='col-md-4'><input type='text' name='sname' id='sname' value='<?php echo $User['surname']; ?>' class='validate[required] form-control form-control-sm'></div>
		<div class='col-md-2'>Last login:</div><div class='col-md-4'><?php echo $User['lastlogin']; ?></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Email:</div><div class='col-md-4'><input type='text' name='email' id='email' value='<?php echo $User['username']; ?>' class='validate[required, custom[email]] form-control form-control-sm'></div>
		<div class='col-md-2'>Password:</div><div class='col-md-3'>
<?php
if($UserID == 0)
	echo "<input type='text' name='usrpass' id='usrpass' value='' class='validate[required] form-control form-control-sm'>";
else
	echo "<input type='text' name='usrpass' id='usrpass' value='' class='form-control form-control-sm'>";
?>
		</div>
		<div class='col-md-1'><button type='button' class='btn btn-outline-success btn-sm' onclick='getPass();' title='Generate Password'><i class='fa fa-refresh'></i></button></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Cell number:</div><div class='col-md-4'><input type='text' name='celln' id='celln' value='<?php echo $User['cellnumber']; ?>' class='validate[required] form-control form-control-sm'></div>
		<div class='col-md-2'>Tel number:</div><div class='col-md-4'><input type='text' name='teln' id='teln' value='<?php echo $User['telnumber']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Shoe size:</div><div class='col-md-1'><input type='text' name='shoe' id='shoe' value='<?php echo $User['shoesize']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Shirt size:</div><div class='col-md-1'><input type='text' name='shirt' id='shirt' value='<?php echo $User['shirtsize']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Pants size:</div><div class='col-md-1'><input type='text' name='pants' id='pants' value='<?php echo $User['pantsize']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'>
		<div class='col-md-12'><button type='submit' class='btn btn-outline-success btn-sm'><i class='fa fa-save'></i> Save</button></div>
	</div>
	<div class='row'><div class='col-md-12'><strong>Privileges</strong></div></div>
<?php
$cnt = 0;
foreach($SysPrivileges AS $PrivID => $PrivRec)
{
	if($cnt == 0)
		echo "<div class='row'>";
	echo "<div class='col-md-3'><div class='form-check'><input type='checkbox' name='priv_" . $PrivID . "' id='priv_" . $PrivID . "' class='form-check-input' value='" . $PrivID . "'";
	if(isset($UsrPrivileges[$PrivID]))
		echo " checked='checked'";
	echo "><label for='priv_" . $PrivID . "' class='form-check-label'>" . $PrivRec['privilegename'] . "</label></div></div>";
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