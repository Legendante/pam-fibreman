<?php
include("db.inc.php");
include("header.inc.php");
$TypeID = pebkac($_GET['t']);
$Questions = getMapPointQuestions($TypeID);
$QTypes = getMapPointQuestionTypes();
$MaxOrder = 0;
foreach($Questions AS $ID => $Question)
{
	if($Question['sort_order'] > $MaxOrder)
		$MaxOrder = $Question['sort_order'];
}
?>
<table class='table table-bordered table-striped table-sm'>
	<tr class='table-custom-header'><th>ID</th><th>Question</th><th>Options</th><th>Type</th><th>Order</th>
	<th><a href='editMapPointTypeQuestion.php?t=<?php echo $TypeID; ?>' class='btn btn-outline-custom btn-sm'><i class='fa fa-plus'></i></a></th></tr>
<?php
foreach($Questions AS $ID => $Question)
{
	$TName = $QTypes[$Question['type_id']]['type_name'];
	$Options = array();
	if(($TName == 'Single selector') || ($TName == 'Multi selector'))
		$Options = getMapPointQuestionOptions($ID);
	echo "<tr>\n";
	echo "<td>" . $ID . "</td>\n";
	echo "<td><a href='editMapPointTypeQuestion.php?q=" . $ID . "'>" . $Question['question'] . "</a></td>\n";
	echo "<td>\n";
	if(count($Options) > 0)
	{
		echo "<table class='table table-bordered table-striped table-sm'>\n";
		echo "<tr><th>Text</th><th>Value</th></tr>\n";
		foreach($Options AS $OptID => $OptRow)
		{
			echo "<tr><td>" . $OptRow['optiontxt'] . "</td><td>" . $OptRow['optionval'] . "</td></tr>\n";
		}
		echo "</table>\n";
	}
	echo "</td>\n";
	echo "<td>" . $TName . "</td>\n";
	echo "<td>\n";
	if($Question['sort_order'] > 1)
		echo "<a href='MapPointQuestionSort.php?o=" . $Question['sort_order'] . "&n=" . ($Question['sort_order'] - 1) . "&t=" . $TypeID . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-arrow-circle-up'></i></a>\n";
	else
		echo "<a class='btn btn-sm btn-outline-custom disabled'><i class='fa fa-arrow-circle-up'></i></a>\n";
	if($Question['sort_order'] < $MaxOrder)
		echo "<a href='MapPointQuestionSort.php?o=" . $Question['sort_order'] . "&n=" . ($Question['sort_order'] + 1) . "&t=" . $TypeID . "' class='btn btn-sm btn-outline-custom'><i class='fa fa-arrow-circle-down'></i></a>\n";
	else
		echo "<a class='btn btn-sm btn-outline-custom disabled'><i class='fa fa-arrow-circle-down'></i></a>\n";
	echo $Question['sort_order'];
	echo "</td><td>\n";
	echo "<a href='editMapPointTypeQuestion.php?q=" . $ID . "&t=" . $TypeID . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-pencil'></i></a>\n";
	echo "</td></tr>\n";
}
?>
</table>
<?php
include("footer.inc.php");
?>