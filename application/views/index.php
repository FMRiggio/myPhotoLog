<div class="container">
	<a href="http://www.good2know.it/wall/" class="title"><img src="<?php echo $this->config->item('base_url'); ?>widgets/title.jpg" /></a>	
	<div class="box">
		<?php
		for($i = 0; $i < 5; $i++) {			
			if ($i == 4) {
				echo '<div class="image last">';
			} else {
				echo '<div class="image">';
			}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);		
			echo img($img);
			echo '</a>';
			echo '</div>';			
		}
		?>
		<div class="clear"></div>		
	</div>
	<div class="clear"></div>
	<div class="box box1">
		<?php		
		for(; $i < 9; $i++) {			
			if ($i == 8) {
				echo '<div class="image last">';
			} else {
				echo '<div class="image">';
			}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);			
			echo img($img);
			echo '</a>';
			echo '</div>';			
		}
		?>	
	</div>
	<div class="clear"></div>
	<div class="box box2">
		<?php		
		for(; $i < 11; $i++) {			
			if ($i == 10) {
				echo '<div class="image last">';
			} else {
				echo '<div class="image">';
			}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);	
			echo img($img);
			echo '</a>';
			echo '</div>';			
		}
		?>		
	</div>
	<div class="clear"></div>
	<div class="box box1">
		<?php		
		for(; $i < 15; $i++) {			
			if ($i == 14) {
				echo '<div class="image last">';
			} else {
				echo '<div class="image">';
			}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);
			echo img($img);
			echo '</a>';
			echo '</div>';			
		}
		?>		
	</div>
	<div class="clear"></div>
	<div class="box">
		<?php
		for(; $i < 20; $i++) {			
			if ($i == 19) {
				echo '<div class="image last">';
			} else {
				echo '<div class="image">';
			}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				echo '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);				
			echo img($img);
			echo '</a>';
			echo '</div>';			
		}
		?>	
	</div>
	<div class="clear"></div>	
</div>