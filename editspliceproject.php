<?php
include("db.inc.php");
include("header.inc.php");
$ProjID = (isset($_GET['pid'])) ? pebkac($_GET['pid']) : 0;
$Clients = getClients();
$Proj = getSpliceProjectByID($ProjID);
$Sections = getSpliceSectionByProjectID($ProjID);
$EmptySections = $Sections;
$ProjClient = $Proj['client_id'];
$CostTemplate = getSpliceProjectCostTemplate();
$ProjCosts = getSpliceProjectCostsByProjectID($ProjID);
$Joins = getSpliceSectionJoinsByProjectID($ProjID);
$Diary = getSpliceProjectDiaryByProjectID($ProjID);
$Users = getAllUsers();
$usrPrivs = getUsersWithPrivilege("In Field");
$PurchaseOrders = getClientPurchaseOrders($ProjClient);
$TotalSplices = 0;
$CompletedSplices = 0;
$NumSections = 0;
$NumJoins = 0;
$SecSpliceCnts = array();
$CompSecSpliceCnts = array();
$CompSpliceCnts = array();
$CompDomeCnts = array();
$StatBreak = array();
$IncSecs = array();
$FinSecs = array();
foreach($Joins AS $SectionID => $SectionRec)
{
	$NumSections++;
	
	foreach($SectionRec AS $JoinID => $JoinRec)
	{
		if(($JoinRec['join_status'] != 2) && ($JoinRec['join_status'] != 3))
			$IncSecs[$SectionID] = $Sections[$SectionID];
		else
			$FinSecs[$SectionID] = $Sections[$SectionID];
		unset($EmptySections[$SectionID]);
		$NumJoins++;
		$TotalSplices += $JoinRec['num_splices'];
		if(!isset($SecSpliceCnts[$SectionID]))
			$SecSpliceCnts[$SectionID] = 0;
		$SecSpliceCnts[$SectionID] += $JoinRec['num_splices'];
		if(!isset($StatBreak[$JoinRec['join_status']]))
			$StatBreak[$JoinRec['join_status']] = 0;
		$StatBreak[$JoinRec['join_status']]++;
	}
}

foreach($Diary AS $TheDay => $TheDayRec)
{
	foreach($TheDayRec AS $DayID => $DayRec)
	{
		$CompletedSplices += $DayRec['num_splices_completed'];
		if(!isset($CompSecSpliceCnts[$DayRec['section_id']]))
			$CompSecSpliceCnts[$DayRec['section_id']] = 0;
		$CompSecSpliceCnts[$DayRec['section_id']] += $DayRec['num_splices_completed'];
		if(!isset($CompSpliceCnts[$DayRec['join_id']]))
			$CompSpliceCnts[$DayRec['join_id']] = 0;
		$CompSpliceCnts[$DayRec['join_id']] += $DayRec['num_splices_completed'];
		if(!isset($CompDomeCnts[$DayRec['join_id']]))
			$CompDomeCnts[$DayRec['join_id']] = 0;
		$CompDomeCnts[$DayRec['join_id']] += $DayRec['num_domes_completed'];
	}
}
?>
<style>
.half-rule { 
    margin-left: 0;
    text-align: left;
    width: 50%;
	border-bottom: 1px solid #f0f0f0;
 }
</style>
<script>
$(document).ready(function()
{
	$("#projForm").validationEngine();
	$("#secForm").validationEngine();
	$("#joinForm").validationEngine();
	$('#pstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#pend').datepicker({"dateFormat": "yy-mm-dd"});
	$('#astart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#aend').datepicker({"dateFormat": "yy-mm-dd"});
	$('#spstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#spend').datepicker({"dateFormat": "yy-mm-dd"});
	$('#asstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#asend').datepicker({"dateFormat": "yy-mm-dd"});
	$('#jnpstart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#jnpend').datepicker({"dateFormat": "yy-mm-dd"});
	$('#jnastart').datepicker({"dateFormat": "yy-mm-dd"});
	$('#jnaend').datepicker({"dateFormat": "yy-mm-dd"});
    $('[data-toggle="popover"]').popover({ html : true});   
});

function openSection(SectionID)
{
	$('#secSectionID').val(SectionID);
	$('#secName').val('');
	$('#secCreated').html('');
	$('#spstart').val('');
	$('#spend').val('');
	$('#asstart').val('');
	$('#asend').val('');
	if(SectionID != 0)
	{
		$('#secName').val($('#sec_' + SectionID + '_name').html());
		$('#secCreated').html($('#sec_' + SectionID + '_created').val());
		$('#spstart').val($('#sec_' + SectionID + '_ps').html());
		$('#spend').val($('#sec_' + SectionID + '_pe').html());
		$('#asstart').val($('#sec_' + SectionID + '_as').html());
		$('#asend').val($('#sec_' + SectionID + '_ae').html());
	}
	$('#section-modal').modal("show");
}

function openJoin(SectionID, JoinID)
{
	$('#dmSectionID').val(SectionID);
	$('#dmJoinID').val(JoinID);
	$('#joinName').val('');
	$('#joinPONum').val('');
	$('#joinCreated').html('');
	$('#joinNumSplices').val('');
	$('#joinNumDomes').val('');
	$('#joinType').html('');
	$('#joinManhole').val('');
	$('#jnpstart').val('');
	$('#jnpend').val('');
	$('#jnastart').val('');
	$('#jnaend').val('');
	$('#joinAddress').val('');
	$('#joinPOID').val('');
	if(SectionID != 0)
	{
		$('#joinName').val($('#join_' + JoinID + '_name').html());
		$('#joinCreated').html($('#join_' + JoinID + '_created').val());
		$('#joinNumSplices').val($('#join_' + JoinID + '_splices').html());
		$('#joinNumDomes').val($('#join_' + JoinID + '_domes').html());
		$('#joinPONum').val($('#join_' + JoinID + '_ponum').val());
		$('#joinType').html($('#join_' + JoinID + '_type').html());
		// $('#joinManhole').val($('#join_' + JoinID + '_name').html());
		// $('#jnpstart').val($('#join_' + JoinID + '_name').html());
		// $('#jnpend').val($('#join_' + JoinID + '_name').html());
		$('#jnastart').val($('#join_' + JoinID + '_as').html());
		$('#jnaend').val($('#join_' + JoinID + '_ae').html());
		$('#joinAddress').val($('#join_' + JoinID + '_address').val());
		var po_id = $('#join_' + JoinID + '_poid').val();
		if(po_id == 0)
			po_id = '';
		$('#joinPOID').val(po_id);
	}
	$('#join-modal').modal("show");
}
</script>
<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#Proj_1' class='nav-link' data-toggle='tab'><strong>Project Details</strong></a></li>
	<li class='nav-item'><a href='#Proj_2' class='nav-link active' data-toggle='tab'><strong>Sections</strong><button type='button' class='btn btn-sm btn-outline-primary float-right' style='margin-left: 10px;' onclick='openSection(0)'><i class='fa fa-plus'></i></button></a></li>
	<!-- <li class='float-right'><a href='editproject.php'><i class='fa fa-plus'></i> Add Project</a></li> -->
</ul>
<div class='tab-content'>
	<div class='tab-pane' id='Proj_1'>
	<form method='POST' action='saveSpliceProject.php' id='projForm'>
	<input type='hidden' name='pid' id='pid' value='<?php echo $ProjID; ?>'>
	<div class='row'><div class='col-md-12'><strong>Project Details</strong></div></div>
	<div class='row'>
		<div class='col-md-2'>Project Name:</div><div class='col-md-4'><select name='client_id' id='client_id' class='validate[required] form-control form-control-sm'>
		<option value=''>-- Select one --</option>
<?php
	foreach($Clients AS $ClientID => $ClientRec)
	{
		echo "<option value='" . $ClientID . "'";
		if($Proj['client_id'] == $ClientID)
			echo " selected='selected'";
		echo ">" . $ClientRec['clientname'] . "</option>";
	}
?>
		</select></div></div>
	<div class='row'>
		<div class='col-md-2'>Project Name:</div><div class='col-md-4'><input type='text' name='projName' id='projName' value='<?php echo $Proj['project_name']; ?>' class='validate[required] form-control form-control-sm'></div>
		<div class='col-md-2'>Created:</div><div class='col-md-4'><?php echo $Proj['creation_time']; ?>
		<a href='genQuote.php?p=<?php echo $ProjID; ?>' class='float-right'>Quote</a>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Project Manager:</div><div class='col-md-4'><input type='text' name='projManager' id='projManager' value='<?php echo $Proj['proj_manager']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Site Manager:</div><div class='col-md-4'><input type='text' name='siteManager' id='siteManager' value='<?php echo $Proj['site_manager']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Wayleave:</div><div class='col-md-4'><input type='text' name='wayleave' id='wayleave' value='<?php echo $Proj['way_leave']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Contractor:</div><div class='col-md-4'><input type='text' name='contractor' id='contractor' value='<?php echo $Proj['contractor']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Planned Start:</div><div class='col-md-4'><input type='text' name='pstart' id='pstart' value='<?php echo $Proj['planned_start_date']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Planned End:</div><div class='col-md-4'><input type='text' name='pend' id='pend' value='<?php echo $Proj['planned_end_date']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'>
		<div class='col-md-2'>Actual Start:</div><div class='col-md-4'><input type='text' name='astart' id='astart' value='<?php echo $Proj['actual_start_date']; ?>' class='form-control form-control-sm'></div>
		<div class='col-md-2'>Actual End:</div><div class='col-md-4'><input type='text' name='aend' id='aend' value='<?php echo $Proj['actual_end_date']; ?>' class='form-control form-control-sm'></div>
	</div>
	<div class='row'><div class='col-md-12'><hr class="half-rule"/></div></div>
	<div class='row'><div class='col-md-12'><strong>Timeline</strong></div></div>
	
		
<?php
if(($Proj['planned_start_date'] != '') && ($Proj['planned_end_date'] != ''))
{
	$Holidays = getPublicHolidays();
	$current_date = new DateTime();
	$begin = new DateTime($Proj['planned_start_date']);
	$end = new DateTime($Proj['planned_end_date']);
	$end = $end->modify('+1 day');
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($begin, $interval, $end);
	$rowStart = 0;
	$i = 1;
	$WorkingDayTotal = 0;
	$WeekendDayTotal = 0;
	$PublicHDayTotal = 0;
	$DaysLeft = 0;
	$DaysDone = 0;
	foreach ($period as $dt)
	{
		if($dt->format("N") > 5)
			$WeekendDayTotal++;
		elseif(isset($Holidays[$dt->format('Y-m-d')]))
			$PublicHDayTotal++;
		else
		{
			$WorkingDayTotal++;
			if($current_date->format('Y-m-d') <= $dt->format('Y-m-d'))
				$DaysLeft++;
			else
				$DaysDone++;
		}
	}
	$TotalAvg = ceil($TotalSplices / $WorkingDayTotal);
	echo "<div class='row'><div class='col-md-12'>";
	echo "<table border='1' cellpadding='0' cellspacing='0' class='table table-bordered table-sm'>";
	echo "<tr><td><strong>Total Sections:</strong> " . $NumSections . "</td>";
	echo "<td><strong>Total Joins:</strong> " . $NumJoins . "</td>";
	echo "<tr><td><strong>Total Splices:</strong> " . $TotalSplices . "</td>";
	echo "<td><strong>Total Days:</strong> " . $WorkingDayTotal . "</td>";
	echo "<td><strong>Avg. Splices per day:</strong> " . $TotalAvg . "</td>";
	echo "<td style='background-color: #CCFFCC;'><strong>Weekend Days:</strong> " . $WeekendDayTotal . "</td>";
	echo "<td style='background-color: #BE33FF;'><strong>Holiday Days:</strong> " . $PublicHDayTotal . "</td></tr>";
	echo "<tr><td><strong>Completed Splices:</strong> " . $CompletedSplices . "</td>";
	echo "<td><strong>Days completed:</strong> " . $DaysDone . "</td>";
	$CompAvg = 0;
	if($DaysDone > 0)
		$CompAvg = ceil($CompletedSplices  / $DaysDone);
	echo "<td><strong>Avg. Splices per day:</strong> " . $CompAvg . "</td>";
	if($CompAvg < $TotalAvg)
		echo "<td style='background-color: #FF6666;'><strong>Health:</strong> Bad</td>";
	else
		echo "<td style='background-color: #CCFFCC;'><strong>Health:</strong> Good</td>";
	echo "</tr>";
	$LeftAvg = ceil(($TotalSplices - $CompletedSplices)  / $DaysLeft);
	echo "<tr><td><strong>Splices left:</strong> " . ($TotalSplices - $CompletedSplices) . "</td>";
	echo "<td><strong>Days left:</strong> " . $DaysLeft . "</td>";
	echo "<td><strong>Avg. Splices per day:</strong> " . $LeftAvg . "</td>";
	if($LeftAvg > $TotalAvg)
		echo "<td style='background-color: #FF6666;'><strong>Health:</strong> Bad</td>";
	else
		echo "<td style='background-color: #CCFFCC;'><strong>Health:</strong> Good</td>";
	echo "</tr>";
	echo "</table></div></div>";
	echo "<div class='row'><div class='col-md-12'>";
	echo "<table border='1' cellpadding='0' cellspacing='0' class='table table-bordered table-sm'>";
	foreach ($period as $dt)
	{
		$DayOfWeek = $dt->format('d');
		$DtDate = $dt->format('Y-m-d');
		if($rowStart == 0)
		{
			echo "<tr><th style='padding: 0px 5px 0px 5px;'>" . $dt->format('M') . "</th>";
			$rowStart = 1;
		}
		$DayBG = '';
		$PopOTitle = "title='" . $dt->format('D') . " " . $DtDate . "'";
		$PopOContent = "";
		$PopOToggle = " data-toggle='popover' data-trigger='hover' data-placement='top'";
		$TotComp = 0;
		if(isset($Diary[$DtDate]))
		{
			foreach($Diary[$DtDate] AS $DayID => $DayRec)
			{
				$TotComp += $DayRec['num_splices_completed'];
			}
		}
		$DayGoal = 1;
		if($TotalAvg > $TotComp)
			$DayGoal = 0;
		if($current_date->format('Y-m-d') == $DtDate)
		{
			$DayBG = " style='background-color: #FFFF00;'";
			$PopOContent = " data-content='<strong>Splices completed:</strong> " . $TotComp . "'";
		}
		elseif($current_date > $dt)
		{
			$PopOContent = " data-content='<strong>Splices completed:</strong> " . $TotComp . "'";
			if($dt->format("N") > 5)
				$DayBG = " style='background-color: #CCFFCC;'";
			elseif(isset($Holidays[$DtDate]))
				$DayBG = " style='background-color: #BE33FF;'";
			else
			{
				if($DayGoal == 1)
					$DayBG = " style='background-color: #33FFF0;'";
				else
					$DayBG = " style='background-color: #FF9933;'";
			}
		}
		else // In the future
		{
			$PopOTitle = "";
			$PopOContent = "";
			$PopOToggle = "";
			if($dt->format("N") > 5)
				$DayBG = " style='background-color: #CCCCCC;'";
			elseif(isset($Holidays[$DtDate]))
				$DayBG = " style='background-color: #BE33FF;'";
		}
		echo "<td" . $DayBG . " " . $PopOToggle . $PopOTitle . $PopOContent . ">" . $DayOfWeek . "</td>";
		// if(($i % 60) == 0)
		if($dt->format("t") == $dt->format("d"))
		{
			echo "</tr>";
			$rowStart = 0;
		}
		$i++;
	}
}
?>
		</table>
		</div>
	</div>
	<div class='row'><div class='col-md-12'><hr class="half-rule"/></div></div>
	<div class='row'><div class='col-md-12'><strong>Project Costs</strong></div></div>
<?php
$Cnt = 0;
foreach($CostTemplate AS $CostID => $CostRec)
{
	$Cost = (!isset($ProjCosts[$CostID]['cost_id'])) ? $CostRec['item_cost_default'] : $ProjCosts[$CostID]['item_cost'];
	echo "<div class='row'>";
	echo "<div class='col-md-2'>" . $CostRec['item_name'] . "</div>";
	echo "<div class='col-md-2'>" . $CostRec['item_unit'] . "</div>";
	echo "<div class='col-md-4'><input type='text' name='cost_" . $CostID . "' id='cost_" . $CostID . "' value='" . $Cost . "' class='form-control form-control-sm'></div>";
	if($Cnt == 0)
		echo "<div class='col-md-2'><a href='spliceProjectQuote.php?pid=" . $ProjID . "'><i class='fa fa-file-excel-o'></i> Quote</a></div>";
	echo "</div>";
	$Cnt = 1;
}
?>
	<div class='row'>
		<div class='col-md-12'><button type='submit' class='btn btn-sm btn-outline-success'><i class='fa fa-save'></i> Save</button></div>
	</div>
	</form>
	</div>
	<div class='tab-pane active' id='Proj_2'>
	<table class='table table-bordered table-striped table-sm'>
	<tr>
<?php
foreach($StatBreak AS $Status => $count)
{
	$Txt = '';
	switch($Status)
	{
		case 0:
			$Txt = 'In progress';
			break;
		case 1:
			$Txt = 'Spliced';
			break;
		case 2:
			$Txt = 'Tested';
			break;
		case 3:
			$Txt = 'Invoiced';
			break;
		case 4:
			$Txt = '';
			break;
		case 5:
			$Txt = 'External';
			break;
		case 13:
			$Txt = 'Problem';
			break;
		default:
			$Txt = $Status;
			break;
	}
	echo "<td>" . $Txt . " = " . $count . "</td>";
}
?>
	</tr>
	</table>
	<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#SecWin_1' class='nav-link active' data-toggle='tab'><strong>Current</strong></a></li>
	<li class='nav-item'><a href='#SecWin_2' class='nav-link' data-toggle='tab'><strong>Tested or Invoiced</strong></a></li>
	<li class='nav-item'><a href='#SecWin_3' class='nav-link' data-toggle='tab'><strong>Empty sections</strong></a></li>
	</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='SecWin_1'>
	<table class='table table-bordered table-striped table-sm'>
<?php
foreach($IncSecs AS $SectionID => $Section)
{
	$DoneCnt = (isset($CompSecSpliceCnts[$SectionID])) ? $CompSecSpliceCnts[$SectionID] : 0;
	$TotCnt = (isset($SecSpliceCnts[$SectionID])) ? $SecSpliceCnts[$SectionID] : 0; 
	$RowBG = "";
	if(($TotCnt > 0) && ($DoneCnt >= $TotCnt))
		$RowBG = " class='table-success'";
	echo "<input type='hidden' id='sec_" . $SectionID . "_created' value='" . $Section['creation_time'] . "'>";
	echo "<tr class='table-danger'><th>ID</th><th>Section</th><th>Total Splices</th>";
	echo "<th colspan='2'><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(0)'><i class='fa fa-plus'></i> Add Section</button></th></tr>";
	echo "<tr" . $RowBG . ">";
	echo "<td>" . $SectionID . "</td>";
	echo "<td><span id='sec_" . $SectionID . "_name'>" . $Section['section_name'] . "</span>";
	if((!isset($Joins[$SectionID])) || (count($Joins[$SectionID]) == 0))
		echo "<a href='deleteSection.php?p=" . $ProjID . "&s=" . $SectionID . "' class='float-right text-danger' title='Delete section'><i class='fa fa-times'></i></a>";
	echo "</td>";
	echo "<td>" . $DoneCnt . " / " . $TotCnt . "</td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(" . $SectionID . ")'><i class='fa fa-pencil'></i></button></td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openJoin(" . $SectionID . ", 0)'><i class='fa fa-plus'></i> Add Join</button>";
	
	echo "</td>";
	echo "</tr>";
	if(isset($Joins[$SectionID]) && (count($Joins[$SectionID]) > 0))
	{
		echo "<tr><td colspan='5'><table class='table table-bordered table-striped table-sm'>";
		echo "<tr><td colspan='11'><strong>Joins</strong></td></tr>";
		echo "<tr class='table-danger'><th>ID</th><th>Join</th><th>Num Splices</th><th>Num Domes</th><th>Address</th><th>PO</th><th>Start</th><th>End</th><td colspan='3'></td></tr>";
		foreach($Joins[$SectionID] AS $JoinID => $JoinRec)
		{
			if(($JoinRec['join_status'] != 2) && ($JoinRec['join_status'] != 3))
			{
				$selQry = 'SELECT COUNT(*) AS num_photos FROM core_splice_join_photos WHERE join_id = ' . $JoinID;
				$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
				$cntData = mysqli_fetch_array($selRes);
				$PhotoCount = $cntData['num_photos'];

				$CompCnt = (isset($CompSpliceCnts[$JoinID])) ? $CompSpliceCnts[$JoinID] : 0;
				$DomeCnt = (isset($CompDomeCnts[$JoinID])) ? $CompDomeCnts[$JoinID] : 0;
				$RowBG = '';
				if($JoinRec['join_status'] == 1)
					$RowBG = " class='table-info'";
				elseif($JoinRec['join_status'] == 2)
					$RowBG = "  class='table-info'";
				elseif($JoinRec['join_status'] == 3)
					$RowBG = " class='table-success'";
				elseif($JoinRec['join_status'] == 5)
					$RowBG = " class='table-dark'";
				elseif($JoinRec['join_status'] == 13)
					$RowBG = "  class='table-light'";
					
				echo "<input type='hidden' id='join_" . $JoinID . "_created' value='" . $JoinRec['creation_time'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_address' value='" . $JoinRec['address'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_ponum' value='" . $JoinRec['po_number'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_poid' value='" . $JoinRec['po_id'] . "'>";
				echo "<tr" . $RowBG . ">";
				echo "<td>" . $JoinID . "</td>";
				echo "<td id='join_" . $JoinID . "_name'>" . $JoinRec['join_name'] . "</td>";
				echo "<td>" . $CompCnt . " / <span id='join_" . $JoinID . "_splices'>" . $JoinRec['num_splices'] . "</span></td>";
				echo "<td>" . $DomeCnt . " / <span id='join_" . $JoinID . "_domes'>" . $JoinRec['num_domes'] . "</span></td>";
				echo "<td>" . $JoinRec['address'] . "</td>";
				$PONum = (isset($PurchaseOrders[$JoinRec['po_id']]['po_number'])) ? $PurchaseOrders[$JoinRec['po_id']]['po_number'] : "-";
				echo "<td id='join_" . $JoinID . "_type'>" . $PONum . "</td>";
				echo "<td id='join_" . $JoinID . "_as'>" . $JoinRec['actual_start_date'] . "</td>";
				echo "<td id='join_" . $JoinID . "_ae'>" . $JoinRec['actual_end_date'] . "</td>";
				echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openJoin(" . $SectionID . ", " . $JoinID . ")'><i class='fa fa-pencil'></i></button></td>";
				echo "<td><a href='joinPhotos.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-info'><i class='fa fa-camera'></i> (" . $PhotoCount . " photos)</a>";
				if($PhotoCount > 0)
					echo "<a href='joinPhotoSheet.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-danger' title='Generate photo sheet'><i class='fa fa-file-excel-o'></i></a>";
				echo "</td>";
				echo "<td>";
				if($JoinRec['join_status'] == 1)
					echo "<a href='setjointested.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' title='Set tested'><i class='fa fa-heartbeat'></i></a>";
				elseif($JoinRec['join_status'] == 2)
					echo "<i class='fa fa-check'></i> Tested";
				elseif($JoinRec['join_status'] == 3)
					echo "<i class='fa fa-legal'></i> Invoiced";
				elseif($JoinRec['join_status'] == 5)
					echo "<a href='resetjoin.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-danger float-left' title='Reset Join'><i class='fa fa-child'></i> External</a>";
				else
				{
					// if($JoinRec['join_status'] != 13)
						echo "<a href='setjoinproblem.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-warning float-left' title='Cannot complete'><i class='fa fa-warning'></i></a>";
					echo "<a href='setjoincomplete.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-primary' style='padding-right: 2px;' title='Set complete'><i class='fa fa-flash'></i></a>";
					echo "<a href='setjoinexternal.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-primary' title='Completed by external technician'><i class='fa fa-child'></i></a>";
				}
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</table></td></tr>";
	}
}
?>
	</table>
	</div>
	<div class='tab-pane' id='SecWin_2'>
	<table class='table table-bordered table-striped table-sm'>
	
<?php
foreach($FinSecs AS $SectionID => $Section)
{
	$DoneCnt = (isset($CompSecSpliceCnts[$SectionID])) ? $CompSecSpliceCnts[$SectionID] : 0;
	$TotCnt = (isset($SecSpliceCnts[$SectionID])) ? $SecSpliceCnts[$SectionID] : 0; 
	$RowBG = "";
	if(($TotCnt > 0) && ($DoneCnt >= $TotCnt))
		$RowBG = " style='background-color: #BB7AFF;'";
	echo "<input type='hidden' id='sec_" . $SectionID . "_created' value='" . $Section['creation_time'] . "'>";
	echo "<tr style='background-color: #CCCCCC;'><th>ID</th><th>Section</th><th>Total Splices</th>";
	echo "<th colspan='2'><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(0)'><i class='fa fa-plus'></i> Add Section</button></th></tr>";
	echo "<tr" . $RowBG . ">";
	echo "<td>" . $SectionID . "</td>";
	echo "<td><span id='sec_" . $SectionID . "_name'>" . $Section['section_name'] . "</span>";
	if((!isset($Joins[$SectionID])) || (count($Joins[$SectionID]) == 0))
		echo "<a href='deleteSection.php?p=" . $ProjID . "&s=" . $SectionID . "' class='float-right text-danger' title='Delete section'><i class='fa fa-times'></i></a>";
	echo "</td>";
	echo "<td>" . $DoneCnt . " / " . $TotCnt . "</td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(" . $SectionID . ")'><i class='fa fa-pencil'></i></button></td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openJoin(" . $SectionID . ", 0)'><i class='fa fa-plus'></i> Add Join</button>";
	
	echo "</td>";
	echo "</tr>";
	if(isset($Joins[$SectionID]) && (count($Joins[$SectionID]) > 0))
	{
		echo "<tr><td colspan='5'><table class='table table-bordered table-striped table-sm'>";
		echo "<tr><td colspan='11'><strong>Joins</strong></td></tr>";
		echo "<tr class='table-danger'><th>ID</th><th>Join</th><th>Num Splices</th><th>Num Domes</th><th>Address</th><th>Type</th><th>Start</th><th>End</th><td colspan='3'></td></tr>";
		foreach($Joins[$SectionID] AS $JoinID => $JoinRec)
		{
			if(($JoinRec['join_status'] == 2) || ($JoinRec['join_status'] == 3))
			{
				$selQry = 'SELECT COUNT(*) AS num_photos FROM core_splice_join_photos WHERE join_id = ' . $JoinID;
				$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
				$cntData = mysqli_fetch_array($selRes);
				$PhotoCount = $cntData['num_photos'];

				$CompCnt = (isset($CompSpliceCnts[$JoinID])) ? $CompSpliceCnts[$JoinID] : 0;
				$DomeCnt = (isset($CompDomeCnts[$JoinID])) ? $CompDomeCnts[$JoinID] : 0;
				$RowBG = '';
				if($JoinRec['join_status'] == 1)
					$RowBG = " style='background-color: #C995FF;'";
				elseif($JoinRec['join_status'] == 2)
					$RowBG = "  class='table-info'";
				elseif($JoinRec['join_status'] == 3)
					$RowBG = " class='table-success'";
				elseif($JoinRec['join_status'] == 5)
					$RowBG = " class='table-dark'";
				elseif($JoinRec['join_status'] == 13)
					$RowBG = "  class='table-dark'";
					
				echo "<input type='hidden' id='join_" . $JoinID . "_created' value='" . $JoinRec['creation_time'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_address' value='" . $JoinRec['address'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_ponum' value='" . $JoinRec['po_number'] . "'>";
				echo "<input type='hidden' id='join_" . $JoinID . "_poid' value='" . $JoinRec['po_id'] . "'>";
				echo "<tr" . $RowBG . ">";
				echo "<td>" . $JoinID . "</td>";
				echo "<td id='join_" . $JoinID . "_name'>" . $JoinRec['join_name'] . "</td>";
				echo "<td>" . $CompCnt . " / <span id='join_" . $JoinID . "_splices'>" . $JoinRec['num_splices'] . "</span></td>";
				echo "<td>" . $DomeCnt . " / <span id='join_" . $JoinID . "_domes'>" . $JoinRec['num_domes'] . "</span></td>";
				echo "<td>" . $JoinRec['address'] . "</td>";
				$PONum = (isset($PurchaseOrders[$JoinRec['po_id']]['po_number'])) ? $PurchaseOrders[$JoinRec['po_id']]['po_number'] : "-";
				echo "<td id='join_" . $JoinID . "_type'>" . $PONum . "</td>";
				echo "<td id='join_" . $JoinID . "_as'>" . $JoinRec['actual_start_date'] . "</td>";
				echo "<td id='join_" . $JoinID . "_ae'>" . $JoinRec['actual_end_date'] . "</td>";
				echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openJoin(" . $SectionID . ", " . $JoinID . ")'><i class='fa fa-pencil'></i></button></td>";
				echo "<td><a href='joinPhotos.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-info'><i class='fa fa-camera'></i> (" . $PhotoCount . " photos)</a>";
				if($PhotoCount > 0)
					echo "<a href='joinPhotoSheet.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='btn btn-sm btn-outline-danger' title='Generate photo sheet'><i class='fa fa-file-excel-o'></i></a>";
				echo "</td>";
				echo "<td>";
				if($JoinRec['join_status'] == 1)
					echo "<a href='setjointested.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' title='Set tested'><i class='fa fa-heartbeat'></i></a>";
				elseif($JoinRec['join_status'] == 2)
					echo "<i class='fa fa-check'></i> Tested";
				elseif($JoinRec['join_status'] == 3)
					echo "<i class='fa fa-legal'></i> Invoiced";
				elseif($JoinRec['join_status'] == 5)
					echo "<a href='resetjoin.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='text-warning float-left' title='Reset Join'><i class='fa fa-child'></i> External</a>";
				else
				{
					if($JoinRec['join_status'] != 13)
						echo "<a href='setjoinproblem.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='text-warning float-left' title='Cannot complete'><i class='fa fa-warning'></i></a>";
					echo "<a href='setjoincomplete.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='float-right' title='Set complete'><i class='fa fa-flash'></i></a>";
					echo "<a href='setjoinexternal.php?p=" . $ProjID . "&s=" . $SectionID . "&j=" . $JoinID . "' class='float-right' style='padding-right: 2px;' title='Completed by external technician'><i class='fa fa-child'></i></a>";
				}
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</table></td></tr>";
	}
}
?>
	</table>
	</div>
	<div class='tab-pane' id='SecWin_3'>
	<table class='table table-bordered table-striped table-sm'>
<?php
foreach($EmptySections AS $SectionID => $Section)
{
	$DoneCnt = (isset($CompSecSpliceCnts[$SectionID])) ? $CompSecSpliceCnts[$SectionID] : 0;
	$TotCnt = (isset($SecSpliceCnts[$SectionID])) ? $SecSpliceCnts[$SectionID] : 0; 
	$RowBG = "";
	if(($TotCnt > 0) && ($DoneCnt >= $TotCnt))
		$RowBG = " style='background-color: #BB7AFF;'";
	echo "<input type='hidden' id='sec_" . $SectionID . "_created' value='" . $Section['creation_time'] . "'>";
	echo "<tr style='background-color: #CCCCCC;'><th>ID</th><th>Section</th><th>Total Splices</th>";
	echo "<th colspan='2'><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(0)'><i class='fa fa-plus'></i> Add Section</button></th></tr>";
	echo "<tr" . $RowBG . ">";
	echo "<td>" . $SectionID . "</td>";
	echo "<td><span id='sec_" . $SectionID . "_name'>" . $Section['section_name'] . "</span>";
	if((!isset($Joins[$SectionID])) || (count($Joins[$SectionID]) == 0))
		echo "<a href='deleteSection.php?p=" . $ProjID . "&s=" . $SectionID . "' class='float-right text-danger' title='Delete section'><i class='fa fa-times'></i></a>";
	echo "</td>";
	echo "<td>" . $DoneCnt . " / " . $TotCnt . "</td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openSection(" . $SectionID . ")'><i class='fa fa-pencil'></i></button></td>";
	echo "<td><button type='button' class='btn btn-sm btn-outline-primary' onclick='openJoin(" . $SectionID . ", 0)'><i class='fa fa-plus'></i> Add Join</button>";
	echo "</td>";
	echo "</tr>";
}
?>
	</table>
	</div>
</div>
</div>
</div>
<div class='modal fade' id='section-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveSpliceSection.php' id='secForm'>
	<input type='hidden' name='secProjID' id='secProjID' value='<?php echo $ProjID; ?>'>
	<input type='hidden' name='secSectionID' id='secSectionID' value='0'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Splice Section<a href="#" class="close" data-dismiss="modal">&times;</a></strong></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-2'>Section Name:</div><div class='col-md-4'><input type='text' name='secName' id='secName' value='' class='validate[required] form-control form-control-sm'></div>
					<div class='col-md-2'>Created:</div><div class='col-md-4' id='secCreated'></div>
				</div>
			<!--	<div class='row'>
					<div class='col-md-2'>Planned Start:</div><div class='col-md-4'><input type='text' name='spstart' id='spstart' value='' class='form-control form-control-sm'></div>
					<div class='col-md-2'>Planned End:</div><div class='col-md-4'><input type='text' name='spend' id='spend' value='' class='form-control form-control-sm'></div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Actual Start:</div><div class='col-md-4'><input type='text' name='asstart' id='asstart' value='' class='form-control form-control-sm'></div>
					<div class='col-md-2'>Actual End:</div><div class='col-md-4'><input type='text' name='asend' id='asend' value='' class='form-control form-control-sm'></div>
				</div> -->
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>

<div class='modal fade' id='join-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveSpliceJoin.php' id='joinForm'>
	<input type='hidden' name='dmProjID' id='dmProjID' value='<?php echo $ProjID; ?>'>
	<input type='hidden' name='dmSectionID' id='dmSectionID' value='0'>
	<input type='hidden' name='dmJoinID' id='dmJoinID' value='0'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Splice Section Join<a href="#" class="close" data-dismiss="modal">&times;</a></strong></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-2'>Join Name:</div><div class='col-md-4'><input type='text' name='joinName' id='joinName' value='' class='validate[required] form-control form-control-sm'></div>
					<div class='col-md-2'>Created:</div><div class='col-md-4' id='joinCreated'></div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Purchase Order:</div><div class='col-md-4'>
					<!-- <input type='text' name='joinPONum' id='joinPONum' value='' class='validate[required, custom[number]] form-control form-control-sm'>-->
					<select name='joinPOID' id='joinPOID' class='form-control form-control-sm'>
					<option value=''>-- If applicable --</option>
<?php
foreach($PurchaseOrders AS $PO_ID => $PO_Rec)
{
	echo "<option value='" . $PO_ID . "'>" . $PO_Rec['po_number'] . "</option>\n";
}
?>
					</select>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Num splices:</div><div class='col-md-4'><input type='text' name='joinNumSplices' id='joinNumSplices' value='' class='validate[required, custom[number]] form-control form-control-sm'></div>
					<div class='col-md-2'>Num domes:</div><div class='col-md-4'><input type='text' name='joinNumDomes' id='joinNumDomes' value='' class='validate[required, custom[number]] form-control form-control-sm'></div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Manhole:</div><div class='col-md-4'><input type='text' name='joinManhole' id='joinManhole' value='' class='form-control form-control-sm'></div>
					<div class='col-md-2'>Join Type:</div><div class='col-md-4' id='joinType'></div>
				</div>
				<div class='row'>
					<div class='col-md-2'>Address:</div><div class='col-md-8'><input type='text' name='joinAddress' id='joinAddress' value='' class='form-control form-control-sm'></div>
				</div>
				<!--<div class='row'>
					<div class='col-md-2'>Planned Start:</div><div class='col-md-4'><input type='text' name='jnpstart' id='jnpstart' value='' class='form-control form-control-sm'></div>
					<div class='col-md-2'>Planned End:</div><div class='col-md-4'><input type='text' name='jnpend' id='jnpend' value='' class='form-control form-control-sm'></div>
				</div>-->
				<div class='row'>
					<div class='col-md-2'>Actual Start:</div><div class='col-md-4'><input type='text' name='jnastart' id='jnastart' value='' class='form-control form-control-sm'></div>
					<div class='col-md-2'>Actual End:</div><div class='col-md-4'><input type='text' name='jnaend' id='jnaend' value='' class='form-control form-control-sm'></div>
				</div>
				<div class='row'><div class='col-md-12'><strong>Assigned Technicians</strong></div></div>
<?php
$cnt = 0;
foreach($usrPrivs AS $UsrID)
{
	if($cnt == 0)
		echo "<div class='row'>";
	echo "<div class='col-md-3'><input type='checkbox' name='tech_" . $UsrID . "' id='tech_" . $UsrID . "' value='" . $UsrID . "'";
	if(isset($UsrPrivileges[$PrivID]))
		echo " checked='checked'";
	echo "> <label for='tech_" . $UsrID . "'>" . $Users[$UsrID]['firstname'] . " " . $Users[$UsrID]['surname'] . "</label></div>";
	if($cnt == 3)
	{
		echo "</div>";
		$cnt = 0;
	}
	else
		$cnt++;
}
?>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
include("footer.inc.php");
?>