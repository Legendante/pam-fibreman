<?php
$dbHost = 'dbhost';
$dbUser = 'dbuser';
$dbPass = 'dbpass';
$dbName = 'dbname';

$mailhost = 'mailserver';
$mailport = '587';
$mailusername = 'mailuser';
$mailpassword = 'mailpassword';
if(date("Y-m-d") > "2018-03-31")
{
	define('VATCALC', 1.15);
	define('VATDISP', 15);
}
else
{
	define('VATCALC', 1.14);
	define('VATDISP', 14);
}
define('PASSTHEPEPPER', '123456789012345678901234567890123456789012345678901234567890');
?>