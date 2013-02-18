<div class="container">
	<?php
	echo anchor('/admin/photos/add', '<img src="../widgets/admin/add.jpg" /> Add photos', array('class' => 'addPhotoLink'));
	
	$this->table->set_heading('ID', 'Image', 'Order', 'Edit', 'Delete');
	
	$tmpl = array ('table_open'  => '<table border="0" cellpadding="0" cellspacing="0" class="tablePhotos">');
	$this->table->set_template($tmpl); 

	foreach ($photos as $stdClass) {
		$extension = substr($stdClass->link, -4);
		if ($extension == 'jpeg') {
			$extension = '.jpg';
		}			
		$pathImg =  $this->config->item('base_url') . '/var/files/thumbs/' . $stdClass->id_photo . $extension;		 
		$cellImg    = array('data' => '<img src="' . $pathImg .'" />');
		$cellEdit   = array('data' => anchor($this->config->item('base_url') . 'admin/photos/edit/id_photo/' . $stdClass->id_photo, '<img src="' . $this->config->item('base_url') . 'widgets/admin/edit.jpg" />'));
		$cellDelete = array('data' => anchor($this->config->item('base_url') . 'admin/photos/delete/id_photo/' . $stdClass->id_photo, '<img src="' . $this->config->item('base_url') . 'widgets/admin/delete.jpg" />'));
		$row = array($stdClass->id_photo, $cellImg, $stdClass->ordine, $cellEdit, $cellDelete);
		$this->table->add_row($row);		
	}
	echo $this->table->generate();	
	echo $this->pagination->create_links();
	
	?>
</div>