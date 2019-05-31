<?php
include_once("db.inc.php");
include("header.inc.php");
$ClientID = (isset($_GET['cid'])) ? pebkac($_GET['cid']) : 0;
$Client = getClientByID($ClientID);
$Invoices = getClientInvoices($ClientID);
$Quotes = getClientQuotes($ClientID);
$POrders = getClientPurchaseOrders($ClientID);
$POUsage = getPurchaseOrderUsage($ClientID);
$Statements = getClientStatements($ClientID);
$OpenBalance = getClientBalanceForDate($ClientID, date("Y-m-d"));
$Accounts = getAccounts();
$InvStatusses = array(0 => 'Invoiced', 1 => 'Paid In full', 2 => 'Partially Paid', 99 => 'Cancelled');
?>
<script>
$(document).ready(function()
{
	$("#payForm").validationEngine();
	$("#StateFrm").validationEngine();
	$('#pay_date').datepicker({"dateFormat": "yy-mm-dd"});
	$('#state_start').datepicker({"dateFormat": "yy-mm-dd"});
	$('#state_end').datepicker({"dateFormat": "yy-mm-dd"});
});

function invoicePayment(InvID)
{
	$('#pay_iid').val(InvID);
	$('#payment-modal').modal("show");
}

function calcVatTotal()
{
	var SubT = $('#po_subtotal').val();
	var Tot = SubT * <?php echo VATCALC; ?>;
	var Vat = Tot - SubT;
	$('#po_vattotal').val(Vat.toFixed(2));
	$('#po_total').val(Tot.toFixed(2));
}
</script>

<ul class='nav nav-tabs'>
	<li class='nav-item'><a href='#Proj_1' data-toggle='tab' class='nav-link active'>Client Details</a></li>
	<li class='nav-item'><a href='#Proj_2' data-toggle='tab' class='nav-link'>Quotes</a></li>
	<li class='nav-item'><a href='#Proj_3' data-toggle='tab' class='nav-link'>Purchase Orders</a></li>
	<li class='nav-item'><a href='#Proj_4' data-toggle='tab' class='nav-link'>Invoices</a></li>
	<li class='nav-item'><a href='#Proj_5' data-toggle='tab' class='nav-link'>Statements</a></li>
	<li class='nav-item'><a href='#Proj_6' data-toggle='tab' class='nav-link'>Users</a></li>
</ul>
<div class='tab-content'>
	<div class='tab-pane active' id='Proj_1'>
		<form method='POST' action='saveClient.php' id='staffFrm'>
		<input type='hidden' name='cid' value='<?php echo $ClientID; ?>'>
		<table class='table table-bordered table-condensed'>
			<tr><th>ID</th><td><?php echo $ClientID; ?></td><td>Balance: R <?php echo $OpenBalance; ?></td>
			<td><div class="btn-group">
				<!-- <a href='oldAddQuote.php?cid=<?php echo $ClientID; ?>' class='btn btn-outline-danger btn-sm'>OLD Quote</a> -->
				<a href='addQuote.php?cid=<?php echo $ClientID; ?>' class='btn btn-outline-secondary btn-sm'>Quote</a>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#po-modal'>Upload PO</button>
				<!-- <a href='oldAddInvoice.php?cid=<?php echo $ClientID; ?>' class='btn btn-outline-danger btn-sm'>OLD Invoice</a> -->
				<a href='addInvoice.php?cid=<?php echo $ClientID; ?>' class='btn btn-outline-secondary btn-sm'>Invoice</a>
				<a href='projectionInvoice.php?cid=<?php echo $ClientID; ?>' class='btn btn-outline-secondary btn-sm'>Invoice Projection</a>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#statement-modal'>Statement</a>
			</div>
			</td></tr>
			<tr><th>Name</th><td><input type='text' name='clientname' id='clientname' value='<?php echo $Client['clientname']; ?>' maxlength='50' class='form-control form-control-sm'></td>
				<th>Short name</th><td><input type='text' name='client_short' id='client_short' value='<?php echo $Client['client_short']; ?>' maxlength='10' class='form-control form-control-sm'></td></tr>
				
			<tr><th>Reg Num</th><td><input type='text' name='client_reg' id='client_reg' value='<?php echo $Client['client_reg']; ?>' maxlength='20' class='form-control form-control-sm'></td>
			<th>Vat Num</th><td><input type='text' name='client_vat' id='client_vat' value='<?php echo $Client['client_vat']; ?>' maxlength='20' class='form-control form-control-sm'></td></tr>
			
			<tr><th>Tel Num</th><td><input type='text' name='client_tel' id='client_tel' value='<?php echo $Client['client_tel']; ?>' maxlength='30' class='form-control form-control-sm'></td>
			<th>Email</th><td><input type='text' name='client_email' id='client_email' value='<?php echo $Client['client_email']; ?>' maxlength='100' class='form-control form-control-sm'></td></tr>
			
			<tr><th>Address</th><td colspan='3'><input type='text' name='client_address' id='client_address' value='<?php echo $Client['client_address']; ?>' maxlength='200' class='form-control form-control-sm'></td></tr>
			<tr><td colspan='4'><button type='submit' class='btn btn-outline-success btn-sm float-right'><i class='fa fa-save'></i> Save</button></td></tr>
		</table>
		</form>
	</div>
	<div class='tab-pane' id='Proj_2'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>Inv #</th><th>Value</th><th>Total</th><th>Name</th> <!-- <th>VAT</th><th>Total</th>--> <th>Date</th><th>Status</th><th>&nbsp;</th></tr>
<?php
foreach($Quotes AS $QuoteID => $QuoteRec)
{
	if($QuoteRec['quote_status'] != 99)
	{
		echo "<tr>";
		echo "<td>" . $QuoteID . "</td>";
		echo "<td>" . $QuoteRec['quote_number'] . "</td>";
		echo "<td>" . $QuoteRec['quote_subtotal'] . "</td>";
		echo "<td>" . $QuoteRec['quote_name'] . "</td>";
		// echo "<td>" . $QuoteRec['quote_vattotal'] . "</td>";
		echo "<td>" . $QuoteRec['quote_total'] . "</td>";
		echo "<td>" . $QuoteRec['logtime'] . "</td>";
		echo "<td>" . $QuoteRec['quote_status'] . "</td>";
		echo "<td><a href='changeQuoteStatus.php?c=" . $ClientID . "&q=" . $QuoteID . "&s=1'><i class='fa fa-times'></i></a></td>";
		echo "<td><a href='" . $QuoteRec['file_path'] . "' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
		echo "</tr>";
	}
}
?>
		</table>
	</div>
	<div class='tab-pane' id='Proj_3'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>PO #</th><th>Value</th><th>Total</th><th>Name</th> <!--<th>VAT</th> --> <th>Date</th><th>Invoiced</th><th>Remaining</th><th>&nbsp;</th></tr>
<?php
foreach($POrders AS $PO_ID => $QuoteRec)
{
	$PO_Used = "-";
	if(isset($POUsage[$PO_ID]))
		$PO_Used = $POUsage[$PO_ID] * VATCALC;
	echo "<tr>";
	echo "<td>" . $PO_ID . "</td>";
	echo "<td>" . $QuoteRec['po_number'] . "</td>";
	echo "<td>" . sprintf("R %0.2f", $QuoteRec['po_subtotal']) . "</td>";
	echo "<td>" . sprintf("R %0.2f", $QuoteRec['po_total']) . "</td>";
	echo "<td>" . $QuoteRec['po_name'] . "</td>";
	// echo "<td>" . sprintf("R %0.2f", $QuoteRec['po_vattotal']) . "</td>";
	
	echo "<td>" . $QuoteRec['logtime'] . "</td>";
	echo "<td>" . sprintf("R %0.2f", $PO_Used) . "</td>";
	echo "<td>" . sprintf("R %0.2f", $QuoteRec['po_total'] - $PO_Used) . "</td>";
	echo "<td><a href='" . $QuoteRec['file_path'] . "' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
	<div class='tab-pane' id='Proj_4'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>Inv #</th><th>Value</th><th>Total</th><th>Name</th> <!-- <th>VAT</th><th>CIT</th> --> <th>Date</th><th>Paid</th><th>Status</th><th colspan='3'>&nbsp;</th></tr>
<?php
$InvTotals = array("sub" => 0, "vat" => 0, "tot" => 0, "cit" => 0);
foreach($Invoices AS $InvID => $InvRec)
{
	$Paid = getInvoicePaymentsTotal($InvID);
	echo "<tr>";
	echo "<td>" . $InvID . "</td>";
	echo "<td>" . $InvRec['inv_number'] . "</td>";
	echo "<td>" . sprintf("R %0.2f", $InvRec['invoicesubtotal']) . "</td>";
	echo "<td>" . sprintf("R %0.2f", $InvRec['invoicetotal']) . "</td>";
	echo "<td>" . $InvRec['inv_name'] . "</td>";
	// echo "<td>" . sprintf("R %0.2f", $InvRec['invoicevattotal']) . "</td>";
	
	// echo "<td>" . sprintf("R %0.2f", $InvRec['cittotal']) . "</td>";
	echo "<td>" . $InvRec['logtime'] . "</td>";
	if($InvRec['inv_status'] == 2)
		echo "<td title='" . sprintf("R %0.2f", ($InvRec['invoicetotal'] - $Paid)) . " outstanding'>" . sprintf("R %0.2f", $Paid) . "</td>";
	else
		echo "<td>" . sprintf("R %0.2f", $Paid) . "</td>";
	echo "<td>" . $InvStatusses[$InvRec['inv_status']] . "</td>";
	if($InvRec['inv_status'] == 0)
		echo "<td><a href='cancelInvoice.php?c=" . $ClientID . "&i=" . $InvID . "' class='text-danger' title='Cancel Invoice'><i class='fa fa-times'></i></a></td>";
	else
		echo "<td>-</td>";
	
	if(($InvRec['inv_status'] == 0) || ($InvRec['inv_status'] == 2))
	{
		echo "<td><button type='button' onclick='invoicePayment(" . $InvID . ");' class='text-success' title='Invoice Payment'><i class='fa fa-dollar'></i></button></td>";
		$InvTotals['sub'] += $InvRec['invoicesubtotal'];
		$InvTotals['vat'] += $InvRec['invoicevattotal'];
		$InvTotals['tot'] += $InvRec['invoicetotal'];
		$InvTotals['cit'] += $InvRec['cittotal'];
	}
	else
		echo "<td>-</td>";
	echo "<td><a href='" . $InvRec['file_path'] . "' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
	echo "</tr>";
}
	echo "<tr><th colspan='2'>Totals</th><td>" . sprintf("R %0.2f", $InvTotals['sub']) . "</td><td>" . sprintf("R %0.2f", $InvTotals['vat']) . "</td>";
	echo "<td>" . sprintf("R %0.2f", $InvTotals['tot']) . "</td><td>" . sprintf("R %0.2f", $InvTotals['cit']) . "</td><td colspan='4'>&nbsp;</td></tr>";
?>
		</table>
	</div>
	<div class='tab-pane' id='Proj_5'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>Statement #</th><th>Date</th><th>State Start</th><th>State End</th><th colspan='3'>&nbsp;</th></tr>
<?php
$InvTotals = array("sub" => 0, "vat" => 0, "tot" => 0, "cit" => 0);
foreach($Statements AS $StatementID => $InvRec)
{
	$Paid = getInvoicePaymentsTotal($InvID);
	echo "<tr>";
	echo "<td>" . $StatementID . "</td>";
	echo "<td>" . $InvRec['statement_number'] . "</td>";
	echo "<td>" . $InvRec['logtime'] . "</td>";
	echo "<td>" . $InvRec['startdate'] . "</td>";
	echo "<td>" . $InvRec['enddate'] . "</td>";
	echo "<td><a href='" . $InvRec['file_path'] . "' target='_blank'><i class='fa fa-file-pdf-o'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
	<div class='tab-pane' id='Proj_6'>
		<table class='table table-bordered table-condensed'>
		<tr><th>ID</th><th>Name</th><th>Username</th><th>Cell</th><th>Tel</th><th>Last Login</th>
		<th><a href='editClientUser.php?c=<?php echo $ClientID; ?>' class='btn btn-sm btn-outline-primary' title='Add Client User'><i class='fa fa-plus'></i></a></th></tr>
<?php
$ClUsers = getAllClientUsers($ClientID);
foreach($ClUsers AS $UserID => $UsrRec)
{
	echo "<tr>";
	echo "<td>" . $UserID . "</td>";
	echo "<td>" . $UsrRec['firstname'] . " " . $UsrRec['surname'] . "</td>";
	echo "<td>" . $UsrRec['username'] . "</td>";
	echo "<td>" . $UsrRec['cellnumber'] . "</td>";
	echo "<td>" . $UsrRec['telnumber'] . "</td>";
	echo "<td>" . $UsrRec['lastlogin'] . "</td>";
	echo "<td><a href='editClientUser.php?c=" . $ClientID . "&u=" . $UserID . "' class='btn btn-sm btn-outline-primary' title='Edit User'><i class='fa fa-pencil'></i></a></td>";
	echo "</tr>";
}
?>
		</table>
	</div>
	
</div>

<div class='modal fade' id='payment-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<form method='POST' action='invoicePayment.php' id='payForm' enctype="multipart/form-data">
			<input type='hidden' name='pay_cid' value='<?php echo $ClientID; ?>'>
			<input type='hidden' name='pay_iid' id='pay_iid' value=''>
			<div class='modal-header'><strong>Load Invoice Payment<a href="#" class="close" data-dismiss="modal">&times;</a></strong></div>
			<div class='modal-body'>
				<div class='table'>
					<table class='table table-bordered'>
					<tr><th>To Account</th><td><select name='payAcc' class='validate[required] form-control form-control-sm'>
<option value=''>-- Select TO account --</option>
<?php
foreach($Accounts AS $AccID => $AccRec)
{
	echo "<option value='" . $AccID . "'>" . $AccRec['accountname'] . "</option>";
}
?>
</select></td></tr>
					<tr><th>Payment Total</th><td><input type='text' name='pay_total' id='pay_total' class='validate[required] form-control form-control-sm'></td></tr>
					<tr><th>Payment Date</th><td><input type='text' name='pay_date' id='pay_date' class='validate[required] form-control form-control-sm'></td></tr>
					<tr><th>Description</th><td><input type='text' name='pay_desc' id='pay_desc' value='Inv Payment' class='validate[required] form-control form-control-sm'></td></tr>
					</table>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm float-right'><i class='fa fa-save'></i> Save</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class='modal fade' id='po-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<form method='POST' action='saveClientPO.php' id='POFrm' enctype="multipart/form-data">
			<input type='hidden' name='cid' value='<?php echo $ClientID; ?>'>
			<div class='modal-header'><strong>Load Purchase Order<a href="#" class="close" data-dismiss="modal">&times;</a></strong></div>
			<div class='modal-body'>
				<div class='table'>
					<table class='table table-bordered'>
					<tr><th>Purchase Order Name</th><td><input type='text' name='po_name' id='po_name' value='' class='form-control form-control-sm'></td></tr>
					<tr><th>Purchase Order #</th><td><input type='text' name='po_number' id='po_number' class='form-control form-control-sm'></td></tr>
					<tr><th>Sub Total</th><td><input type='text' name='po_subtotal' id='po_subtotal' class='form-control form-control-sm' onchange='calcVatTotal();'></td></tr>
					<tr><th>VAT</th><td><input type='text' name='po_vattotal' id='po_vattotal' class='form-control form-control-sm'></td></tr>
					<tr><th>Total</th><td><input type='text' name='po_total' id='po_total' class='form-control form-control-sm'></td></tr>
					<tr><th>File</th><td><input type='file' name='po_file' id='po_file' class='form-control form-control-sm'></td></tr>
					</table>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success float-right'><i class='fa fa-save'></i> Save</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class='modal fade' id='statement-modal' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<form method='POST' action='genStatement.php' id='StateFrm' enctype="multipart/form-data">
			<input type='hidden' name='state_cid' value='<?php echo $ClientID; ?>'>
			<div class='modal-header'><strong>Generate statement<a href="#" class="close" data-dismiss="modal">&times;</a></strong></div>
			<div class='modal-body'>
				<div class='table'>
					<table class='table table-bordered'>
					<tr><th>Start Date</th><td><input type='text' name='state_start' id='state_start' class='validate[required] form-control form-control-sm'></td></tr>
					<tr><th>End Date</th><td><input type='text' name='state_end' id='state_end' class='validate[required] form-control form-control-sm'></td></tr>
					</table>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><span class='fa fa-times'></span> Close</button>
				<button type='submit' class='btn btn-outline-success btn-sm float-right'><i class='fa fa-save'></i> Generate</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php
include("footer.inc.php");
?>