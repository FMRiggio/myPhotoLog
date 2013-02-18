<?php 
echo $this->form_validation->error_string;

echo form_open('admin/account/register', array('class' => 'account'));
	echo form_fieldset('Register');
	
		$js = 'onFocus="this.value=\'\'"';	
		echo form_label('Username :', 'username');
		echo form_input('username');
		
		echo form_label('Password :', 'password');
		echo form_password('password');

		echo form_label('Repeat password :', 'password2');
		echo form_password('password2');

		echo form_label('Email :', 'email');
		echo form_input('email');

		echo form_label('Secret Question :', 'question');
		echo form_input('question');				

		echo form_label('Answer :', 'answer');
		echo form_input('answer');	
				
		$data = array(
           'name'        => 'invio',
           'value'       => 'Registrati',
           'class'		 =>	'submitAccount'
        );
		echo form_submit($data);
		echo '<div class="clear"></div>';
	echo form_fieldset_close();
echo form_close();

?>