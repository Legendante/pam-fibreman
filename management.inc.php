<?php
function getDepartments()
{
	global $dbCon;
	
	$selQry = 'SELECT departmentid, departmentname FROM departments WHERE departmentid > 0 ORDER BY departmentname';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['departmentid']]['departmentid'] = $selData['departmentid'];
		$RetArr[$selData['departmentid']]['departmentname'] = $selData['departmentname'];
	}
	return $RetArr;
}

function getDepartmentByName($DeptName)
{
	global $dbCon;
	
	$selQry = 'SELECT departmentid, departmentname FROM departments WHERE departmentid > 0 AND LOWER(departmentname) = "' . strtolower($DeptName) . '" ORDER BY departmentname';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}


function addDepartment($SaveArr)
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
	$updQry = 'INSERT INTO departments(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateDepartment($DeptID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE departments SET ' . $updStr . ' WHERE departmentid = ' . $DeptID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getProjects()
{
	global $dbCon;
	
	$selQry = 'SELECT id, project_name, creation_time, planned_start_date, planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, client_id, status_id ';
	$selQry .= 'FROM projects WHERE id > 0 ORDER BY client_id, project_name';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['project_name'] = $selData['project_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['status_id'] = $selData['status_id'];
	}
	return $RetArr;
}

function getClientProjects($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, project_name, creation_time, planned_start_date, planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, client_id, status_id ';
	$selQry .= 'FROM projects WHERE id > 0 AND client_id = ' . $ClientID . ' ORDER BY client_id, project_name';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['project_name'] = $selData['project_name'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['status_id'] = $selData['status_id'];
	}
	return $RetArr;
}

function getProjectByID($ProjectID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, project_name, creation_time, planned_start_date, planned_end_date, DATE(actual_start_date) AS actual_start_date, DATE(actual_end_date) AS actual_end_date, client_id, status_id ';
	$selQry .= 'FROM projects WHERE id > 0 AND id = ' . $ProjectID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addProject($SaveArr)
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
	$updQry = 'INSERT INTO projects(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateProject($DeptID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE projects SET ' . $updStr . ' WHERE id = ' . $DeptID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getProjectSections($PrjID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time FROM project_sections WHERE project_id = ' . $PrjID . ' ORDER BY section_name';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['section_name'] = $selData['section_name'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
	}
	return $RetArr;
}

function getSections()
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time FROM project_sections WHERE id > 0 ORDER BY section_name';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['section_name'] = $selData['section_name'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
	}
	return $RetArr;
}

function getSectionByID($SectionID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, section_name, project_id, creation_time FROM project_sections WHERE id = ' . $SectionID . ' ORDER BY section_name';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addProjectSection($SaveArr)
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
	$updQry = 'INSERT INTO project_sections(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateProjectSection($SectionID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE project_sections SET ' . $updStr . ' WHERE id = ' . $SectionID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getTasks($StatusID = '', $ClientID = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_name, client_id, section_id, project_id, department_id, creation_time, planned_start_date, planned_end_date, actual_start_date, actual_end_date, task_status, po_id, cable_num, pvc_num ';
	$selQry .= 'FROM project_tasks WHERE id > 0 ';
	if($StatusID != '')
		$selQry .= ' AND task_status = ' . $StatusID;
	if($ClientID != '')
		$selQry .= ' AND client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['task_name'] = $selData['task_name'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['department_id'] = $selData['department_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['task_status'] = $selData['task_status'];
		$RetArr[$selData['id']]['po_id'] = $selData['po_id'];
		$RetArr[$selData['id']]['cable_num'] = $selData['cable_num'];
		$RetArr[$selData['id']]['pvc_num'] = $selData['pvc_num'];
		
	}
	return $RetArr;
}

function getTasksByDepartment($DeptID, $StatusID = '', $ClientID = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_name, client_id, section_id, project_id, department_id, creation_time, planned_start_date, planned_end_date, actual_start_date, actual_end_date, task_status, po_id, cable_num, pvc_num ';
	$selQry .= 'FROM project_tasks WHERE id > 0 AND department_id = ' . $DeptID;
	if($StatusID != '')
		$selQry .= ' AND task_status = ' . $StatusID;
	if($ClientID != '')
		$selQry .= ' AND client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['task_name'] = $selData['task_name'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['department_id'] = $selData['department_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['task_status'] = $selData['task_status'];
		$RetArr[$selData['id']]['po_id'] = $selData['po_id'];
		$RetArr[$selData['id']]['cable_num'] = $selData['cable_num'];
		$RetArr[$selData['id']]['pvc_num'] = $selData['pvc_num'];
	}
	return $RetArr;
}

function getTasksBySection($SectionID, $StatusID = '', $ClientID = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_name, client_id, section_id, project_id, department_id, creation_time, planned_start_date, planned_end_date, actual_start_date, actual_end_date, task_status, po_id, cable_num, pvc_num ';
	$selQry .= 'FROM project_tasks WHERE id > 0 AND section_id = ' . $SectionID;
	if($StatusID != '')
		$selQry .= ' AND task_status = ' . $StatusID;
	if($ClientID != '')
		$selQry .= ' AND client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['task_name'] = $selData['task_name'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['department_id'] = $selData['department_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['task_status'] = $selData['task_status'];
		$RetArr[$selData['id']]['po_id'] = $selData['po_id'];
		$RetArr[$selData['id']]['cable_num'] = $selData['cable_num'];
		$RetArr[$selData['id']]['pvc_num'] = $selData['pvc_num'];
	}
	return $RetArr;
}

function getTasksByIDs($TaskIDs)
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_name, client_id, section_id, project_id, department_id, creation_time, planned_start_date, planned_end_date, actual_start_date, actual_end_date, task_status, po_id, cable_num, pvc_num ';
	$selQry .= 'FROM project_tasks WHERE id IN (' . implode(",", $TaskIDs) . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['task_name'] = $selData['task_name'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['department_id'] = $selData['department_id'];
		$RetArr[$selData['id']]['creation_time'] = $selData['creation_time'];
		$RetArr[$selData['id']]['planned_start_date'] = $selData['planned_start_date'];
		$RetArr[$selData['id']]['planned_end_date'] = $selData['planned_end_date'];
		$RetArr[$selData['id']]['actual_start_date'] = $selData['actual_start_date'];
		$RetArr[$selData['id']]['actual_end_date'] = $selData['actual_end_date'];
		$RetArr[$selData['id']]['task_status'] = $selData['task_status'];
		$RetArr[$selData['id']]['po_id'] = $selData['po_id'];
		$RetArr[$selData['id']]['cable_num'] = $selData['cable_num'];
		$RetArr[$selData['id']]['pvc_num'] = $selData['pvc_num'];
	}
	return $RetArr;
}

function getTaskByID($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_name, client_id, section_id, project_id, department_id, creation_time, planned_start_date, planned_end_date, actual_start_date, actual_end_date, task_status, po_id, cable_num, pvc_num ';
	$selQry .= 'FROM project_tasks WHERE id = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addTask($SaveArr)
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
	$updQry = 'INSERT INTO project_tasks(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateTask($TaskID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE project_tasks SET ' . $updStr . ' WHERE id = ' . $TaskID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getTaskBOQItems($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_id, item_id, estimated, completed FROM project_task_boqitems WHERE task_id = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['item_id']]['id'] = $selData['id'];
		$RetArr[$selData['item_id']]['task_id'] = $selData['task_id'];
		$RetArr[$selData['item_id']]['item_id'] = $selData['item_id'];
		$RetArr[$selData['item_id']]['estimated'] = $selData['estimated'];
		$RetArr[$selData['item_id']]['completed'] = $selData['completed'];
	}
	return $RetArr;
}

function getProjectBOQCount($ProjectID)
{
	global $dbCon;
	
	$selQry = 'SELECT item_id, SUM(estimated) AS estimated, SUM(completed) AS completed FROM project_task_boqitems ';
	$selQry .= 'INNER JOIN project_tasks ON project_tasks.id = project_task_boqitems.task_id AND project_tasks.project_id = ' . $ProjectID . ' ';
	$selQry .= 'GROUP BY item_id';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['item_id']]['item_id'] = $selData['item_id'];
		$RetArr[$selData['item_id']]['estimated'] = $selData['estimated'];
		$RetArr[$selData['item_id']]['completed'] = $selData['completed'];
	}
	return $RetArr;
}

function getMultiTaskBOQItems($TaskIDs)
{
	global $dbCon;
	
	$selQry = 'SELECT id, task_id, item_id, estimated, completed FROM project_task_boqitems WHERE task_id IN (' . implode(',', $TaskIDs) . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['task_id']][$selData['item_id']]['id'] = $selData['id'];
		$RetArr[$selData['task_id']][$selData['item_id']]['task_id'] = $selData['task_id'];
		$RetArr[$selData['task_id']][$selData['item_id']]['item_id'] = $selData['item_id'];
		$RetArr[$selData['task_id']][$selData['item_id']]['estimated'] = $selData['estimated'];
		$RetArr[$selData['task_id']][$selData['item_id']]['completed'] = $selData['completed'];
	}
	return $RetArr;
}

function addTaskBOQItem($TaskID, $ItemID, $Estimate, $Actual, $UserID)
{
	global $dbCon;
	$Estimate = ($Estimate == '') ? 0 : $Estimate;
	$Actual = ($Actual == '') ? 0 : $Actual;
	
	$updQry = 'INSERT INTO project_task_boqitems_log(task_id, item_id, estimated, completed, userid) SELECT task_id, item_id, estimated, completed, ' . $UserID . ' ';
	$updQry .= 'FROM project_task_boqitems WHERE task_id = ' . $TaskID . ' AND item_id = ' . $ItemID . ' AND (estimated != ' . $Estimate . ' OR completed != ' . $Actual . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'DELETE FROM project_task_boqitems WHERE task_id = ' . $TaskID . ' AND item_id = ' . $ItemID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'INSERT INTO project_task_boqitems(task_id, item_id, estimated, completed) VALUES (' . $TaskID . ', ' . $ItemID . ', ' . $Estimate . ', ' . $Actual . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function deleteTaskBOQItem($TaskID, $ItemID, $UserID)
{
	global $dbCon;
	
	$updQry = 'INSERT INTO project_task_boqitems_log(task_id, item_id, estimated, completed, userid) SELECT task_id, item_id, estimated, completed, ' . $UserID . ' ';
	$updQry .= 'FROM project_task_boqitems WHERE task_id = ' . $TaskID . ' AND item_id = ' . $ItemID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'DELETE FROM project_task_boqitems WHERE task_id = ' . $TaskID . ' AND item_id = ' . $ItemID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getTaskStatusses()
{
	global $dbCon;
	
	$selQry = 'SELECT id, status_name, status_rating, quotable, invoiceable, projectable FROM task_status WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['status_name'] = $selData['status_name'];
		$RetArr[$selData['id']]['status_rating'] = $selData['status_rating'];
		$RetArr[$selData['id']]['quotable'] = $selData['quotable'];
		$RetArr[$selData['id']]['invoiceable'] = $selData['invoiceable'];
		$RetArr[$selData['id']]['projectable'] = $selData['projectable'];
	}
	return $RetArr;
}

function getTaskStatusByName($Status)
{
	global $dbCon;
	
	$selQry = 'SELECT id, status_name, status_rating, quotable, invoiceable FROM task_status WHERE id > 0 AND LOWER(status_name) = "' . strtolower($Status) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getTaskFileTypes()
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_name, has_thumbnail FROM task_file_types WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_name'] = $selData['type_name'];
		$RetArr[$selData['id']]['has_thumbnail'] = $selData['has_thumbnail'];
	}
	return $RetArr;
}

function getTaskFileTypeByName($Name)
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_name, has_thumbnail FROM task_file_types WHERE id > 0 AND LOWER(type_name) = "' . strtolower($Name) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getTaskCheckGroups($TypeID = '', $DepartmentID = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_name, group_order, type_id, department_id FROM task_check_groups WHERE id > 0 ';
	if($TypeID != '')
		$selQry .= 'AND type_id = ' . $TypeID . ' ';
	if($DepartmentID != '')
		$selQry .= 'AND department_id = ' . $DepartmentID . ' ';
	$selQry .= 'ORDER BY group_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['group_name'] = $selData['group_name'];
		$RetArr[$selData['id']]['group_order'] = $selData['group_order'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['department_id'] = $selData['department_id'];
	}
	return $RetArr;
}

function getTaskCheckGroupByName($Name)
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_name, group_order, type_id, department_id FROM task_check_groups WHERE id > 0 AND LOWER(group_name) = "' . strtolower($Name) . '" ORDER BY group_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getTaskChecks()
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM task_checks ORDER BY check_order';
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

function getTaskCheckTypeByName($GroupID, $Name)
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM task_checks WHERE id > 0 AND group_id = ' . $GroupID . ' AND LOWER(check_name) = "' . strtolower($Name) . '"';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getTaskChecksOnly()
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM task_checks ORDER BY check_order';
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

function getTaskCheckByCheckID($CheckID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, group_id, check_name, check_description, check_order FROM task_checks WHERE id = ' . $CheckID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_fetch_array($selRes);
}

function addTaskFile($SaveArr)
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
	$updQry = 'INSERT INTO task_files(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateTaskFile($FileID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE task_files SET ' . $updStr . ' WHERE id = ' . $FileID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getTaskFiles($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, task_id, check_id, type_id, filepath, takendate, thumbnail, lat, lon, acc, batch FROM task_files WHERE task_id = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['task_id'] = $selData['task_id'];
		$RetArr[$selData['id']]['check_id'] = $selData['check_id'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['filepath'] = $selData['filepath'];
		$RetArr[$selData['id']]['takendate'] = $selData['takendate'];
		$RetArr[$selData['id']]['thumbnail'] = $selData['thumbnail'];
		$RetArr[$selData['id']]['lat'] = $selData['lat'];
		$RetArr[$selData['id']]['lon'] = $selData['lon'];
		$RetArr[$selData['id']]['acc'] = $selData['acc'];
		$RetArr[$selData['id']]['batch'] = $selData['batch'];
	}
	return $RetArr;
}

function getTaskFileByID($FileID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, task_id, check_id, type_id, filepath, takendate, thumbnail, lat, lon, acc, batch FROM task_files WHERE id = ' . $FileID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addTaskFileNote($SaveArr)
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
	$updQry = 'INSERT INTO task_filenotes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function addTaskNote($SaveArr)
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
	$updQry = 'INSERT INTO task_notes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getTaskNotes($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, taskid, userid, creationdate, noteval FROM task_notes WHERE taskid = ' . $TaskID . ' ORDER BY creationdate DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['taskid'] = $selData['taskid'];
		$RetArr[$selData['id']]['creationdate'] = $selData['creationdate'];
		$RetArr[$selData['id']]['noteval'] = $selData['noteval'];
	}
	return $RetArr;
}

function addMaintenance($SaveArr)
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
	$updQry = 'INSERT INTO maintenancetasks(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateMaintenance($MainID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE maintenancetasks SET ' . $updStr . ' WHERE id = ' . $MainID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getMaintenanceByTaskID($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, unitid, taskid, createddate, ticketnumber, tplocationid, infrastuctid, timeonsite, faultdesc, solutiondesc, wascustomerneglect, custonsite, maintnote, apptime ';
	$selQry .= 'FROM maintenancetasks WHERE taskid = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getTPLocations()
{
	global $dbCon;
	
	$selQry = 'SELECT id, location FROM tplocations WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['location'] = $selData['location'];
	}
	return $RetArr;
}

function getInfrastructureMethods()
{
	global $dbCon;
	
	$selQry = 'SELECT id, method FROM infrastructure_methods WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['method'] = $selData['method'];
	}
	return $RetArr;
}

function addProjectFile($SaveArr)
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
	$updQry = 'INSERT INTO projectfiles(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getProjectFiles($ProjectID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, project_id, filename, filepath, takendate FROM projectfiles WHERE project_id = ' . $ProjectID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['project_id'] = $selData['project_id'];
		$RetArr[$selData['id']]['filename'] = $selData['filename'];
		$RetArr[$selData['id']]['filepath'] = $selData['filepath'];
		$RetArr[$selData['id']]['takendate'] = $selData['takendate'];
	}
	return $RetArr;
}

function addSectionFile($SaveArr)
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
	$updQry = 'INSERT INTO sectionfiles(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getSectionFiles($SectionID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, userid, section_id, filename, filepath, takendate FROM sectionfiles WHERE section_id = ' . $SectionID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['id']]['filename'] = $selData['filename'];
		$RetArr[$selData['id']]['filepath'] = $selData['filepath'];
		$RetArr[$selData['id']]['takendate'] = $selData['takendate'];
	}
	return $RetArr;
}

function addAccessBuild($SaveArr)
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
	$updQry = 'INSERT INTO accessbuildtasks(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateAccessBuild($MainID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE accessbuildtasks SET ' . $updStr . ' WHERE id = ' . $MainID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getAccessBuildByTaskID($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, unitid, taskid, createddate, ticketnumber, tplocationid, infrastuctid, timeonsite, faultdesc, solutiondesc, wascustomerneglect, custonsite, maintnote, apptime ';
	$selQry .= 'FROM accessbuildtasks WHERE taskid = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addLinkedTasks($RightTaskID, $LeftTaskID, $LinkLength = 0)
{
	global $dbCon;
	
	$selQry = 'INSERT INTO linked_tasks(left_taskid, right_taskid, link_length) VALUES (' . $LeftTaskID . ', ' . $RightTaskID . ', ' . $LinkLength . ')';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateLinkedTasks($RightTaskID, $LeftTaskID, $LinkLength = 0)
{
	global $dbCon;
	
	$selQry = 'UPDATE linked_tasks SET link_length = ' . $LinkLength . ' WHERE left_taskid = ' . $LeftTaskID . ' AND right_taskid = ' . $RightTaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
}

function getLinkedTasks($TaskID)
{
	global $dbCon;
	
	$selQry = 'SELECT left_taskid, right_taskid, link_length FROM linked_tasks WHERE left_taskid = ' . $TaskID . ' OR right_taskid = ' . $TaskID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['right_taskid']]['right_taskid'] = $selData['right_taskid'];
		$RetArr[$selData['right_taskid']]['left_taskid'] = $selData['left_taskid'];
		$RetArr[$selData['right_taskid']]['link_length'] = $selData['link_length'];
	}
	return $RetArr;
}
?>