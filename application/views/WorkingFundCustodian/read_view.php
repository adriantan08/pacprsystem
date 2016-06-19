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
			<font class="label">Date:</font> 6/12/2016
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Payee: </font>
		</td>
		<td>
			John Smith
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Amount: </font>
		</td>
		<td>
			P100.50
		</td>
	</tr>
	<tr>
		<td>
			<font class="label">Form: </font>
		</td>
		<td>
			<span>
			<input type="radio" name="prForm" value="cash" checked/> Cash
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
			<input type="radio" name="prPurpose" value="disbursement" /> Disbursement
			<input type="radio" name="prPurpose" value="liquidation" checked/> Liquidation
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
			<input type="radio" name="prDisbClass" value="spent" checked/> Spent
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
			<input type="radio" name="prDisbYield" value="consumable" checked/> Consumable
			<input type="radio" name="prDisbYield" value="asset"/> Asset
			</span>
		</td>
	</tr>
	<tr><td colspan=2><b>Supporting Documents:</b></td></tr>
	<!--
	<tr>
		<td>
			P.O./J.O. No.:
		</td>
		<td>
			<input type=text id="prPoJoNo"/>
		</td>
	</tr>
	<tr>
		<td>
			Receiving Report No.:
		</td>
		<td>
			<input type=text id="prRcvReportNo"/>
		</td>
	</tr>-->
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Invoice No.:</font>
		</td>
		<td>
			<span>
				1023
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
			Some remarks would be seen here.
		</td>
	</tr>
	<tr>
		<td valign=top>
			<font class="label">Details:</font>
		</td>
		<td>
			<textarea disabled style="text-align:left;" id="prDetails" rows=10 cols=40>there was a problem</textarea>
		</td>
	</tr>
	
	<tr>
		<td colspan=2 align=center>
			<button style="width:100px;" class="flatbutton">Submit</button>
		</td>
	</tr>
</table>
</div><br/><br/>