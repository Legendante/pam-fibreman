<?php
session_start();
include_once("db.inc.php");

$FromAcc = pebkac($_POST['frmAcc']);
$SupplierID = pebkac($_POST['expSupp']);
$CostCentre = pebkac($_POST['expCostC']);
$SubTotal = pebkac($_POST['expSub'], 10, 'STRING');
$VATTotal = pebkac($_POST['expVAT'], 10, 'STRING');
$AllTotal = pebkac($_POST['expTotal'], 10, 'STRING');
$ExpDate = pebkac($_POST['expDate'], 10, 'STRING');
$ExpDesc = pebkac($_POST['expDesc'], 255, 'STRING');
$UplFileName = pebkac($_FILES['exp_file']['name'], 255, 'STRING');
$SaveArr = array();
$SaveArr['userid'] = $_SESSION['userid'];
$SaveArr['supplier_id'] = $SupplierID;
$SaveArr['cost_centre_id'] = $CostCentre;
$SaveArr['transdate'] = $ExpDate;
$SaveArr['expensesubtotal'] = $SubTotal;
$SaveArr['expensevattotal'] = $VATTotal;
$SaveArr['expensetotal'] = $AllTotal;
$SaveArr['description'] = $ExpDesc;
if($UplFileName == '')
{
	$ExpenseID = addExpense($SaveArr);
	doAccountTransfer($FromAcc, $AllTotal, $ExpDate, $ExpDesc, $_SESSION['userid'], '', '', $ExpenseID);
}
else
{
	// Expense sub directory by date
	$SavePath = 'uploads/accounting/expenses/' . date("Ymd");
	$FileName = date("d_m_y_His") . "_" . $UplFileName;
	$FileName = cleanFileName($FileName);
	if(!file_exists($SavePath))
	{
		if(!mkdir($SavePath))
		{
			logDBError("Failed to create expense directory", $SavePath, __FILE__, __FUNCTION__, __LINE__);
			return FALSE;
		}
		else
			file_put_contents($SavePath . "/index.html", "");
	}
	if(move_uploaded_file($_FILES['exp_file']['tmp_name'], $SavePath . "/" . $FileName))
	{
		$SaveArr['file_path'] = $SavePath . "/" . $FileName;
		$ExpenseID = addExpense($SaveArr);
		doAccountTransfer($FromAcc, $AllTotal, $ExpDate, $ExpDesc, $_SESSION['userid'], '', '', $ExpenseID);
	}
}

header("Location: expenses.php");
?>