<?php
function getUsersDetailsByUsername($Username)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive, shoesize, pantsize, shirtsize ';
	$selQry .= 'FROM userdetails WHERE LOWER(username) = "' . strtolower($Username) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function getUserDetailsByUserID($UserID)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive, shoesize, pantsize, shirtsize ';
	$selQry .= 'FROM userdetails WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function getAllUsers()
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive, shoesize, pantsize, shirtsize ';
	$selQry .= 'FROM userdetails ORDER BY firstname, surname';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['userid']]['userid'] = $selData['userid'];
		$retArr[$selData['userid']]['username'] = $selData['username'];
		$retArr[$selData['userid']]['userpass'] = $selData['userpass'];
		$retArr[$selData['userid']]['firstname'] = $selData['firstname'];
		$retArr[$selData['userid']]['surname'] = $selData['surname'];
		$retArr[$selData['userid']]['dateregistered'] = $selData['dateregistered'];
		$retArr[$selData['userid']]['lastlogin'] = $selData['lastlogin'];
		$retArr[$selData['userid']]['lastaction'] = $selData['lastaction'];
		$retArr[$selData['userid']]['lastupdate'] = $selData['lastupdate'];
		$retArr[$selData['userid']]['customerid'] = $selData['customerid'];
		$retArr[$selData['userid']]['cellnumber'] = $selData['cellnumber'];
		$retArr[$selData['userid']]['telnumber'] = $selData['telnumber'];
		$retArr[$selData['userid']]['inactive'] = $selData['inactive'];
		$retArr[$selData['userid']]['shoesize'] = $selData['shoesize'];
		$retArr[$selData['userid']]['pantsize'] = $selData['pantsize'];
		$retArr[$selData['userid']]['shirtsize'] = $selData['shirtsize'];
	}
	return $retArr;
}

function addUser($SaveArr)
{
	global $dbCon;
	
	$fieldA = array();
	$valueA = array();
	$cnt = 0;
	foreach($SaveArr AS $Field => $Value)
	{
		$fieldA[$cnt] = $Field;
		$valueA[$cnt] = '"' . $Value . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO userdetails(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveUser($UserID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE userdetails SET ' . $updStr . ' WHERE userid = ' . $UserID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateLastLogin($UserID)
{
	global $dbCon;
	
	$selQry = 'UPDATE userdetails SET lastlogin = NOW() WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function toggleUserActive($UserID)
{
	global $dbCon;
	
	$selQry = 'UPDATE userdetails SET inactive = !inactive WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}


function saltAndPepper($Username, $Password)
{
	return substr($Password . $Username . PASSTHEPEPPER, 0, 70);
}

function hashPassword($Username, $Password)
{
	$Username = strtolower($Username);
	$Peppered = saltAndPepper($Username, $Password);
	$options = array("cost" => 14);
	return password_hash($Peppered, PASSWORD_BCRYPT, $options);
}

function getSystemPrivileges()
{
	global $dbCon;
	
	$selQry = 'SELECT privilegeid, privilegename FROM systemprivileges';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['privilegeid']]['privilegeid'] = $selData['privilegeid'];
		$retArr[$selData['privilegeid']]['privilegename'] = $selData['privilegename'];
		// $retArr[$selData['privilegename']] = $selData['privilegeid'];
	}
	return $retArr;
}

function getUserPrivileges($UserID)
{
	global $dbCon;
		
	$selQry = 'SELECT privilegeid FROM userprivileges WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['privilegeid']] = $selData['privilegeid'];
	}
	return $retArr;
}

function getUsersWithPrivilege($Privilege)
{
	global $dbCon;
	
	$selQry = 'SELECT privilegeid FROM systemprivileges WHERE LOWER(privilegename) = "' . strtolower($Privilege) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$seekPriv = $selData['privilegeid'];
	$selQry = 'SELECT userid FROM userprivileges WHERE privilegeid = ' . $seekPriv;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['userid']] = $selData['userid'];
	}
	return $retArr;
}

function clearUserPrivileges($UserID)
{
	global $dbCon;
		
	$selQry = 'UPDATE userprivileges SET userid = userid * -1, privilegeid = privilegeid * -1 WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function addUserPrivilege($UserID, $PrivID)
{
	global $dbCon;
		
	$selQry = 'INSERT INTO userprivileges (userid, privilegeid) VALUES (' . $UserID . ', ' . $PrivID . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function getPassword($Limit = 3)
{
	global $dbCon;
	$randQry = 'SELECT LOWER(theword) AS theword FROM wordlist ORDER BY RAND() LIMIT ' . $Limit;
	$randRes = mysqli_query($dbCon, $randQry) or logDBError(mysqli_error($dbCon), $randQry, __FILE__, __FUNCTION__, __LINE__);
	$GenPass = "";
	while($randData = mysqli_fetch_array($randRes))
	{
		$GenPass .= ucfirst($randData['theword']);
	}
	return $GenPass;
}
?>