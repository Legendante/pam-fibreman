<?php
function getMapDetails()
{
	global $dbCon;
	
	$selQry = 'SELECT id, map_name, sort_order FROM mapdetails ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['map_name'] = $selData['map_name'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;	
}

function getMapDetailByID($MapID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, map_name, sort_order FROM mapdetails WHERE id = ' . $MapID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addMapDetails($SaveArr)
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
	if(!isset($SaveArr['sortorder']))
	{
		$selQry = 'SELECT MAX(sort_order) AS maxsort FROM mapdetails';
		$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
		$selData = mysqli_fetch_array($selRes);
		$SortO = $selData['maxsort'];
		$fieldA[$cnt] = 'sort_order';
		$valueA[$cnt] = '"' . ($SortO + 1) . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO mapdetails(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateMapDetails($MapID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE mapdetails SET ' . $updStr . ' WHERE id = ' . $MapID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getMapPointTypes()
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_name, sort_order FROM mappointstypes ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_name'] = $selData['type_name'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;	
}

function addMapPointType($SaveArr)
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
	if(!isset($SaveArr['sortorder']))
	{
		$selQry = 'SELECT MAX(sort_order) AS maxsort FROM mappointstypes';
		$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
		$selData = mysqli_fetch_array($selRes);
		$SortO = $selData['maxsort'];
		$fieldA[$cnt] = 'sort_order';
		$valueA[$cnt] = '"' . ($SortO + 1) . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO mappointstypes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateMapPointType($PointID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE mappointstypes SET ' . $updStr . ' WHERE id = ' . $PointID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateMapPointTypeSort($OldVal, $NewVal)
{
	global $dbCon;
	
	$updQry = 'UPDATE mappointstypes SET sort_order = sort_order * -1 WHERE sort_order = ' . $NewVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE mappointstypes SET sort_order = ' . $NewVal . ' WHERE sort_order = ' . $OldVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE mappointstypes SET sort_order = ' . $OldVal . ' WHERE sort_order = ' . ($NewVal * -1);
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getMapPointQuestionTypes()
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_name FROM mappointquestiontypes';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_name'] = $selData['type_name'];
	}
	return $RetArr;
}

function getAllMapPointQuestions()
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_id, pointtype_id, question, parent_id, sort_order FROM mappointquestions ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['pointtype_id'] = $selData['pointtype_id'];
		$RetArr[$selData['id']]['question'] = $selData['question'];
		$RetArr[$selData['id']]['parent_id'] = $selData['parent_id'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;
}

function getMapPointQuestions($PointTypeID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_id, pointtype_id, question, parent_id, sort_order FROM mappointquestions WHERE pointtype_id = ' . $PointTypeID . ' ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['pointtype_id'] = $selData['pointtype_id'];
		$RetArr[$selData['id']]['question'] = $selData['question'];
		$RetArr[$selData['id']]['parent_id'] = $selData['parent_id'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;
}

function getMapPointQuestionByID($QuestionID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_id, pointtype_id, question, parent_id, sort_order FROM mappointquestions WHERE id = ' . $QuestionID . ' ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addMapPointQuestion($SaveArr)
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
	if(!isset($SaveArr['sortorder']))
	{
		$selQry = 'SELECT MAX(sort_order) AS maxsort FROM mappointquestions';
		$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
		$selData = mysqli_fetch_array($selRes);
		$SortO = $selData['maxsort'];
		$fieldA[$cnt] = 'sort_order';
		$valueA[$cnt] = '"' . ($SortO + 1) . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO mappointquestions(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}
	
function updateMapPointQuestion($QuestionID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE mappointquestions SET ' . $updStr . ' WHERE id = ' . $QuestionID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateMapPointQuestionSort($TypeID, $OldVal, $NewVal)
{
	global $dbCon;
	
	$updQry = 'UPDATE mappointquestions SET sort_order = sort_order * -1 WHERE pointtype_id = ' . $TypeID . ' AND sort_order = ' . $NewVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE mappointquestions SET sort_order = ' . $NewVal . ' WHERE pointtype_id = ' . $TypeID . ' AND sort_order = ' . $OldVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE mappointquestions SET sort_order = ' . $OldVal . ' WHERE pointtype_id = ' . $TypeID . ' AND sort_order = ' . ($NewVal * -1);
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getAllMapPointQuestionOptions()
{
	global $dbCon;
	
	$selQry = 'SELECT id, question_id, optiontxt, optionval, sort_order FROM mappointoptions ORDER BY question_id, sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['question_id'] = $selData['question_id'];
		$RetArr[$selData['id']]['optiontxt'] = $selData['optiontxt'];
		$RetArr[$selData['id']]['optionval'] = $selData['optionval'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;
}

function getMapPointQuestionOptions($QuestionID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, question_id, optiontxt, optionval, sort_order FROM mappointoptions WHERE question_id = ' . $QuestionID . ' ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['question_id'] = $selData['question_id'];
		$RetArr[$selData['id']]['optiontxt'] = $selData['optiontxt'];
		$RetArr[$selData['id']]['optionval'] = $selData['optionval'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;
}

function addMapPointQuestionOption($SaveArr)
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
	if(!isset($SaveArr['sortorder']))
	{
		$selQry = 'SELECT MAX(sort_order) AS maxsort FROM mappointoptions WHERE question_id = ' . $SaveArr['question_id'];
		$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
		$selData = mysqli_fetch_array($selRes);
		$SortO = $selData['maxsort'];
		$fieldA[$cnt] = 'sort_order';
		$valueA[$cnt] = '"' . ($SortO + 1) . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO mappointoptions(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}
	
function updateMapPointQuestionOption($OptionID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE mappointoptions SET ' . $updStr . ' WHERE id = ' . $OptionID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}


function getMapDataFields()
{
	global $dbCon;
	
	$selQry = 'SELECT id, field_name, sort_order FROM mapdatafields ORDER BY sort_order';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['field_name'] = $selData['field_name'];
		$RetArr[$selData['id']]['sort_order'] = $selData['sort_order'];
	}
	return $RetArr;	
}

function getMapPointTypeFields($TypeID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, type_id, field_id FROM mapdatatypefields WHERE type_id = ' . $TypeID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['field_id'] = $selData['field_id'];
	}
	return $RetArr;	
}

function addMapPoint($SaveArr)
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
	$updQry = 'INSERT INTO mappoints(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateMapPoint($PointID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE mappoints SET ' . $updStr . ' WHERE id = ' . $PointID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getMapPoints($MapID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, point_name, type_id, map_id, lat, lon, acc FROM mappoints WHERE map_id = ' . $MapID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['type_id'] = $selData['type_id'];
		$RetArr[$selData['id']]['point_name'] = $selData['point_name'];
		$RetArr[$selData['id']]['map_id'] = $selData['map_id'];
		$RetArr[$selData['id']]['lat'] = $selData['lat'];
		$RetArr[$selData['id']]['lon'] = $selData['lon'];
		$RetArr[$selData['id']]['acc'] = $selData['acc'];
	}
	return $RetArr;	
}

function addMapPointValue($SaveArr)
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
	$updQry = 'INSERT INTO mappointquestiondata(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getMapPointValuesByMapID($MapID)
{
	global $dbCon;
	
	$selQry = 'SELECT mappointquestiondata.id AS id, point_id, question_id, option_id, question_val FROM mappointquestiondata ';
	$selQry .= 'INNER JOIN mappoints ON mappoints.id = mappointquestiondata.point_id AND mappoints.map_id = ' . $MapID . ' ';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['point_id']][$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['point_id']][$selData['id']]['point_id'] = $selData['point_id'];
		$RetArr[$selData['point_id']][$selData['id']]['question_id'] = $selData['question_id'];
		$RetArr[$selData['point_id']][$selData['id']]['option_id'] = $selData['option_id'];
		$RetArr[$selData['point_id']][$selData['id']]['question_val'] = $selData['question_val'];
	}
	return $RetArr;
}
?>