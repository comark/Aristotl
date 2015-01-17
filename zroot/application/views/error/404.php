<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<title><?php echo Config::get('admin::config.site_title') ?> - Error page</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo URL::base(); ?>/admin_assets/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?php echo URL::base(); ?>/admin_assets/css/bootstrap-responsive.min.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo URL::base(); ?>/admin_assets/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo URL::base(); ?>/admin_assets/css/themes.css">


	<!-- jQuery -->
	<script src="<?php echo URL::base(); ?>/admin_assets/js/jquery.min.js"></script>
	
	<!-- Nice Scroll -->
	<script src="<?php echo URL::base(); ?>/admin_assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo URL::base(); ?>/admin_assets/js/bootstrap.min.js"></script>

	<!--[if lte IE 9]>
		<script src="<?php echo URL::base(); ?>/admin_assets/js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->
	

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo URL::base(); ?>/admin_assets/img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo URL::base(); ?>/admin_assets/img/apple-touch-icon-precomposed.png" />

</head>

<body class='error'>
	<div class="wrapper" style="width:600px">
    <div class="code" style="text-align:left;"><span >404</span><i class="icon-warning-sign"></i></div>
    <div class="desc">Nothing found</div>
    
   <div class="desc"></div>
		<div class="buttons">
			<div class="pull-left"><a href="<?php echo URL::base(); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a></div>
		</div>
	</div>
</body>
</html>