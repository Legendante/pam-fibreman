<?php
include("db.inc.php");
include("header.inc.php");
$Projs = getProjects();
$Clients = getClients();
$Dept = getDepartmentByName("Maintenance - FTTH");
$DeptID = $Dept['departmentid'];
$Tasks = getTasksByDepartment($DeptID);
$Sections = getSections();
$PurchOrders = getPurchaseOrders();
$TaskStatusses = getTaskStatusses();
$tmpSt = array();
foreach($Tasks AS $TaskID => $Task)
{
	$tmpSt[$Task['task_status']] = $Task['task_status'];
}
echo "<div class='row'><div class='col-lg-12'><h3>Maintenance</h3></div></div>";
echo "<div class='row'>";
echo "<div class='col-lg-10'>";
echo "<ul class='nav nav-tabs'>";
$act = " active";
foreach($TaskStatusses AS $StatID => $Stat)
{
	if(isset($tmpSt[$StatID]))
	{
		echo "<li class='nav-item'>";
		echo "<a href='#Win_" . $StatID . "' data-toggle='tab' class='nav-link" . $act . "'><strong>" . $Stat['status_name'] . "</strong></a></li>";
		$act = '';
	}
}
echo "</ul>";
echo "</div>";
echo "<div class='col-lg-2'>";
echo "<a href='logMaintenance.php' class='btn btn-sm btn-outline-primary float-right' title='Add Maintenance'><i class='fa fa-plus'></i></a>";
echo "<a href='genMaintenanceSummary.php' class='btn btn-sm btn-outline-success float-right' style='margin-right: 10px;' target='_blank'><i class='fa fa-download'></i> Summary</a>";
echo "</div>";
echo "</div>";
echo "<div class='tab-content'>\n";
$act = " active";
$Today = date("Y-m-d");
foreach($TaskStatusses AS $StatID => $Stat)
{
	if(isset($tmpSt[$StatID]))
	{
		echo "<div class='tab-pane " . $act . "' id='Win_" . $StatID . "'>\n";
		echo "<table class='table table-bordered table-sm'>\n";
		echo "<tr class='table-custom-header'><th>ID</th><th>Task</th><th>Appointment</th><th>Client</th><th>PO</th><th>Start</th><th>Status</th>\n"; // <th>End</th>
		echo "<th></th></tr>\n";
		$act = '';
		foreach($Tasks AS $TaskID => $Task)
		{
			if($StatID == $Task['task_status'])
			{
				$Maint = getMaintenanceByTaskID($TaskID);
				$PO = ($Task['po_id'] > 0) ? $PurchOrders[$Task['po_id']]['po_number'] : "";
				$HiCls = '';
				if($Today > substr($Maint['apptime'], 0, 10))
					$HiCls = " class='bg-warning'";
				elseif($Today == substr($Maint['apptime'], 0, 10))
					$HiCls = " class='bg-success text-white'";
				echo "<tr" . $HiCls . ">";
				echo "<td><a href='editMaintenance.php?t=" . $TaskID . "'>" . $TaskID . "</a></td>";
				echo "<td><a href='editMaintenance.php?t=" . $TaskID . "'>" . $Task['task_name'] . "</a></td>";
				echo "<td>" . substr($Maint['apptime'], 0, 16) . "</td>";
				echo "<td>" . $Clients[$Task['client_id']]['clientname'] . "</td>";
				echo "<td>" . $PO . "</td>";
				echo "<td>" . substr($Task['actual_start_date'], 0, 10) . "</td>";
				// echo "<td>" . $Task['actual_end_date'] . "</td>";
				echo "<td>" . $TaskStatusses[$Task['task_status']]['status_name'] . "</td>";
				echo "<td><a href='editMaintenance.php?t=" . $TaskID . "' class='btn btn-outline-primary btn-sm' title='Edit Task'><i class='fa fa-pencil'></i></a></td>";
				echo "</tr>\n";
			}
		}
		echo "</table>\n";
		echo "</div>\n";
	}
}
echo "</div>\n";
include("footer.inc.php");
?>