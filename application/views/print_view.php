<style type="text/css">
	.supportingDocumentSection td{
		position:relative; left:5%;
	
		word-break:break-all;
		max-width:300px;
	
	}
	.mylabel{
		font-weight:600;
	}
	
	textarea{
		
	}
	
.myTable{
	background-color:white; 
	border-collapse: collapse; 
	width:100%;
}
.myTable tbody tr td{
	font-size:10px;
	font-family:Arial;
	border-bottom: 0.1em solid #BDBDBD;
	padding:10px;
}

.myTable tr:last-child td{
	border-bottom:0;
}

.pagebreak { 
	page-break-before:always; 
}

</style>
<body oncontextmenu="return false;">
<div style="position:relative; top:1%; left:1%;"><br>
<table>
<?php
$ctr=0;
$separateRow = 2;

foreach($prList as $prDetails){
	if($ctr == 0)
		echo '<tr>';
	else if($ctr % $separateRow == 0)
		echo '</tr><tr>';
	
	$ctr++;
	
?>

<td style="padding-left:5%; width:600px;">

	<table>
	<tr>
	<td valign=top>
		<table>
		<tr>
		<td>
			<font style="font-size:15px; font-family:Arial;"><b>PR# <?=$prDetails['pr_id']?></b></font>
			<br><font style="font-size:13px; font-family:Arial;">Last Modified: <?=$prDetails['changed_on']?></font><br><br>
		</td>

		</tr>
		</table>
	<table class="myTable" >
		<tr >
			<td colspan=2 align=right>
				<font class="mylabel">Date:</font>
				<?=$prDetails['pr_date']?>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">PR#: </font>
			</td>
			<td>
				<?=$prDetails['pr_id']?>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Payee: </font>
			</td>
			<td>
				<?=$prDetails['payee']?>
				
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Amount: </font>
			</td>
			<td>
				<div id="amountPlaceholderRead">P <?=number_format($prDetails['amount'])?></div>
				
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Form: </font>
			</td>
			<td>
				<span>
				<input type="radio" name="prForm" value="cash" disabled
				<?php if($prDetails['payment_form']=='cash') echo 'checked';?>/> Cash
				
				<input type="radio" name="prForm" value="check" disabled
				<?php if($prDetails['payment_form']=='check') echo 'checked';?>/> Check
				
				<input type="radio" name="prForm" value="none" disabled
				<?php if($prDetails['payment_form']=='none') echo 'checked';?>/> None
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Purpose: </font>
			</td>
			<td>
				<span>
				<input type="radio" name="prPurpose" value="disbursement" disabled
				<?php if($prDetails['purpose']=='disbursement') echo 'checked';?>/> Disbursement
				<input type="radio" name="prPurpose" value="liquidation" disabled
				<?php if($prDetails['purpose']=='liquidation') echo 'checked';?>/> Liquidation
				<input type="radio" name="prPurpose" value="recordonly" disabled
				<?php if($prDetails['purpose']=='recordonly') echo 'checked';?>/> Record Only
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Disb'mnt Class:</font>
			</td>
			<td>
				<span>
				<input type="radio" name="prDisbClass" value="spent" disabled
				<?php if($prDetails['dist_class']=='spent') echo 'checked';?>/> Spent
				<input type="radio" name="prDisbClass" value="unspent" disabled
				<?php if($prDetails['dist_class']=='unspent') echo 'checked';?>/> Unspent
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Disb'mnt Yield:</font>
			</td>
			<td>
				<span>
				<input type="radio" name="prDisbYield" value="consumable" disabled
				<?php if($prDetails['dist_yield']=='consumable') echo 'checked';?>/> Consumable
				<input type="radio" name="prDisbYield" value="asset" disabled
				<?php if($prDetails['dist_yield']=='asset') echo 'checked';?>/> Asset
				</span>
			</td>
		</tr>
		<tr><td colspan=2><b>Supporting Documents</b></td></tr>
		
		<tr>
			<td>
				<font class="mylabel">P.O./J.O. No.: </font>
			</td>
			<td>
				<?=$prDetails['po_jo_no']?>
				
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Receiving Report No.: </font>
			</td>
			<td>
				<?=$prDetails['rr_no']?>
				
			</td>
		</tr>
		<tr class="supportingDocumentSection">
			<td>
				<font class="mylabel">Invoice No.:</font>
			</td>
			<td>
				<span>
					<?=$prDetails['inv_no']?>
					
				</span>
			</td>
		</tr>
		<tr class="supportingDocumentSection">
			<td>
				<font class="mylabel">Others:</font>
			</td>
			<td>
				<?=$prDetails['others']?>
			</td>
		</tr>
		<tr class="supportingDocumentSection">
			<td>
				<font class="mylabel">Expenditure Code:</font>
			</td>
			<td>
				<?=str_replace('|','<br>',$prDetails['exp_code'])?>
			</td>
		</tr>
		<tr>
			<td valign=top>
				<font class="mylabel">Details:</font>
			</td>
			<td>
				<?=$prDetails['details']?>
			</td>
		</tr>
		

	</table>
	</td>
	</tr></table>
<br/>
<?php
	//Forces page break. We added an if condition to stop forcing a page break when we are on final page.
	//Final page means it's on last row and rows are cut for every $separateRow value, thus $ctr+$separateRow
	if($ctr+$separateRow<= count($prList))
		echo '<div class="pagebreak"></div>';
?>
</td>
<?php 

}
?>	
</table>
</body>