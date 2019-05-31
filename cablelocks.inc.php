<?php
function getLocks()
{
	global $dbCon;
	
	$selQry = 'SELECT id, locknum, creation_time FROM cable_locks ORDER BY locknum';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getLockByCompanyID($CompanyID)
{
	global $dbCon;
	
	$selQry = 'SELECT cable_locks.id, locknum, userid, company_id, cable_lock_log.creation_time FROM cable_locks ';
	$selQry .= 'INNER JOIN cable_lock_log ON cable_lock_log.lockid = cable_locks.id AND cable_lock_log.historyserial = 0 ';
	$selQry .= 'WHERE company_id = ' . $CompanyID . ' ORDER BY locknum';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getLockByID($LockID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, locknum, creation_time FROM cable_locks WHERE id = ' . $LockID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addLock($SaveArr)
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
	$updQry = 'INSERT INTO cable_locks(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	$LockID = mysqli_insert_id($dbCon);
	$updQry = 'INSERT INTO cable_locks(lockid) VALUES (' . $LockID . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return $LockID;
}

function updateLock($LockID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE cable_locks SET ' . $updStr . ' WHERE id = ' . $LockID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}
?>