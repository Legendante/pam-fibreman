<?php
include("db.inc.php");
include("header.inc.php");
$MapID = pebkac($_GET['m']);
$Map = getMapDetailByID($MapID);
$Points = getMapPoints($MapID);
$Types = getMapPointTypes();
?>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<table class='table table-bordered table-sm'>
		<tr><td colspan='7'>Map points for <?php echo $Map['map_name']; ?></td></tr>
		<tr><th>ID</th><th>Name</th><th>Type</th><th>Lat</th><th>Lon</th>
		<th><div class='btn-group'><a href='viewmap.php?m=<?php echo $MapID; ?>' class='btn btn-outline-primary btn-sm'><i class='fa fa-map-marker'></i> View Map</a>
		<a href='capturepoint.php?m=<?php echo $MapID; ?>' class='btn btn-outline-primary btn-sm'><i class='fa fa-map-pin'></i> Capture Point</a></div></th>
		</tr>
<?php
foreach($Points AS $ID => $Point)
{
	echo "<tr>";
	echo "<td>" . $ID . "</td>";
	echo "<td id='map_" . $ID . "' data-pointname='" . $Point['point_name'] . "'>" . $Point['point_name'] . "</td>";
	echo "<td>" . $Types[$Point['type_id']]['type_name'] . "</td>";
	echo "<td>" . $Point['lat'] . "</td>";
	echo "<td>" . $Point['lon'] . "</td>";
	echo "<td colspan='2'><a href='editPoint.php?m=" . $ID . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
</div>
<?php
include("footer.inc.php");
?>