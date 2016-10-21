<table border="1" width="100%">
    <tr>
		<th>ID</th>
		<th>Name</th>
		<th>Role Status</th>
		<th>Actions</th>
    </tr>
	<?php foreach($pac_emp_roles as $p){ ?>
    <tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['role_status']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_emp_role/edit/'.$p['id']); ?>">Edit</a> | 
            <a href="<?php echo site_url('pac_emp_role/remove/'.$p['id']); ?>">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>