<?php
include("db.inc.php");
include("header.inc.php");
$Projs = getProjects();
$Clients = getClients();
$Depts = getDepartments();
$Tasks = getTasks();
$Sections = getSections();
$PurchOrders = getPurchaseOrders();
$TaskStatusses = getTaskStatusses();
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-striped table-sm'>
		<tr class='table-custom-header'><th>ID</th><th>Task</th><th>Client</th><th>Dept</th><th>Project</th><th>Section</th><th>PO</th><th>Start</th><th>End</th><th>Status</th>
			<th><a href='editTask.php' class='btn btn-sm btn-outline-custom' title='Add Task'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Tasks AS $TaskID => $Task)
{
	$PO = ($Task['po_id'] > 0) ? $PurchOrders[$Task['po_id']]['po_number'] : "";
	$Proj = ($Task['project_id'] > 0) ? $Projs[$Task['project_id']]['project_name'] : "";
	$Sect = ($Task['section_id'] > 0) ? $Sections[$Task['section_id']]['section_name'] : "";
	
	echo "<tr>";
	echo "<td><a href='editTask.php?t=" . $TaskID . "'>" . $TaskID . "</a></td>";
	echo "<td><a href='editTask.php?t=" . $TaskID . "'>" . $Task['task_name'] . "</a></td>";
	echo "<td>" . $Clients[$Task['client_id']]['clientname'] . "</td>";
	echo "<td>" . $Depts[$Task['department_id']]['departmentname'] . "</td>";
	echo "<td>" . $Proj . "</td>";
	echo "<td>" . $Sect . "</td>";
	echo "<td>" . $PO . "</td>";
	echo "<td>" . $Task['actual_start_date'] . "</td>";
	echo "<td>" . $Task['actual_end_date'] . "</td>";
	echo "<td>" . $TaskStatusses[$Task['task_status']]['status_name'] . "</td>";
	echo "<td><a href='editTask.php?t=" . $TaskID . "' class='btn btn-outline-custom btn-sm' title='Edit Task'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
</div>
<?php
include("footer.inc.php");
?>