<?php
include_once("db.inc.php");
include("header.inc.php");
$ClientID = (isset($_GET['cid'])) ? pebkac($_GET['cid']) : 0;
$Client = getClientByID($ClientID);
$Projs = getProjects();
$Clients = getClients();
$Depts = getDepartments();
$Tasks = getTasks('', $ClientID);
$Sections = getSections();
$PurchOrders = getPurchaseOrders();
$TaskStatusses = getTaskStatusses();
foreach($Tasks AS $TaskID => $Task)
{
	if(($TaskStatusses[$Task['task_status']]['quotable'] != 1) || ($Task['po_id'] != 0))
		unset($Tasks[$TaskID]);
}
?>
<form method='POST' action='genQuote.php'>
<input type='hidden' name='cid' value='<?php echo $ClientID; ?>'>
<div class='panel panel-default'>
	<div class='panel-heading'>Quote for <?php echo $Client['clientname']; ?></div>
	<div class='panel-body'>
		<table class='table table-bordered table-condensed'>
		<tr><th colspan='2'>Quote Name</th><th colspan='6'><input type='text' name='quotename' id='quotename' value='' class='form-control'></th></tr>
		<tr><th></th><th>Task</th><th>Dept</th><th>Project</th><th>Section</th><th>PO</th><th>Start</th><th>End</th><th>Status</th></tr>
<?php
foreach($Tasks AS $TaskID => $Task)
{
	$PO = ($Task['po_id'] > 0) ? $PurchOrders[$Task['po_id']]['po_number'] : "";
	$Proj = ($Task['project_id'] > 0) ? $Projs[$Task['project_id']]['project_name'] : "";
	$Sect = ($Task['section_id'] > 0) ? $Sections[$Task['section_id']]['section_name'] : "";
	
	echo "<tr>";
	echo "<td><input type='checkbox' name='task[]' id='task_" . $TaskID . "' value='" . $TaskID . "'></td>";
	echo "<td><label for='task_" . $TaskID . "'>" . $Task['task_name'] . "</label></td>";
	echo "<td>" . $Depts[$Task['department_id']]['departmentname'] . "</td>";
	echo "<td>" . $Proj . "</td>";
	echo "<td>" . $Sect . "</td>";
	echo "<td>" . $PO . "</td>";
	echo "<td>" . $Task['actual_start_date'] . "</td>";
	echo "<td>" . $Task['actual_end_date'] . "</td>";
	echo "<td>" . $TaskStatusses[$Task['task_status']]['status_name'] . "</td>";
	echo "</tr>";
}
?>
		<tr><td colspan='9'><button type='submit' class='btn btn-success pull-right'><span class='fa fa-save'></span> Generate</button></td></tr>
		</table>
	</div>
</div>
</form>
<?php
include("footer.inc.php");
?>