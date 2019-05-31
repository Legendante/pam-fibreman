<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db.inc.php");

$Username = "jacques@legendante.com";
$Password = "jksicoe123";

echo $Username . "<br>";
echo $Password . "<br>";

echo hashPassword($Username, $Password);

$Username = "test@example.com";
$Password = "Password";

echo $Username . "<br>";
echo $Password . "<br>";

echo hashPassword($Username, $Password);
?>