<?php
include("db.inc.php");
include("header.inc.php");
$Projects = getAllSpliceProjects();
$Clients = getClients();
$FStart = date("Y-m-d", mktime(1,1,1,date("m"), 13,date("Y")));
$FEnd = date("Y-m-d", mktime(1,1,1,date("m") + 1, 12, date("Y")));
$FCount = getMonthlySpliceCount($FStart, $FEnd);

$Start = date("Y-m-d", mktime(1,1,1,date("m") - 1, 13,date("Y")));
$End = date("Y-m-d", mktime(1,1,1,date("m"), 12, date("Y")));
$Count = getMonthlySpliceCount($Start, $End);
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
<?php // echo $Start . " :: " . $End . " = " . $Count . "<br>"; ?>
<?php // echo $FStart . " :: " . $FEnd . " = " . $FCount . "<br>"; ?>
	<table class='table table-bordered table-sm'>
	<tr class='table-danger'><th>Project</th><th>Client</th><th>Planned Start</th><th>Planned End</th><th>Actual Start</th><th>Actual End</th><th><a href='editspliceproject.php' class='btn btn-outline-primary btn-sm'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Projects AS $ProjID => $ProjRec)
{
	echo "<tr>";
	echo "<td><a href='editspliceproject.php?pid=" . $ProjID . "'>" . $ProjRec['project_name'] . "</a></td>";
	echo "<td><a href='editclient.php?cid=" . $ProjRec['client_id'] . "'>" . $Clients[$ProjRec['client_id']]['clientname'] . "</a></td>";
	echo "<td>" . $ProjRec['planned_start_date'] . "</td>";
	echo "<td>" . $ProjRec['planned_end_date'] . "</td>";
	echo "<td>" . $ProjRec['actual_start_date'] . "</td>";
	echo "<td>" . $ProjRec['actual_end_date'] . "</td>";
	echo "<td><a href='editspliceproject.php?pid=" . $ProjID . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
	</table>
	</div>
	<div class='tab-pane' id='Proj_2'>
	Second
	</div>
</div>
<?php
include("footer.inc.php");
?>
