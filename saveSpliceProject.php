<?php
session_start();
include_once("db.inc.php");
$SaveArr = array();
$ProjID = pebkac($_POST['pid']);
$ClientID = pebkac($_POST['client_id']);
$SaveArr['client_id'] = $ClientID;
$SaveArr['project_name'] = pebkac($_POST['projName'], 50, 'STRING');
$SaveArr['proj_manager'] = pebkac($_POST['projManager'], 50, 'STRING');
$SaveArr['site_manager'] = pebkac($_POST['siteManager'], 50, 'STRING');
$SaveArr['way_leave'] = pebkac($_POST['wayleave'], 50, 'STRING');
$SaveArr['contractor'] = pebkac($_POST['contractor'], 50, 'STRING');
$SaveArr['planned_start_date'] = pebkac($_POST['pstart'], 10, 'STRING');
$SaveArr['planned_end_date'] = pebkac($_POST['pend'], 10, 'STRING');
$SaveArr['actual_start_date'] = pebkac($_POST['astart'], 10, 'STRING');
$SaveArr['actual_end_date'] = pebkac($_POST['aend'], 10, 'STRING');
if($ProjID == 0)
	$ProjID = addSpliceProject($SaveArr);
else
	saveSpliceProject($ProjID, $SaveArr);

$CostArr = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 5) == 'cost_')
	{
		$CostArr[substr($Key, 5)] = $Val;
	}
}
foreach($CostArr AS $CostID => $Cost)
{
	saveSpliceProjectCost($ProjID, $CostID, $Cost);
}
header("Location: editspliceproject.php?pid=" . $ProjID);
?>