<font color=red><?php echo validation_errors(); ?></font>
<?php $this->load->helper('form');
echo form_open('pac_emp_exp_code/add'); ?>

	<div>Codename : <input type="text" name="codename" value="<?php echo $this->input->post('codename'); ?>" /></div>
<br/>
	<button type="submit" class="flatbutton">Save</button>

<?php echo form_close(); ?>
