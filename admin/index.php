<?php

use util\Util;

require_once "../vendor/autoload.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br" ng-app="precode.app" ng-controller="precode.AppCtrl as AppCtrl" ng-cloak>

<head>
	<base href="<?= \util\Util::getPathAdmin(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="author" content="Precode">

	<meta property="og:type" content="website" />

	<title>Admin Precode | Thiago Cichoki</title>

	<link rel="stylesheet" href="<?= \util\Util::getPathAdmin(); ?>lib/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= \util\Util::getPathAdmin() ?>lib/fontawesome/css/all.css">
	<link rel="stylesheet" href="<?= \util\Util::getPathAdmin() ?>dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="<?= \util\Util::getPathAdmin(); ?>" class="brand-link">
				<span class="brand-text font-weight-light">PRECODE</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item has-treeview menu-open">
							<a href class="nav-link">
								<i class="nav-icon fas fa-tag"></i>
								<p>Produtos</p>
								<i class="right fas fa-angle-left"></i>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= \util\Util::getPathAdmin(); ?>/produtos" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Meus produtos</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= \util\Util::getPathAdmin(); ?>/produtos/novo" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Novo Produto</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= \util\Util::getPathAdmin(); ?>/categoria" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Categorias</p>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<div ui-view></div>
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->
			<div class="float-right d-none d-sm-inline">
				Aguardo o contato da equipe Precode!
			</div>
			<!-- Default to the left -->
			<strong>Copyright &copy; 2020 <a href="{{AppCtrl.Util.POINT}}">Thiago Miranda Cichoki</a>.</strong>
		</footer>
	</div>
	<!-- ./wrapper -->


</body>


<script src="<?= \util\Util::getPathAdmin(); ?>lib/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/jquery/jquery-migrate-3.0.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

<!-- REQUIRED SCRIPTS -->


<!-- AdminLTE App -->
<script src="<?= \util\Util::getPathAdmin(); ?>dist/js/adminlte.min.js"></script>

<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular-resource.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular-sanitize.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular-animate.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-1.7.0/angular-touch.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/ui-router/angular-ui-router.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/ui-router/angular-ui-router.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/angular-loading-bar/loading-bar.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/closure-library/closure/goog/base.js"></script>


<script src="<?= \util\Util::getPathAdmin(); ?>lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/ui-bootstrap/ui-bootstrap-tpls-1.2.5.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/jquery/jquery-3.2.1.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/owl-carousel/owl.carousel.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/nice-select/jquery.nice-select.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>lib/Magnific-Popup/jquery.magnific-popup.min.js"></script>
<script src="<?= \util\Util::getPathAdmin(); ?>app/app.js"></script>



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