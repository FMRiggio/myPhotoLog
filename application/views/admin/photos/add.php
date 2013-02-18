<?php 
echo '<div class="container">';

echo form_open('/admin/photos/add');
	echo form_label('Links');
	$data = array(
           'name'        => 'links',
           'value'       => '',
           'class'		 =>	'linksTextarea',
           'id'			 =>	'links'
    );
	echo form_textarea($data);
	
	$data = array(
           'name'        => 'invio',
           'value'       => 'Save photos',
           'class'		 =>	'submit'
    );
	echo form_submit($data);
	echo '<div class="clear"></div>';
	echo '<div id="boxes"></div>';
echo form_close();
echo '</div>';
?>