<?php 
echo doctype('xhtml1-trans');
?>
<html>
<head>
	<title>The Good2know Wall</title>
	<?php 
	echo link_tag('css/reset.css');
	echo link_tag('css/style.css');
	echo link_tag('js/fancybox/jquery.fancybox-1.3.4.css');
	?>
	<script type="text/javascript">
		basepath = "<?php echo $this->config->item('base_url'); ?>";
	</script>	
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/application.js"></script>
</head>
<body>