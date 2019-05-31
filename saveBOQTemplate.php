<?php
include_once("db.inc.php");
$TemplateID = pebkac($_POST['templID']);
$SaveArr = array();
$SaveArr['template_name'] = pebkac($_POST['templName'], 50, 'STRING');
//$SaveArr['client_id'] = pebkac($_POST['templClient']);
if($TemplateID == 0)
	addBOQTemplate($SaveArr);
else
	updateBOQTemplate($TemplateID, $SaveArr);
header("Location: boqtemplates.php");
?>