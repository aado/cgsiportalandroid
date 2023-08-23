<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

*{
  list-style: none;
  text-decoration: none;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Open Sans', sans-serif;
}

body{
  background: #f5f6fa;
}

.wrapper .sidebar{
  background: rgb(5, 68, 104);
  position: fixed;
  top: 0;
  left: 0;
  width: 225px;
  height: 100%;
  padding: 20px 0;
  transition: all 0.5s ease;
}

.wrapper .sidebar .profile{
  margin-bottom: 30px;
  text-align: center;
}

.wrapper .sidebar .profile img{
  display: block;
  width: 100px;
  height: 100px;
    border-radius: 50%;
  margin: 0 auto;
}

.wrapper .sidebar .profile h3{
  color: #ffffff;
  margin: 10px 0 5px;
}

.wrapper .sidebar .profile p{
  color: rgb(206, 240, 253);
  font-size: 14px;
}

.wrapper .sidebar ul li a{
  display: block;
  padding: 13px 30px;
  border-bottom: 1px solid #10558d;
  color: rgb(241, 237, 237);
  font-size: 16px;
  position: relative;
}

.wrapper .sidebar ul li a .icon{
  color: #dee4ec;
  width: 30px;
  display: inline-block;
}

 

.wrapper .sidebar ul li a:hover,
.wrapper .sidebar ul li a.active{
  color: #0c7db1;

  background:white;
    border-right: 2px solid rgb(5, 68, 104);
}

.wrapper .sidebar ul li a:hover .icon,
.wrapper .sidebar ul li a.active .icon{
  color: #0c7db1;
}

.wrapper .sidebar ul li a:hover:before,
.wrapper .sidebar ul li a.active:before{
  display: block;
}

.wrapper .section{
  width: calc(100% - 225px);
  margin-left: 225px;
  transition: all 0.5s ease;
}

.wrapper .section .top_navbar{
  background: rgb(7, 105, 185);
  height: 50px;
  display: flex;
  align-items: center;
  padding: 0 30px;
 
}

.wrapper .section .top_navbar .hamburger a{
  font-size: 28px;
  color: #f4fbff;
}

.wrapper .section .top_navbar .hamburger a:hover{
  color: #a2ecff;
}

 .wrapper .section .container{
  margin: 30px;
  background: #fff;
  padding: 50px;
  line-height: 28px;
}

body.active .wrapper .sidebar{
  left: -225px;
}

body.active .wrapper .section{
  margin-left: 0;
  width: 100%;
}
		</style>
   
    <div class="wrapper">
       <div class="section">
    <div class="top_navbar">
      <div class="hamburger">
        <a href="#">
          <i class="fas fa-bars"></i>
        </a>
      </div>
    </div>
    <div class="container" style="margin-left: 0px;margin-top: 0px;">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div>
        <div class="sidebar">
            <div class="profile">
                <img src="https://1.bp.blogspot.com/-vhmWFWO2r8U/YLjr2A57toI/AAAAAAAACO4/0GBonlEZPmAiQW4uvkCTm5LvlJVd_-l_wCNcBGAsYHQ/s16000/team-1-2.jpg" alt="profile_picture">
                <h3><?= ( $fullname ?? 'Guest'); ?></h3>
                <p><?= $designation; ?></p>
            </div>
            <ul style="margin-left: -31px;">
                <li>
                    <a href="#" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-desktop"></i></span>
                        <span class="item">My Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-user-friends"></i></span>
                        <span class="item">Payslip</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="item">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        
    </div>
 
</body>
</html>





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
  <!-- <link  href="<?= site_url('public/img/cgsi.png'); ?>" rel="apple-touch-icon"> -->

	<title>CGSI Portal - <?= ($page['title'] ?? 'Undefined'); ?></title>

	<!-- Custom fonts for this template-->
	<link href="<?= site_url('public/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" rel="stylesheet"> -->

	<!-- Custom styles for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="<?= site_url('public/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <!-- <link href="<?= site_url('public/vendor/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet"> -->
    <!-- <link href="<?= site_url('public/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet"> -->
	<link href="<?= site_url('public/css/style.css'); ?>" rel="stylesheet">

	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->

	<link href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css" rel="stylesheet">
	<!-- <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> -->
	<!-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> -->
	<!-- <link href="<?= site_url('public/css/adminlte.min.css'); ?>" rel="stylesheet"> -->
	<link href="<?= site_url('public/css/style.css'); ?>" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

	<script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.3/jquery.datetimepicker.css" rel="stylesheet"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.3/build/jquery.datetimepicker.full.js"></script> -->

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
<header class="mdc-top-app-bar">
  <div class="mdc-top-app-bar__row">
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
      <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" aria-label="Open navigation menu">menu</button>
      <span class="mdc-top-app-bar__title">Page title</span>
    </section>
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
      <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button" aria-label="Favorite">favorite</button>
      <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button" aria-label="Search">search</button>
      <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button" aria-label="Options">more_vert</button>
    </section>
  </div>
</header>
<main class="mdc-top-app-bar--fixed-adjust">
  App content
</main>
<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url(); ?>">
				<div class="sidebar-brand-icon">
					<!-- <i class="fas fa-code"></i> -->
					<img class="img-profile" style="width: 86px;height: 79px;margin-top: 40px;" src="<?= site_url('public/img/cgsi.png'); ?>">
				</div>
			</a>
			<hr class="sidebar-divider" style="margin-top: 45px;">

			<!-- Heading -->
			<div class="sidebar-heading" style="font-size: 15px;">
				Menu
			</div>
			<?php //echo phpinfo(); ?>
			<!-- Nav Item - Homepages -->
			<!-- <li class="nav-item">
				<?php
					$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
					$pathFragments = explode('/', $path);
					$end = end($pathFragments);
				?>
				<a class="nav-link <?php echo ($end == '')? 'active_link' : 'pb-0'?>" href="<?= site_url(); ?>">
					<i class="fas fa-fw fa-tachometer-alt" style="color:#4bc9e7"></i>
					<span>Dashboard</span>
				</a>
			</li> -->

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
						<i class="fa fa-money" style="color:#10c4a5"></i>
						<span>Payslip</span>
					</a>
				</li>
			<?php } ?>

			<!-- <li class="nav-item">
				<a class="nav-link <?php echo ($end == 'Timekeeping')? 'active_link' : 'pb-0'?>" href="<?= site_url('/Timekeeping'); ?>">
					<i class="fas fa-clock" style="color:#10c4a5"></i>
					<span>Timekeeping</span>
				</a>
			</li> -->
			

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
			<?//= print_r($user) ?>
            <!-- Topbar -->
			<!-- style="height: 45px;
				width: 100%;
				z-index: 999;
			" -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
			<!-- <h4 class="h4 mb-4" style="margin-top: 15px;"><?= ($page['title'] ?? 'Undefined'); ?></h4> -->

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
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
  var hamburger = document.querySelector(".hamburger");
  hamburger.addEventListener("click", function(){
    document.querySelector("body").classList.toggle("active");
  })
			
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

        