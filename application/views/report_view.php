<style>
	tbody.tablebody tr td{ border:1pt solid black;}
</style>
<br/><br/>
<!--
	1. All PRs issued and approved for a period of time
		2. All PRs encoded for a selected period of time that were not yet approved
		3. All PRs encoded that were not yet verified as of date
		4. All PRs issued for particule payee for a period of time

-->
<table border=0 align=center cellpadding=20 cellspacing=30px  style="border-collapse: collapse; font-size:15px;">
	
	<tbody class="tablebody">
		<tr>
			<td><b/>Report Type</td>
			<td><b/>Filter</td>
			<td><b/>Action</td>
		</tr>
		<tr>
			<td >
				All PRs issued and approved for a period of time
			</td>
			<td>
				From:<br/>
				<input type="text" id="report1Date_from" name="field1" class="field-divided"/><br/><br/>
				To:<br/>
				<input type="text" id="report1Date_to" name="field1" class="field-divided"/>
			</td>
			<td>
				<button class="flatbutton" name="download" id="1">Download</button>
			</td>
		</tr>
		<tr>
			<td>
				All PRs encoded for a selected period of time that were not yet approved
			</td>
			<td>
				-
			</td>
			<td>
				<button class="flatbutton" name="download" id="2">Download</button>
			</td>
		</tr>
		<tr>
			<td>
				All PRs encoded that were not yet verified as of date
			</td>
			<td>
				-
			</td>
			<td>
				<button class="flatbutton" name="download" id="3">Download</button>
			</td>
		</tr>
		<tr>
			<td>
				All PRs issued for particule payee for a period of time
			</td>
			<td>
				<?php
					$payees = json_decode($this->Crud_model->getDistinctPayees(),true);
					echo "<select id ='payeeSelect'>";
						echo "<option value='none'>Select a payee</option>";
						foreach($payees as $p)
							echo "<option value='$p'>$p</option>";
					echo "</select>";
				?><br/><br/>
				From:<br/>
				<input type="text" id="report4Date_from" name="field1" class="field-divided"/><br/><br/>
				To:<br/>
				<input type="text" id="report4Date_to" name="field1" class="field-divided"/>
			</td>
			<td>
				<button class="flatbutton" name="download" id="4">Download</button>
			</td>
		</tr>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		$( "#report1Date_from").datepicker("setDate", new Date());
		$( "#report1Date_from").datepicker({ dateFormat: 'yy-mm-dd'});
		
		$( "#report1Date_to").datepicker("setDate", new Date());
		$( "#report1Date_to").datepicker({ dateFormat: 'yy-mm-dd'});
		
		
		$( "#report4Date_from").datepicker("setDate", new Date());
		$( "#report4Date_from").datepicker({ dateFormat: 'yy-mm-dd'});
		
		$( "#report4Date_to").datepicker("setDate", new Date());
		$( "#report4Date_to").datepicker({ dateFormat: 'yy-mm-dd'});
	});

	$("button[name='download']").on("click",function(){
		if(this.id == 1){
			var report1Date_from = document.getElementById("report1Date_from").value;
			var report1Date_to = document.getElementById("report1Date_to").value;
			var url = "<?=base_url()?>home/downloadreport1/"+report1Date_from+"/"+report1Date_to;
		}
		else if(this.id == 2){
			var url = "<?=base_url()?>home/downloadreport2";
		}
		else if(this.id==3){
			var url = "<?=base_url()?>home/downloadreport3";
		}
		else if(this.id==4){
			var e = document.getElementById("payeeSelect");
			var payee = e.options[e.selectedIndex].value; 
			
			var report4Date_from = document.getElementById("report4Date_from").value;
			var report4Date_to = document.getElementById("report4Date_to").value;
			
			if(report4Date_from != "" && report4Date_to != "" && payee != 'none')
				var url = "<?=base_url()?>home/downloadreport4/"+payee+"/"+report4Date_from+"/"+report4Date_to;
			else{
				swal("Invalid filters.","","error");
				return;
			}
		}
		else{
			return;
		}
		
		$.ajax({
			url:url,
			method:"GET",
			async: false,
			
			success: function(data){
				
				window.open(url,'_blank' );		
			}
		})
		.done(function(data){
			
		});
	});
</script>