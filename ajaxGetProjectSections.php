<?php
include("db.inc.php");
$ProjID = pebkac($_POST['p']);
$Sects = getProjectSections($ProjID);
echo json_encode($Sects);
?>