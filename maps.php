<?php
include("db.inc.php");
include("header.inc.php");
$Maps = getMapDetails();
?>
<script>
$(document).ready(function()
{
	if (navigator.geolocation) 
	{
		navigator.geolocation.getCurrentPosition(function(mylocation) 
		{
			$('#lat').val(mylocation.coords.latitude);
			$('#lon').val(mylocation.coords.longitude);
			$('#acc').val(mylocation.coords.accuracy);
		},
		function(error)
		{
			$('#gpserr').val(error);
			$('#geoError').html("geolocation error: " + error.message);
		});
	}
	else
	{
		$('#gpserr').val("geolocation not supported");
		$('#geoError').html("geolocation not supported");
	}
});
function openMap(MapID)
{
	$('#MapID').val(MapID);
	$('#mapName').val('');
	if(MapID != 0)
	{
		$('#mapName').val($('#map_' + MapID).data('mapname'));
	}
	$('#map-modal').modal("show");
}
</script>
<!-- <div class='row'>
	<div class='col-md-2'><input type='text' id='lat' value=''></div>
	<div class='col-md-2'><input type='text' id='lon' value=''></div>
	<div class='col-md-2'><input type='text' id='acc' value=''></div>
	<div class='col-md-2'><input type='text' id='gpserr' value=''></div>
	<div class='col-md-4' id='geoError'></div>
</div> -->
		<table class='table table-bordered table-striped table-sm'>
		<tr class='table-custom-header'><th>ID</th><th>Map</th><th colspan='3'><button type='button' class='btn btn-outline-custom btn-sm' onclick='openMap(0);'><i class='fa fa-plus'></i> Add Map</button></th></tr>
<?php
foreach($Maps AS $MapID => $Map)
{
	echo "<tr>";
	echo "<td>" . $MapID . "</td>";
	echo "<td id='map_" . $MapID . "' data-mapname='" . $Map['map_name'] . "'>" . $Map['map_name'] . "</td>";
	echo "<td><div class='btn-group'><button type='button' class='btn btn-outline-custom btn-sm' onclick='openMap(" . $MapID . ");'><i class='fa fa-pencil'></i></button>";
	echo "<a href='capturepoint.php?m=" . $MapID . "' class='btn btn-outline-custom btn-sm' class='float-right'><i class='fa fa-map-pin'></i> Capture Point</a>";
	echo "<a href='viewmap.php?m=" . $MapID . "' class='btn btn-outline-custom btn-sm'><i class='fa fa-map-marker'></i> View Map</button>";
	echo "<a href='viewmap_points.php?m=" . $MapID . "' class='btn btn-outline-custom btn-sm'><i class='fa fa-code-fork'></i> View Points Map (Alpha)</button>";
	echo "<a href='mappoints.php?m=" . $MapID . "' class='btn btn-outline-custom btn-sm'><i class='fa fa-map-o'></i> Map Points</button></div></td>";
	echo "</tr>";
}
?>
		</table>
<div class='modal fade' id='map-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<form method='POST' action='saveMap.php' id='joinForm'>
	<input type='hidden' name='MapID' id='MapID' value='0'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'><strong>Map Details</strong><a href="#" class="close" data-dismiss="modal">&times;</a></div>
			<div class='modal-body'>
				<div class='row'>
					<div class='col-md-3'>Map name:</div><div class='col-md-4'><input type='text' name='mapName' id='mapName' value='' class='form-control form-control-sm'></div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
include("footer.inc.php");
?>