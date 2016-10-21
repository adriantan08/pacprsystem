<?php $this->load->helper('form');
echo form_open('pac_emp_role/add'); ?>

	<div>Name : <input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" /></div>
	<div>
				Role Status :
				<select name="role_status">
					<option value="">select</option>
					<?php
					$role_status_values = array(
						'ACTIVE'=>'Active',
						'INACTIVE'=>'Inactive',
					);

					foreach($role_status_values as $value => $display_text)
					{
						$selected = ($value == $this->input->post('role_status')) ? ' selected="selected"' : null;

						echo '<option value="'.$value.'" '.$selected.'>'.$display_text.'</option>';
					}
					?>
				</select>
	</div>

	<button type="submit">Save</button>

<?php echo form_close(); ?>
