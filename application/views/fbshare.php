<?php 
echo doctype('xhtml1-trans');
?>
<html>
<head>
	<script type="text/javascript">
		location.href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $link_img; ?>";
	</script>	
</head>
<body>
	<p>Immagine proveniente da <a href="">The Good2know Wall</a></p>
	<img src="<?php echo $link_img; ?>" />
</body>
</html>