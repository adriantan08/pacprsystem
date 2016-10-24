<div style="width: 75%; margin: 0 auto; ">
<a href="<?=base_url()?>pac_employee/add" class="flatbutton">Add </a><br/><br/><br/>
  <table class="display" id="mytable1" width="100%">
    <thead>

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

		<td><?php echo $p['emp_firstname']; ?></td>
		<td><?php echo $p['emp_lastname']; ?></td>
		<td><?php echo $p['emp_email']; ?></td>
    <?php
      //override text values of roles
      if($p['name'] == 'WFC')
        $p['name'] = 'PREPARE';
      else if($p['name'] == 'ASH')
        $p['name'] = 'POST';
    ?>
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
