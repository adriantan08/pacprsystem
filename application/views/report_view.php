<br/><br/>
<!--
	1. All PRs issued and approved for a period of time
		2. All PRs encoded for a selected period of time that were not yet approved
		3. All PRs encoded that were not yet verified as of date
		4. All PRs issued for particule payee for a period of time
-->
<table class="myTable">
	<th>Type</th>
	<th>Filter</th>
	<th>Action</th>
	<tbody>
		<tr>
			<td>
				All PRs issued and approved for a period of time
			</td>
			<td>
				Filter
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
				Filter
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
				Filter
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
				Filter
			</td>
			<td>
				<button class="flatbutton" name="download" id="4">Download</button>
			</td>
		</tr>
	</tbody>
</table>

<script>
	$("button[name='download']").click(function(){
		var type = this.id;
		
		$.ajax({
			url:"<?=base_url()?>home/downloadreport",
			method:"POST",
			async: true,
			data:{
				type: type
			},
			success: function(data){
				window.open(url,'_blank' );
			}
		})
		.done(function(data){
			
		});
	});
</script>