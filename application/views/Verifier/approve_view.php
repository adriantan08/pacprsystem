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

.approveButton{
	width:100px;
	background-color:#00b48d;
}
.rejectButton{
	width:100px;
	background-color:red;
}

</style>

<div style="position:relative; top:5%; left:5%; width:95%;"><br>
<table>
<tr>
<td valign=top>
<table>
<tr>
<td>
	<font style="font-size:15px;"><b>PR# <?=$prDetails['pr_id']?></b></font><br>
	<br><i>Last Modified: <?=$prDetails['changed_on']?></i><br><br>
</td>

<td>
	<?php
		if($prDetails['pr_status'] == VERIFIED_STATUS){
			echo '<div style="position:relative; left:50px; font-size:17px;"><i><b>Pending review</b></i></div>';
		}else{
	?>
	
	<span>
		<button style="position:relative; left:20px;" class="flatbutton approveButton" id="verify" name="submitButton">Verify</button>
		<button style="position:relative; left:20px;" class="flatbutton rejectButton" id="return" name="submitButton">Return PR</button>
		
	</span>
	<?php } ?>
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
			<div id="amountPlaceholderRead">P <?=number_format($prDetails['amount'], 2,'.',',')?></div>
			<div id="amountPlaceholderEdit" style="display:none;" >P <input type=number id="prAmount"  name="editable" class="input-read" disabled value="<?=$prDetails['amount']?>"/></div>
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
	<tr class="supportingDocumentSection">
		<td>
			<font class="label">Expenditure Code: </font>
		</td>
			
		<td>
			<div class="hideable-longtext"><?=$prDetails['exp_code']?>
			</div>
			
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

</td>
<td valign=top style="position:relative; left:10%;">
	<h2>Receipts</h2>
	<div id="existingImagesDiv">
	<?php
		if($prDetails['receipt_img'] !== 'none' && $prDetails['receipt_img'] !== null){
			/*if there's at least one image, exploding will always result into an array i.e. IMG1||IMG2||
			
			we just have to always check if current array value is no blank
			*/
			
			$imgArr = explode("||", $prDetails['receipt_img']);
			//for goodness sake, we still want to catch if it's array
			if(is_array($imgArr)){
				for($i=0; $i<count($imgArr); $i++){
					if($imgArr[$i] !== ""){
						$imgDomId = "image-".$i;
						$buttonDomId = "removebutton-".$i;
						
						echo '<a href="'.IMG_DIR.$imgArr[$i].'" target="_blank"><img name="existingImages" id="'.$imgDomId.'" width=300px src = "'.IMG_DIR.$imgArr[$i].'" data-filename="'.$imgArr[$i].'"/></a><br/><br/>';
						
						echo '<button class="flatbutton" style="background-color:red; visibility:hidden;" name="removeImageButtons" id = "'.$buttonDomId.'" onclick="removeExistingImage('."'".$imgDomId."'".','."'".$buttonDomId."'".');"> Remove</button><br/><br/>';
					}
				}
			}
			
		}
		else{
			echo 'No receipts.';
		}
	?>
	</div>
</td>
<td valign=top style="border-left:1px; position:relative; left:20%;">
	<?php
		echo $this->load->view('comments_view', null, true);
	?>
</td>
</tr>
</table>
<input type=hidden id="prNum" value="<?=$prDetails['pr_id']?>" />
</div><br/><br/>
<script src="<?=base_url()?>js/approve_pr.js"></script>

<script>
	$("button[name='submitButton']").click(function(){
		var status = null;
		var prNum = document.getElementById('prNum').value;
		if($(this).attr('id') == 'return'){
			status = <?=FORREVIEW_STATUS?>;
			$.ajax({
				url:"<?=base_url()?>api/addcomment",
				method:"POST",
				async: true,
				data:{
					prId : <?=$prDetails['pr_id']?>,
					comment: "The ticket was sent back by a Verifier (auto-generated)."
					
				},
				success: function(data){}
			})
			.done(function(data){
				approvePr("<?=base_url()?>", 'VERIFIER', status, prNum);
			});
		}
			
		else if($(this).attr('id') == 'verify'){
			status = <?=VERIFIED_STATUS?>;
			approvePr("<?=base_url()?>", 'VERIFIER', status, prNum);
		}
		
	});
	
</script>