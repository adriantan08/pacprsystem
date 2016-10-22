<div style="width: 75%; margin: 0 auto; ">
  <table class="display" id="mytable1" width="100%">
    <thead>
		<th>ID</th>
		<th>Emp Firstname</th>
		<th>Emp Lastname</th>
		<th>Emp Email</th>
		<th>Emp Role Id</th>
		<th>Exp Code Id</th>
		<th>Emp Status</th>
		<th>Emp Username</th>
		<th>Actions</th>
  </thead>
    <tbody>
	<?php foreach($pac_employees as $p){ ?>
    <tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['emp_firstname']; ?></td>
		<td><?php echo $p['emp_lastname']; ?></td>
		<td><?php echo $p['emp_email']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['codename']; ?></td>
		<td><?php echo $p['emp_status']; ?></td>
		<td><?php echo $p['emp_username']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_employee/edit/'.$p['id']); ?>">Edit</a>
        </td>
    </tr>
  </tbody>
	<?php } ?>
</table>
</div>
<script>
	$(document).ready(function() {
      $('#mytable1').DataTable({"pageLength":50});

    } );
</script>
