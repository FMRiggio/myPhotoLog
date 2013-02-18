<?php 
echo '<div class="container">';

echo form_open('/admin/photos/edit');
	echo form_label('Fonte');
	$data = array(
			'name'		=> 'fonte',
			'value'		=> $fonte,
			'class'		=> 'fonte'
	);
	echo form_input($data);
	
	echo form_label('Links');
	$data = array(
           'name'        => 'links',
           'value'       => $link,
           'class'		 =>	'linksTextarea'
    );
	echo form_textarea($data);
	
	$data = array(
           'name'        => 'invio',
           'value'       => 'Save photos',
           'class'		 =>	'submit'
    );
	echo form_submit($data);
	echo '<div class="clear"></div>';
	echo form_hidden('id_photo', $id_photo);
echo form_close();
echo '</div>';
?>