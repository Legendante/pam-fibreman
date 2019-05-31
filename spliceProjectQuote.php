<?php
include("db.inc.php");
include("header.inc.php");
$ProjID = (isset($_GET['pid'])) ? pebkac($_GET['pid']) : 0;
$Proj = getSpliceProjectByID($ProjID);
$Sections = getSpliceSectionByProjectID($ProjID);
$CostTemplate = getSpliceProjectCostTemplate();
$ProjCosts = getSpliceProjectCostsByProjectID($ProjID);
$Joins = getSpliceSectionJoinsByProjectID($ProjID);
$Diary = getSpliceProjectDiaryByProjectID($ProjID);
$TotalSplices = 0;
$CompletedSplices = 0;
$NumSections = 0;
$NumJoins = 0;
$SecSpliceCnts = array();
foreach($Joins AS $SectionID => $SectionRec)
{
	$NumSections++;
	foreach($SectionRec AS $JoinID => $JoinRec)
	{
		if(!isset($SecSpliceCnts[$SectionID]))
			$SecSpliceCnts[$SectionID] = 0;
		$SecSpliceCnts[$SectionID] += $JoinRec['num_splices'];
	}
}
foreach($Joins AS $SectionID => $SectionRec)
{
	echo $Sections[$SectionID]['section_name'] . " - " . $SecSpliceCnts[$SectionID] . " splices<br>\n";
	foreach($SectionRec AS $JoinID => $JoinRec)
	{
		echo " - " . $JoinRec['join_name'] . " - " . $JoinRec['num_splices'] . " splices<br>\n";
	}
}
?>