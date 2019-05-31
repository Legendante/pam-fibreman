<?php
function getAccounts($Type = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, accountname, accountbalance, accounttype FROM accounts WHERE id > 0';
	if($Type != '')
		$selQry .= ' AND accounttype = ' . $Type;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['id']]['id'] = $selData['id'];
		$retArr[$selData['id']]['accountname'] = $selData['accountname'];
		$retArr[$selData['id']]['accountbalance'] = $selData['accountbalance'];
		$retArr[$selData['id']]['accounttype'] = $selData['accounttype'];
	}
	return $retArr;
}

function getAccountTypes()
{
	global $dbCon;
	
	$selQry = 'SELECT id, typename FROM account_types';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['id']]['id'] = $selData['id'];
		$retArr[$selData['id']]['typename'] = $selData['typename'];
	}
	return $retArr;
}

function doAccountTransfer($FromAcc, $Amount, $Date, $Descr, $User, $ToAcc = '', $InvID = '', $ExpID = '')
{
	global $dbCon;
	$ToAcc = ($ToAcc == '') ? 'NULL' : $ToAcc;
	$InvID = ($InvID == '') ? 'NULL' : $InvID;
	$ExpID = ($ExpID == '') ? 'NULL' : $ExpID;
	
	$updQry = 'INSERT INTO accounts_log(from_id, to_id, invoice_id, expense_id, amount, transdate, description, userid) VALUES ';
	$updQry .= '(' . $FromAcc . ', ' . $ToAcc . ', ' . $InvID . ', ' . $ExpID . ', "' . $Amount . '", "' . $Date . '", "' . $Descr . '", ' . $User . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	$updQry = 'UPDATE accounts SET accountbalance = accountbalance - "' . $Amount . '" WHERE id = ' . $FromAcc;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	
	if($ToAcc != 'NULL')
	{
		$updQry = 'UPDATE accounts SET accountbalance = accountbalance + "' . $Amount . '" WHERE id = ' . $ToAcc;
		$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	}
}

// function getInvoices($InvStatus = '')
// {
	// global $dbCon;
	
	// $selQry = 'SELECT id, supplier_id, invoicesubtotal, invoicevattotal, invoicetotal, logtime, inv_status FROM invoices WHERE id > 0';
	// if($InvStatus != '')
		// $selQry .= ' AND inv_status = ' . $InvStatus;
	// $selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	// $retArr = array();
	// while($selData = mysqli_fetch_array($selRes))
	// {
		// $retArr[$selData['id']]['id'] = $selData['id'];
		// $retArr[$selData['id']]['supplier_id'] = $selData['supplier_id'];
		// $retArr[$selData['id']]['invoicesubtotal'] = $selData['invoicesubtotal'];
		// $retArr[$selData['id']]['invoicevattotal'] = $selData['invoicevattotal'];
		// $retArr[$selData['id']]['invoicetotal'] = $selData['invoicetotal'];
		// $retArr[$selData['id']]['logtime'] = $selData['logtime'];
		// $retArr[$selData['id']]['inv_status'] = $selData['inv_status'];
	// }
	// return $retArr;
// }

function getSuppliers()
{
	global $dbCon;
	
	$selQry = 'SELECT id, suppliername, supplierbalance, costcentre_id FROM supplier WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['id']]['id'] = $selData['id'];
		$retArr[$selData['id']]['suppliername'] = $selData['suppliername'];
		$retArr[$selData['id']]['supplierbalance'] = $selData['supplierbalance'];
		$retArr[$selData['id']]['costcentre_id'] = $selData['costcentre_id'];
	}
	return $retArr;
}

function getCostCentres()
{
	global $dbCon;
	
	$selQry = 'SELECT id, centrename FROM cost_centre WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['id']]['id'] = $selData['id'];
		$retArr[$selData['id']]['centrename'] = $selData['centrename'];
	}
	return $retArr;
}

function getClients()
{
	global $dbCon;
	
	$selQry = 'SELECT id, clientname, client_short, client_balance, client_reg, client_vat, client_address, client_tel, client_email FROM client_details WHERE id > 0';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$retArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$retArr[$selData['id']]['id'] = $selData['id'];
		$retArr[$selData['id']]['clientname'] = $selData['clientname'];
		$retArr[$selData['id']]['client_short'] = $selData['client_short'];
		$retArr[$selData['id']]['client_balance'] = $selData['client_balance'];
		$retArr[$selData['id']]['client_reg'] = $selData['client_reg'];
		$retArr[$selData['id']]['client_vat'] = $selData['client_vat'];
		$retArr[$selData['id']]['client_address'] = $selData['client_address'];
		$retArr[$selData['id']]['client_tel'] = $selData['client_tel'];
		$retArr[$selData['id']]['client_email'] = $selData['client_email'];
	}
	return $retArr;
}

function getClientByID($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, clientname, client_short, client_balance, client_reg, client_vat, client_address, client_tel, client_email FROM client_details WHERE id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function addClient($SaveArr)
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
	$updQry = 'INSERT INTO client_details(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveClient($ClientID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE client_details SET ' . $updStr . ' WHERE id = ' . $ClientID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getInvoiceReadyItems($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT core_splice_joins.id AS id, join_name, core_splice_sections.id AS section_id, core_splice_project.id AS project_id, join_type, core_splice_joins.creation_time, num_splices, num_domes, ';
	$selQry .= 'join_coord_lat, join_coord_lon, manhole_number, address, DATE(core_splice_joins.planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(core_splice_joins.planned_end_date) AS planned_end_date, DATE(core_splice_joins.actual_start_date) AS actual_start_date, DATE(core_splice_joins.actual_end_date) AS actual_end_date, join_status, po_number, ';
	$selQry .= 'po_id ';
	$selQry .= 'FROM core_splice_project ';
	$selQry .= 'INNER JOIN core_splice_sections ON core_splice_sections.project_id = core_splice_project.id ';
	$selQry .= 'INNER JOIN core_splice_joins ON core_splice_joins.section_id = core_splice_sections.id AND join_status = 2 ';
	$selQry .= 'INNER JOIN core_splice_diary ON core_splice_diary.join_id = core_splice_joins.id ';
	$selQry .= 'WHERE core_splice_project.client_id = ' . $ClientID;
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

function getToBeTestedItems($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT core_splice_joins.id AS id, join_name, core_splice_sections.id AS section_id, core_splice_project.id AS project_id, join_type, core_splice_joins.creation_time, num_splices, num_domes, ';
	$selQry .= 'join_coord_lat, join_coord_lon, manhole_number, address, DATE(core_splice_joins.planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(core_splice_joins.planned_end_date) AS planned_end_date, DATE(core_splice_joins.actual_start_date) AS actual_start_date, DATE(core_splice_joins.actual_end_date) AS actual_end_date, join_status, po_number, ';
	$selQry .= 'po_id ';
	$selQry .= 'FROM core_splice_project ';
	$selQry .= 'INNER JOIN core_splice_sections ON core_splice_sections.project_id = core_splice_project.id ';
	$selQry .= 'INNER JOIN core_splice_joins ON core_splice_joins.section_id = core_splice_sections.id AND join_status = 1 ';
	$selQry .= 'INNER JOIN core_splice_diary ON core_splice_diary.join_id = core_splice_joins.id ';
	$selQry .= 'WHERE core_splice_project.client_id = ' . $ClientID;
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


function getQuoteReadyItems($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT core_splice_joins.id AS id, join_name, core_splice_sections.id AS section_id, core_splice_project.id AS project_id, join_type, core_splice_joins.creation_time, num_splices, num_domes, ';
	$selQry .= 'join_coord_lat, join_coord_lon, manhole_number, address, DATE(core_splice_joins.planned_start_date) AS planned_start_date, ';
	$selQry .= 'DATE(core_splice_joins.planned_end_date) AS planned_end_date, DATE(core_splice_joins.actual_start_date) AS actual_start_date, DATE(core_splice_joins.actual_end_date) AS actual_end_date, join_status ';
	$selQry .= 'FROM core_splice_project ';
	$selQry .= 'INNER JOIN core_splice_sections ON core_splice_sections.project_id = core_splice_project.id ';
	$selQry .= 'INNER JOIN core_splice_joins ON core_splice_joins.section_id = core_splice_sections.id AND join_status IN (0,1,2) AND (po_number IS NULL OR po_number = "") ';
	$selQry .= 'WHERE core_splice_project.client_id = ' . $ClientID;
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
	}
	return $RetArr;
}

function getNextQuoteNumber($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT MAX(quote_number) AS maxnum FROM client_quotes WHERE client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$NxtNum = $selData['maxnum'];
	$NxtNum = ($NxtNum == '') ? 1 : $NxtNum + 1;
	return $NxtNum;
}

function getNextInvoiceNumber($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT MAX(inv_number) AS maxnum FROM client_invoices WHERE client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$NxtNum = $selData['maxnum'];
	$NxtNum = ($NxtNum == '') ? 1 : $NxtNum + 1;
	return $NxtNum;
}

function getNextStatementNumber($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT MAX(statement_number) AS maxnum FROM client_statements WHERE client_id = ' . $ClientID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$NxtNum = $selData['maxnum'];
	$NxtNum = ($NxtNum == '') ? 1 : $NxtNum + 1;
	return $NxtNum;
}

function addStatement($SaveArr)
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
	$updQry = 'INSERT INTO client_statements(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function addInvoice($SaveArr)
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
	$updQry = 'INSERT INTO client_invoices(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveInvoice($InvoiceID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE client_invoices SET ' . $updStr . ' WHERE id = ' . $InvoiceID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}


function addQuote($SaveArr)
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
	$updQry = 'INSERT INTO client_quotes(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function saveQuote($QuoteID, $SaveArr)
{
	global $dbCon;
	
	$updStr = '';
	foreach($SaveArr AS $Field => $Value)
	{
		if($updStr != '')
			$updStr .= ', ';
		$updStr .= $Field . ' = "' . $Value . '"';
	}
	$updQry = 'UPDATE client_quotes SET ' . $updStr . ' WHERE id = ' . $QuoteID;
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function addInvoiceItem($SaveArr)
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
	$updQry = 'INSERT INTO invoice_items(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	// return mysqli_insert_id($dbCon);
}

function getInvoiceItemsByInvoiceID($InvID)
{
	global $dbCon;
	
	$selQry = 'SELECT invoice_id, join_id, section_id, project_id FROM invoice_items WHERE invoice_id = ' . $InvID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['join_id']]['invoice_id'] = $selData['invoice_id'];
		$RetArr[$selData['join_id']]['join_id'] = $selData['join_id'];
		$RetArr[$selData['join_id']]['section_id'] = $selData['section_id'];
		$RetArr[$selData['join_id']]['project_id'] = $selData['project_id'];
	}
	return $RetArr;
}

function getInvoicePayments($InvID)
{
	global $dbCon;
	
	$selQry = 'SELECT from_id, to_id, invoice_id, amount, transdate, logtime, userid, description FROM accounts_log WHERE invoice_id = ' . $InvID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['logtime']]['from_id'] = $selData['from_id'];
		$RetArr[$selData['logtime']]['to_id'] = $selData['to_id'];
		$RetArr[$selData['logtime']]['invoice_id'] = $selData['invoice_id'];
		$RetArr[$selData['logtime']]['amount'] = $selData['amount'];
		
		$RetArr[$selData['logtime']]['transdate'] = $selData['transdate'];
		$RetArr[$selData['logtime']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['logtime']]['userid'] = $selData['userid'];
		$RetArr[$selData['logtime']]['description'] = $selData['description'];
	}
	return $RetArr;
}

function increaseClientBalance($ClientID, $Amount)
{
	global $dbCon;
	
	$selQry = 'SELECT balance_total FROM client_balances WHERE client_id = ' . $ClientID . ' AND DATE(balance_date) <= DATE(NOW()) ORDER BY balance_date DESC LIMIT 1';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$oldBalance = $selData['balance_total'];
	$NewAmount = $oldBalance + $Amount;
	
	$updQry = 'INSERT INTO client_balances(client_id, balance_total) VALUES (' . $ClientID . ', ' . $NewAmount . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function decreaseClientBalance($ClientID, $Amount)
{
	global $dbCon;
	
	$selQry = 'SELECT balance_total FROM client_balances WHERE client_id = ' . $ClientID . ' AND DATE(balance_date) <= DATE(NOW()) ORDER BY balance_date DESC LIMIT 1';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	$oldBalance = $selData['balance_total'];
	$NewAmount = $oldBalance - $Amount;
	
	$updQry = 'INSERT INTO client_balances(client_id, balance_total) VALUES (' . $ClientID . ', ' . $NewAmount . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
}

function getClientBalanceForDate($ClientID, $TheDate)
{
	global $dbCon;
	
	$selQry = 'SELECT balance_total FROM client_balances WHERE client_id = ' . $ClientID . ' AND DATE(balance_date) <= DATE("' . $TheDate . '") ORDER BY balance_date DESC LIMIT 1';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData['balance_total'];
}

function getInvoicePaymentsTotal($InvID)
{
	global $dbCon;
	
	$selQry = 'SELECT SUM(amount) AS amount FROM accounts_log WHERE invoice_id = ' . $InvID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData['amount'];
}


function addQuoteItem($SaveArr)
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
	$updQry = 'INSERT INTO quote_items(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	// return mysqli_insert_id($dbCon);
}

function addClientPurchaseOrder($SaveArr)
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
	$updQry = 'INSERT INTO client_purchase_orders(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

function getClientInvoices($ClientID, $StartDate = '', $EndDate = '')
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, inv_number, invoicesubtotal, invoicevattotal, invoicetotal, cittotal, logtime, inv_status, file_path, inv_name FROM client_invoices WHERE client_id = ' . $ClientID;
	if($StartDate != '')
		$selQry .= ' AND DATE(logtime) >= DATE("' . $StartDate . '") ';
	if($EndDate != '')
		$selQry .= ' AND DATE(logtime) <= DATE("' . $EndDate . '") ';
	$selQry .= ' ORDER BY logtime DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['inv_number'] = $selData['inv_number'];
		$RetArr[$selData['id']]['invoicesubtotal'] = $selData['invoicesubtotal'];
		$RetArr[$selData['id']]['invoicevattotal'] = $selData['invoicevattotal'];
		$RetArr[$selData['id']]['invoicetotal'] = $selData['invoicetotal'];
		$RetArr[$selData['id']]['cittotal'] = $selData['cittotal'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['inv_status'] = $selData['inv_status'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
		$RetArr[$selData['id']]['inv_name'] = $selData['inv_name'];
	}
	return $RetArr;
}

function getClientPayments($ClientID, $StartDate = '', $EndDate = '')
{
	global $dbCon;
	
	$selQry = 'SELECT invoice_id, amount, transdate, accounts_log.logtime AS logtime, description FROM accounts_log ';
	$selQry .= 'INNER JOIN client_invoices ON client_invoices.ID = accounts_log.invoice_id AND client_invoices.client_id = ' . $ClientID . ' ';
	if($StartDate != '')
		$selQry .= ' AND DATE(transdate) >= DATE("' . $StartDate . '") ';
	if($EndDate != '')
		$selQry .= ' AND DATE(transdate) <= DATE("' . $EndDate . '") ';
	$selQry .= 'ORDER BY transdate DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['logtime']]['invoice_id'] = $selData['invoice_id'];
		$RetArr[$selData['logtime']]['amount'] = $selData['amount'];
		$RetArr[$selData['logtime']]['transdate'] = $selData['transdate'];
		$RetArr[$selData['logtime']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['logtime']]['description'] = $selData['description'];
	}
	return $RetArr;
}

function getClientStatements($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, statement_number, startdate, enddate, logtime, file_path FROM client_statements ';
	$selQry .= 'ORDER BY logtime DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['statement_number'] = $selData['statement_number'];
		$RetArr[$selData['id']]['startdate'] = $selData['startdate'];
		$RetArr[$selData['id']]['enddate'] = $selData['enddate'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
	}
	return $RetArr;
}

function getClientInvoiceByID($InvoiceID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, inv_number, invoicesubtotal, invoicevattotal, invoicetotal, cittotal, logtime, inv_status, file_path, inv_name FROM client_invoices WHERE id = ' . $InvoiceID;
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$selData = mysqli_fetch_array($selRes);
	return $selData;
}

function getClientQuotes($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, quote_number, quote_subtotal, quote_vattotal, quote_total, logtime, quote_status, file_path, quote_name FROM client_quotes WHERE client_id = ' . $ClientID . ' ORDER BY logtime DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['quote_number'] = $selData['quote_number'];
		$RetArr[$selData['id']]['quote_subtotal'] = $selData['quote_subtotal'];
		$RetArr[$selData['id']]['quote_vattotal'] = $selData['quote_vattotal'];
		$RetArr[$selData['id']]['quote_total'] = $selData['quote_total'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['quote_status'] = $selData['quote_status'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
		$RetArr[$selData['id']]['quote_name'] = $selData['quote_name'];
	}
	return $RetArr;
}

function getClientPurchaseOrders($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, po_number, po_subtotal, po_vattotal, po_total, logtime, po_status, file_path, po_name FROM client_purchase_orders WHERE client_id = ' . $ClientID . ' ORDER BY logtime DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['po_number'] = $selData['po_number'];
		$RetArr[$selData['id']]['po_subtotal'] = $selData['po_subtotal'];
		$RetArr[$selData['id']]['po_vattotal'] = $selData['po_vattotal'];
		$RetArr[$selData['id']]['po_total'] = $selData['po_total'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['po_status'] = $selData['po_status'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
		$RetArr[$selData['id']]['po_name'] = $selData['po_name'];
	}
	return $RetArr;
}

function getPurchaseOrders()
{
	global $dbCon;
	
	$selQry = 'SELECT id, client_id, po_number, po_subtotal, po_vattotal, po_total, logtime, po_status, file_path, po_name FROM client_purchase_orders';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['client_id'] = $selData['client_id'];
		$RetArr[$selData['id']]['po_number'] = $selData['po_number'];
		$RetArr[$selData['id']]['po_subtotal'] = $selData['po_subtotal'];
		$RetArr[$selData['id']]['po_vattotal'] = $selData['po_vattotal'];
		$RetArr[$selData['id']]['po_total'] = $selData['po_total'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['po_status'] = $selData['po_status'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
		$RetArr[$selData['id']]['po_name'] = $selData['po_name'];
	}
	return $RetArr;
}


function getPurchaseOrderUsage($ClientID)
{
	global $dbCon;
	
	$selQry = 'SELECT client_purchase_orders.id AS id, SUM(itemtotal) AS po_total FROM client_purchase_orders ';
	$selQry .= 'INNER JOIN core_splice_joins ON core_splice_joins.po_id = client_purchase_orders.id ';
	$selQry .= 'INNER JOIN invoice_items ON invoice_items.join_id = core_splice_joins.id ';
	$selQry .= 'INNER JOIN client_invoices ON client_invoices.id = invoice_items.invoice_id AND inv_status IN (0,1) ';
	$selQry .= 'WHERE client_purchase_orders.client_id = ' . $ClientID . ' ';
	$selQry .= 'GROUP BY client_purchase_orders.id';
	
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']] = $selData['po_total'];
	}
	return $RetArr;
}

function getExpenses()
{
	global $dbCon;
	
	$selQry = 'SELECT id, supplier_id, expensesubtotal, expensevattotal, expensetotal, logtime, exp_status, file_path, cost_centre_id, transdate, userid, description FROM expenses ORDER BY transdate DESC';
	$selRes = mysqli_query($dbCon, $selQry) or logDBError(mysqli_error($dbCon), $selQry, __FILE__, __FUNCTION__, __LINE__);
	$RetArr = array();
	while($selData = mysqli_fetch_array($selRes))
	{
		$RetArr[$selData['id']]['id'] = $selData['id'];
		$RetArr[$selData['id']]['supplier_id'] = $selData['supplier_id'];
		$RetArr[$selData['id']]['expensesubtotal'] = $selData['expensesubtotal'];
		$RetArr[$selData['id']]['expensevattotal'] = $selData['expensevattotal'];
		$RetArr[$selData['id']]['expensetotal'] = $selData['expensetotal'];
		$RetArr[$selData['id']]['logtime'] = $selData['logtime'];
		$RetArr[$selData['id']]['exp_status'] = $selData['exp_status'];
		$RetArr[$selData['id']]['cost_centre_id'] = $selData['cost_centre_id'];
		$RetArr[$selData['id']]['file_path'] = $selData['file_path'];
		
		$RetArr[$selData['id']]['transdate'] = $selData['transdate'];
		$RetArr[$selData['id']]['userid'] = $selData['userid'];
		$RetArr[$selData['id']]['description'] = $selData['description'];
	}
	return $RetArr;
}

function addExpense($SaveArr)
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
	$updQry = 'INSERT INTO expenses(' . implode(",", $fieldA) . ') VALUES (' . implode(",", $valueA) . ')';
	$updRes = mysqli_query($dbCon, $updQry) or logDBError(mysqli_error($dbCon), $updQry, __FILE__, __FUNCTION__, __LINE__);
	return mysqli_insert_id($dbCon);
}

?>