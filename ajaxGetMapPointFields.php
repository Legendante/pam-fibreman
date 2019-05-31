<?php
include("db.inc.php");
$TypeID = (isset($_POST['t'])) ? pebkac($_POST['t']) : 0;
$Questions = getMapPointQuestions($TypeID);
$QTypes = getMapPointQuestionTypes();
// print_r($TypeFields);
foreach($Questions AS $ID => $Question)
{
	$TName = $QTypes[$Question['type_id']]['type_name'];
	$Options = array();
	echo "<tr>\n";
	echo "<td>" . $Question['question'] . "</td>\n";
	if($TName == 'Number')
		echo "<td><input type='number' name='ans_" . $ID . "' class='form-control'></td>\n";
	elseif($TName == 'Text')
		echo "<td><input type='text' name='ans_" . $ID . "' class='form-control'></td>\n";
	elseif($TName == 'Single selector')
	{
		$Options = getMapPointQuestionOptions($ID);
		echo "<td><select name='ans_" . $ID . "' class='form-control'>\n";
		echo "<option value='0'>-- Select --</option>\n";
		foreach($Options AS $OptID => $OptRow)
		{
			echo "<option value='" . $OptRow['optionval'] . "'>" . $OptRow['optiontxt'] . "</option>\n";
		}
		echo "</select></td>\n";
	}
	elseif($TName == 'Multi selector')
	{
		$Options = getMapPointQuestionOptions($ID);
		echo "<td>\n";
		foreach($Options AS $OptID => $OptRow)
		{
			echo "<div class='form-check form-check-inline'>";
			echo "<input type='checkbox' name='ans_" . $ID . "[]' id='ans_" . $ID . "_" . $OptID . "' value='" . $OptRow['optionval'] . "' class='form-check'>&nbsp;";
			echo "<label class='form-check-label' for='ans_" . $ID . "_" . $OptID . "'> ". $OptRow['optiontxt'] . "</label>\n";
			echo "</div><br>";
		}
		echo "</td>\n";
	}
	echo "</tr>";
}
?>