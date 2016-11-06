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
	<div><font style="font-size:10px; font-family:Arial;">PAC Form No. C-32</font></div>
	<br/>
	<div style="position:relative; left:10%;"><img src="<?=base_url().'img/pac_logo.png'?>" width=30 /><font style="font-family:'Mistral'; font-size:22px; position:relative; top:-5px;"><?=COMPANY_NAME?></font></div>
	<div style="position:relative; left:25%;"><font style="font-size:12px; font-family:Arial;">Coron, Palawan</font></div>
	
	<div style="position:relative; left:10%;"><font style="font-size:12px; font-family:Arial;">Mailing Address: 925 M. Naval St., Navotas City</font></div>
	<br/>
	<div style="position:relative; left:20%;"><font style="font-size:15px; font-family:Arial;"><b>PAYMENT REQUEST</b></font></div>
	<table>
	<tr>
	<td valign=top>
		
	<table class="myTable" >
		<tr >
			<td colspan=2 align=right>
				<font style="font-size:15px; font-family:Arial;"><b>No. <?=$prDetails['pr_id']?></b></font><br/><br/>
				<font class="mylabel">Date:</font>
				<?=$prDetails['pr_date']?>
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
				<div id="amountPlaceholderRead">P <?=number_format($prDetails['amount'], 2)?></div>
				
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Form: </font>
			</td>
			<td>
				<span>
				<?=ucwords($prDetails['payment_form'])?>
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Purpose: </font>
			</td>
			<td>
				<span>
				<?=ucwords($prDetails['purpose'])?>
				
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Disb'mnt Class:</font>
			</td>
			<td>
				<span>
				<?=ucwords($prDetails['dist_class'])?>
				
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<font class="mylabel">Disb'mnt Yield:</font>
			</td>
			<td>
				<span>
				<?=ucwords($prDetails['dist_yield'])?>
				
				</span>
			</td>
		</tr>
		<tr><td colspan=2><b>Supporting Documents</b></td></tr>
		
		<tr class="supportingDocumentSection">
			<td>
				<font class="mylabel">P.O./J.O. No.: </font>
			</td>
			<td>
				<?=$prDetails['po_jo_no']?>
				
			</td>
		</tr>
		<tr class="supportingDocumentSection">
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
				<?php
					//limiting others to display max of 25 chars
					if(strlen($prDetails['others'])>25)
						echo substr($prDetails['others'], 0, 25).'...';
					else 
						echo $prDetails['others'];
				?>
				
			</td>
		</tr>
		<tr>
			<td valign=top>
				<font class="mylabel">Details:</font>
			</td>
			<td>
				<?php
					if(strlen($prDetails['details'])>0){
						echo $prDetails['details'].'<br/><br/>';
					}
					
					echo str_replace('|','<br>',$prDetails['exp_code'])
				?>
				
			</td>
		</tr>
		<tr>
			<!--Put signature URL elsewhere; in constants.php-->
			<td colspan=2>
				<table>
					<tr>
						<td>
							<font style="font-size:13px;"><u><?=$prDetails['prepare_name']?></u><br/>
							Prepared by:</font>
						</td>
						<td>
							<?php
								if($prDetails['approver1_id'] != 999){
									echo '<font style="font-size:13px;"><u>'.$prDetails['post_name'].'</u><br/>Verified by:</font>';
								}
							?>
							
						</td>
						<td>
							<?php
								if($prDetails['approver2_id'] != 999){
									echo '<font style="font-size:13px;"><u>'.$prDetails['verifier_name'].'</u><br/>Verified by:</font>';
								}
							?>
						</td>
						<td>
							<font style="font-size:13px;"><u><?=$prDetails['approver_name']?></u><br/>
							Approved by:</font>
						</td>
					</tr>
				</table>
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