<?php 

echo $this->form_validation->error_string;

echo form_open('admin/account/login', array('class' => 'account'));
	echo form_fieldset('Login');
	
		$js = 'onFocus="this.value=\'\'"';	
		echo form_input('email', 'Indirizzo email', $js);
			
		echo form_password('password', 'password', $js);
		
		$data = array(
           'name'        => 'invio',
           'value'       => 'Accedi',
           'class'		 =>	'submitAccount'
        );
		echo form_submit($data);
		echo '<div class="clear"></div>';
	echo form_fieldset_close();
echo form_close();
?>
<div class="content">
	<a href="/admin/account/register">Registrazione</a>
</div>