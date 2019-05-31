<?
session_start();
include("db.inc.php");
$ClientID = (isset($_POST['cid'])) ? pebkac($_POST['cid']) : 0;
$SavePath = 'uploads/accounting/purchase_orders';
$UplFileName = pebkac($_FILES['po_file']['name'], 100, 'STRING');
$FileName = $ClientID . "_" . date("d_m_y") . "_" . $UplFileName;
$FileName = cleanFileName($FileName);

if(move_uploaded_file($_FILES['po_file']['tmp_name'], $SavePath . "/" . $FileName))
{	
	$SaveArr = array();
	$SaveArr['client_id'] = $ClientID;
	$SaveArr['po_number'] = pebkac($_POST['po_number'], 10, 'STRING');
	$SaveArr['po_subtotal'] = pebkac($_POST['po_subtotal'], 10, 'STRING');
	$SaveArr['po_vattotal'] = pebkac($_POST['po_vattotal'], 10, 'STRING');
	$SaveArr['po_total'] = pebkac($_POST['po_total'], 10, 'STRING');
	$SaveArr['po_name'] = pebkac($_POST['po_name'], 100, 'STRING');
	$SaveArr['file_path'] = $SavePath . "/" . $FileName;
	addClientPurchaseOrder($SaveArr);
}
// exit();
header("Location: editclient.php?cid=" . $ClientID);
?>