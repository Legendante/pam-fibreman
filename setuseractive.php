<?php
session_start();
include_once("db.inc.php");
$UserID = pebkac($_GET['uid']);
toggleUserActive($UserID);
header("Location: users.php");
?>