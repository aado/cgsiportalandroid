	<!-- Begin Page Content -->

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->


	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1> -->

	
		<style>
			/* body {
  background: url('https://images.unsplash.com/photo-1420496368970-d83b063b5b48?fit=crop&fm=jpg&h=700&q=80&w=1225') no-repeat center center;
  background-size: 1400px 700px;
  background-position: 30%;
  background-attachment: fixed;
} */


.text {
  font-family: sans-serif;
  font-size: 40px;
  position: absolute center;
  text-align: center;
  padding-left: 0%;
  color: #906be7;
  margin-top: 43px;
}

.text1 {
  font-family: sans-serif;
  font-size: 21px;
  text-align: center;
  margin-top: -20px;
  color: #000;
}

<?php
	$image_url = site_url('public/img/idpicture/'.$idnumber.'.jpg');
	$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
	if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
		$empimage = site_url('public/img/idpicture/noimage.jpg');
	} else {
		$empimage = site_url('public/img/idpicture/'.$idnumber.'.jpg');
	}
?>

.image {
  text-align: center;
  width: 200px;
  /* Container's dimensions */
  
  height: 200px;
  -webkit-border-radius: 75%;
  -moz-border-radius: 75%;
  box-shadow: 0 0 0 1px #eee;
  background: url("<?php echo $empimage ?>") center center no-repeat;
  background-size: cover;
  margin: auto;
  margin-top: 20px;
  margin-bottom: -30px;
  align-content: center;
}



.trick {
  display: inline-block;
  vertical-align: middle;
  height: 150px;
}

.image:hover {
  box-shadow: 0px 5px 20px .9px #3F3F3F;
}

.image:hover {
  -webkit-transform: scale(1.12);
  transform: scale(1.12);
  -webkit-transition: 1.6s ease-in-out;
  transition: 1.6s ease-in-out;
}



.trick:hover img {
  -webkit-transform: scale(1);
  transform: scale(1);
}

#overlay {
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  padding: 0 0 0 0;
  opacity: 1.0;
  -webkit-transition: opacity 2.25s ease;
  -moz-transition: opacity 10.25s ease;
}

#box:hover #overlay {
  opacity: 1;
}





.panel-group{
  width:350px;
  margin:auto;
  /*margin:50px 400px 50px 400px;*/
  max-width:100%;
}

.panel-heading{
  background-color:transparent !important;
}

.title{
  text-align: center;
  background-color:transparent;
  color:#000;
  font-family:sans-serif;
  font-weight:300;
  font-size:15px;
  max-width:100%;
}




#accordion{
  background-color: transparent;
  max-width:100%;
  margin-bottom:200px;
}







.btn-outline {
  color: inherit;
  transition: all 1.4s;
  background-color: transparent;
}
/* button CSS */

.btn-danger.btn-outline {
  margin-top: 9px;
  background-color: transparent;
  color: #000;
  border-color: #000;
  padding:auto;
  padding:10px 0px 10px 0px;
  margin: 1px 5px 1px 0px;
  width: 100%;
  text-align:center;
  font-family: sans-serif;
  font-weight: 300;
  max-width:100%;
}


















/*---------    Contact Form    ------------*/

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
  color: #000;
  font-size: 15px;
}
/* on hover placeholder */

input:hover::-webkit-input-placeholder,
textarea:hover::-webkit-input-placeholder {
  color: #fff;
  font-size: 15px;
  font-family: sans-serif;
}

input:hover:focus::-webkit-input-placeholder,
textarea:hover:focus::-webkit-input-placeholder {
  color: #fff;
  font-family: sans-serif;
}

input:hover::-moz-placeholder,
textarea:hover::-moz-placeholder {
  color: #fff;
  font-size: 15px;
  font-family: sans-serif;
}

input:hover:focus::-moz-placeholder,
textarea:hover:focus::-moz-placeholder {
  color: #fff;
  font-family: sans-serif;
}

input:hover::placeholder,
textarea:hover::placeholder {
  color: #fff;
  font-size: 15px;
  font-family: sans-serif;
}

input:hover:focus::placeholder,
textarea:hover:focus::placeholder {
  color: #fff;
  font-family: sans-serif;
}

input:hover::placeholder,
textarea:hover::placeholder {
  color: #fff;
  font-size: 15px;
  font-family: sans-serif;
}

input:hover:focus::-ms-placeholder,
textarea:hover::focus:-ms-placeholder {
  color: #fff;
  font-family: sans-serif;
}

#form {
  position: relative;
  width: 100%;
  margin: 0px auto 0px auto;
  font-family: sans-serif;
}

input {
  font-family: sans-serif;
  font-size: 15px;
  width: 100%;
  height: 50px;
  padding: 0px 12px 0px 12px;
  background: transparent;
  outline: none;
  color: #726659;
  border: solid 1px #eee;
  border-bottom: none;
  transition: all 0.9s ease-in-out;
  -webkit-transition: all 0.9s ease-in-out;
  -moz-transition: all 0.9s ease-in-out;
  -ms-transition: all 0.9s ease-in-out;
}

input:hover {
  background: #ccc;
  color: #fff;
  font-family: sans-serif;
}

textarea {
  width: 100%;
  max-width: 100%;
  height: 110px;
  max-height: 110px;
  padding: 15px;
  background: transparent;
  outline: none;
  color: #000;
  font-family: sans-serif;
  font-size: 25px;
  border: solid 1px #eee;
  transition: all 0.9s ease-in-out;
  -webkit-transition: all 0.9s ease-in-out;
  -moz-transition: all 0.9s ease-in-out;
  -ms-transition: all 0.9s ease-in-out;
}

textarea:hover {
  background: #ccc;
  color: #fff;
  font-family: sans-serif;
}

#submit {
  width: 100%;
  padding: 0;
  font-family: sans-serif;
  font-size: 20px;
  color: #000;
  outline: none;
  cursor: pointer;
  border: solid 1px #eee;
  border-top: none;
  margin-bottom: 0px;
}

#submit:hover {
  color: #fff;
  background-color: #ccc;
}

.form {
    display: table;
    border-collapse: collapse;
    padding: 0;
    margin: 0;
}
.form > li {
    display: table-row;
}
.form > li > div {
    display: table-cell;
    padding-bottom: 5px;
}
.form > li > div:first-child {
    padding-right: 10px;
}
			</style>


		<!-- <head> -->

<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->

<!-- <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'> -->
<!-- </head> -->

<div class="box">
  <div id="overlay">
	<div class="image">
	  <div class="trick">

	  </div>
	</div>
	<ul class="text"><?=$fullname?></ul>
	<div class="text1"><?=$departmentname?></div>




<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
  <div class="panel-heading " role="tab" id="headingOne">
	<h4 class="panel-title ">
	  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="" aria-controls="collapseOne">
		<div class="title  btn btn-danger btn-outline btn-lg">INFORMATION</div>
	  </a>
	</h4>
  </div>
  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
	<div class="panel-body">

	<table class="table table-striped">
  <!-- <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead> -->
  <tbody>
    <tr>
      <th scope="row">Full Name</th>
      <td><?=$fullname?></td>
      <!-- <td>Otto</td>
      <td>@mdo</td> -->
    </tr>
    <tr>
      <th scope="row">Employee ID</th>
      <td><?=$idnumber?></td>
      <!-- <td>Thornton</td>
      <td>@fat</td> -->
    </tr>
    <tr>
      <th scope="row">Birth Date</th>
      <td><?=isset($getuserDetails[0]['Birthdate'])? $getuserDetails[0]['Birthdate'] : ''?></td>
      <!-- <td>the Bird</td>
      <td>@twitter</td> -->
    </tr>
	<tr>
      <th scope="row">Contact</th>
      <td><?=isset($getuserDetails[0]['contact_number'])? $getuserDetails[0]['contact_number']: ''?></td>
      <!-- <td>the Bird</td>
      <td>@twitter</td> -->
    </tr>
  </tbody>
</table>

	</div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="headingTwo">
	<h4 class="panel-title">
	  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		<div class="title btn btn-danger btn-outline btn-lg">ACCOUNT</div>
	  </a>
	</h4>
  </div>
  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
	<div class="panel-body">

	<table class="table table-striped">
		<tbody>
			<tr>
			<th scope="row">Department</th>
			<td><?=$departmentname?></td>
			</tr>
			<tr>
			<th scope="row">Designation</th>
			<td><?=$designation?></td>
			</tr>
		</tbody>
	</table>

	</div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="headingThree">
	<h4 class="panel-title">
	  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
		<div class="title btn btn-danger btn-outline btn-lg">CONTACT</div>
	  </a>
	</h4>
  </div>
  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
	<div class="panel-body">

	  
	  
				<form id="form" class="topBefore">

		  <input id="name" type="text" placeholder="NAME">
		  <input id="email" type="text" placeholder="E-MAIL">
		  <textarea id="message" type="text" placeholder="MESSAGE"></textarea>
		  <input id="submit" type="submit" value="Submit Now!">

		</form>


	  
	  
	  
	  
	</div>
  </div>
</div>
</div>


		




		<!-- <div class="card mb-3" style="max-width: 100%;max-height:100%;">
			<div class="row g-0">
				<div class="col-md-6">
					<?php
						// $image_url = site_url('public/img/idpicture/'.$idnumber.'.jpg');
						// $image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
						// if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
						// 	$empimage = site_url('public/img/idpicture/noimage.jpg');
						// } else {
						// 	$empimage = site_url('public/img/idpicture/'.$idnumber.'.jpg');
						// }
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
							</div>
						</div>
						<div class="row" style="margin-top:1%;margin-right:5%;">
							<div class="col">
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
		</div> -->
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