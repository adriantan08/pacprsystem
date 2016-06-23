<style>
	.supportingDocumentSection td{
		position:relative; left:5%;
	}
	.label{
		font-weight:600;
	}
	input{
		border: 0;
		outline: 0;
		background: transparent;
		border-bottom: 1px solid #a9a9a9;
		
	}
	input:focus{
		outline:none;
	}
	textarea{
		
	}
	
.myTable{
	background-color:white; 
	border-collapse: collapse; 
	width:100%;
}
.myTable tbody tr td{
	font:inherit;
	border-bottom: 0.1em solid #BDBDBD;
	padding:10px;
}

.myTable tr:last-child td{
	border-bottom:0;
}

</style>

<div style="position:relative; top:5%; left:5%; ">
<h3>View Payment Record</h3>
<i>Last Modified: <?=$prDetails['changed_on']?></i><br><br>
<table class="myTable">
	<tr >
		<td colspan=2 align=right>
			<font class="label">Date:</font><input type=text disabled id="prDate" value="<?=$prDetails['pr_date']?>" /> 
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">PR#: </font>
		</td>
		<td>
			<input type=number id="prNum" disabled value="<?=$prDetails['pr_id']?>" />
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Payee: </font>
		</td>
		<td>
			<input type=text id="prPayee" disabled value="<?=$prDetails['payee']?>"/>
			
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Amount: </font>
		</td>
		<td>
			P<?=number_format($prDetails['amount'])?>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Form: </font>
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
			<font class="label">Purpose: </font>
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
			<font class="label">Disb'mnt Class:</font>
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
			<font class="label">Disb'mnt Yield:</font>
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
			<font class="label">P.O./J.O. No.: </font>
		</td>
		<td>
			<?=$prDetails['po_jo_no']?>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Receiving Report No.: </font>
		</td>
		<td>
			<?=$prDetails['rr_no']?>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Invoice No.:</font>
		</td>
		<td>
			<span>
				<?=$prDetails['inv_no']?>
				<!--&nbsp&nbsp WFR No.
				<input type=text id="prWfrNo"/>-->
			</span>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Others:</font>
		</td>
		<td>
			<?=$prDetails['others']?>
		</td>
	</tr>
	<tr>
		<td valign=top>
			<font class="label">Details:</font>
		</td>
		<td>
			<textarea disabled style="text-align:left;" id="prDetails" rows=10 cols=40><?=$prDetails['details']?></textarea>
		</td>
	</tr>
	

</table>
</div><br/><br/>

<script>
	$( "#prDate").datepicker("setDate", new Date());
</script>