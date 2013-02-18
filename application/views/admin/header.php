<?php 
echo doctype('xhtml1-trans');
?>
<html>
<head>
	<title>MyPhotoLog - Admin</title>
	<?php 
	echo link_tag('css/reset.css');
	echo link_tag('css/admin/admin.css');
	?>
	<script type="text/javascript">
		basepath = "<?php echo $this->config->item('base_url'); ?>";
	</script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>js/admin/application.js"></script>
</head>
<body>