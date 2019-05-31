<?php
function addComplex($SaveArr)
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
	$updQry = 'INSERT INTO complexdetails(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateComplex($ComplexID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE complexdetails SET ' . $updStr . ' WHERE complexid = ' . $ComplexID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getComplexes()
{
	global $dbCon;
	
	$selQry = 'SELECT complexid, complexname, numunits, shortcode, complexaddress1, complexaddress2, complexaddress3, complexaddress4, complexaddress5, complexstatus, dateregistered, clientid, lat, lon ';
	$selQry .= 'FROM complexdetails WHERE complexid > 0 ORDER BY complexname';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['complexid']]['complexid'] = $selData['complexid'];
		$RetArr[$selData['complexid']]['complexname'] = $selData['complexname'];
		$RetArr[$selData['complexid']]['numunits'] = $selData['numunits'];
		$RetArr[$selData['complexid']]['shortcode'] = $selData['shortcode'];
		$RetArr[$selData['complexid']]['complexaddress1'] = $selData['complexaddress1'];
		$RetArr[$selData['complexid']]['complexaddress2'] = $selData['complexaddress2'];
		$RetArr[$selData['complexid']]['complexaddress3'] = $selData['complexaddress3'];
		$RetArr[$selData['complexid']]['complexaddress4'] = $selData['complexaddress4'];
		$RetArr[$selData['complexid']]['complexaddress5'] = $selData['complexaddress5'];
		$RetArr[$selData['complexid']]['complexstatus'] = $selData['complexstatus'];
		$RetArr[$selData['complexid']]['dateregistered'] = $selData['dateregistered'];
		$RetArr[$selData['complexid']]['clientid'] = $selData['clientid'];
		$RetArr[$selData['complexid']]['lat'] = $selData['lat'];
		$RetArr[$selData['complexid']]['lon'] = $selData['lon'];
	}
	return $RetArr;
}

function getComplexByName($Name)
{
	global $dbCon;
	
	$selQry = 'SELECT complexid, complexname, numunits, shortcode, complexaddress1, complexaddress2, complexaddress3, complexaddress4, complexaddress5, complexstatus, dateregistered, clientid, lat, lon ';
	$selQry .= 'FROM complexdetails WHERE complexid > 0 AND LOWER(complexname) = "' . strtolower($Name) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getComplexByID($ComplexID)
{
	global $dbCon;
	
	$selQry = 'SELECT complexid, complexname, numunits, shortcode, complexaddress1, complexaddress2, complexaddress3, complexaddress4, complexaddress5, complexstatus, dateregistered, clientid, lat, lon ';
	$selQry .= 'FROM complexdetails WHERE complexid = ' . $ComplexID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addComplexUnit($SaveArr)
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
	$updQry = 'INSERT INTO complexunits(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateComplexUnit($UnitID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE complexunits SET ' . $updStr . ' WHERE unitid = ' . $UnitID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getComplexeUnits($ComplexID)
{
	global $dbCon;
	
	$selQry = 'SELECT unitid, complexid, unitname, firstname, lastname, email, cell, tel, altfirstname, altlastname, altemail, altcell, alttel, fsannum ';
	$selQry .= 'FROM complexunits WHERE unitid > 0 AND complexid = ' . $ComplexID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['unitid']]['unitid'] = $selData['unitid'];
		$RetArr[$selData['unitid']]['complexid'] = $selData['complexid'];
		$RetArr[$selData['unitid']]['unitname'] = $selData['unitname'];
		$RetArr[$selData['unitid']]['firstname'] = $selData['firstname'];
		$RetArr[$selData['unitid']]['lastname'] = $selData['lastname'];
		$RetArr[$selData['unitid']]['email'] = $selData['email'];
		$RetArr[$selData['unitid']]['cell'] = $selData['cell'];
		$RetArr[$selData['unitid']]['tel'] = $selData['tel'];
		$RetArr[$selData['unitid']]['altfirstname'] = $selData['altfirstname'];
		$RetArr[$selData['unitid']]['altlastname'] = $selData['altlastname'];
		$RetArr[$selData['unitid']]['altemail'] = $selData['altemail'];
		$RetArr[$selData['unitid']]['altcell'] = $selData['altcell'];
		$RetArr[$selData['unitid']]['alttel'] = $selData['alttel'];
		$RetArr[$selData['unitid']]['fsannum'] = $selData['fsannum'];
	}
	return $RetArr;
}

function getComplexeUnitByUnitID($UnitID)
{
	global $dbCon;
	
	$selQry = 'SELECT unitid, complexid, unitname, firstname, lastname, email, cell, tel, altfirstname, altlastname, altemail, altcell, alttel, fsannum ';
	$selQry .= 'FROM complexunits WHERE unitid = ' . $UnitID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getComplexeUnitByUnitName($ComplexID, $UnitNum)
{
	global $dbCon;
	
	$selQry = 'SELECT unitid, complexid, unitname, firstname, lastname, email, cell, tel, altfirstname, altlastname, altemail, altcell, alttel, fsannum ';
	$selQry .= 'FROM complexunits WHERE unitid > 0 AND complexid = ' . $ComplexID . ' AND unitname = "' . $UnitNum . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addComplexFile($SaveArr)
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
	$updQry = 'INSERT INTO complexfiles(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getComplexFiles($ComplexID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, complex_id, filename, filepath, takendate FROM complexfiles WHERE complex_id = ' . $ComplexID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['complex_id'] = $selData['complex_id'];
		$RetArr[$selData['id']]['filename'] = $selData['filename'];
		$RetArr[$selData['id']]['filepath'] = $selData['filepath'];
		$RetArr[$selData['id']]['takendate'] = $selData['takendate'];
	}
	return $RetArr;
}
?>