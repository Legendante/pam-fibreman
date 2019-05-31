<?php
include("db.inc.php");
$ClientID = pebkac($_POST['c']);
$Projs = getClientProjects($ClientID);
echo json_encode($Projs);
?>