<?php
include("db.inc.php");
include("header.inc.php");
$TaskStatusses = getTaskStatusses();
$Projs = getProjects();
$Clients = getClients();
$BOQLines = getBOQLineItems();
$Dept = getDepartmentByName("Engineering");
$DeptID = $Dept['departmentid'];
$Sections = getSections();
$PurchOrders = getPurchaseOrders();
$tmpSt = array();
$tmpPr = array();
$Tasks = getTasksByDepartment($DeptID);
$PrjCnt = array();
$PrjTot = array();
foreach($Tasks AS $TaskID => $Task)
{
	if(!isset($PrjCnt[$Task['project_id']]))
		$PrjCnt[$Task['project_id']] = array();
	if(!isset($PrjCnt[$Task['project_id']][$Task['task_status']]))
		$PrjCnt[$Task['project_id']][$Task['task_status']] = 0;
	$PrjCnt[$Task['project_id']][$Task['task_status']]++;
	if(!isset($PrjTot[$Task['project_id']]))
		$PrjTot[$Task['project_id']] = 0;
	$PrjTot[$Task['project_id']]++;
	$tmpSt[$Task['task_status']] = $Task['task_status'];
	$tmpPr[$Task['task_status']][$Task['project_id']] = $Task['project_id'];
}
echo "<div class='row'><div class='col-lg-12'><h3>Engineering</h3></div></div>\n";
echo "<ul class='nav nav-tabs'>\n";
$act = " active";
foreach($TaskStatusses AS $StatID => $Stat)
{
	if(isset($tmpSt[$StatID]))
	{
		echo "<li class='nav-item'><a href='#Win_" . $StatID . "' data-toggle='tab' class='nav-link" . $act . "'><strong>" . $Stat['status_name'] . "</strong></a></li>\n";
		$act = '';
	}
}
echo "</ul>";
echo "<div class='tab-content'>\n";
$act = " active show";
foreach($TaskStatusses AS $StatID => $Stat)
{
	if(isset($tmpSt[$StatID]))
	{
		echo "<div class='tab-pane fade " . $act . "' id='Win_" . $StatID . "'>\n";
		echo "<div class='panel-group'>\n";
		$act = '';
		$HiL = 0;
		foreach($tmpPr[$StatID] AS $PrjID)
		{
			$Files = getProjectFiles($PrjID);
			
			$Proj = $Projs[$PrjID]['project_name'];
			if($HiL == 0)
				echo "<div class='card bg-light'><div class='card-header'>";
			else
				echo "<div class='card bg-secondary'><div class='card-header text-white'>";
			echo "<h5>Project: " . $Proj . "<a href='#prjpanel_" . $PrjID . "' onclick='$(\"i\", this).toggleClass(\"fa-toggle-down fa-toggle-up\");' class='btn btn-sm btn-outline-custom float-right' data-toggle='collapse'>";
			echo "<i class='fa fa-toggle-up'></i></a>\n";
			$HiL = !$HiL;
			if(count($PrjCnt) > 0)
			{
				echo "<button type='button' class='btn btn-outline-info btn-sm float-right' style='margin-right: 10px;' title='Project Details' data-toggle='collapse' data-target='#prjcharts_" . $StatID . "_" . $PrjID . "'>";
				echo "<i class='fa fa-bar-chart'></i></button>\n";
			}
			if(count($Files) > 0)
			{
				echo "<button type='button' class='btn btn-outline-success btn-sm float-right' style='margin-right: 10px;' title='I have files for this project' data-toggle='collapse' data-target='#prjfiles_" . $StatID . "_" . $PrjID . "'>";
				echo "<i class='fa fa-file'></i></button>\n";
			}
			echo "<a href='editTask.php' class='btn btn-sm btn-outline-primary float-right' style='margin-right: 10px;' title='Add Task'><i class='fa fa-plus'></i></a>";
			echo "</h5></div>\n";
			echo "<div class='card-body collapse show' id='prjpanel_" . $PrjID . "'>\n";
			if(count($Files) > 0)
			{
				echo "<div id='prjfiles_" . $StatID . "_" . $PrjID . "' class='row collapse'><div class='col-lg-3'>\n";
				echo "<table class='table table-bordered table-sm table-light'>\n";
				echo "<tr class='table-custom-header'><th>Files</th></tr>";
				foreach($Files AS $FileID => $FileRec)
				{
					echo "<tr><td><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></td></tr>\n";
				}
				echo "</table></div></div>\n";
			}
			if(count($PrjCnt[$PrjID]) > 0)
			{
				$BOQCounts = getProjectBOQCount($PrjID);
				echo "<div id='prjcharts_" . $StatID . "_" . $PrjID . "' class='collapse'>\n";
				echo "<div class='row'><div class='col-sm'>\n";
				echo "<table class='table table-bordered table-sm table-light'>\n";
				echo "<tr class='table-custom-header'><th>Status</th><th>#</th><th>%</th></tr>";
				foreach($PrjCnt[$PrjID] AS $PrjStatID => $PrjCounter)
				{
					$Perc = sprintf("%0.2f", (($PrjCounter / $PrjTot[$PrjID]) * 100));
					echo "<tr><td>" . $TaskStatusses[$PrjStatID]['status_name'] . "</td><td>" . $PrjCounter . "</td><td>" . $Perc . "%</td></tr>";
				}
				echo "</table>\n";
				echo "</div><div class='col-sm'>";
				if(count($BOQCounts) > 0)
				{
					echo "<table class='table table-bordered table-sm table-light'>\n";
					echo "<tr class='table-custom-header'><th>Item</th><th>Estimated</th><th>Completed</th><th>%</th></tr>";
					foreach($BOQCounts AS $BOQItemID => $BOQArr)
					{
						if(($BOQArr['estimated'] > 0) || ($BOQArr['completed'] > 0))
						{
							$Perc = ($BOQArr['estimated'] > 0) ? sprintf("%0.2f", (($BOQArr['completed'] / $BOQArr['estimated']) * 100)) : "0.00";
							echo "<tr><td>" . $BOQLines[$BOQArr['item_id']]['item_name'] . "</td><td>" . $BOQArr['estimated'] . "</td><td>" . $BOQArr['completed'] . "</td><td>" . $Perc . "%</td></tr>";
						}
					}
					echo "</table>\n";
				}
				echo "</div><div class='col-sm'></div><div class='col-sm'></div></div></div>\n";
			}
			echo "<table class='table table-bordered table-sm table-light'>\n";
			echo "<tr class='table-custom-header'><th>ID</th><th>Task</th><th>Client</th><th>Section</th><th>PO</th><th>Start</th><th>End</th><th>Status</th><th></th></tr>\n";
			$SecID = 0;
			$rowCt = 0;
			$rowHi = '';
			$SectFiles = array();
			foreach($Tasks AS $TaskID => $Task)
			{
				if(($StatID == $Task['task_status']) && ($PrjID == $Task['project_id']))
				{
					if($rowCt != $Task['section_id'])
					{
						$rowCt = $Task['section_id'];
						$SecID = !$SecID;
						$rowHi = '';
						$SectFiles = getSectionFiles($Task['section_id']);
						// print_r($SectFiles);
					}
					$rowHi = ($SecID == 0) ? '' : " class='table-info'";
					$PO = ($Task['po_id'] > 0) ? $PurchOrders[$Task['po_id']]['po_number'] : "";
					$Sect = ($Task['section_id'] > 0) ? $Sections[$Task['section_id']]['section_name'] : "";
					echo "<tr" . $rowHi . ">";
					echo "<td><a href='editTask.php?t=" . $TaskID . "'>" . $TaskID . "</a></td>";
					echo "<td><a href='editTask.php?t=" . $TaskID . "'>" . $Task['task_name'] . "</a></td>";
					echo "<td>" . $Clients[$Task['client_id']]['clientname'] . "</td>";
					echo "<td>" . $Sect;
					if(count($SectFiles) > 0)
					{
						echo "<button type='button' class='btn btn-outline-success btn-sm float-right' title='I have files for this section' data-toggle='collapse' data-target='#sc_" . $Task['section_id'] . "'>";
						echo "<i class='fa fa-file'></i></button>\n";
					}
					echo "</td>";
					echo "<td>" . $PO . "</td>";
					echo "<td>" . $Task['actual_start_date'] . "</td>";
					echo "<td>" . $Task['actual_end_date'] . "</td>";
					echo "<td>" . $TaskStatusses[$Task['task_status']]['status_name'] . "</td>";
					echo "<td><a href='editTask.php?t=" . $TaskID . "' class='btn btn-outline-primary btn-sm' title='Edit Task'><i class='fa fa-pencil'></i></a></td>";
					echo "</tr>\n";
					if(count($SectFiles) > 0)
					{
						echo "<tr id='sc_" . $Task['section_id'] . "' class='collapse'><td colspan='9'>";
						foreach($SectFiles AS $FileID => $FileRec)
						{
							echo "<div class='row'><div class='col-md-12'><a href='" . $FileRec['filepath'] . "' target='_blank'>" . $FileRec['filename'] . "</a></div></div>\n";
						}
						echo "</td></tr>";
					}
				}
			}
			echo "</table>\n";
			echo "</div>\n";
			echo "</div>\n";
		}
		echo "</div>\n";
		echo "</div>\n";
	}
}
echo "</div>\n";
include("footer.inc.php");
?>