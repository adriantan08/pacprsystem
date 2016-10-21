<table border="1" width="100%">
    <tr>
		<th>ID</th>
		<th>Codename</th>
		<th>Actions</th>
    </tr>
	<?php foreach($pac_emp_exp_code as $p){ ?>
    <tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['codename']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_emp_exp_code/edit/'.$p['id']); ?>">Edit</a> |
            <a href="<?php echo site_url('pac_emp_exp_code/remove/'.$p['id']); ?>">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>
