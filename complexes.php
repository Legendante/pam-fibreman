<?php
include("db.inc.php");
include("header.inc.php");
$Complexes = getComplexes();
$Clients = getClients();
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-striped table-sm'>
		<tr class='table-custom-header'><th>ID</th><th>Complex</th><th>Client</th>
			<th><a href='complexDetails.php' class='btn btn-sm btn-outline-custom'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Complexes AS $ComplexID => $Complex)
{
	echo "<tr>";
	echo "<td><a href='complexDetails.php?c=" . $ComplexID . "'>" . $ComplexID . "</a></td>";
	echo "<td><a href='complexDetails.php?c=" . $ComplexID . "'>" . $Complex['complexname'] . "</a></td>";
	echo "<td>" . $Clients[$Complex['clientid']]['clientname'] . "</td>";
	echo "<td><a href='complexDetails.php?c=" . $ComplexID . "' class='btn btn-sm btn-outline-primary'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
</div>
<?php
include("footer.inc.php");
?>