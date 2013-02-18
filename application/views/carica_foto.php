<?php 
$html = "";
if (count($photos) > 0) {
	$html .= '<div class="box" id="' . $offset . '">';
	
	for($i = 0; $i < count($photos); $i++) {			
		if ($i == 4) {
			$html .= '<div class="image last">';
		} else {
			$html .= '<div class="image">';
		}
			$extension = substr($photos[$i]->link, -4);
			if ($extension == 'jpeg') {
				$extension = '.jpg';
			}			
			$pathResized = $this->config->item('path') . $photos[$i]->id_photo . '_resize' . $extension;
			if (file_exists($pathResized) == true) {
				$html .= '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . '_resize' . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			} else {
				$html .= '<a href="' . $this->config->item('base_url') . 'var/files/' . $photos[$i]->id_photo . $extension . '" title="' . $photos[$i]->id_photo . '" rel="fancybox">';
			}
			$img = array(
				  'src' => $this->config->item('base_url') . 'var/files/thumbs/' . $photos[$i]->id_photo . $extension
			);		
		$html .= img($img);
		$html .= '</a>';
		$html .= '</div>';			
	}
	
	$html .= '<div class="clear"></div>';
	$html .= '</div>';
}
echo $html;
?>