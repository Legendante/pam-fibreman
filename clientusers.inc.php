<?php
function getClientUsersDetailsByUsername($Username)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive ';
	$selQry .= 'FROM clientuserdetails WHERE LOWER(username) = "' . strtolower($Username) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function getClientUserDetailsByUserID($UserID)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive ';
	$selQry .= 'FROM clientuserdetails WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function getAllClientUsers($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, username, userpass, firstname, surname, dateregistered, lastlogin, lastaction, lastupdate, customerid, cellnumber, telnumber, inactive ';
	$selQry .= 'FROM clientuserdetails WHERE customerid = ' . $ClientID . ' ORDER BY firstname, surname';
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
	}
	return $retArr;
}

function getClientUserDepartments($UserID)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, departmentid FROM clientuserdepartments WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['departmentid']] = $selData['departmentid'];
	}
	return $retArr;
}

function clearClientUserDepartments($UserID)
{
	global $dbCon;
		
	$selQry = 'UPDATE clientuserdepartments SET userid = userid * -1, departmentid = departmentid * -1 WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function addClientUserDepartment($UserID, $DeptID)
{
	global $dbCon;
		
	$selQry = 'INSERT INTO clientuserdepartments (userid, departmentid) VALUES (' . $UserID . ', ' . $DeptID . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function addClientUser($SaveArr)
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
	$updQry = 'INSERT INTO clientuserdetails(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveClientUser($UserID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE clientuserdetails SET ' . $updStr . ' WHERE userid = ' . $UserID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateClientUserLastLogin($UserID)
{
	global $dbCon;
	
	$selQry = 'UPDATE clientuserdetails SET lastlogin = NOW() WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function toggleClientUserActive($UserID)
{
	global $dbCon;
	
	$selQry = 'UPDATE clientuserdetails SET inactive = !inactive WHERE userid = ' . $UserID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}
?>