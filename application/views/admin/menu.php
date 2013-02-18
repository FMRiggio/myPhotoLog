<?php 
echo '<div class="intestazione">';
echo 'Benvenuto ' . $username . '.';
echo anchor('/admin/account/logout', '<img src="../widgets/admin/exit.jpg" /> Logout', array('class' => 'logout'));
echo '</div>';

$attributes = array('class' => 'menu');
$menuOriginale = array('/admin/photos' => 'Photos');
		      
foreach ($menuOriginale as $link => $label) {
	if ($active == strtolower($label)) {
		$menu[] = anchor($link, $label, array('class' => 'active'));
	} else {
		$menu[] = anchor($link, $label);
	}
}
echo ul($menu, $attributes);


?>