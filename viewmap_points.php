<?php
include("db.inc.php");
include("header.inc.php");
$MapID = pebkac($_GET['m']);
$Points = getMapPoints($MapID);
$PolyCoords = array();
$LineCoords = array();
$cntr = 0;
$Zoom = 16;
$LastOne = array();
foreach($Points AS $PointID => $PointArr)
{
	$LineCoords[$cntr]['lat'] = trim($PointArr['lat']);
	$LineCoords[$cntr]['lng'] = trim($PointArr['lon']);
	$LastOne['lat'] = $PointArr['lat'];
	$LastOne['lng'] = $PointArr['lon'];
	$cntr++;
}
?>
<style>
#map { 
width: 100%;
height: 600px;
border: 0px solid #FF0000;
}
</style>
<!-- <div class='row'>
	<div class='col-md-12'>
		<button type='button' onclick='calcRoute();'>Click Me</button>
	</div>
</div> -->
<div class='row'>
	<div class='col-md-12'>
		<div id="map">&nbsp;</div>
	</div>
</div>
<div class='row'>
	<div class='col-md-12'>
		<div id="directions_panel">&nbsp;</div>
	</div>
</div>
<script>
var directionsDisplay;
var directionsService; // = new google.maps.DirectionsService();
var map;

function initialize() 
{
	directionsDisplay = new google.maps.DirectionsRenderer();
	directionsService = new google.maps.DirectionsService();
	var mapOptions = 
	{
		zoom: <?php echo $Zoom; ?>,
		center: new google.maps.LatLng(<?php echo $LineCoords[0]['lat'] . ", " . $LineCoords[0]['lng']; ?>)
	};
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	directionsDisplay.setMap(map);
	calcRoute();
}

function calcRoute() 
{
	var start = new google.maps.LatLng(<?php echo $LineCoords[0]['lat'] . ", " . $LineCoords[0]['lng']; ?>);
	var end = new google.maps.LatLng(<?php echo $LastOne['lat'] . ", " . $LastOne['lng']; ?>);
	var waypts = [
<?php
foreach($LineCoords AS $cnt => $Coord)
{
	echo "{ location: new google.maps.LatLng(" . $Coord['lat'] . ", " . $Coord['lng'] . ") },\n"; //{lat: " . $Coord['lat'] . ", lng: " . $Coord['lng'] . "},\n";
}
?>
	];
	var request = 
	{
		origin: start,
		destination: end,
		waypoints: waypts,
		optimizeWaypoints: true,
		travelMode: google.maps.TravelMode.WALKING
	};
	directionsService.route(request, function(response, status) 
	{
		if (status == google.maps.DirectionsStatus.OK) 
		{
			directionsDisplay.setDirections(response);
			var route = response.routes[0];
			var warnings = document.getElementById("directions_panel");
			warnings.innerHTML = "" + response.routes[0].warnings + "";
			directionsDisplay.setDirections(response);
			
			var total = 0;
			var myroute = response.routes[0];
			for (var i = 0; i < myroute.legs.length; i++) 
			{
				total += myroute.legs[i].distance.value;
			}
			warnings.innerHTML = "" + total + " meters";
			
			/*var myRoute = response.routes[0].legs[0];
			for (var i = 0; i < myRoute.steps.length; i++) 
			{
				var marker = new google.maps.Marker({
					position: myRoute.steps[i].start_point,
					map: map
				});
			}//*/
		}
	});
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDWPfPQwmP6LY9O9A87AbzcGGfZXbhGyrY&libraries=drawing&callback=initialize" async defer></script>
<?php
include("footer.inc.php");
?>