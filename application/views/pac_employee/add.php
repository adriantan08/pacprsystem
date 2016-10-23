<font color=red><?php echo validation_errors(); ?></font>

<?php echo form_open('pac_employee/add'); ?>

	<div>Emp Firstname : <input type="text" name="emp_firstname" value="<?php echo $this->input->post('emp_firstname'); ?>" /></div><br/>
	<div>Emp Lastname : <input type="text" name="emp_lastname" value="<?php echo $this->input->post('emp_lastname'); ?>" /></div><br/>
	<div>Emp Email : <input type="text" name="emp_email" value="<?php echo $this->input->post('emp_email'); ?>" /></div><br/>
	<div>
				Role:
				<select name="emp_role_id">
					<option value="">Select</option>
					<?php
					foreach($all_pac_emp_roles as $pac_emp_role)
					{	
						//override text values of 
						if($pac_emp_role['name'] == 'WFC')
							$pac_emp_role['name'] = 'PREPARE';
						else if($pac_emp_role['name'] == 'ASH')
							$pac_emp_role['name'] = 'POST';
					
						
						$selected = ($pac_emp_role['id'] == $this->input->post('emp_role_id')) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_role['id'].'" '.$selected.'>'.$pac_emp_role['name'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Role (for Exp Code mapping):
				<select name="exp_code_id">
					<option value="">Select</option>
					<?php 
					foreach($all_pac_emp_exp_codes as $pac_emp_role)
					{
						$selected = ($pac_emp_role['id'] == $this->input->post('exp_code_id')) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_role['id'].'" '.$selected.'>'.$pac_emp_role['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Emp Status :
				<select name="emp_status">
					<option value="">Select</option>
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
				</select><br/><br/>
	</div><hr class="carved"/>
	<h4><b>Account </b></h4>
	<div>Emp Username : <input type="text" name="emp_username" value="<?php echo $this->input->post('emp_username'); ?>" /></div><br/>
	<div>Emp Password : <input type="password" name="emp_password" value="<?php echo $this->input->post('emp_password'); ?>" /></div>
	<br/>
	<button type="submit" class="flatbutton">Save</button>

<?php echo form_close(); ?>
