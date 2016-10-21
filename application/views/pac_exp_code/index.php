<div style="width: 75%; margin: 0 auto; ">
<table class="display" id="mytable1">
    <thead>
		<th>Exp Code Id</th>
		<th>Exp Desc</th>
		<th>Exp Remarks</th>
		<th>Status</th>
		<th>Submit Step</th>
		<th>Post Step</th>
		<th>Verify Step</th>
		<th>Approve Step</th>
		<th>Actions</th>
    </thead>
	<tbody>
	<?php foreach($pac_exp_codes as $p){ ?>
    <tr>
		<td><?php echo $p['exp_code_id']; ?></td>
		<td><?php echo $p['exp_desc']; ?></td>
		<td><?php echo $p['exp_remarks']; ?></td>
		<td><?php echo $p['status']; ?></td>
		<td><?php echo $p['submit_step']; ?></td>
		<td><?php echo $p['post_step']; ?></td>
		<td><?php echo $p['verify_step']; ?></td>
		<td><?php echo $p['approve_step']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_exp_code/edit/'.$p['exp_code_id']); ?>">Edit</a> |
            <a href="<?php echo site_url('pac_exp_code/remove/'.$p['exp_code_id']); ?>">Delete</a>
        </td>
    </tr>
	<?php } ?>
	</tbody>
</table>
</div>
<script>
	$(document).ready(function() {
      $('#mytable1').DataTable({"pageLength":50});
    
    } );
</script>
