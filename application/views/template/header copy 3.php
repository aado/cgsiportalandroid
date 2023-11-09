
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Masterlist">
	<meta name="author" content="">

	  <!-- Favicons -->
  <link href="<?= site_url('public/img/cgsi.png'); ?>" rel="icon">

	<title>CGSI Portal - <?= ($page['title'] ?? 'Undefined'); ?></title>

	<!-- Custom fonts for this template-->
	<link href="<?= site_url('public/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="<?= site_url('public/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
	<link href="<?= site_url('public/css/style.css'); ?>" rel="stylesheet">

	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->

	<link href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css" rel="stylesheet">
	<link href="<?= site_url('public/css/style.css'); ?>" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

	<script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<head>
		<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
		<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
	</head>

	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	</head>
	
</head>
<style>
	#accordionSidebar {
		background-image:url("<?=site_url()?>/public/img/sidebarBg.jpg");
		background-repeat:no-repeat;
		background-size: cover;
	}
</style>
<body id="page-top">

<body>
  <!-- <aside class="mdc-drawer mdc-drawer--dismissible">
    <div class="mdc-drawer__content">
      <div class="mdc-list">
        <a class="mdc-list-item mdc-list-item--activated" href="#" aria-current="page">
          <span class="mdc-list-item__ripple"></span>
          <i class="material-icons mdc-list-item__graphic" aria-hidden="true">inbox</i>
          <span class="mdc-list-item__text">Inbox</span>
        </a>
        <a class="mdc-list-item" href="#">
          <span class="mdc-list-item__ripple"></span>
          <i class="material-icons mdc-list-item__graphic" aria-hidden="true">send</i>
          <span class="mdc-list-item__text">Outgoing</span>
        </a>
        <a class="mdc-list-item" href="#">
          <span class="mdc-list-item__ripple"></span>
          <i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
          <span class="mdc-list-item__text">Drafts</span>
        </a>
      </div>
    </div>
  </aside> -->

  <!-- <div class="mdc-drawer-app-content">
    <header class="mdc-top-app-bar app-bar" id="app-bar">
      <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
          <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="sidebarToggleTop">menu</button>
          <span class="mdc-top-app-bar__title">
				<div class="sidebar-brand-icon">
					<img class="img-profile" style="max-width: 15%;margin-left: 30%;margin-top: 20px;margin-bottom: 20px;" src="<?= site_url('public/img/cgsi.png'); ?>">
				</div>
		   </span>
        </section>
      </div>
    </header>
  </div> -->
</body>

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
			<!-- Sidebar - Brand -->
			<hr class="sidebar-divider" style="margin-top: 45px;">

			<!-- Heading -->
			<div class="sidebar-heading" style="font-size: 15px;">
				Menu
			</div>
			<?php
				$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
				$pathFragments = explode('/', $path);
				$end = end($pathFragments);
			?>

			<li class="nav-item" id="profile">
				<a class="nav-link <?php echo ($end == 'Profile')? 'active_link' : 'pb-0'?>" href="<?= site_url('/Profile'); ?>">
					<i class="fas fa-user" style="color:#10c4a5"></i>
					<span>Profile</span>
				</a>
			</li>

			<?php if($posi_type == '1') {?>
			<li class="nav-item" id="adminmasterlist">
				<a class="nav-link <?php echo ($end == 'AdminMasterlist')? 'active_link' : 'pb-0'?>" href="<?= site_url('/AdminMasterlist'); ?>">
					<i class="fas fa-user" style="color:#10c4a5"></i>
					<span>Masterlist</span>
				</a>
			</li>
			<?php } ?>

			<?php if ($designationID !== '18') { ?>
				<li class="nav-item">
					<a class="nav-link <?php echo ($end == 'PayslipIndiv')? 'active_link' : 'pb-0'?>" href="<?= site_url('/PayslipIndiv'); ?>">
						<i class="fa fa-address-card" style="color:#10c4a5"></i>
						<span>Payslip</span>
					</a>
				</li>
			<?php } ?>

			<!-- Nav Item - Logout -->
			<li class="nav-item">
				<a class="nav-link pb-0" href="<?= site_url('logout'); ?>" data-toggle="modal" data-target="#logoutModal">
					<i class="fas fa-fw fa-sign-out-alt" style="color:#7e381b"></i>
					<span>Logout</span>
				</a>
			</li>

			<br>
			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
		<!-- End of Sidebar -->

        
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
			<!-- <h4 class="h4 mb-4" style="margin-top: 15px;"><?= ($page['title'] ?? 'Undefined'); ?></h4> -->

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop2" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
				<!-- style="padding-right: 250px;" -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div style="margin-left: 15px; margin-bottom: 10px">
								<div id="userInfo" style="margin-right: 19px;margin-top: 0px;">
									<span class="capitalize" style="text-transform: Capitalize;font-size: 12px;font-weight: bold;color: #074f9d;"><?= ( $fullname ?? 'Guest'); ?></span>

									<span style="font-size: 0.6em; display: block; color: #6610f2"><?= $designation; ?></span>
									<!-- <span style="font-size: 0.6em; display: block;"><?= $departmentname; ?></span> -->
								</div>
							</div>
							<div>
								<?php
									$image_url = site_url('public/img/idpicture/'.$idnumber.'.jpg');
									$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
									if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
										$empimage = site_url('public/img/idpicture/noimage.jpg');
									} else {
										$empimage = site_url('public/img/idpicture/'.$idnumber.'.jpg');
									}
								?>
								<img class="img-profile rounded-circle" style="width: 40px;float: left;height: 40px;margin-top: -10px;" src="<?= $empimage ?>">
							</div>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php //= ($username ?? 'Guest'); ?>
                                <?php
                                    //($username ?? 'Guest'); 
                                ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            
                            <a class="dropdown-item" href="<?= site_url('logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
    <!-- End of Topbar -->
	<script>
		$(document).ready(function(){
			import {MDCTopAppBar} from "@material/top-app-bar";
const topAppBar = MDCTopAppBar.attachTo(document.getElementById('app-bar'));
topAppBar.setScrollTarget(document.getElementById('main-content'));
topAppBar.listen('MDCTopAppBar:nav', () => {
  drawer.open = !drawer.open;
});

const listEl = document.querySelector('.mdc-drawer .mdc-list');
const mainContentEl = document.querySelector('.main-content');

listEl.addEventListener('click', (event) => {
  mainContentEl.querySelector('input, button').focus();
});

document.body.addEventListener('MDCDrawer:closed', () => {
  mainContentEl.querySelector('input, button').focus();
});
			
			$(".main-menu .submenu").hide(); 
			$('li.main-menu').on('click', function(e) {
				$(this).children('ul').toggle();
				$(this).siblings('li').find('ul').hide();
				e.stopPropagation();
			});
			localStorage.getItem('openMain');
			if (localStorage.getItem('openMain') == 'po') {
				$("li#po").children('ul.submenu').removeAttr('style');
				$("li#voucher").children('ul.submenu').attr('style','display: none');
			} else if (localStorage.getItem('openMain') == 'voucher') {
				$("li#voucher").children('ul.submenu').removeAttr('style');
				$("li#po").children('ul.submenu').attr('style','display: none');
			} else {
				$("li#voucher").children('ul.submenu').attr('style','display: none');
				$("li#po").children('ul.submenu').attr('style','display: none');
			}
			$("#po").click(function() {
				localStorage.setItem('openMain','po');
			});
			$("#voucher").click(function() {
				localStorage.setItem('openMain','voucher');
			});
			$("#memo,#leave,#payroll,#profile").click(function() {
				localStorage.setItem('openMain','nosub');
			});
		});
	</script>

        