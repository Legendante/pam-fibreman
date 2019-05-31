<?php
$_SESSION['photofrom'] = $_SERVER['HTTP_REFERER'];
include_once("header.inc.php");
$JoinID = (isset($_GET['jid'])) ? pebkac($_GET['jid']) : 0;
$CheckID = (isset($_GET['cid'])) ? pebkac($_GET['cid']) : 0;
$Check = getSpliceCheckByCheckID($CheckID);
$CheckGroups = getSpliceCheckGroups();
$Success = (isset($_GET['s'])) ? pebkac($_GET['s']) : 0;
?>
	<script>
	$(document).ready(function()
	{
		if (navigator.geolocation) 
		{
			navigator.geolocation.getCurrentPosition(function(location) 
			{
				$('#lat').val(location.coords.latitude);
				$('#lon').val(location.coords.longitude);
				$('#acc').val(location.coords.accuracy);
			},
			function(error)
			{
				$('#gpserr').val(error);
				$('#geoError').html("geolocation error: " + error);
			});
		}
		else
		{
			$('#gpserr').val("geolocation not supported");
			$('#geoError').html("geolocation not supported");
		}
		
<?php
if($Success == 1)
	echo "setTimeout(function() { $('#successMessage').hide('blind', {}, 500) }, 5000);";
?>	
		$('#phonePhoto').on('change', function()
		{
			if($('#phonePhoto').val() != '')
				$('#showLater').show();
		});
	});
	</script>
<form action="uploadPhoto.php" method="post" enctype="multipart/form-data">
<input type='hidden' name='jid' id='jid' value='<?php echo $JoinID; ?>'>
<input type='hidden' name='cid' id='cid' value='<?php echo $CheckID; ?>'>
<input type='hidden' name='lat' id='lat' value=''>
<input type='hidden' name='lon' id='lon' value=''>
<input type='hidden' name='acc' id='acc' value=''>
<input type='hidden' name='gpserr' id='gpserr' value=''>
<input type="file" style="display:none;" name="phonePhoto" id="phonePhoto" accept="image/*" capture="camera" title='Take photo' autofocus = "autofocus">
<?php
if($Success == 1)
{
	echo "<div class='row' id='successMessage'>";
	echo "<div class='col-md-1 col-sm-1 col-xs-1'></div>";
	echo "<div class='col-md-4 col-sm-10 col-xs-10'><h3 class='bg-success text-success'>Photo Uploaded</h3></div>";
	echo "</div>";
}
?>
<div class='row'><div class='col-md-12 col-sm-12 col-xs-12'><strong><?php echo $CheckGroups[$Check['group_id']]['group_name'] . " - " . $Check['check_name']; ?></strong></div></div>
<div class='row'>
<div class='col-md-1 col-sm-1 col-xs-1'></div>
<div class='col-md-4 col-sm-10 col-xs-10'><button type="button" class='btn btn-primary' onclick="document.getElementById('phonePhoto').click();">Take Photo</button></div>
</div>
<div class='row'>
<div class='col-md-12 col-sm-12 col-xs-12' id='geoError'></div>
</div>
<div id='showLater' style='display: none;'>
	<div class='row'>
		<div class='col-md-1 col-sm-1 col-xs-1'></div>
		<div class='col-md-4 col-sm-10 col-xs-10'><strong>Comments</strong></div>
	</div>
	<div class='row'>
		<div class='col-md-1 col-sm-1 col-xs-1'></div>
		<div class='col-md-4 col-sm-10 col-xs-10'><textarea class='form-control' name='photonote' id='photonote'></textarea></div>
	</div>
	<div class='row'>
		<div class='col-md-1 col-sm-1 col-xs-1'></div>
		<div class='col-md-4 col-sm-10 col-xs-10'><button type="submit" class='btn btn-success'>Upload Photo</button></div>
	</div>
</div>
</form>
<?php
include("footer.inc.php");
?>