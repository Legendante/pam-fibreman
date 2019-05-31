<?php
include("db.inc.php");
$TaskID = pebkac($_POST['s']);
$TemplateID = pebkac($_POST['t']);
$Items = getBOQTemplateItems($TemplateID);
$BOQLines = getBOQLineItems();
$BOQUnits = getBOQTaskUnits();
$BOQCats = getBOQCategories();
$BOQItems = getTaskBOQItems($TaskID);
$ItemShow = array();
$TemplateItems = array();
foreach($BOQCats AS $CatID => $Cat)
{
	foreach($BOQLines AS $LineID => $Line)
	{
		if(($Line['categoryid'] == $CatID) && (isset($Items[$LineID])))
		{
			if(!isset($BOQItems[$LineID]))
			{
				$TemplateItems[$LineID] = $LineID;
				$ItemShow[$CatID][$LineID] = 1;
			}
		}
	}
}
$OldCat = 0;
$StrOut = "";
foreach($ItemShow AS $CatID => $Lines)
{
	if($OldCat != $CatID)
	{
		$StrOut .= "<tr class='table-danger'><th colspan='8'>" . $BOQCats[$CatID]['categoryname'] . "</th></tr>\n";
		$StrOut .= "<tr><th>Item name</th><th>Unit</th><th>Cost</th><th>Est. #</th><th>Act. #</th><th>Est. Cost</th><th>Act. Cost</th></tr>\n";
		foreach($Lines AS $LineID => $One)
		{
			$StrOut .= "<tr id='boqrow_" . $LineID . "'><td>" . $BOQLines[$LineID]['item_name'] . "</td>";
			$StrOut .= "<td>" . $BOQUnits[$BOQLines[$LineID]['unitid']]['unitname'] . "</td>";
			$StrOut .= "<td>" . $BOQLines[$LineID]['defaultcost'] . "</td>";
			$StrOut .= "<td><input type='text' name='boq_est_" . $LineID . "' id='boq_est_" . $LineID . "' value='' class='form-control form-control-sm'></td>";
			$StrOut .= "<td><input type='text' name='boq_act_" . $LineID . "' id='boq_act_" . $LineID . "' value='' class='form-control form-control-sm'></td>";
			$StrOut .= "<td>R 0.00</td><td>R 0.00</td>";
			$StrOut .= "<td><button type='button' class='btn btn-sm btn-outline-danger' title='Delete Item' onclick='deleteBOQItem(" . $LineID . ");'><i class='fa fa-times'></i></button></td>";
			$StrOut .= "</tr>\n";
		}
		$OldCat = $CatID;
	}
}
echo $StrOut;
?>