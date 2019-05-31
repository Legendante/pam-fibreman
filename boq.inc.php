<?php
function addBOQLineItem($SaveArr)
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
	$updQry = 'INSERT INTO boqlineitems(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateBOQLineItem($ItemID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE boqlineitems SET ' . $updStr . ' WHERE itemid = ' . $ItemID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getBOQLineItems()
{
	global $dbCon;
	
	$selQry = 'SELECT itemid, item_name, unitid, categoryid, defaultcost FROM boqlineitems WHERE itemid > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['itemid']]['itemid'] = $selData['itemid'];
		$RetArr[$selData['itemid']]['item_name'] = $selData['item_name'];
		$RetArr[$selData['itemid']]['unitid'] = $selData['unitid'];
		$RetArr[$selData['itemid']]['categoryid'] = $selData['categoryid'];
		$RetArr[$selData['itemid']]['defaultcost'] = $selData['defaultcost'];
	}
	return $RetArr;
}

function addBOQCategory($SaveArr)
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
		$selQry = 'SELECT MAX(sortorder) AS maxsort FROM boqcategories';
		$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
		$selData = mysqli_fetch_array($selRes);
		$SortO = $selData['maxsort'];
		$fieldA[$cnt] = 'sortorder';
		$valueA[$cnt] = '"' . ($SortO + 1) . '"';
		$cnt++;
	}
	$updQry = 'INSERT INTO boqcategories(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateBOQCategory($CatID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE boqcategories SET ' . $updStr . ' WHERE categoryid = ' . $CatID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function updateBOQCategorySort($OldVal, $NewVal)
{
	global $dbCon;
	
	$updQry = 'UPDATE boqcategories SET sortorder = sortorder * -1 WHERE sortorder = ' . $NewVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE boqcategories SET sortorder = ' . $NewVal . ' WHERE sortorder = ' . $OldVal;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE boqcategories SET sortorder = ' . $OldVal . ' WHERE sortorder = ' . ($NewVal * -1);
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getBOQTaskUnits()
{
	global $dbCon;
	
	$selQry = 'SELECT unitid, unitname FROM boqtaskunits WHERE unitid > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['unitid']]['unitid'] = $selData['unitid'];
		$RetArr[$selData['unitid']]['unitname'] = $selData['unitname'];
	}
	return $RetArr;
}

function getBOQCategories()
{
	global $dbCon;
	
	$selQry = 'SELECT categoryid, categoryname, sortorder FROM boqcategories WHERE categoryid > 0 ORDER BY sortorder';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['categoryid']]['categoryid'] = $selData['categoryid'];
		$RetArr[$selData['categoryid']]['categoryname'] = $selData['categoryname'];
		$RetArr[$selData['categoryid']]['sortorder'] = $selData['sortorder'];
	}
	return $RetArr;
}

function addBOQTemplate($SaveArr)
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
	$updQry = 'INSERT INTO boqtemplate(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function updateBOQTemplate($TemplateID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE boqtemplate SET ' . $updStr . ' WHERE templateid = ' . $TemplateID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getBOQTemplates()
{
	global $dbCon;
	
	$selQry = 'SELECT templateid, template_name, client_id FROM boqtemplate WHERE templateid > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['templateid']]['templateid'] = $selData['templateid'];
		$RetArr[$selData['templateid']]['template_name'] = $selData['template_name'];
		$RetArr[$selData['templateid']]['client_id'] = $selData['client_id'];
	}
	return $RetArr;
}

function getBOQTemplateByID($TemplateID)
{
	global $dbCon;
	
	$selQry = 'SELECT templateid, template_name, client_id FROM boqtemplate WHERE templateid = ' . $TemplateID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr['templateid'] = $selData['templateid'];
		$RetArr['template_name'] = $selData['template_name'];
		$RetArr['client_id'] = $selData['client_id'];
	}
	return $RetArr;
}

function addBOQTemplateItem($SaveArr)
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
	$updQry = 'INSERT INTO boqtemplate_items(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function clearBOQTemplateItems($TemplateID)
{
	global $dbCon;
	
	$updQry = 'UPDATE boqtemplate_items SET templateid = templateid * -1, item_id = item_id * -1 WHERE templateid = ' . $TemplateID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getBOQTemplateItems($TemplateID)
{
	global $dbCon;
	
	$selQry = 'SELECT template_item_id, templateid, item_id FROM boqtemplate_items WHERE templateid = ' . $TemplateID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['item_id']]['item_id'] = $selData['item_id'];
		$RetArr[$selData['item_id']]['templateid'] = $selData['templateid'];
	}
	return $RetArr;
}

function addBOQItemClientCost($ClientID, $ItemID, $Cost)
{
	global $dbCon;
	
	$updQry = 'UPDATE boqlineitems_costing SET client_id = client_id * -1, item_id = item_id * -1 WHERE client_id = ' . $ClientID . ' AND item_id = ' . $ItemID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'INSERT INTO boqlineitems_costing(client_id, item_id, cost) VALUES (' . $ClientID . ', ' . $ItemID . ', "' . $Cost . '")';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getBOQItemsClientCost($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT client_id, item_id, cost FROM boqlineitems_costing WHERE client_id = ' . $ClientID . ' AND item_id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['item_id']] = $selData['cost'];
	}
	return $RetArr;
}

?>