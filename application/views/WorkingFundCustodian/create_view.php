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
</style>

<div style="position:relative; top:5%; left:5%; width:40%;">
<h3>Create a Payment Record</h3>
<table  style="width:100%;" cellspacing=20px >
	<tr >
		<td colspan=2 align=right>
			<font class="label">Date:</font> <input type=text id="prDate"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">PR#: </font>
		</td>
		<td>
			<input type=number id="prNum"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Payee: </font>
		</td>
		<td>
			<input type=text id="prPayee"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Amount: </font>
		</td>
		<td>
			P<input type=number id="prAmount"/>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Form: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prForm" value="cash"/> Cash
			<input type="radio" name="prForm" value="check"/> Check
			<input type="radio" name="prForm" value="none"/> None
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Purpose: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prPurpose" value="disbursement"/> Disbursement
			<input type="radio" name="prPurpose" value="liquidation"/> Liquidation
			<input type="radio" name="prPurpose" value="recordonly"/> Record Only
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Disb'mnt Class:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbClass" value="spent"/> Spent
			<input type="radio" name="prDisbClass" value="unspent"/> Unspent
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Disb'mnt Yield:</font>
		</td>
		<td>
			<span>
			<input type="radio" name="prDisbYield" value="consumable"/> Consumable
			<input type="radio" name="prDisbYield" value="asset"/> Asset
			</span>
		</td>
	</tr>
	<tr><td colspan=2><b>Supporting Documents:</b></td></tr>
	
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">P.O./J.O. No.:</font>
		</td>
		<td>
			<input type=text id="prPoJoNo"/>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Receiving Report No.:</font>
		</td>
		<td>
			<input type=text id="prRcvReportNo"/>
		</td>
	</tr>
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Invoice No.:</font>
		</td>
		<td>
			<span>
				<input type=text id="prInvoiceNo"/>
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
			<input type=text id="prOthers"/>
		</td>
	</tr>
	<tr>
		<td valign=top>
			<font class="label">Details:</font>
		</td>
		<td>
			<textarea id="prDetails" rows=10 cols=40></textarea>
		</td>
	</tr>
	
	<tr>
		<td colspan=2 align=center>
			<button style="background-color:green" class="flatbutton" name="submitButtom" id="draft">Draft</button>
			<button style="background-color:green" class="flatbutton" name="submitButtom" id="submit">Submit for Approval</button>
			<button style="width:100px;" class="flatbutton" id="cancel">Cancel</button>
		</td>
	</tr>
</table>
</div><br/><br/>
<script src="<?=base_url()?>js/create_pr.js"></script>
<script src="<?=base_url()?>js/form_validator.js"></script>
<script>
	
	$( "#prDate").datepicker("setDate", new Date());
	$( "#prDate").datepicker({ dateFormat: 'yy/mm/dd'});
	
	$("button[name='submitButtom']").click(function(){
		var action = null;
		if($(this).attr('id') == 'draft')
			action = 0;
		else if($(this).attr('id') == 'submit')
			action = 1;
			
		var check = runValidation();
		publishPr("<?=base_url()?>", action,'create');
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
