<?php
include("db.inc.php");
include("header.inc.php");
$QuestionID = (isset($_GET['q'])) ? pebkac($_GET['q']) : 0;
$PointTypeID = (isset($_GET['t'])) ? pebkac($_GET['t']) : 0;
$QTypes = getMapPointQuestionTypes();
$Question = getMapPointQuestionByID($QuestionID);
$Options = getMapPointQuestionOptions($QuestionID);
$HideOptions = '';
if(($Question['type_id'] != 3) && ($Question['type_id'] != 4))
	$HideOptions = 'display: none;';
// id, type_id, pointtype_id, question, parent_id, sort_order
?>
<script>
function showOptions()
{
	$('#optionsBox').hide();
	var typeVal = $('#qtype').val();
	if((typeVal == 3) || (typeVal == 4))
		$('#optionsBox').show();
}
</script>
<div class='row'><div class='col-md-3'><a href='mappointtypequestions.php?t=<?php echo $PointTypeID; ?>'><i class='fa fa-arrow-left'></i>Point Type Questions</a></div></div>
<form method='POST' action='saveMapPointTypeQuestion.php' id='projForm'>
<input type='hidden' name='QID' id='QID' value='<?php echo $QuestionID; ?>'>
<input type='hidden' name='TID' id='TID' value='<?php echo $PointTypeID; ?>'>
<div class='row'>
	<div class='col-md-1'>Question:</div><div class='col-md-5'><input type='text' name='Question' id='Question' value='<?php echo $Question['question']; ?>' class='validate[required] form-control form-control-sm'></div>
	<div class='col-md-1'>Type:</div><div class='col-md-2'>
	<select name='qtype' id='qtype' class='validate[required] form-control form-control-sm' onchange='showOptions();'>
		<option value='0'>-- Select One --</option>
<?php
foreach($QTypes AS $TypeID => $TypeRec)
{
	echo "<option value='" . $TypeID . "'";
	if($Question['type_id'] == $TypeID)
		echo " selected='selected'";
	echo ">" . $TypeRec['type_name'] . "</option>";
}
?>
	</select>
	</div>
</div>
<div class='row'><div class='col-md-12'><button type='submit' class='btn btn-outline-success btn-sm float-right'><span class='fa fa-save'></span> Save</button></div></div>
<div id='optionsBox' style='<?php echo $HideOptions; ?>'>
<div class='row'><div class='col-md-12'>Options</div></div>
<div class='row'><div class='col-md-9'>Option</div><div class='col-md-3'>Value</div></div>
<div class='row'>
<div class='col-md-9'><input type='text' name='optionName_0' id='optionName_0' value='' class='validate[required] form-control form-control-sm'></div>
<div class='col-md-3'><input type='text' name='optionVal_0' id='optionVal_0' value='' class='validate[required] form-control form-control-sm'></div>
</div>
<?php
foreach($Options AS $OptionID => $OptionRec)
{
	echo "<div class='row'>";
	echo "<div class='col-md-9'><input type='text' name='optionName_" . $OptionID . "' id='optionName_" . $OptionID . "' value='" . $OptionRec['optiontxt'] . "' class='validate[required] form-control form-control-sm'></div>";
	echo "<div class='col-md-3'><input type='text' name='optionVal_" . $OptionID . "' id='optionVal_" . $OptionID . "' value='" . $OptionRec['optionval'] . "' class='validate[required] form-control form-control-sm'></div>";
	echo "</div>";
}
?>
</form>
<?php
include("footer.inc.php");
?>