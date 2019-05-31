<?php
function getAllSpliceProjects()
{
	global $dbCon;
	
	$selQry = 'SELECT id, project_name, creation_time, way_leave, contractor, proj_manager, site_manager, DATE(planned_start_date) AS planned_start_date, DATE(planned_end_date) AS planned_end_date, ';
	$selQry .= 'DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, client_id ';
	$selQry .= 'FROM core_splice_project WHERE id > 0 ORDER BY creation_time, planned_start_date';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['project_name'] = $selData['project_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['way_leave'] = $selData['way_leave'];
		$RetArr[$selData['id']]['contractor'] = $selData['contractor'];
		$RetArr[$selData['id']]['proj_manager'] = $selData['proj_manager'];
		$RetArr[$selData['id']]['site_manager'] = $selData['site_manager'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
	}
	return $RetArr;
}

function getSpliceProjectByID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, project_name, creation_time, way_leave, contractor, proj_manager, site_manager, DATE(planned_start_date) AS planned_start_date, DATE(planned_end_date) AS planned_end_date, ';
	$selQry .= 'DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, client_id ';
	$selQry .= 'FROM core_splice_project ';
	$selQry .= 'WHERE id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function addSpliceProject($SaveArr)
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
	$updQry = 'INSERT INTO core_splice_project(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveSpliceProject($ProjID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE core_splice_project SET ' . $updStr . ' WHERE id = ' . $ProjID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getSpliceSectionByID($SectionID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time, DATE(planned_start_date) AS planned_start_date, DATE(planned_end_date) AS planned_end_date, ';
	$selQry .= 'DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date ';
	$selQry .= 'FROM core_splice_sections ';
	$selQry .= 'WHERE id = ' . $SectionID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function getSpliceSectionByProjectID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time, DATE(planned_start_date) AS planned_start_date, DATE(planned_end_date) AS planned_end_date, ';
	$selQry .= 'DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date ';
	$selQry .= 'FROM core_splice_sections ';
	$selQry .= 'WHERE id > 0 AND project_id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['section_name'] = $selData['section_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
	}
	return $RetArr;
}

function getAllSpliceSections()
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time, DATE(planned_start_date) AS planned_start_date, DATE(planned_end_date) AS planned_end_date, ';
	$selQry .= 'DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date ';
	$selQry .= 'FROM core_splice_sections ';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['section_name'] = $selData['section_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
	}
	return $RetArr;
}


function addSpliceSection($SaveArr)
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
	$updQry = 'INSERT INTO core_splice_sections(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveSpliceSection($SectionID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE core_splice_sections SET ' . $updStr . ' WHERE id = ' . $SectionID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getSpliceProjectCostTemplate()
{
	global $dbCon;
	
	$selQry = 'SELECT id, item_name, item_unit, item_cost_default ';
	$selQry .= 'FROM core_splice_project_costbreakdown ';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['item_name'] = $selData['item_name'];
		$RetArr[$selData['id']]['item_unit'] = $selData['item_unit'];
		$RetArr[$selData['id']]['item_cost_default'] = $selData['item_cost_default'];
	}
	return $RetArr;
}

function getSpliceProjectCostsByProjectID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT project_id, cost_id, item_cost ';
	$selQry .= 'FROM core_splice_project_costs WHERE project_id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['cost_id']]['cost_id'] = $selData['cost_id'];
		$RetArr[$selData['cost_id']]['item_cost'] = $selData['item_cost'];
		$RetArr[$selData['cost_id']]['project_id'] = $selData['project_id'];
	}
	return $RetArr;
}

function saveSpliceProjectCost($ProjID, $CostID, $Cost)
{
	global $dbCon;
	
	$selQry = 'UPDATE core_splice_project_costs SET project_id = project_id * -1 WHERE project_id = ' . $ProjID . ' AND cost_id = ' . $CostID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$updQry = 'INSERT INTO core_splice_project_costs(project_id, cost_id, item_cost) VALUES ("' . $ProjID . '", "' . $CostID . '", "' . $Cost . '")';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function addSpliceSectionJoin($SaveArr)
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
	$updQry = 'INSERT INTO core_splice_joins(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveSpliceSectionJoin($JoinID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE core_splice_joins SET ' . $updStr . ' WHERE id = ' . $JoinID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getSpliceSectionJoinsByProjectID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, join_name, section_id, project_id, join_type, creation_time, num_splices, num_domes, join_coord_lat, join_coord_lon, manhole_number, address, DATE(planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(planned_end_date) AS planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, join_status, po_number, po_id ';
	$selQry .= 'FROM core_splice_joins ';
	$selQry .= 'WHERE project_id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['section_id']][$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['section_id']][$selData['id']]['join_name'] = $selData['join_name'];
		$RetArr[$selData['section_id']][$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['section_id']][$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['section_id']][$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['section_id']][$selData['id']]['join_type'] = $selData['join_type'];
		$RetArr[$selData['section_id']][$selData['id']]['num_splices'] = $selData['num_splices'];
		$RetArr[$selData['section_id']][$selData['id']]['num_domes'] = $selData['num_domes'];
		$RetArr[$selData['section_id']][$selData['id']]['join_coord_lat'] = $selData['join_coord_lat'];
		$RetArr[$selData['section_id']][$selData['id']]['join_coord_lon'] = $selData['join_coord_lon'];
		$RetArr[$selData['section_id']][$selData['id']]['manhole_number'] = $selData['manhole_number'];
		$RetArr[$selData['section_id']][$selData['id']]['address'] = $selData['address'];
		$RetArr[$selData['section_id']][$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['section_id']][$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['section_id']][$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['section_id']][$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['section_id']][$selData['id']]['join_status'] = $selData['join_status'];
		$RetArr[$selData['section_id']][$selData['id']]['po_number'] = $selData['po_number'];
		$RetArr[$selData['section_id']][$selData['id']]['po_id'] = $selData['po_id'];
	}
	return $RetArr;
}

function getSpliceJoinsByProjectID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, join_name, section_id, project_id, join_type, creation_time, num_splices, num_domes, join_coord_lat, join_coord_lon, manhole_number, address, DATE(planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(planned_end_date) AS planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, join_status, po_number, po_id ';
	$selQry .= 'FROM core_splice_joins ';
	$selQry .= 'WHERE project_id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['join_name'] = $selData['join_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['join_type'] = $selData['join_type'];
		$RetArr[$selData['id']]['num_splices'] = $selData['num_splices'];
		$RetArr[$selData['id']]['num_domes'] = $selData['num_domes'];
		$RetArr[$selData['id']]['join_coord_lat'] = $selData['join_coord_lat'];
		$RetArr[$selData['id']]['join_coord_lon'] = $selData['join_coord_lon'];
		$RetArr[$selData['id']]['manhole_number'] = $selData['manhole_number'];
		$RetArr[$selData['id']]['address'] = $selData['address'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['join_status'] = $selData['join_status'];
		$RetArr[$selData['id']]['po_number'] = $selData['po_number'];
		$RetArr[$selData['id']]['po_id'] = $selData['po_id'];
	}
	return $RetArr;
}

function getSpliceSectionJoinsByDay($Day, $Status = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, join_name, section_id, project_id, join_type, creation_time, num_splices, num_domes, join_coord_lat, join_coord_lon, manhole_number, address, DATE(planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(planned_end_date) AS planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, join_status, po_number, po_id ';
	$selQry .= 'FROM core_splice_joins ';
	$selQry .= 'WHERE (actual_start_date <= "' . $Day . '" AND actual_start_date != "0000-00-00" AND actual_start_date IS NOT NULL) ';
	if($Status !== '')
		$selQry .= ' AND join_status = ' . $Status . ' ';
	// echo $selQry . "<Br>";
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['section_id']][$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['section_id']][$selData['id']]['join_name'] = $selData['join_name'];
		$RetArr[$selData['section_id']][$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['section_id']][$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['section_id']][$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['section_id']][$selData['id']]['join_type'] = $selData['join_type'];
		$RetArr[$selData['section_id']][$selData['id']]['num_splices'] = $selData['num_splices'];
		$RetArr[$selData['section_id']][$selData['id']]['num_domes'] = $selData['num_domes'];
		$RetArr[$selData['section_id']][$selData['id']]['join_coord_lat'] = $selData['join_coord_lat'];
		$RetArr[$selData['section_id']][$selData['id']]['join_coord_lon'] = $selData['join_coord_lon'];
		$RetArr[$selData['section_id']][$selData['id']]['manhole_number'] = $selData['manhole_number'];
		$RetArr[$selData['section_id']][$selData['id']]['address'] = $selData['address'];
		$RetArr[$selData['section_id']][$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['section_id']][$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['section_id']][$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['section_id']][$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['section_id']][$selData['id']]['join_status'] = $selData['join_status'];
		$RetArr[$selData['section_id']][$selData['id']]['po_number'] = $selData['po_number'];
		$RetArr[$selData['section_id']][$selData['id']]['po_id'] = $selData['po_id'];
	}
	return $RetArr;
}

function getSpliceSectionJoinByJoinID($JoinID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, join_name, section_id, project_id, join_type, creation_time, num_splices, num_domes, join_coord_lat, join_coord_lon, manhole_number, address, DATE(planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(planned_end_date) AS planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, join_status, po_number, po_id ';
	$selQry .= 'FROM core_splice_joins ';
	$selQry .= 'WHERE id = ' . $JoinID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getPublicHolidays()
{
	global $dbCon;
	
	$selQry = 'SELECT holidayname, holidaydate FROM publicholidays';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['holidaydate']]['holidaydate'] = $selData['holidaydate'];
		$RetArr[$selData['holidaydate']]['holidayname'] = $selData['holidayname'];
	}
	return $RetArr;
}

function getSpliceProjectDiaryByProjectID($ProjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, theday, userid, join_id, section_id, project_id, num_splices_completed, num_domes_completed, creation_time ';
	$selQry .= 'FROM core_splice_diary ';
	$selQry .= 'WHERE join_id > 0 AND section_id > 0 AND project_id = ' . $ProjID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['theday']][$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['theday']][$selData['id']]['theday'] = $selData['theday'];
		$RetArr[$selData['theday']][$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['theday']][$selData['id']]['join_id'] = $selData['join_id'];
		$RetArr[$selData['theday']][$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['theday']][$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['theday']][$selData['id']]['num_splices_completed'] = $selData['num_splices_completed'];
		$RetArr[$selData['theday']][$selData['id']]['num_domes_completed'] = $selData['num_domes_completed'];
		$RetArr[$selData['theday']][$selData['id']]['creation_time'] = $selData['creation_time'];
	}
	return $RetArr;
}

function getSpliceDiaryJoinTotals($JoinID)
{
	global $dbCon;
	
	$selQry = 'SELECT join_id, SUM(num_splices_completed) AS splice_compl, SUM(num_domes_completed) AS dome_compl ';
	$selQry .= 'FROM core_splice_diary ';
	$selQry .= 'WHERE join_id IN (' . $JoinID . ') AND section_id > 0 AND project_id > 0 GROUP BY join_id';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['join_id']]['join_id'] = $selData['join_id'];
		$RetArr[$selData['join_id']]['splice_compl'] = $selData['splice_compl'];
		$RetArr[$selData['join_id']]['dome_compl'] = $selData['dome_compl'];
	}
	return $RetArr;
}

function getMonthlySpliceCount($StartDate, $EndDate)
{
	global $dbCon;
	
	$selQry = 'SELECT SUM(num_splices_completed) AS splicecount ';
	$selQry .= 'FROM core_splice_diary ';
	$selQry .= 'WHERE join_id > 0 AND theday BETWEEN "' . $StartDate . ' 00:00:00" AND "' . $EndDate . ' 23:59:59"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData['splicecount'];
}

function getJoinUsers($JoinID)
{
	global $dbCon;
	
	$selQry = 'SELECT userid, join_id FROM core_splice_join_techs WHERE join_id = ' . $JoinID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['userid']]['userid'] = $selData['userid'];
		$RetArr[$selData['userid']]['join_id'] = $selData['join_id'];
	}
	return $RetArr;
}

function clearJoinUsers($JoinID)
{
	global $dbCon;
		
	$selQry = 'UPDATE core_splice_join_techs SET userid = userid * -1, join_id = join_id * -1 WHERE join_id = ' . $JoinID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function addJoinUser($UserID, $JoinID)
{
	global $dbCon;
		
	$selQry = 'INSERT INTO core_splice_join_techs (join_id, userid) VALUES (' . $JoinID . ', ' . $UserID . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function getSpliceCheckGroups()
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_name, group_order FROM core_splice_check_groups ORDER BY group_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['group_name'] = $selData['group_name'];
		$RetArr[$selData['id']]['group_order'] = $selData['group_order'];
	}
	return $RetArr;
}

function getSpliceChecks()
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM core_splice_checks ORDER BY check_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['group_id']][$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['group_id']][$selData['id']]['group_id'] = $selData['group_id'];
		$RetArr[$selData['group_id']][$selData['id']]['check_name'] = $selData['check_name'];
		$RetArr[$selData['group_id']][$selData['id']]['check_description'] = $selData['check_description'];
		$RetArr[$selData['group_id']][$selData['id']]['check_order'] = $selData['check_order'];
	}
	return $RetArr;
}

function getSpliceChecksOnly()
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM core_splice_checks ORDER BY check_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['group_id'] = $selData['group_id'];
		$RetArr[$selData['id']]['check_name'] = $selData['check_name'];
		$RetArr[$selData['id']]['check_description'] = $selData['check_description'];
		$RetArr[$selData['id']]['check_order'] = $selData['check_order'];
	}
	return $RetArr;
}

function getSpliceCheckByCheckID($CheckID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM core_splice_checks WHERE id = ' . $CheckID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function addSpliceJoinPhoto($SaveArr)
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
	$updQry = 'INSERT INTO core_splice_join_photos(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function addSpliceJoinPhotoNote($SaveArr)
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
	$updQry = 'INSERT INTO core_splice_join_photonotes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getSpliceJoinPhotos($JoinID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, join_id, check_id, photopath, takendate, thumbnail, lat, lon, acc  FROM core_splice_join_photos WHERE join_id = ' . $JoinID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['join_id'] = $selData['join_id'];
		$RetArr[$selData['id']]['check_id'] = $selData['check_id'];
		$RetArr[$selData['id']]['photopath'] = $selData['photopath'];
		$RetArr[$selData['id']]['takendate'] = $selData['takendate'];
		$RetArr[$selData['id']]['thumbnail'] = $selData['thumbnail'];
		$RetArr[$selData['id']]['lat'] = $selData['lat'];
		$RetArr[$selData['id']]['lon'] = $selData['lon'];
		$RetArr[$selData['id']]['acc'] = $selData['acc'];
	}
	return $RetArr;
}

function getJoinStatusses()
{
	$StatusArr = array(0 => 'In progress', 1 => 'Spliced', 2 => 'Tested', 3 => 'Invoiced', 4 => '', 5 => 'External', 13 => 'Problem');
	return $StatusArr;
}
?>