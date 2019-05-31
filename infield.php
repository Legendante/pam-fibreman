<?php
include("db.inc.php");
include("header.inc.php");
$usrPrivs = getUsersWithPrivilege("In Field");
$Joins = getSpliceSectionJoinsByDay(date("Y-m-d"), 0);
$CheckGroups = getSpliceCheckGroups();
$Checks = getSpliceChecks();

$selQry = 'SELECT join_id, check_id, COUNT(*) AS num_photos FROM core_splice_join_photos ';
$selQry .= 'WHERE DATE(takendate) = "' . date("Y-m-d") . '" AND userid = ' . $_SESSION['userid'] . ' ';
$selQry .= 'GROUP BY join_id, check_id';
$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
$PhotoCount = array();
while($selData = mysqli_fetch_array($selRes))
{
	$PhotoCount[$selData['join_id']][$selData['check_id']] = $selData['num_photos'];
}

$selQry = 'SELECT join_id, SUM(num_splices_completed) AS num_splices_completed, SUM(num_domes_completed) AS num_domes_completed FROM core_splice_diary ';
$selQry .= 'WHERE theday = "' . date("Y-m-d") . '" AND userid = ' . $_SESSION['userid'] . ' ';
$selQry .= 'GROUP BY join_id';
$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
$JoinTotals = array();
while($selData = mysqli_fetch_array($selRes))
{
	$JoinTotals[$selData['join_id']]['num_splices_completed'] = $selData['num_splices_completed'];
	$JoinTotals[$selData['join_id']]['num_domes_completed'] = $selData['num_domes_completed'];
}
$selQry = 'SELECT join_id, num_splices_completed, num_domes_completed FROM core_splice_diary WHERE theday = ' . date("Y-m-d") . ' AND userid = ' . $_SESSION['userid'];
$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
$JoinDiary = array();
while($selData = mysqli_fetch_array($selRes))
{
	$JoinDiary[$selData['join_id']]['num_splices_completed'] = $selData['num_splices_completed'];
	$JoinDiary[$selData['join_id']]['num_domes_completed'] = $selData['num_domes_completed'];
}
echo "<div class='row'><div class='col-md-12'></div></div>\n";
echo "<div class='row'><div class='col-md-12'></div></div>\n";
echo "<div class='btn-group-vertical'>\n";
foreach($Joins AS $SectionID => $SecRec)
{
	$sectionRec = getSpliceSectionByID($SectionID);
	foreach($SecRec AS $JoinID => $JoinRec)
	{
		$TotSplices = (isset($JoinTotals[$JoinID])) ? $JoinTotals[$JoinID]['num_splices_completed'] : 0;
		$TotDomes = (isset($JoinTotals[$JoinID])) ? $JoinTotals[$JoinID]['num_domes_completed'] : 0;
		$NumSplices = (isset($JoinDiary[$JoinID])) ? $JoinDiary[$JoinID]['num_splices_completed'] : '';
		$NumDomes = (isset($JoinDiary[$JoinID])) ? $JoinDiary[$JoinID]['num_domes_completed'] : '';
		echo "<button href='#bl_" . $JoinID . "' class='btn btn-warning' data-toggle='collapse'>" . $sectionRec['section_name'] . " - " . $JoinRec['join_name'] . " - " . $JoinRec['address'] . "</button>\n";
		echo "<div id='bl_" . $JoinID . "' class='collapse'>";
		echo "<form method='POST' action='saveDaily.php'>";
		echo "<input type='hidden' name='proj_id' id='proj_id' value='" . $sectionRec['project_id'] . "'>";
		echo "<input type='hidden' name='section_id' id='join_id' value='" . $SectionID . "'>";
		echo "<input type='hidden' name='join_id' id='join_id' value='" . $JoinID . "'>";
		echo "<p>Address: " . $JoinRec['address'] . "</p>";
		echo "<p>Manhole: " . $JoinRec['manhole_number'] . "</p>";
		echo "<p><strong>Report</strong></p>\n";
		echo "<p>Splices completed: " . $TotSplices . "</p>";
		echo "<p>Splices done: <input type='text' name='numspliced' id='numspliced' value='" . $NumSplices . "' class='form-control'></p>";
		echo "<p>Domes completed: " . $TotDomes . "</p>";
		echo "<p>Domes done: <input type='text' name='numdomes' id='numdomes' value='" . $NumDomes . "' class='form-control'></p>";
		echo "<p><button type='submit' class='btn btn-info'><i class='fa fa-save'></i> Save</button></p>";
		echo "</form>";
		echo "<p><strong>Checks</strong></p>\n";
		echo "<div class='btn-group-vertical'>\n";
		foreach($CheckGroups AS $GroupID => $GroupRec)
		{
			echo "<button href='#cg_" . $JoinID . "_" . $GroupID . "' type='button' class='btn btn-primary' data-toggle='collapse'>" . $GroupRec['group_name'] . "</button>\n";
			echo "<div id='cg_" . $JoinID . "_" . $GroupID . "' class='collapse'>\n";
			echo "<div class='btn-group-vertical'>\n";
			foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
			{
				$PCnt = (isset($PhotoCount[$JoinID][$CheckID])) ? $PhotoCount[$JoinID][$CheckID] : 0;
				echo "<a href='takePhoto.php?jid=" . $JoinID . "&cid=" . $CheckID . "' class='btn btn-success'>" . $CheckRec['check_name'] . "\n";
				echo "(" . $PCnt . " photos)</a>";
			}
			echo "</div></div>\n";
		}
		echo "</div></div>\n";
	}
	
}
echo "</div>\n";
include("footer.inc.php");
?>