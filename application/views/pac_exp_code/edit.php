<?php $this->load->helper('form');
echo form_open('pac_exp_code/edit/'.$pac_exp_code['exp_code_id']); ?>

	<div>Exp Code Id : <input type="text" name="exp_code_id" value="<?php echo ($this->input->post('exp_code_id') ? $this->input->post('exp_code_id') : $pac_exp_code['exp_code_id']); ?>" /></div>
	<div>Exp Desc : <input type="text" name="exp_desc" value="<?php echo ($this->input->post('exp_desc') ? $this->input->post('exp_desc') : $pac_exp_code['exp_desc']); ?>" /></div>
	<div>Exp Remarks : <input type="text" name="exp_remarks" value="<?php echo ($this->input->post('exp_remarks') ? $this->input->post('exp_remarks') : $pac_exp_code['exp_remarks']); ?>" /></div>
	<div>
				Status :
				<select name="status">
					<option value="">select</option>
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
				</select>
	</div>
	<div>
				Submit Step :
				<select name="submit_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['submit_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['id'].'</option>';
					}
					?>
				</select>
		</div>
	<div>
				Post Step :
				<select name="post_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['post_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['id'].'</option>';
					}
					?>
				</select>
		</div>
	<div>
				Verify Step :
				<select name="verify_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['verify_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['id'].'</option>';
					}
					?>
				</select>
		</div>
	<div>
				Approve Step :
				<select name="approve_step">
					<option value="">select pac_emp_exp_code</option>
					<?php
					foreach($all_pac_emp_exp_code as $pac_emp_exp_code)
					{
						$selected = ($pac_emp_exp_code['id'] == $pac_exp_code['approve_step']) ? ' selected="selected"' : null;

						echo '<option value="'.$pac_emp_exp_code['id'].'" '.$selected.'>'.$pac_emp_exp_code['id'].'</option>';
					}
					?>
				</select>
		</div>

	<button type="submit">Save</button>

<?php echo form_close(); ?>
