<?php echo validation_errors(); ?>

<?php echo form_open('pac_employee/add'); ?>

	<div>Emp Firstname : <input type="text" name="emp_firstname" value="<?php echo $this->input->post('emp_firstname'); ?>" /></div>
	<div>Emp Lastname : <input type="text" name="emp_lastname" value="<?php echo $this->input->post('emp_lastname'); ?>" /></div>
	<div>Emp Email : <input type="text" name="emp_email" value="<?php echo $this->input->post('emp_email'); ?>" /></div>
	<div>
				Emp Role Id :
				<select name="emp_role_id">
					<option value="">select pac_emp_role</option>
					<?php
					foreach($all_pac_emp_roles as $pac_emp_role)
					{
						$selected = ($pac_emp_role['id'] == $this->input->post('emp_role_id')) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_role['id'].'" '.$selected.'>'.$pac_emp_role['id'].'</option>';
					}
					?>
				</select>
		</div>
	<div>
				Exp Code Id :
				<select name="exp_code_id">
					<option value="">select pac_emp_role</option>
					<?php
					foreach($all_pac_emp_roles as $pac_emp_role)
					{
						$selected = ($pac_emp_role['id'] == $this->input->post('exp_code_id')) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_role['id'].'" '.$selected.'>'.$pac_emp_role['id'].'</option>';
					}
					?>
				</select>
		</div>
	<div>
				Emp Status :
				<select name="emp_status">
					<option value="">select</option>
					<?php
					$emp_status_values = array(
						'ACTIVE'=>'Active',
						'INACTIVE'=>'Inactive',
					);

					foreach($emp_status_values as $value => $display_text)
					{
						$selected = ($value == $this->input->post('emp_status')) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					}
					?>
				</select>
	</div>
	<div>Emp Username : <input type="text" name="emp_username" value="<?php echo $this->input->post('emp_username'); ?>" /></div>
	<div>Emp Password : <input type="password" name="emp_password" value="<?php echo $this->input->post('emp_password'); ?>" /></div>

	<button type="submit">Save</button>

<?php echo form_close(); ?>