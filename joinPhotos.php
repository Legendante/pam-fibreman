<?php
include_once("db.inc.php");
include("header.inc.php");
$SaveArr = array();
$ProjID = pebkac($_GET['p']);
$SectionID = pebkac($_GET['s']);
$JoinID = pebkac($_GET['j']);
$CheckGroups = getSpliceCheckGroups();
$Checks = getSpliceChecks();
$PhotoChecks = getSpliceChecksOnly();
$Photos = getSpliceJoinPhotos($JoinID);
?>
<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#Proj_1' data-toggle='tab' class='nav-link active'><strong>Photos</strong></a></li>
	<li class='nav-item'><a href='#Proj_2' data-toggle='tab' class='nav-link'><strong>Upload</strong></a></li>
	<!-- <li class='pull-right'><a href='editproject.php'><i class='fa fa-plus'></i> Add Project</a></li> -->
</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
<?php
$cnt = 0;
foreach($Photos AS $PhotoID => $PhotoRec)
{
	if($cnt == 0)
		echo "<div class='row'>";
	echo "<div class='col-md-3 col-sm-3 col-xs-3'>";
	echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	echo "<img src='" . $PhotoRec['thumbnail'] . "' width='200px'>";
	echo "</div>";
	echo "</div>";
	echo "<div class='row'>";
	echo "<div class='col-md-12'>ID: " . $PhotoID . "</div>";
	echo "<div class='col-md-12'>" . $PhotoChecks[$PhotoRec['check_id']]['check_name'] . "</div>";
	echo "</div>";
	echo "</div>";
	if($cnt == 3)
	{
		echo "</div>\n";
		$cnt = 0;
	}
	else
		$cnt++;
}
if($cnt != 0)
	echo "</div>";
?>
	</div>
	<div class='tab-pane' id='Proj_2'>
		<form action="uploadMultiPhotos.php" method="post" enctype="multipart/form-data">
		<input type='hidden' name='pid' id='pid' value='<?php echo $ProjID; ?>'>
		<input type='hidden' name='jid' id='jid' value='<?php echo $JoinID; ?>'>
		<input type='hidden' name='sid' id='sid' value='<?php echo $SectionID; ?>'>
<!--		<div class='row'>
			<div class='col-md-1 col-sm-1 col-xs-1'></div>
			<div class='col-md-4 col-sm-10 col-xs-10'><select name='checkid' id='checkid' class='form-control form-control-sm'>
		<?php
			foreach($CheckGroups AS $GroupID => $GroupRec)
			{
				echo "<option disabled='disabled'>" . $GroupRec['group_name'] . "</option>\n";
				foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
				{
					echo "<option value='" . $CheckID . "'>" . $CheckRec['check_name'] . "</option>\n";
				}
				echo "<option disabled='disabled'>──────────</option>\n\n";
			}
		?>
			</select></div>
		</div>
	-->	
<?php
for($i = 1; $i <= 30; $i += 2)
{
?>
		<div class='row'>
			<div class='col-md-1 col-sm-1 col-xs-1'>Photo <?php echo $i; ?></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><input type="file" name="phonePhoto_<?php echo $i; ?>" id="phonePhoto_<?php echo $i; ?>" class='form-control form-control-sm'></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><select name='checkid_<?php echo $i; ?>' id='checkid_<?php echo $i; ?>' class='form-control form-control-sm'>
			<?php
				foreach($CheckGroups AS $GroupID => $GroupRec)
				{
					echo "<option disabled='disabled'>" . $GroupRec['group_name'] . "</option>\n";
					foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
					{
						echo "<option value='" . $CheckID . "'>" . $CheckRec['check_name'] . "</option>\n";
					}
					echo "<option disabled='disabled'>──────────</option>\n\n";
				}
			?>
			</select></div>
			<div class='col-md-1 col-sm-1 col-xs-1'>Photo <?php echo $i + 1; ?></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><input type="file" name="phonePhoto_<?php echo $i + 1; ?>" id="phonePhoto_<?php echo $i + 1; ?>" class='form-control form-control-sm'></div>
			<div class='col-md-2 col-sm-3 col-xs-3'><select name='checkid_<?php echo $i + 1; ?>' id='checkid_<?php echo $i + 1; ?>' class='form-control form-control-sm'>
			<?php
				foreach($CheckGroups AS $GroupID => $GroupRec)
				{
					echo "<option disabled='disabled'>" . $GroupRec['group_name'] . "</option>\n";
					foreach($Checks[$GroupID] AS $CheckID => $CheckRec)
					{
						echo "<option value='" . $CheckID . "'>" . $CheckRec['check_name'] . "</option>\n";
					}
					echo "<option disabled='disabled'>──────────</option>\n\n";
				}
			?>
			</select></div>
		</div>
<?php
}
?>
		<div class='row'><div class='col-md-1 col-sm-1 col-xs-1'></div><div class='col-md-4 col-sm-10 col-xs-10'><strong>Comments</strong></div></div>
		<div class='row'><div class='col-md-1 col-sm-1 col-xs-1'></div><div class='col-md-4 col-sm-10 col-xs-10'><textarea class='form-control form-control-sm' name='photonote' id='photonote'></textarea></div></div>
		<div class='row'><div class='col-md-4 col-sm-10 col-xs-10'><button type="submit" class='btn btn-primary'>Upload Photos</button></div></div>
		</form>
	</div>
</div>
<?php
include("footer.inc.php");
?>