<?php
include_once("db.inc.php");
include("header.inc.php");
$Staff = getAllStaff();
?>
<table class='table table-bordered table-striped table-sm'>
	<tr class='table-custom-header'><th>ID</th><th>Name</th><th>Known As</th><th>Cell</th><th>Email</th><th><a href='editstaff.php' class='btn btn-sm btn-outline-custom'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Staff AS $StaffID => $StaffRec)
{
	echo "<tr>";
	echo "<td>" . $StaffID . "</td>";
	echo "<td><a href='editstaff.php?sid=" . $StaffID . "'>" . $StaffRec['firstname'] . " " . $StaffRec['surname'] . "</a></td>";
	echo "<td>" . $StaffRec['knownas'] . "</td>";
	echo "<td>" . $StaffRec['cellnumber'] . "</td>";
	echo "<td>" . $StaffRec['email'] . "</td>";
	echo "<td><a href='editstaff.php?sid=" . $StaffID . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
</table>
<?php
include("footer.inc.php");
?>