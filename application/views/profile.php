	<!-- Begin Page Content -->

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->


	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>

		<div class="card mb-3" style="max-width: 100%;max-height:100%;">
			<div class="row g-0">
				<div class="col-md-6">
					<?php
						$image_url = site_url('public/img/idpicture/'.$idnumber.'.jpg');
						$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
						if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
							$empimage = site_url('public/img/idpicture/noimage.jpg');
						} else {
							$empimage = site_url('public/img/idpicture/'.$idnumber.'.jpg');
						}
					?>
					<img class="img-profile rounded-circle" style="max-width: 350px;margin-left:100px; margin-top: 60px;margin-bottom: 20px;" src="<?= $empimage ?>">
				</div>
				<div class="col-md-6" style="margin-bottom: 10px">
					<br>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item" role="presentation">
					    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true"> BASIC INFO</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false"> ACCOUNT INFO </button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="changepassword-tab" data-bs-toggle="tab" data-bs-target="#changepassword" type="button" role="tab" aria-controls="changepassword" aria-selected="false"> CHANGE PASSWORD </button>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
					  	<div class="row" style="margin-top:5%;margin-right:5%;">
						<div class="col">
							<label for="formGroupExampleInput2"> Fullname </label>
							<span style="display: block;font-weight: bold; color: blue"><?=$fullname?></span>
						</div>
						<div class="col">
							<label for="formGroupExampleInput2"> Employee ID </label>
							<span style="display: block;font-weight: bold; color: blue"><?=$idnumber?></span>
						</div>
              		</div>
              		<div class="row" style="margin-top:2%;margin-right:5%;">
							<div class="col">
								<label for="formGroupExampleInput2"> Birthdate </label>
								<span style="display: block;font-weight: bold; color: blue"><?=isset($getuserDetails[0]['Birthdate'])? $getuserDetails[0]['Birthdate'] : ''?></span>
							</div>
							<div class="col">
								<label for="formGroupExampleInput2"> Contact </label>
								<span style="display: block;font-weight: bold; color: blue"><?=isset($getuserDetails[0]['contact_number'])? $getuserDetails[0]['contact_number']: ''?></span>
								</div>
							</div>
						<div class="row" style="margin-top:2%;margin-right:5%;">
							<div class="col">
								<label for="formGroupExampleInput2"> Email </label>
								<span style="display: block;font-weight: bold; color: blue"><?=isset($getuserDetails[0]['email'])?$getuserDetails[0]['email']:'' ?></span>
							</div>
							<div class="col">
								<label for="formGroupExampleInput2"> Address </label>
								<span style="display: block;font-weight: bold; color: blue"><?=isset($getuserDetails[0]['address'])? $getuserDetails[0]['address']: ''?></span>
								<!-- <input type="text" class="form-control form-control-sm" id="formGroupExampleInput2"  -->
									<!-- value="<?=($getuserDetails[0]['address']) ?>"> -->
							</div>
						</div>
						<div class="row" style="margin-top:1%;margin-right:5%;">
							<div class="col">
							<!-- <button type="submit" class="btn btn-primary" id="submitBtnInfo"> UPDATE INFO</button> -->
							</div>
						</div>
            		</div>
					  <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
							<div class="row" style="margin-top:5%;margin-right:5%;">
							  <div class="col">
							   	<label for="formGroupExampleInput2"> Department </label>
								<span style="display: block;font-weight: bold; color: blue"><?=$departmentname?></span>
							  </div>
							</div>
							<div class="row" style="margin-top:2%;margin-right:5%;">
							  <div class="col">
							   	<label for="formGroupExampleInput2"> Designation </label>
								<span style="display: block;font-weight: bold; color: blue"><?=$designation?></span>
							  </div>
							</div>
					  </div>
					  <div class="tab-pane fade" id="changepassword" role="tabpanel" aria-labelledby="changepassword-tab" style="background: deepskyblue;padding: 10px;">
						<div class="alert alert-danger" role="alert" style="margin-top: 9px;margin-right: 8px;">
							You are advice to <b>change password</b> on first login. 
						</div>
					  	<form id="changePassword">
					  		<div class="row" style="margin-top:5%;margin-right:5%;">
							  <div class="col">
							    <label for="formGroupExampleInput2"> Username </label>
								<span style="display: block;font-weight: bold; color: blue"><?=$username?></span>
							  </div>
							</div>
							<div class="row" style="margin-top:2%;margin-right:5%;">
							  <div class="col">
							    <label for="formGroupExampleInput2"> New Password </label>
								<input type="hidden" id="idnumber" name="idnumber" value="<?=$idnumber?>">
							   	<input type="password" id="password" name="password" class="form-control form-control-sm" id="formGroupExampleInput2">
							  </div>
							  <div class="col">
							    <label for="formGroupExampleInput2"> Retype-Password </label>
							   	<input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm" id="formGroupExampleInput2">
							  </div>
							</div>
							<div class="row" style="margin-top:1%;margin-right:5%;">
							  <div class="col">
							   <button type="submit" class="btn btn-primary" id="submitBtn"> CHANGE PASSWORD</button>
							  </div>
							</div>
					  	</form>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- /.container-fluid -->
	<script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
	<script>
		function onChange() {
			const password = document.querySelector('input[name=password]');
			const confirm = document.querySelector('input[name=confirm]');
			if (confirm.value === password.value) {
				confirm.setCustomValidity('');
			} else {
				confirm.setCustomValidity('Passwords do not match');
			}
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
	<script src="<?= site_url('public/js/profile.js'); ?>"></script>