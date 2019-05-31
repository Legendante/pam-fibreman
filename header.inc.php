<?php
session_start();
include_once("db.inc.php");
$ErrMsg = (!isset($_SESSION['errmsg'])) ? '' : $_SESSION['errmsg'];
$_SESSION['errmsg'] = '';
$SystemPrivileges = array();
$SysPrivs = array();
$UserPrivs = array();
if(isset($_SESSION['userid']))
{
	$HClients = getClients();
	$SystemPrivileges = getSystemPrivileges();
	$UserPrivs = getUserPrivileges($_SESSION['userid']);
	foreach($SystemPrivileges AS $PrivID => $PrivRec)
	{
		$SysPrivs[$PrivRec['privilegename']] = $PrivID;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/jquery-ui.min.css">
	<link rel="stylesheet" href="css/jquery-ui.theme.min.css">
	<link rel="stylesheet" href="css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="css/font-awesome.css"/>
	<link rel="stylesheet" href="css/validationEngine.jquery.css"/>
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
</head>
<body style="background-color: #EEEEEE;">
<!--<div class="container-fluid"> -->
	<nav class="navbar navbar-dark navbar-expand-md" role="navigation" style="background-color: #631A35;">
		<button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>&#x2630;</button>	
		<a class="navbar-brand" href="index.php">Home</a>
		<div id="navbar" class="navbar-collapse collapse">
<?php
// if((!isset($_SESSION['userid'])) || ($_SESSION['userid'] == ''))
	// echo "<a href='index.php' class='nav-link'><i class='fa fa-home'></i> Home</a>\n";
// else
if((isset($_SESSION['userid'])) && ($_SESSION['userid'] != ''))
{
	echo "<ul class='nav navbar-nav'>\n";
	if((isset($UserPrivs[$SysPrivs['View Splice Projects']])) || (isset($UserPrivs[$SysPrivs['Edit Splice Projects']])))
	{
		echo "<li class='dropdown nav-item'>\n";
		echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='Tasks'><i class='fa fa-check-circle'></i> Tasks <span class='caret'></span></a>\n";
		echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
		echo "<li><a class='dropdown-item' href='engineering.php'><i class='fa fa-plug'></i> Engineering</a></li>\n";
		echo "<li><a class='dropdown-item' href='maintenance.php'><i class='fa fa-wrench'></i> Maintenance</a></li>\n";
		echo "<li><a class='dropdown-item' href='accessbuilds.php'><i class='fa fa-external-link-square'></i> Access Builds</a></li>\n";
		echo "<li class='dropdown-divider'></li>\n";
		echo "<li><a class='dropdown-item' href='tasks.php'><i class='fa fa-cogs'></i> Tasks</a></li>\n";
		echo "<li class='dropdown-divider'></li>\n";
		echo "<li><a class='dropdown-item' href='spliceprojects.php'><i class='fa fa-compress'></i> Splice Projects</a></li>\n";
		echo "</ul></li>\n";
	}
	// if(isset($UserPrivs[$SysPrivs['In Field']]))
		// echo "<li class='nav-item'><a href='infield.php' class='nav-link'><i class='fa fa-car'></i> <strong>Field Menu</strong></a></li>\n";
	if(isset($UserPrivs[$SysPrivs['View Clients']]))
		echo "<li class='nav-item'><a href='clientindex.php' class='nav-link' title='Clients'><i class='fa fa-user-circle'></i> Clients</a></li>\n"; // <span class='navbar-text hidden-sm-up'> Clients</span>
	if(isset($UserPrivs[$SysPrivs['Finance']]))
	{
		echo "<li class='dropdown nav-item'>\n";
		echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='BOQ'><i class='fa fa-list'></i> BOQ<span class='caret'></span></a>\n";
		echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
		echo "<li><a class='dropdown-item' href='boqitems.php'>Line items</a></li>\n";
		echo "<li><a class='dropdown-item' href='boqtemplates.php'>BOQ Templates</a></li>\n";
		echo "<li class='dropdown-divider'></li>\n";
		foreach($HClients AS $ClientID => $ClientRec)
		{
			echo "<li><a class='dropdown-item' href='boqclientcost.php?c=" . $ClientID . "'>" . $ClientRec['clientname'] . " BOQ Cost</a></li>\n";
		}
		echo "</ul></li>\n";
		echo "<li class='dropdown nav-item'>\n";
		echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='Management'><i class='fa fa-superpowers'></i> Management<span class='caret'></span></a>\n";
		echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
		echo "<li><a class='dropdown-item' href='departments.php'>Departments</a></li>\n";
		echo "<li><a class='dropdown-item' href='projects.php'>Projects</a></li>\n";
		echo "</ul></li>\n";
		echo "<li><a href='complexes.php' class='nav-link' title='Complexes'><i class='fa fa-building'></i> Complexes</a></li>\n";
	
		echo "<li class='dropdown nav-item'>\n";
		echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='Mapping'><i class='fa fa-map'></i> Mapping<span class='caret'></span></a>\n";
		echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
		echo "<li><a href='maps.php' class='dropdown-item' title='Maps'><i class='fa fa-map'></i> Maps</a></li>\n";
		echo "<li class='dropdown-divider'></li>\n";
		echo "<li><a href='mappointtypes.php' class='dropdown-item' title='Map Points'><i class='fa fa-map-pin'></i> Map Points</a></li>\n";
		echo "</ul>\n";
		echo "</li>\n";
	}
	if(isset($UserPrivs[$SysPrivs['View Staff']]))
	{
		echo "<li class='dropdown nav-item'>\n";
		echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='Staff'><i class='fa fa-superpowers'></i> Staff<span class='caret'></span></a>\n";
		echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
		echo "<li><a class='dropdown-item' href='staffindex.php' title='Staff Details'><i class='fa fa-id-card'></i> Staff Details</a></li>\n";
		echo "<li><a class='dropdown-item' href='stafffiletypes.php'><i class='fa fa-file'></i> Staff File Types</a></li>\n";
		echo "</ul></li>\n";
		
		
	}
	if((isset($UserPrivs[$SysPrivs['View Users']])) || (isset($UserPrivs[$SysPrivs['Edit Users']])))
		echo "<li class='nav-item'><a href='users.php' class='nav-link' title='Users'><i class='fa fa-users'></i> Users</a></li>\n";
	echo "<li class='dropdown nav-item'>\n";
	echo "<a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' title='Lock Management'><i class='fa fa-lock'></i> Locks<span class='caret'></span></a>\n";
	echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
	echo "<li><a class='dropdown-item' href='locks.php'>Locks</a></li>\n";
	echo "<li><a class='dropdown-item' href='lockusers.php'>Lock Users</a></li>\n";
	echo "</ul>\n";
	echo "</li>\n";
	echo "</ul>\n";
	echo "<ul class='nav navbar-nav ml-auto'>\n";
	echo "<li class='nav-item'><a class='nav-link' href='logout.php'><i class='fa fa-power-off'></i> Logout</a></li>\n";
	echo "</ul>\n";
}
?>
	</div>
	</nav>
<!--	</div> -->
	<div class="container-fluid" style='padding-bottom: 100px;'>