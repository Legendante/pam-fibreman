<?php
include_once("db.inc.php");
$QuestionID = (isset($_POST['QID'])) ? pebkac($_POST['QID']) : 0;
$PointTypeID = (isset($_POST['TID'])) ? pebkac($_POST['TID']) : 0;
$OptionsArr = array();
foreach($_POST AS $Key => $Val)
{
	if(substr($Key, 0, 11) == 'optionName_')
	{
		$ID = explode("_", $Key);
		$ID = $ID[1];
		$OptionsArr[$ID]['name'] = $Val;
		$OptionsArr[$ID]['val'] = pebkac($_POST['optionVal_' . $ID], 100, 'STRING');
	}
}
$SaveArr = array();
$SaveArr['question'] = pebkac($_POST['Question'], 100, 'STRING');
$SaveArr['type_id'] = pebkac($_POST['qtype'], 2);
$SaveArr['pointtype_id'] = $PointTypeID;
if($QuestionID == 0)
	$QuestionID = addMapPointQuestion($SaveArr);
else
	updateMapPointQuestion($QuestionID, $SaveArr);
if(count($OptionsArr) > 0)
{
	foreach($OptionsArr AS $ID => $OptRec)
	{
		if(($OptRec['name'] != '') && ($OptRec['val'] != ''))
		{
			$SaveArr = array();
			$SaveArr['question_id'] = $QuestionID;
			$SaveArr['optiontxt'] = $OptRec['name'];
			$SaveArr['optionval'] = $OptRec['val'];
			if($ID == 0)
				addMapPointQuestionOption($SaveArr);
			else
				updateMapPointQuestionOption($ID, $SaveArr);
		}
	}
}
header("Location: editMapPointTypeQuestion.php?q=" . $QuestionID . "&t=" . $PointTypeID);
?>