<style type="text/css">
.form-style-1 {
    margin:10px auto;
    max-width: 400px;
    padding: 20px 12px 10px 20px;
    font: 12px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}
.form-style-1 label{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
.form-style-1 input[type=text],
.form-style-1 input[type=date],
.form-style-1 input[type=datetime],
.form-style-1 input[type=number],
.form-style-1 input[type=search],
.form-style-1 input[type=time],
.form-style-1 input[type=url],
.form-style-1 input[type=email],
textarea,
select{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border:1px solid #BEBEBE;
    padding: 7px;
    margin:0px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;
}
.form-style-1 input[type=text]:focus,
.form-style-1 input[type=date]:focus,
.form-style-1 input[type=datetime]:focus,
.form-style-1 input[type=number]:focus,
.form-style-1 input[type=search]:focus,
.form-style-1 input[type=time]:focus,
.form-style-1 input[type=url]:focus,
.form-style-1 input[type=email]:focus,
.form-style-1 textarea:focus,
.form-style-1 select:focus{
    -moz-box-shadow: 0 0 8px #88D5E9;
    -webkit-box-shadow: 0 0 8px #88D5E9;
    box-shadow: 0 0 8px #88D5E9;
    border: 1px solid #88D5E9;
}
.form-style-1 .field-divided{
    width: 49%;
}

.form-style-1 .field-long{
    width: 100%;
		height: 80%;
}
.form-style-1 .field-select{
    width: 100%;
}
.form-style-1 .field-textarea{
    height: 100px;
}
.form-style-1 input[type=submit], .form-style-1 input[type=button]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
.form-style-1 input[type=submit]:hover, .form-style-1 input[type=button]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
.form-style-1 .required{
    color:red;
}
</style>

<<<<<<< HEAD
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
			<input type=number id="prNum" min="0"/>
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
			P<input type=number id="prAmount" min="0"/>
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
=======
<div class="align:left">
<ul class="form-style-1">
    <li><label>PR Date <span class="required">*</span></label>
    <input type="text" id="prDate" name="field1" class="field-divided"/>
    </li>
    <li>
        <label>PR # <span class="required">*</span></label>
        <input type="number" id="prNum" name="field2" class="field-long" />
    </li>
    <li>
        <label>Payee <span class="required">*</span></label>
        <input type="text" id="prPayee" name="field3" class="field-long" />
    </li>
    <li>
        <label>Amount <span class="required">*</span></label>
        <input type="number" id="prAmount" name="field4" class="field-long" />
    </li>
    <li>
        <label>Form: <span class="required">*</span></label>
        <span>
  			<input type="radio" name="prForm" value="cash"/> Cash
  			<input type="radio" name="prForm" value="check"/> Check
  			<input type="radio" name="prForm" value="none"/> None
  			</span>
    </li>
    <li>
        <label>Purpose: <span class="required">*</span></label>
        <span>
  			<input type="radio" name="prPurpose" value="disbursement"/> Disbursement
  			<input type="radio" name="prPurpose" value="liquidation"/> Liquidation
  			<input type="radio" name="prPurpose" value="recordonly"/> Record Only
  			</span>
    </li>
    <li>
        <label>Disbursement Class: <span class="required">*</span></label>
        <span>
  			<input type="radio" name="prDisbClass" value="spent"/> Spent
  			<input type="radio" name="prDisbClass" value="unspent"/> Unspent
  			</span>
    </li>
    <li>
        <label>Disbursement Yield: <span class="required">*</span></label>
        <span>
  			<input type="radio" name="prDisbYield" value="consumable"/> Consumable
  			<input type="radio" name="prDisbYield" value="asset"/> Asset
  			</span>
    </li>
    <li>
        <label>Supporting Documents: </label>
    </li>
    <li>
        <label>Receiving Report No.: </label>
        <input type=text id="prRcvReportNo"/>
    </li>
    <li>
        <label>Invoice No.: </label>
        <input type=text id="prInvoiceNo"/>
    </li>
    <li>
        <label>Others: </label>
        <input type=text id="prOthers"/>
    </li>
    <li>
        <label>Details: </label>
        <textarea id="prDetails" rows=10 cols=40 class="field-textarea"></textarea>
    </li>
    <li>
    <button style="background-color:green" class="flatbutton" name="submitButtom" id="draft">Draft</button>
    <button style="background-color:green" class="flatbutton" name="submitButtom" id="submit">Submit for Approval</button>
    <button style="width:100px;" class="flatbutton" id="cancel">Cancel</button>
    </li>
</ul>
</div>

>>>>>>> b5dc6a407d8451d589741171a8b693f970d2454c
<script src="<?=base_url()?>js/create_pr.js"></script>
<script src="<?=base_url()?>js/form_validator.js"></script>
<script>

	$( "#prDate").datepicker("setDate", new Date());
	$( "#prDate").datepicker({ dateFormat: 'yy/mm/dd'});

	$("button[name='submitButtom']").click(function(){
		var action = null;
		if($(this).attr('id') == 'draft')
			action = <?=DRAFT_STATUS?>;
		else if($(this).attr('id') == 'submit')
<<<<<<< HEAD
			action = <?=SUBMITTED_STATUS?>;
			
		
		var check = runValidation();
		publishPr("<?=base_url()?>", action,'create');
		
=======
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
>>>>>>> b5dc6a407d8451d589741171a8b693f970d2454c
	});

</script>
