<font color=red><?php echo validation_errors(); ?></font>
<?php $this->load->helper('form'); echo form_open('pac_emp_exp_code/edit/'.$pac_emp_exp_code['id']); ?>

	<div>Codename : <input type="text" size="70" name="codename" value="<?php echo ($this->input->post('codename') ? $this->input->post('codename') : $pac_emp_exp_code['codename']); ?>" /></div></br>

	<button type="submit" class="flatbutton">Save</button>

<?php echo form_close(); ?>
