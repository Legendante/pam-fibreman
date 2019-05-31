<?php
include("db.inc.php");
include("header.inc.php");
$MapID = pebkac($_GET['m']);
$Points = getMapPoints($MapID);
$Questions = getAllMapPointQuestions();
$QTypes = getMapPointQuestionTypes();
$QVals = getMapPointValuesByMapID($MapID);
$Options = getAllMapPointQuestionOptions();
// print_r($QVals);
$PolyCoords = array();
$LineCoords = array();
$cntr = 0;
$Zoom = 16;
$LastOne = array();

foreach($Points AS $PointID => $PointArr)
{
	$QStr = '<div class="card text-center">';
    $QStr .= '<div class="card-body">';
    $QStr .= '<h5 class="card-title">' . trim($PointArr['point_name']) . '</h5>';
    $QStr .= '<p class="card-text">';
	if(isset($QVals[$PointID]))
	{
		foreach($QVals[$PointID] AS $ValID => $QArr)
		{
			$Q = $Questions[$QArr['question_id']]['question'];
			$T = $Questions[$QArr['question_id']]['type_id'];
			$TName = $QTypes[$T]['type_name'];
			$QStr .= $Q . ": ";
			if(($TName == 'Multi selector') || ($TName == 'Multi selector'))
			{
				$O = $Options[$QArr['question_id']]['optiontxt'];
				$A = $QArr['question_val'];
				$AArr = explode("_", $A);
				// print_r($AArr);
			}
			else
				$A = $QArr['question_val'];
			$QStr .= $A . "<br>";
		}
	}
	$QStr .= '</p>';
    $QStr .= '<p class="card-text"><small class="text-muted">Soft subtext for more info</small></p>';
    $QStr .= '</div>';
	$QStr .= '</div>';
	$LineCoords[$cntr]['qstr'] = trim($QStr);
	$LineCoords[$cntr]['lat'] = trim($PointArr['lat']);
	$LineCoords[$cntr]['lng'] = trim($PointArr['lon']);
	$LineCoords[$cntr]['id'] = trim($PointID);
	$LineCoords[$cntr]['name'] = trim($PointArr['point_name']);
	
	$LastOne['lat'] = $PointArr['lat'];
	$LastOne['lng'] = $PointArr['lon'];
	$cntr++;
}
?>
<style>
#map { width: 800px; height: 600px; border: 0px solid #FF0000; }
</style>
<div class='row'><div class='col-md-12'><div id="map">&nbsp;</div></div></div>
<div class='row'><div class='col-md-12'><div id="directions_panel">&nbsp;</div></div>
<script>
var map;

function initialize() 
{
	var mapOptions = 
	{
		zoom: <?php echo $Zoom; ?>,
		center: new google.maps.LatLng(<?php echo $LineCoords[0]['lat'] . ", " . $LineCoords[0]['lng']; ?>)
	};
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	
<?php
foreach($LineCoords AS $cnt => $Coord)
{
	echo "var contentString = '" . $Coord['qstr'] . "';\n";
	echo "var infowindow_" . $cnt . " = new google.maps.InfoWindow({ content: contentString });\n";
	echo "var marker_" . $cnt . " = new google.maps.Marker({\n";
	echo "position: new google.maps.LatLng(" . $Coord['lat'] . ", " . $Coord['lng'] . "),\n";
	echo "map: map\n";
	echo "});\n";
	echo "marker_" . $cnt . ".addListener('click', function() {\n";
    echo "infowindow_" . $cnt . ".open(map, marker_" . $cnt . ");\n";
	echo "});\n";
}
?>
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDWPfPQwmP6LY9O9A87AbzcGGfZXbhGyrY&libraries=drawing&callback=initialize" async defer></script>
<?php
include("footer.inc.php");
?>