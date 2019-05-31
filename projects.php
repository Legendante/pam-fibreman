<?php
include("db.inc.php");
include("header.inc.php");
$Projs = getProjects();
$Clients = getClients();
?>
		<table class='table table-bordered table-striped table-sm'>
		<tr class='table-custom-header'><th>ID</th><th>Project</th><th>Client</th><th>Start Date</th><th>End Date</th>
		<th><a href='editproject.php' class='btn btn-sm btn-outline-custom float-right'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Projs AS $ID => $Proj)
{
	echo "<tr>";
	echo "<td>" . $ID . "</td>";
	echo "<td id='prjname_" . $ID . "'>" . $Proj['project_name'] . "</td>";
	echo "<td><input type='hidden' name='prjclient_" . $ID . "' id='prjclient_" . $ID . "' value='" . $Proj['client_id'] . "'>" . $Clients[$Proj['client_id']]['clientname'] . "</td>";
	echo "<td id='prjstrt_" . $ID . "'>" . $Proj['actual_start_date'] . "</td>";
	echo "<td id='prjend_" . $ID . "'>" . $Proj['actual_end_date'] . "</td>\n";
	echo "<td><a href='editproject.php?p=" . $ID . "' class='btn btn-sm btn-outline-primary float-right'><i class='fa fa-pencil'></i></a>";
	echo "<a href='project_sections.php?p=" . $ID . "' class='btn btn-sm btn-outline-primary'><i class='fa fa-list'></i> Sections</a>";
	echo "</td>";
	echo "</tr>\n";
}
?>
		</table>
<?php
include("footer.inc.php");
?>