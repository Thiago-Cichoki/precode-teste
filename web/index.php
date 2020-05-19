<?php

use util\Util;

require_once "../vendor/autoload.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br" ng-app="precode.app" ng-controller="precode.sistema.AppCtrl as AppCtrl" ng-cloak>

<head>
	<base href="<?= \util\Util::getPathSite(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="author" content="Precode">

	<meta property="og:type" content="website" />

	<title>Precode | Thiago Cichoki</title>

	<link rel="stylesheet" href="<?= \util\Util::getPathSite(); ?>lib/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= \util\Util::getPathSite() ?>lib/fontawesome/css/all.css">
	<link rel="stylesheet" href="<?= \util\Util::getPathSite(); ?>lib/themify-icons/themify-icons.css">

	<link rel="stylesheet" href="<?= \util\Util::getPathSite(); ?>css/style.css">
	<link rel="stylesheet" href="<?= \util\Util::getPathSite(); ?>css/responsive.css">
</head>

<body>
	<!--================Header Area =================-->
	<header class="header_area mb-5">
		<div class="top_menu">
			<div class="container">
				<div class="row">
					<div class="col-lg-7">
						<div class="float-left">
							<p>WhatsApp: (44) 99857-8925</p>
							<p>email: thiagocichoki7@gmail.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!--================Header Area =================-->

	<div ui-view></div>
</body>


<script src="<?= \util\Util::getPathSite(); ?>lib/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/jquery/jquery-migrate-3.0.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>


<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular-resource.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular-sanitize.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular-animate.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-1.7.0/angular-touch.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/ui-router/angular-ui-router.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/ui-router/angular-ui-router.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/angular-loading-bar/loading-bar.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/closure-library/closure/goog/base.js"></script>


<script src="<?= \util\Util::getPathSite(); ?>lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/ui-bootstrap/ui-bootstrap-tpls-1.2.5.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>js/bootstrap-slider/bootstrap-slider.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>js/bootstrap-select/bootstrap-select.min.js"></script>

<script src="<?= \util\Util::getPathSite(); ?>lib/jquery/jquery-3.2.1.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/owl-carousel/owl.carousel.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/nice-select/jquery.nice-select.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>lib/Magnific-Popup/jquery.magnific-popup.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>js/jquery.ajaxchimp.min.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>js/mail-script.js"></script>
<script src="<?= \util\Util::getPathSite(); ?>js/main.js"></script>

<?php
if (\util\Util::isDevelopmentMode()) {
	echo "<script src='app/deps.js'></script>";
} else {
	echo "<script src='app/precode.app.js'></script>";
}
?>

<script>
	goog.require('precode.app');
</script>

</html>