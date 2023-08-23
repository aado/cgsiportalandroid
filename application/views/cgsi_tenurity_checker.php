<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PHP Simple Login with CodeIgniter Framework">
    <meta name="author" content="">

    <title>CGSI Portal - <?= ($page['title'] ?? 'Undefined'); ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= site_url('public/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= site_url('public/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body class="">
<canvas style="position: absolute"></canvas>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@2.4.0/dist/email.min.js"></script>
    <div style="padding: 20px">
		<h2>Probationary</h2>
		<p>The below list are employee work on less or equals to 6 months period.</p>            
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Date Hired</th>
					<!-- <th>Months</th> -->
					<th>Confirmed By</th>
				</tr>
			</thead>
			<tbody>
				<?php if($getProbeEmployee) {
					foreach ($getProbeEmployee as $getprobe) {
						if ($getprobe['mFromDhired'] <= 6) {
							echo '<tr><td><span style="display: block;font-weight: bold;color: #0d0d10;">'.$getprobe['firstname'].' '.$getprobe['middlename'].' '.$getprobe['lastname'].'</span><span style="display: block;font-size: 11px;font-weight: bold;color: blue;">'.$getprobe['departmentname'].'</span></td><td> '.date("F d, Y", strtotime($getprobe['date_hired'])).' <span style="display: block;color: forestgreen;font-weight: bold;font-size: 15px;">'.$getprobe['mFromDhired'].' month/s</span></td><td></td></tr>';
							if ($getprobe['mFromDhired'] == '6') { ?>
							<script>
								var data = {
									'emp_id': <?=$getprobe['emp_id']?>,
									'posi_type': <?=$getprobe['position_type']?>,
									'deep_type': <?=$getprobe['emp_department']?>,
									'designationID': <?=$getprobe['emp_designation']?>,
									'department': '<?=$getprobe['departmentname']?>',
									'designation': '<?=$getprobe['designationname']?>'
								}
								$.ajax({
									url: 'getdirecthead',
									type: 'POST',
									data: data,	
									cache: false,
									error: function() {	
										alert('Something is wrong');
									},
									success: function(data) {
										var result = JSON.parse(data);
										if(result['success']) {
											var data = result['data'];
											console.log(data);
											// emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj");
											// var templateParams = {
											// 	to_email: data['email'],
											// 	to_name:'<?=$getprobe['firstname']?>', 
											// 	emp_name:'<?=$getprobe['firstname'].' '.$getprobe['middlename'].' '.$getprobe['lastname']?>'
											// };
											
											// emailjs.send('service_37v4ai9', 'template_191v0e6', templateParams)
											// .then(function(response) {
											// 	console.log('SUCCESS!', response.status, response.text);
											// }, function(error) {
											// 	console.log('FAILED...', error);
											// });
										}
									}
								});
							</script>
						<?php }
						}
					}
				}?>
			</tbody>
		</table>
    </div>

	<script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>			
    <!-- Bootstrap core JavaScript-->
    <script src="<?= site_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= site_url('public/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= site_url('public/js/sb-admin-2.min.js'); ?>"></script>

</body>
</html>