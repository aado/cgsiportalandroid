
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
</body>
<style>
	.navbar {
		position: fixed !important;
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		justify-content: space-between;
		padding-top: .5rem;
		padding-bottom: .5rem;
		width: 100%;
	}
</style>
	<!-- Page Wrapper -->
	<div id="wrapper">
        
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow" style="height: 85px;z-index: 99999;">
			<!-- <h4 class="h4 mb-4" style="margin-top: 15px;"><?= ($page['title'] ?? 'Undefined'); ?></h4> -->

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop2" class="btn btn-link d-md-none rounded-circle mr-3">
                    <!-- <i class="fa fa-bars"></i> -->
					<img class="img-profile" style="width: 72px;height: 69px;margin-top: -7px;margin-left: -21px;" src="<?= site_url('public/img/cgsi.png'); ?>">
                </button>

                <!-- Topbar Navbar -->
				<!-- style="padding-right: 250px;" -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div style="margin-left: 15px; margin-bottom: 10px">
								<div id="userInfo" style="margin-right: 19px;margin-top: 0px;">
									<!-- <span class="capitalize" style="text-transform: Capitalize;font-size: 12px;font-weight: bold;color: #fff;"><?= ( $fullname ?? 'Guest'); ?></span> -->

									<!-- <span style="font-size: 0.6em; display: block; color: #fff"><?= $designation; ?></span> -->
									<!-- <span style="font-size: 0.6em; display: block;"><?= $departmentname; ?></span> -->
								</div>
							</div>
							<div>
								<?php
									// $image_url = site_url('public/img/idpicture/'.$idnumber.'.jpg');
									// $image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
									// if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
									// 	$empimage = site_url('public/img/idpicture/noimage.jpg');
									// } else {
									// 	$empimage = site_url('public/img/idpicture/'.$idnumber.'.jpg');
									// }
								?>
								<!-- <img class="img-profile rounded-circle" style="width: 40px;float: left;height: 40px;margin-top: -10px;" src="<?= $empimage ?>"> -->
							</div>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php //= ($username ?? 'Guest'); ?>
                                <?php
                                    //($username ?? 'Guest'); 
                                ?>
                            </span>
                        </a>
                        <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            
                            <a class="dropdown-item" href="<?= site_url('logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div> -->
                    </li>

                </ul>

            </nav>
    <!-- End of Topbar -->
	<script>
		$(document).ready(function(){
		});
	</script>

        