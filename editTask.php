<?php
include("db.inc.php");
include("header.inc.php");
$TaskID = (isset($_GET['t'])) ? pebkac($_GET['t']) : 0;
$Clients = getClients();
$Depts = getDepartments();
$Task = getTaskByID($TaskID);
$Templates = getBOQTemplates();
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$BOQItems = getTaskBOQItems($TaskID);
$TaskStatusses = getTaskStatusses();
$FileTypes = getTaskFileTypes();
$TaskFiles = getTaskFiles($TaskID);
$FileBatches = array();
foreach($TaskFiles AS $FileID => $File)
{
	$FileBatches[$File['batch']] = $File['batch'];
}
$ItemShow = array();
foreach($BOQCats AS $CatID => $Cat)
{
	foreach($BOQLines AS $LineID => $Line)
	{
		if(($Line['categoryid'] == $CatID) && (isset($BOQItems[$LineID])))
		{
			$ItemShow[$CatID][$LineID] = 1;
		}
	}
}

if($TaskID != 0)
{
	$Projs = getClientProjects($Task['client_id']);
	$PurchOrders = getClientPurchaseOrders($Task['client_id']);
	$Sections = getProjectSections($Task['project_id']);
}
else
{
	$Projs = getProjects();
	$Sections = getSections();
	$PurchOrders = getPurchaseOrders();
}
?>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
	$('#taskstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#taskend').datepicker({"dateFormat": "yy-mm-dd"});
});

function getClientElements()
{
	var clientid = $("#ClientID").val();
	var adate = new Date().getTime();
	
	$('#POID').empty();
	$('#ProjID').empty();
	$('#SectionID').empty();
	
	if(clientid != '')
	{
		$.ajax({async: false, type: "POST", url: "ajaxGetClientProjects.php", dataType: "json",
			data: "dc=" + adate + "&c=" + clientid,
			success: function (feedback)
			{
				var div_data = "<option value=''>-- If applicable --</option>";
				$.each(feedback,function(i,obj)
				{
					div_data += "<option value='" + obj.id + "'>" + obj.project_name + "</option>";
				}); 
				$(div_data).appendTo('#ProjID');
			},
			error: function(request, feedback, error)
			{
				alert("Request failed\n" + feedback + "\n" + error);
				return false;
			}
		});
		$.ajax({async: false, type: "POST", url: "ajaxGetClientPurchase.php", dataType: "json",
			data: "dc=" + adate + "&c=" + clientid,
			success: function (feedback)
			{
				var div_data = "<option value=''>-- If applicable --</option>";
				$.each(feedback,function(i,obj)
				{
					div_data += "<option value='" + obj.id + "'>" + obj.po_number + "</option>";
				});  
				$(div_data).appendTo('#POID'); 
			},
			error: function(request, feedback, error)
			{
				alert("Request failed\n" + feedback + "\n" + error);
				return false;
			}
		});
	}
}

function getProjectSections()
{
	var ProjID = $("#ProjID").val();
	var adate = new Date().getTime();
	
	$('#SectionID').empty();
	
	if(ProjID != '')
	{
		$.ajax({async: false, type: "POST", url: "ajaxGetProjectSections.php", dataType: "json",
			data: "dc=" + adate + "&p=" + ProjID,
			success: function (feedback)
			{
				var div_data = "<option value=''>-- If applicable --</option>";
				$.each(feedback,function(i,obj)
				{
					div_data += "<option value='" + obj.id + "'>" + obj.section_name + "</option>";
					
				}); 
				$(div_data).appendTo('#SectionID');
			},
			error: function(request, feedback, error)
			{
				alert("Request failed\n" + feedback + "\n" + error);
				return false;
			}
		});
	}
}

function showBOQTemplates()
{
	$('#templ-modal').modal("show");
}

function loadBOQTemplate(templateID)
{
	var adate = new Date().getTime();

	$.ajax({async: false, type: "POST", url: "ajaxGetTemplateItems.php", dataType: "html",
		data: "dc=" + adate + "&s=<?php echo $TaskID; ?>&t=" + templateID,
		success: function (feedback)
		{
			$(feedback).appendTo('#boqtable');
			$('#templ-modal').modal("hide");
		},
		error: function(request, feedback, error)
		{
			alert("Request failed\n" + feedback + "\n" + error);
			return false;
		}
	});
}

function deleteBOQItem(lineID)
{
	var adate = new Date().getTime();

	$.ajax({async: false, type: "POST", url: "ajaxDeleteBOQItems.php", dataType: "html",
		data: "dc=" + adate + "&t=<?php echo $TaskID; ?>&l=" + lineID,
		success: function (feedback)
		{
			$('#boqrow_' + lineID).remove();
		},
		error: function(request, feedback, error)
		{
			alert("Request failed\n" + feedback + "\n" + error);
			return false;
		}
	});
}

function calcEst(lineID)
{
	var sum = ($('#boq_est_' + lineID).val() * $('#cost_' + lineID).data('costval'));
	$('#estVal_' + lineID).html('R ' + sum.toFixed(2))
}

function calcAct(lineID)
{
	var sum = ($('#boq_act_' + lineID).val() * $('#cost_' + lineID).data('costval'));
	$('#actVal_' + lineID).html('R ' + sum.toFixed(2))
}
</script>
<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#Proj_1' data-toggle='tab' class='nav-link active'><strong>Task Details</strong></a></li>
	<li class='nav-item'><a href='#Task_Files' data-toggle='tab' class='nav-link'><strong>Files</strong></a></li>
	<li class='nav-item'><a href='#Task_Notes' data-toggle='tab' class='nav-link'><strong>Notes</strong></a></li>
</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<form method='POST' action='saveTask.php' id='projForm'>
		<input type='hidden' name='TaskID' id='TaskID' value='<?php echo $TaskID; ?>'>
		<div class='row'>
			<div class='col-md-2'>Task Name:</div><div class='col-md-5'><input type='text' name='taskName' id='taskName' value='<?php echo $Task['task_name']; ?>' class='validate[required] form-control form-control-sm'></div>
			<div class='col-md-1'>Created:</div><div class='col-md-2'><?php echo $Task['creation_time']; ?></div>
<?php
if($TaskID > 0)
{
?>
		<div class='col-md-1'>
			<div class="dropdown float-right" role="group">
				<button id="btnGroupDrop1" type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload <span class='caret'></span></button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
<?php
foreach($FileTypes AS $ID => $Type)
{
	echo "<a class='dropdown-item' href='uploadTaskFile.php?t=" . $TaskID . "&i=" . $ID . "'>" . $Type['type_name'] . "</a>\n";
}
?>
				</div>
			</div>
		</div>
<?php
}
?>
		</div>
		<div class='row'>
			<div class='col-md-2'>Department:</div><div class='col-md-4'>
			<select name='DeptID' id='DeptID' class='validate[required] form-control form-control-sm'>
			<option value=''>-- Select --</option>
<?php
foreach($Depts AS $DeptID => $Dept)
{
	echo "<option value='" . $DeptID . "'";
	if($Task['department_id'] == $DeptID)
		echo " selected='selected'";
	echo ">" . $Dept['departmentname'] . "</option>\n";
}
?>
			</select>
			</div>
			<div class='col-md-2'>Status:</div><div class='col-md-4'>
			<select name='StatusID' id='StatusID' class='form-control form-control-sm'>
			<option value=''>-- Select --</option>
<?php
foreach($TaskStatusses AS $StatusID => $Status)
{
	echo "<option value='" . $StatusID . "'";
	if($Task['task_status'] == $StatusID)
		echo " selected='selected'";
	echo ">" . $Status['status_name'] . "</option>\n";
}
?>
			</select>			
			</div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Client:</div><div class='col-md-4'>
			<select name='ClientID' id='ClientID' class='validate[required] form-control form-control-sm' onchange='getClientElements();'>
			<option value=''>-- Select --</option>
<?php
foreach($Clients AS $ClientID => $Client)
{
	echo "<option value='" . $ClientID . "'";
	if($Task['client_id'] == $ClientID)
		echo " selected='selected'";
	echo ">" . $Client['clientname'] . "</option>\n";
}
?>
			</select>
			</div>
			<div class='col-md-2'>Purchase Order:</div><div class='col-md-4'>
			<select name='POID' id='POID' class='form-control form-control-sm'>
			<option value=''>-- If applicable --</option>
<?php
foreach($PurchOrders AS $PO_ID => $PO_Rec)
{
	echo "<option value='" . $PO_ID . "'";
	if($Task['po_id'] == $PO_ID)
		echo " selected='selected'";
	echo ">" . $PO_Rec['po_number'] . " - " . $PO_Rec['po_name'] . "</option>\n";
}
?>
			</select>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Project:</div><div class='col-md-4'>
			<select name='ProjID' id='ProjID' class='form-control form-control-sm' onchange='getProjectSections();'>
			<option value=''>-- If applicable --</option>
<?php
foreach($Projs AS $ProjID => $Project)
{
	echo "<option value='" . $ProjID . "'";
	if($Task['project_id'] == $ProjID)
		echo " selected='selected'";
	echo ">" . $Project['project_name'] . "</option>\n";
}
?>
			</select>
			</div>
			<div class='col-md-2'>Section:</div><div class='col-md-4'>
			<select name='SectionID' id='SectionID' class='form-control form-control-sm'>
			<option value=''>-- If applicable --</option>
<?php
foreach($Sections AS $SectionID => $Section)
{
	echo "<option value='" . $SectionID . "'";
	if($Task['section_id'] == $SectionID)
		echo " selected='selected'";
	echo ">" . $Section['section_name'] . "</option>\n";
}
?>
			</select>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Start:</div><div class='col-md-4'><input type='text' name='taskstart' id='taskstart' value='<?php echo $Task['actual_start_date']; ?>' class='form-control form-control-sm'></div>
			<div class='col-md-2'>End:</div><div class='col-md-4'><input type='text' name='taskend' id='taskend' value='<?php echo $Task['actual_end_date']; ?>' class='form-control form-control-sm'></div>
		</div>
		<div class='row'>
			<div class='col-md-1'>PVC lock:</div><div class='col-md-2'><input type='text' name='pvclock' id='pvclock' value='<?php echo $Task['pvc_num']; ?>' class='form-control form-control-sm'></div>
			<div class='col-md-1'>Cable lock:</div><div class='col-md-2'><input type='text' name='cablelock' id='cablelock' value='<?php echo $Task['cable_num']; ?>' class='form-control form-control-sm'></div>
		</div>
		
		<div class='row'><div class='col-md-12'></div></div>
		<div class='row'><div class='col-md-12'><h4>BOQ Items
		<button type='button' class='btn btn-outline-primary btn-sm float-right' onclick='showBOQTemplates();'><i class='fa fa-list'></i> Load from template</button></h4>
		</div></div>
		<div class='row'><div class='col-md-12'>
			<div class='table'>
			<table class='table table-bordered table-sm' id='boqtable'>
			<!-- <tr><th>Item name</th><th>Unit</th><th>Cost</th><th>Est. #</th><th>Act. #</th><th>Est. Cost</th><th>Act. Cost</th></tr> -->
<?php
$OldCat = 0;
foreach($ItemShow AS $CatID => $Lines)
{
	if($OldCat != $CatID)
	{
		echo "<tr><th colspan='8'>" . $BOQCats[$CatID]['categoryname'] . "</th></tr>\n";
		echo "<tr><th>Item name</th><th>Unit</th><th>Cost</th><th>Est. #</th><th>Act. #</th><th>Est. Cost</th><th>Act. Cost</th><th></th></tr>\n";
		foreach($Lines AS $LineID => $One)
		{
			echo "<tr id='boqrow_" . $LineID . "'><td>" . $BOQLines[$LineID]['item_name'] . "</td>";
			echo "<td>" . $BOQUnits[$BOQLines[$LineID]['unitid']]['unitname'] . "</td>";
			echo "<td id='cost_" . $LineID . "' data-costval='" . $BOQLines[$LineID]['defaultcost'] . "'>R " . $BOQLines[$LineID]['defaultcost'] . "</td>";
			echo "<td><input type='text' name='boq_est_" . $LineID . "' id='boq_est_" . $LineID . "' value='" . $BOQItems[$LineID]['estimated'] . "' class='form-control form-control-sm' onchange='calcEst(" . $LineID . ");'></td>";
			echo "<td><input type='text' name='boq_act_" . $LineID . "' id='boq_act_" . $LineID . "' value='" . $BOQItems[$LineID]['completed'] . "' class='form-control form-control-sm' onchange='calcAct(" . $LineID . ");'></td>";
			echo "<td id='estVal_" . $LineID . "'>" . sprintf("R %0.2f", $BOQItems[$LineID]['estimated'] * $BOQLines[$LineID]['defaultcost']) . "</td>";
			echo "<td id='actVal_" . $LineID . "'>" . sprintf("R %0.2f", $BOQItems[$LineID]['completed'] * $BOQLines[$LineID]['defaultcost']) . "</td>";
			echo "<td>";
			if(($BOQItems[$LineID]['estimated'] == 0) && ($BOQItems[$LineID]['completed'] == 0))
				echo "<button type='button' class='btn btn-sm btn-outline-danger' title='Delete Item' onclick='deleteBOQItem(" . $LineID . ");'><i class='fa fa-times'></i></button>";
			echo "</td>";
			echo "</tr>\n";
		}
		$OldCat = $CatID;
	}
}
?>

			</table>
			</div>
		</div></div>
		<div class='row'><div class='col-md-2'><button type='submit' class='btn btn-sm btn-outline-success'><span class='fa fa-save'></span> Save</button></div></div>
		</form>
	</div>
	<div class='tab-pane' id='Task_Files'>	
<?php
foreach($FileTypes AS $ID => $Type)
{
	echo "<div class='panel panel-default'>";
	echo "<div class='panel-heading'>" . $Type['type_name'];
if($TaskID > 0)
{
?>
		<div class="dropdown float-right dropleft" role="group">
			<button id="btnGroupDrop1" type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload <span class='caret'></span></button>
			<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
<?php
foreach($FileTypes AS $tmpID => $tmpType)
{
	echo "<a class='dropdown-item' href='uploadTaskFile.php?t=" . $TaskID . "&i=" . $tmpID . "'>" . $tmpType['type_name'] . "</a>\n";
}
?>
			</div>
		</div>
<?php
}
	if($Type['has_thumbnail'] == 1)
	{
		echo "<a href='taskPhotoSheet.php?t=" . $TaskID . "&i=" . $ID . "' class='btn btn-sm btn-outline-danger' title='Generate photo sheet'><i class='fa fa-file-excel-o'></i></a>";
	}
	echo "</div>";
	echo "<div class='panel-body'>";
	echo "<div class='row'>";
	$cnt = -1;
	foreach($TaskFiles AS $FileID => $File)
	{
		if($File['type_id'] == $ID)
		{
			// foreach($FileBatches AS $BatchID)
			// {
				if($File['batch'] == 0)
				{
					if($Type['has_thumbnail'] == 0)
					{
						echo "<div class='col-md-12'><a href='" . $File['filepath'] . "'>111 " . $File['filepath'] . "</a>";
						echo "<a href='archiveFile.php?t=" . $TaskID . "&f=" . $FileID . "' class='float-right'><i class='fa fa-archive'></i> Archive</a></div>";
					}
					else
					{
						echo "<div class='col-md-4'><div class='card' style='width: 20rem;'>";
						if(file_exists($File['thumbnail']))
							echo "<img class='card-img-top' src='" . $File['thumbnail'] . "' alt='Thumbnail'>";
						else
							echo "<img class='card-img-top' src='" . $File['filepath'] . "' alt='Thumbnail'>";
						echo "<div class='card-block'>";
						// echo "<h4 class='card-title'>" . $File['filepath'] . "</h4>";
						echo "<a href='" . $File['filepath'] . "'>Download</a>";
						echo "<a href='archiveFile.php?t=" . $TaskID . "&f=" . $FileID . "' class='float-right'><i class='fa fa-archive'></i> Archive</a><br>";
						echo $FileTypes[$File['type_id']]['type_name'] . "<br>";
						echo "</div>";
						echo "</div></div>";
					}
					$cnt++;
				}
			// }
		}
	}
	if($cnt == -1)
		echo "<div class='row'><div class='col-md-12'><em>No files uploaded</em></div></div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}	
?>
	</div>
	<div class='tab-pane' id='Task_Notes'>
	<form method='POST' action='saveTaskNote.php' id='projForm'>
	<input type='hidden' name='NoteTaskID' id='NoteTaskID' value='<?php echo $TaskID; ?>'>
	<div class='row'><div class='col-md-12'><textarea id='TaskNote' name='TaskNote' class='form-control form-control-sm'></textarea></div></div>
	<div class='row'><div class='col-md-12'><button type='submit' class='btn btn-sm btn-outline-success float-right'><span class='fa fa-save'></span> Save</button></div></div>
	</form>
<?php
$Users = getAllUsers();
$Notes = getTaskNotes($TaskID);
foreach($Notes AS $ID => $Note)
{
	echo "<div class='panel panel-default'>";
	echo "<div class='panel-heading'>";
	echo "<div class='row'><div class='col-md-6'><strong>By:</strong> " . $Users[$Note['userid']]['firstname'] . " " . $Users[$Note['userid']]['surname'] . "</div>";
	echo "<div class='col-md-6'><strong>Date:</strong> " . $Note['creationdate'] . "</div></div>";
	echo "</div>";
	echo "<div class='panel-body'>";
	echo "<div class='row'><div class='col-md-12'>" . $Note['noteval'] . "</div></div>";
	echo "</div></div>";
	
}
?>	
	</div>
</div>

<div class='modal fade' id='templ-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'><strong>BOQ Template</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='btn-group-vertical'>
<?php
foreach($Templates AS $TempID => $Template)
{
	// echo "<div class='row'><div class='col-md-6'>";
	echo "<button type='button' class='btn btn-sm btn-outline-primary' onclick='loadBOQTemplate(" . $TempID . ");'>" . $Template['template_name'] . "</button>";
	// echo "</div></div>";
}
?>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
			</div>
		</div>
	</div>
</div>
<?php
include("footer.inc.php");
?>