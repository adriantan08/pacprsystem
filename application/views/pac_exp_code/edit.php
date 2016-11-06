<font color=red><?php echo validation_errors(); ?></font>
<?php $this->load->helper('form');
echo form_open('pac_exp_code/edit/'.$pac_exp_code['exp_code_id']); ?>

	<div>Exp Code Id : <input disabled type="text" name="exp_code_id" value="<?php echo ($this->input->post('exp_code_id') ? $this->input->post('exp_code_id') : $pac_exp_code['exp_code_id']); ?>" /></div><br/>
	<div>Exp Desc : <input type="text" size="75" name="exp_desc" value="<?php echo ($this->input->post('exp_desc') ? $this->input->post('exp_desc') : $pac_exp_code['exp_desc']); ?>" /></div><br/>
	<div>Exp Remarks : <input type="text" size="75" name="exp_remarks" value="<?php echo ($this->input->post('exp_remarks') ? $this->input->post('exp_remarks') : $pac_exp_code['exp_remarks']); ?>" /></div><br/>
	<div>
				Status :
				<select name="status">
					<option value="">Select</option>
					<?php
					$status_values = array(
						'A'=>'Active',
						'I'=>'Inactive',
					);

					foreach($status_values as $value => $display_text)
					{
						$selected = ($value == $pac_exp_code['status']) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					}
					?>
				</select><br/><br/>
	</div>
	<hr class="carved"/>
		<font><i/>To skip a step (i.e. auto-approve), select Auto Approve</font><br/><br/>
	<div>
				Prepare Step :
				<select name="submit_step">
					<option value="">Select</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['submit_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Verify Step :
				<select name="post_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['post_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Verify2 Step :
				<select name="verify_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['verify_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>
	<div>
				Approve Step :
				<select name="approve_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['approve_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['codename'].'</option>';
					}
					?>
				</select><br/><br/>
		</div>

	<button type="submit" class="flatbutton">Save</button>

<?php echo form_close(); ?>
