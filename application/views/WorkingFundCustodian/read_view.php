<style>
	.supportingDocumentSection td{
		position:relative; left:5%;
	}
	.label{
		font-weight:600;
	}
	.input-edit{
		border: 0;
		outline: 0;
		background: transparent;
		border-bottom: 1px solid #a9a9a9;
	}
	.input-read{
		border: 0;
		outline: 0;
		background: transparent;
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

<div style="position:relative; top:5%; left:25%; width:40%;"><br>
<table>
<tr>
<td>
	<font style="font-size:15px;"><b>View Payment Record</b></font><br>
	<br><i>Last Modified: <?=$prDetails['changed_on']?></i><br><br>
</td>

<td>
	<span>
		<button style="position:relative; left:10px;" class="flatbutton" id="editButton">Edit</button>
		<span id="finishEditDiv" style="visibility:hidden;">
		<button style="position:relative; left:20px; background-color:green;" class="flatbutton" id="draft" name="submitButton">Draft</button>
		<button style="position:relative; left:20px; background-color:green;" class="flatbutton" id="submit" name="submitButton">Submit for Approval</button>
		</span>
	</span>
	
</td>
</tr>
</table><br>

<table class="myTable">
	<tr >
		<td colspan=2 align=right>
			<font class="label">Date:</font>
			<input class="input-read" name="editable" type=text disabled id="prDate" value="<?=$prDetails['pr_date']?>" /> 
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">PR#: </font>
		</td>
		<td>
			<input type=number min="0" id="prNum" name="editable" class="input-read" disabled value="<?=$prDetails['pr_id']?>" />
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Payee: </font>
		</td>
		<td>
			<input type=text id="prPayee" name="editable" class="input-read" disabled value="<?=$prDetails['payee']?>"/>
			
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Amount: </font>
		</td>
		<td>
			<div id="amountPlaceholderRead">P <?=number_format($prDetails['amount'])?></div>
			<div id="amountPlaceholderEdit" style="display:none;" >P <input type=number id="prAmount" min="0"  name="editable" class="input-read" disabled value="<?=$prDetails['amount']?>"/></div>
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
			<input type=text id="prPoJoNo" name="editable" class="input-read" disabled value ="<?=$prDetails['po_jo_no']?>"/>
			
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Receiving Report No.: </font>
		</td>
		<td>
			<input type=text id="prRcvReportNo" name="editable" class="input-read" disabled value="<?=$prDetails['rr_no']?>"/>
			
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Invoice No.:</font>
		</td>
		<td>
			<span>
				<input type=text id="prInvoiceNo" name="editable" class="input-read" disabled value="<?=$prDetails['inv_no']?>"/>
				
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
			<input type=text id="prOthers" name="editable" class="input-read" disabled value="<?=$prDetails['others']?>"/>
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
<script src="<?=base_url()?>js/create_pr.js"></script>
<script src="<?=base_url()?>js/form_validator.js"></script>
<script>
	$( "#prDate").datepicker("setDate", new Date());
	
	//Once edit has been clicked, we make the fields editable
	$("#editButton").click(function(){
		var nodes = document.getElementsByName("editable");
		
		for(var i=0; i<nodes.length; i++){
			/*	a WORKAROUND to enable support for comma's in amount. 1 div to show text, and 1 div to show 
				input element with number format already
			*/
			if(nodes[i].id =='prAmount'){
				document.getElementById('amountPlaceholderRead').style.display = 'none';
				document.getElementById('amountPlaceholderEdit').style.display = 'block';
			}
			nodes[i].className = "input-edit";
			nodes[i].disabled = false;
		}
		var nodes = document.getElementsByName("prForm");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prPurpose");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prDisbClass");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		var nodes = document.getElementsByName("prDisbYield");
		for(var i=0; i < nodes.length; i++)
			nodes[i].disabled=false;
		
		document.getElementById('prDetails').disabled = false;
		document.getElementById('finishEditDiv').style.visibility = 'visible';
		swal("You may now start editing!","","info");
	});
	
	
	$("button[name='submitButton']").click(function(){
		var action = null;
		
		if($(this).attr('id') == 'draft')
			action = <?=DRAFT_STATUS?>;
		else if($(this).attr('id') == 'submit')
			action = <?=SUBMITTED_STATUS?>;
			
		var check = runValidation();
		publishPr("<?=base_url()?>", action, 'update');
		/* temporarily TURNED  OFF validation
		if(!check){
			publishPr("<?=base_url()?>");
		}
		
		else{
			swal("Data Validation Failed!","Please review the fields highlighted in red.", "error");
		}
		*/
	});
	
</script>