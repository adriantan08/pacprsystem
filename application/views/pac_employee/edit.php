<font color=red><?php echo validation_errors(); ?></font>
<?php $this->load->helper('form'); echo form_open('pac_employee/edit/'.$pac_employee['id']); ?>

	<div>Emp Firstname : <input type="text" name="emp_firstname" value="<?php echo ($this->input->post('emp_firstname') ? $this->input->post('emp_firstname') : $pac_employee['emp_firstname']); ?>" /></div><br/>
	<div>Emp Lastname : <input type="text" name="emp_lastname" value="<?php echo ($this->input->post('emp_lastname') ? $this->input->post('emp_lastname') : $pac_employee['emp_lastname']); ?>" /></div><br/>
	<div>Emp Email : <input type="text" name="emp_email" value="<?php echo ($this->input->post('emp_email') ? $this->input->post('emp_email') : $pac_employee['emp_email']); ?>" /></div><br/>
	<div>
				Role:
				<select name="emp_role_id">
					<option value="">Select</option>
					<?php
					foreach($all_pac_emp_roles as $pac_emp_role)
					{
						//override text values of roles
						if($pac_emp_role['name'] == 'WFC')
							$pac_emp_role['name'] = 'PREPARE';
						else if($pac_emp_role['name'] == 'ASH')
							$pac_emp_role['name'] = 'POST';




						$selected = ($pac_emp_role['id'] == $pac_employee['emp_role_id']) ? ' selected="selected"' : null;

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
						$selected = ($pac_emp_role['id'] == $pac_employee['exp_code_id']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_role['id'].'" '.$selected.'>'.$pac_emp_role['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Emp Status :
				<?php
				// if role is SYSADMIN (EXP_CODE_ID = 0) disable change of status
				if( $pac_employee['exp_code_id'] == '0' ){
					$placeholder =  '<font><i>We have disabled deactivating user if the role is SYS Admin</i></font>';
					echo '<select disabled name="emp_status">';
				}
				else{
					$placeholder = "";
					echo '<select name="emp_status">';
				}
				?>
					<option value="">select</option>
					<?php
					$emp_status_values = array(
						'ACTIVE'=>'Active',
						'INACTIVE'=>'Inactive',
					);

					foreach($emp_status_values as $value => $display_text)
					{
						$selected = ($value == $pac_employee['emp_status']) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					}
					?>
				</select><br/>
				<?=$placeholder?>
				<br/>
	</div>
	<hr class='carved'/>
	<div>Emp Username : <input disabled type="text" name="emp_username" value="<?php echo ($this->input->post('emp_username') ? $this->input->post('emp_username') : $pac_employee['emp_username']); ?>" /></div><br/>
	<div>Emp Password : <input type="password" name="emp_password" value="<?php echo ($this->input->post('emp_password') ? $this->input->post('emp_password') : $pac_employee['emp_password']); ?>" /></div><br/>

	<button type="submit" class="flatbutton">Save</button>

<?php echo form_close(); ?>
