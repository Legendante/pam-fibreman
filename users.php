<?php
include("db.inc.php");
include("header.inc.php");
$Users = getAllUsers();
?>
<table class='table table-bordered table-striped table-sm'>
	<tr class='table-custom-header'><th>ID</th><th>Firstname</th><th>Surname</th><th>Email</th><th>Cell</th><th>Last login</th><th>Active</th>
	<th><a href='edituser.php' class='btn btn-sm btn-outline-custom'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Users AS $UserID => $UserRec)
{
	$Active = ($UserRec['inactive'] == 0) ? "fa-check" : "fa-times";
	$ActBut = ($UserRec['inactive'] == 0) ? "btn-outline-success" : "btn-outline-danger";
	echo "<tr>";
	echo "<td><a href='edituser.php?uid=" . $UserID . "'>" . $UserID . "</a></td>";
	echo "<td><a href='edituser.php?uid=" . $UserID . "'>" . $UserRec['firstname'] . "</a></td>";
	echo "<td>" . $UserRec['surname'] . "</td>";
	echo "<td>" . $UserRec['username'] . "</td>";
	echo "<td>" . $UserRec['cellnumber'] . "</td>";
	echo "<td>" . $UserRec['lastlogin'] . "</td>";
	echo "<td><a href='setuseractive.php?uid=" . $UserID . "' class='btn btn-sm " . $ActBut . "'><i class='fa " . $Active . "'></i></a></td>";
	echo "<td><a href='edituser.php?uid=" . $UserID . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
</table>
<?php
include("footer.inc.php");
?>