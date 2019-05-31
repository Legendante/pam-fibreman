<?php
function getAllStaff()
{
	global $dbCon;
	
	$selQry = 'SELECT id, firstname, surname, knownas, cellnumber, homenumber, email, idnumber, birthday, passportnum, taxnumber, address1, address2, address3, address4, address5, address6, ';
	$selQry .= 'bankname, bankaccnum, bankbranchcode, bankbranch, salary, startdate, dateregistered, lastupdate, inactive, shoesize, pantsize, shirtsize ';
	$selQry .= 'FROM staff_details ORDER BY firstname, surname';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['firstname'] = $selData['firstname'];
		$RetArr[$selData['id']]['surname'] = $selData['surname'];
		$RetArr[$selData['id']]['knownas'] = $selData['knownas'];
		$RetArr[$selData['id']]['idnumber'] = $selData['idnumber'];
		$RetArr[$selData['id']]['cellnumber'] = $selData['cellnumber'];
		$RetArr[$selData['id']]['homenumber'] = $selData['homenumber'];
		$RetArr[$selData['id']]['email'] = $selData['email'];
		$RetArr[$selData['id']]['birthday'] = $selData['birthday'];
		$RetArr[$selData['id']]['passportnum'] = $selData['passportnum'];
		$RetArr[$selData['id']]['taxnumber'] = $selData['taxnumber'];
		$RetArr[$selData['id']]['address1'] = $selData['address1'];
		$RetArr[$selData['id']]['address2'] = $selData['address2'];
		$RetArr[$selData['id']]['address3'] = $selData['address3'];
		$RetArr[$selData['id']]['address4'] = $selData['address4'];
		$RetArr[$selData['id']]['address5'] = $selData['address5'];
		$RetArr[$selData['id']]['address6'] = $selData['address6'];
		$RetArr[$selData['id']]['bankname'] = $selData['bankname'];
		$RetArr[$selData['id']]['bankaccnum'] = $selData['bankaccnum'];
		$RetArr[$selData['id']]['bankbranchcode'] = $selData['bankbranchcode'];
		$RetArr[$selData['id']]['bankbranch'] = $selData['bankbranch'];
		$RetArr[$selData['id']]['salary'] = $selData['salary'];
		$RetArr[$selData['id']]['startdate'] = $selData['startdate'];
		$RetArr[$selData['id']]['dateregistered'] = $selData['dateregistered'];
		$RetArr[$selData['id']]['lastupdate'] = $selData['lastupdate'];
		$RetArr[$selData['id']]['inactive'] = $selData['inactive'];
		$RetArr[$selData['id']]['shoesize'] = $selData['shoesize'];
		$RetArr[$selData['id']]['pantsize'] = $selData['pantsize'];
		$RetArr[$selData['id']]['shirtsize'] = $selData['shirtsize'];
	}
	return $RetArr;
}

function getStaffMemberByID($StaffID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, firstname, surname, knownas, cellnumber, homenumber, email, idnumber, birthday, passportnum, taxnumber, address1, address2, address3, address4, address5, address6, ';
	$selQry .= 'bankname, bankaccnum, bankbranchcode, bankbranch, salary, startdate, dateregistered, lastupdate, inactive, shoesize, pantsize, shirtsize ';
	$selQry .= 'FROM staff_details WHERE id = ' . $StaffID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function addStaffMember($SaveArr)
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
	$updQry = 'INSERT INTO staff_details(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveStaffMember($StaffID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE staff_details SET ' . $updStr . ' WHERE id = ' . $StaffID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getStaffFileTypes()
{
	global $dbCon;
	
	$selQry = 'SELECT id, typename, sortorder FROM staff_filetypes ORDER BY sortorder';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['typename'] = $selData['typename'];
		$RetArr[$selData['id']]['sortorder'] = $selData['sortorder'];
	}
	return $RetArr;
}

function addStaffFileType($SaveArr)
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
	
	$selQry = 'SELECT MAX(sortorder) AS maxnum FROM staff_filetypes';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$NxtNum = $selData['maxnum'];
	$NxtNum = ($NxtNum == '') ? 1 : $NxtNum + 1;
	
	$fieldA[$cnt] = 'sortorder';
	$valueA[$cnt] = '"' . $NxtNum . '"';
	$cnt++;
	
	$updQry = 'INSERT INTO staff_filetypes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveStaffFileType($TypeID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE staff_filetypes SET ' . $updStr . ' WHERE id = ' . $TypeID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateStaffFileTypeSort($OldVal, $NewVal)
{
	global $dbCon;
	
	$updQry = 'UPDATE staff_filetypes SET sortorder = sortorder * -1 WHERE sortorder = ' . $NewVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE staff_filetypes SET sortorder = ' . $NewVal . ' WHERE sortorder = ' . $OldVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE staff_filetypes SET sortorder = ' . $OldVal . ' WHERE sortorder = ' . ($NewVal * -1);
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}


function getStaffMemberFilesByID($StaffID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, staff_id, filetype_id, filename, filepath, expiry_date, creation_time FROM staff_files WHERE staff_id = ' . $StaffID . ' ORDER BY expiry_date, creation_time, filetype_id, id';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['staff_id'] = $selData['staff_id'];
		$RetArr[$selData['id']]['filetype_id'] = $selData['filetype_id'];
		$RetArr[$selData['id']]['filename'] = $selData['filename'];
		$RetArr[$selData['id']]['filepath'] = $selData['filepath'];
		$RetArr[$selData['id']]['expiry_date'] = $selData['expiry_date'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
	}
	return $RetArr;
}

function addStaffMemberFile($SaveArr)
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
	$updQry = 'INSERT INTO staff_files(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}
?>