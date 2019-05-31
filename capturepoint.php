<?php
include("db.inc.php");
include("header.inc.php");
$MapID = (isset($_GET['m'])) ? pebkac($_GET['m']) : 0;
$Maps = getMapDetails();
$PointTypes = getMapPointTypes();
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
			// $('#gpserr').val(error);
			$('#geoError').html("geolocation error: " + error.message);
		});
	}
	else
	{
		// $('#gpserr').val("geolocation not supported");
		$('#geoError').html("geolocation not supported");
	}
});
function getPointTypeFields()
{
	var TypeID = $("#TypeID").val();
	var adate = new Date().getTime();
	
	$('#mapVals').html('');
	
	if(TypeID != '')
	{
		$.ajax({async: false, type: "POST", url: "ajaxGetMapPointFields.php", dataType: "html",
			data: "dc=" + adate + "&t=" + TypeID,
			success: function (feedback)
			{
				$('#mapVals').html(feedback);
			},
			error: function(request, feedback, error)
			{
				alert("Request failed\n" + feedback + "\n" + error);
				return false;
			}
		});
	}
}
</script>
<div class='row'>
	<div class='col-md-12' id='geoError'></div>
</div>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<form method='POST' action='saveCapturePoint.php' id='projForm'>
		<input type='hidden' name='PointID' id='PointID' value='0'>
		<input type='hidden' name='acc' id='acc' value=''>
		<div class='row'>
			<div class='col-md-2'>Point name:</div><div class='col-md-4'><input type='text' name='pointName' id='pointName' value='' class='validate[required] form-control form-control-sm'></div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Lat:</div><div class='col-md-4'><input type='text' name='lat' id='lat' value='' maxlength='11' class='validate[required] form-control form-control-sm'></div>
			<div class='col-md-2'>Lon:</div><div class='col-md-4'><input type='text' name='lon' id='lon' value='' maxlength='11' class='validate[required] form-control form-control-sm'></div>
		</div>
		<div class='row'>
			<div class='col-md-2'>Map:</div><div class='col-md-4'>
			<select name='MapID' id='MapID' class='validate[required] form-control form-control-sm'>
			<option value=''>-- Select --</option>
<?php
foreach($Maps AS $ID => $Map)
{
	echo "<option value='" . $ID . "'";
	if($MapID == $ID)
		echo " selected='selected'";
	echo ">" . $Map['map_name'] . "</option>\n";
}
?>
			</select>
			</div>
			<div class='col-md-2'>Point Type:</div><div class='col-md-4'>
			<select name='TypeID' id='TypeID' class='validate[required] form-control form-control-sm' onchange='getPointTypeFields();'>
			<option value=''>-- Select --</option>
<?php
foreach($PointTypes AS $PointID => $Point)
{
	echo "<option value='" . $PointID . "'>" . $Point['type_name'] . "</option>\n";
}
?>
			</select>			
			</div>
		</div>
		<div class='row'><div class='col-md-12' id='mapVals'>Awaiting type selection</div></div>
		<div class='row'><div class='col-md-2'><button type='submit' class='btn btn-outline-success btn-sm'><span class='fa fa-save'></span> Save</button></div></div>
		</form>
	</div>
</div>
<?php
include("footer.inc.php");
?>