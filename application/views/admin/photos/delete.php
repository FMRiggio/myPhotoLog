<?php 
echo '<div class="container">';

echo form_open('/admin/photos/delete');
	echo '<p>Sei sicuro di voler eliminare la foto?</p><br />';
	$image_properties = array(
          'src' => $link
	);

	echo img($image_properties);
	
	$data = array(
           'name'        => 'invio',
           'value'       => 'Yes',
           'class'		 =>	'submit'
    );
	echo form_submit($data);
	
	$data = array(
           'name'        => 'invio',
           'value'       => 'No',
           'class'		 =>	'submit'
    );
	echo form_submit($data);	
	echo '<div class="clear"></div>';
	
	echo form_hidden('id_photo', $id_photo);
echo form_close();
echo '</div>';
?>