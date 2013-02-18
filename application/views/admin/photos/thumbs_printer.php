<?php

$html = "";
$i = 0;
$k = 0;
foreach ($links as $link) {
	$html .= '<div class="boxCheck';
	$html .= ($i==4 ? ' last' : '');
	$html .= '" id="' . $k . '">';
		$image_properties = array(
	          'src'    => $link,
	          'width'  => '160',
	          'height' => '100'			  
		);

		$html .= "\t\n" . img($image_properties);
		$data = array(
		    'name'        => 'photos[]',
		    'class'       => $k,
		    'value'       => $link,
		    'checked'     => FALSE
		    );
				
		$html .= "\t\n" . form_checkbox($data); 
	$html .= "\n" . '</div>' . "\n";
	
	$i++;
	if ($i != 0 && $i%5 == 0) {
		$html .= '<div class="clear"></div>';
		$i = 0;
	}		
	$k++;
}
$html .= '<div class="clear"></div>';
echo $html;