<div style="width: 75%; margin: 0 auto; ">
	<a href="<?=base_url()?>pac_emp_exp_code/add" class="flatbutton">Add </a><br/><br/><br/>
  <table class="display" id="mytable1" width="100%">
    <thead>
		
		<th>Codename</th>
		<th>Actions</th>
    </thead>
    <tbody>
	<?php foreach($pac_emp_exp_code as $p){ ?>
    <tr>
		
		<td><?php echo $p['codename']; ?></td>
		<td>
            <a href="<?php echo site_url('pac_emp_exp_code/edit/'.$p['id']); ?>">Edit</a>
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
