<div style="width: 75%; margin: 0 auto; ">
  <table class="display" id="mytable1" width="100%">
    <thead>
		<th>ID</th>
		<th>Name</th>
		<th>Role Status</th>
		<th>Actions</th>
  </thead>
    <tbody>
	<?php foreach($pac_emp_roles as $p){ ?>
    <tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['role_status']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_emp_role/edit/'.$p['id']); ?>">Edit</a>
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
