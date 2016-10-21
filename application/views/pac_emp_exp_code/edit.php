<?php $this->load->helper('form');
echo form_open('pac_emp_exp_code/edit/'.$pac_emp_exp_code['id']); ?>

	<div>Codename : <input type="text" name="codename" value="<?php echo ($this->input->post('codename') ? $this->input->post('codename') : $pac_emp_exp_code['codename']); ?>" /></div>

	<button type="submit">Save</button>

<?php echo form_close(); ?>
