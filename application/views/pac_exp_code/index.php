<div style="width: 75%; margin: 0 auto; ">
<a href="<?=base_url()?>pac_exp_code/add" class="flatbutton">Add </a><br/><br/><br/>
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
    <?php
      //override text values of roles
      if($p['status'] == 'I')
        $p['status'] = 'Inactive';
      else if($p['status'] == 'A')
        $p['status'] = 'Active';
    ?>
		<td><?php echo $p['status']; ?></td>
		<td><?php echo $p['submit_name']; ?></td>
		<td><?php echo $p['post_name']; ?></td>
		<td><?php echo $p['verify_name']; ?></td>
		<td><?php echo $p['approve_name']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_exp_code/edit/'.$p['exp_code_id']); ?>">Edit</a>
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
