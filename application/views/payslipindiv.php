<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style>
	div.payslipBody{
		margin: 4px, 4px;
		padding: 4px;
		/* background-color: #08c708; */
		width: 1095px;
		overflow-x: auto;
		overflow-y: hidden;
		white-space: nowrap;
	}
	.payslipHeader {
		margin-left: -20px;
		font-family: math;
		font-weight: bold;
		font-size: 20px;
	}
	.netPay {
		width: 31%;
		margin-right: 7%;
		float: right;
		margin-top: -23px;
		font-weight: bold;
	}
	.billicon{
		margin-left: 230px;
		font-size: 20px;
		color: blue;"
	}
	.pc {
		visibility: visible;
		margin-bottom: -85px;
	}
	.mobile {
		visibility: hidden;
	}
	@media only screen and (max-device-width: 480px) {

      	.netPaylbl{
			position: absolute;
			padding-top: 48px;
			padding-bottom: 20px;
			margin-left: -164px;
		}
		.billicon{
			margin-left: 82px !important;
			font-size: 20px;
			color: blue;
			margin-top: 49px !important;
		}

		.payslipHeader {
			margin-left: 0px;
			font-family: math;
			font-weight: bold;
			font-size: 20px;
		}

		.pc {
			visibility: hidden;
		}

		.mobile {
			visibility: visible;
			margin-top: -75%;
		}

		.billiconMob {
			font-size: 20px;
			color: red;
			margin-left: 81px !important;
			margin-top: 48px;
		}

		.netPayVal {
			margin-left: 0px !important;
			font-weight: bold;
			padding: 8px;
			position: absolute;
			padding-top: 47px !important;
		}

    }
	
	#deductions {
		font-size: 10px;
		float: right;
		margin-top: -290px;
		margin-right: 0px;
		width: 334px;
	}
	.gPay {
		font-size: 12px;
		width: 874px;
		font-weight: bold;
		margin-top: 5px;
		margin-left: 0px;
		padding-bottom: 52px;
	}
	.addPay {
		font-size: 10px;
		width: 874px;
		float: left;
		margin-top: -40px;
	}
	.addPay .row {
		margin-left: 0px;
	}

	#showPayslip {
		font-size: 18px;
		float: right;
		margin-top: -20px;
		color: fuchsia; 
		cursor: pointer;
	}
	.card-body {
		flex: 1 1 auto;
		padding: 1rem 1rem;
		text-align: center;
	}
	.verificationLogo {
		width: 86px;
		height: 79px;
		margin-top: 5px;
		display: block;
		margin-left: 35%;
	}
	em#otp-error {
		margin-top: 7px !important;
		position: absolute;
		left: 10px;
	}
	.sidebar-dark .nav-item .nav-link {
		/* color: #f8f9fa; */
		font-weight: 600 !important;
	}
	.vercard {
		width: 100%!important;
    	top: 90px;
    }
    @media (min-width:480px)  { 
        /* smartphones, Android phones, landscape iPhone */ 
        .vercard {
			width: 25%!important; margin-left: 35%; top: 90px;
        }
    }
   
</style>
<?php if(!$verified['otp_verified']) { ?>
<div class="container-fluid" id="otPContainer">
	<div class="card w-50 vercard">
	<div class="card-body">
		<p class="card-text" style="font-weight: bold;font-size: 20px;">
			Verification</p>
			
		<form id="frmOTP">
			<input type="hidden" name="idnumber" id="idnumber" value="<?=$idnumber?>">
			<p class="card-text">You will get an Verification Code Via Email</p>
			<p class="card-text"><input type="text" name="otp" id="otp" class="form-control text-center" style="font-size:30px"></p>
			<span style="display: block;font-size: 12px;padding: 14px;" id="timerLabel">Expire at: <span class="otpcount"></span></span>
			<span id="res_message" style="display: block; margin-bottom: 10px;"></span>
			<button type="button" class="btn btn-danger" style="display: none" id="resendVerif"><i class="fa fa-refresh" aria-hidden="true"></i> Resend OTP</button>
			<button type="submit" class="btn btn-primary w-50" id="verify"><i class="fa fa-check" aria-hidden="true"></i> Verify</button>
		</form>
	</div>
	</div>
</div>
<?php } ?>
<?php if($verified['otp_verified']) { ?>
<div class="container-fluid" id="paySlipContainer">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<!-- <hr /> -->
	<div style="margin-top: 65px">
		<table id="tblPayslip" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Payroll Period</th>
					<th>Payroll Cut off</th>
					<th>Uploaded Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($payslipList as $payslip) {
						echo '<tr>';
							echo '<td>'.$payslip['payroll_period'].'</td>';
							echo '<td>'.$payslip['payroll_cutoff'].'</td>';
							echo '<td>'.$payslip['created'].'</td>';
							echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#payslipViewModal" onclick="viewPayslip('.$payslip['payslip_id'].','.$idnumber.')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button></td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="payslipViewModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-body" id="payslipMainContainer" style="font-size: 1px">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="row" style="margin-left: 35%;margin-top:-10px">
						<div class="col-sm">
							<span class="payslipHeader">CEBU GENERAL SERVICES, INC.</span>				
							<span style="font-size: 11px;display: block;">RKD BLDG., A.S FORTUNA ST., BANILAD, MANDAUE CITY	</span>
						</div>
					</div>	
					<div class="container" style="margin-top: 10px;">
						<table class="pc" style="font-size: 13px; width:100%">
							<tr>
								<td>ID NO</td>
								<td style="font-weight: bold;"><?php echo $idnumber; ?></td>
								<td>ACCT. NO.</td>
								<td><span id="accntNum" style="font-weight: bold;"></span></td>
								<td>PAY PERIOD</td>
								<td><span id="pcutofflbl" style="font-weight: bold;"></span></td>
							</tr>
							<tr>
								<td>NAME</td>
								<td style="font-weight: bold;"><?php echo strtoupper($fullname); ?><span style="display: block;font-size: 10px;"><label id="jobDescription">0</label></span></td>
								<td>TIN</td>
								<td></td>
							</tr>
						</table>

						<table class="mobile" style="font-size: 13px; width:100%">
							<tr>
								<td>ID NO</td>
								<td style="font-weight: bold;"><?php echo $idnumber; ?></td>
								<td>ACCT. NO.</td>
								<td><span id="accntNum2" style="font-weight: bold;"></span></td>
							</tr>
							<tr>
								<td>NAME</td>
								<td style="font-weight: bold;"><?php echo strtoupper($fullname); ?><span style="display: block;font-size: 10px;"><label id="jobDescription2"></label></span></td>
								<td>TIN</td>
								<td></td>
							</tr>
							<tr>
								<td>PAY PERIOD</td>
								<td><span id="pcutofflbl2" style="font-weight: bold;"></span></td>
							</tr>
						</table>
						
						<i class="fa fa-arrow-down" aria-hidden="true" id="showPayslip"></i>
					</div>
					<div id="payslipContainer" style="display: none">
						<div class="payslipBody" style="margin-left: 10px; margin-top: 10px">
							<table style="font-size:10px; width:70%">
								<thead>
									<th>BASIC EARNINGS</th>
									<th></th>
									<th>RATE</th>
									<th>AMOUNT</th>
									<th></th>
									<th>ADJUSTMENT</th>
									<th></th>
								</thead>
								<tbody>
									<tr>
										<td>Reg Days work</td>
										<td><span id="regDays"></span></td>
										<td>
											<i class="fa fa-money-bill" style="margin-left: 0px;color: blue;" aria-hidden="true" onclick="showbasicRate(this)"></i>
											<span>
											<!-- <span style="position: absolute;"></span> -->
											<span style="display: none; cursor: pointer" id="basicRate"></span></span>
										</td>
										<td>
											<span style="display: none; cursor: pointer" id="basicPay"></span><i class="fa fa-money-bill" style="margin-left: 0px;color: blue;" aria-hidden="true" 
									onclick="showbasicPay(this)"></i></span>
											<!-- <span ></span> -->
										</td>
										<td><span id="regDays2"></span></td>
										<td style="width: 80px;"><span id="adjustment1">#####</span></td>
										<td><span id="ADJUSTMENTAMT">0</span></td>
									</tr>
									<tr>
										<td>Reg Overtime</td>
										<td><span id="regOT"></span></td>
										<td><span id="otRate"></span></td>
										<td><span id="regOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment2">2</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Sun Duty</td>
										<td><span id="sunDuty"></span></td>
										<td><span id="sunDRate"></span></td>
										<td><span id="SUNDUTYAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment3">3</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Sun OT</td>
										<td><span id="SUNOT"></span></td>
										<td><span id="sunDOTRate"></span></td>
										<td><span id="SUNOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment4">4</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal Duty</td>
										<td><span id="SUNLEGALDUTY"></span></td>
										<td><span id="sunLRate"></span></td>
										<td><span id="SUNLEGALAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment5">5</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal OT</td>
										<td><span id="SUNLEGALOT"></span></td>
										<td><span id="sunLOTRate"></span></td>
										<td><span id="SUNLEGALOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment6">6</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Spl Duty</td>
										<td><span id="SPECIALDUTY"></span></td>
										<td><span id="splDutyRate"></span></td>
										<td><span id="SPLDUTYAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment7">7</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Spl OT</td>
										<td><span id="SPECIALOT"></span></td>
										<td><span id="splDutyOTRate"></span></td>
										<td><span id="SPLOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment8">8</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>RATE ADJ</td>
										<td>0</td>
										<td><span id="ADJUSTMENT"></span></td>
										<td>-</td>
										<td>0</td>
										<td><span id="adjustment9">9</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr>
									<tr>
										<td>Spl Sun OT</td>
										<td><span id="SPLSUNOT"></span></td>
										<td><span id="splSunOtRate"></span></td>
										<td><span id="SPLSUNOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment10">10</span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>Legal Duty</td>
										<td><span id="LEGALHOLDUTY"></span></td>
										<td><span id="LEGALDUTY"></span></td>
										<td><span id="LEGALHOLDUTYAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment11">11</span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOT"></span></td>
										<td><span id="legHolyOTRate"></span></td>
										<td><span id="LEGALHOLOTAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment12">12</span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td></td>
										<td><span id="LEGALPAYBDAYPAY"></span></td>
										<td>0</td>
										<td>0</td>
										<td><span id="adjustment13"></span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>Night Premium</td>
										<td><span id="NP"></span></td>
										<td><span id="NPRATE"></span></td>
										<td><span id="NPAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment14">14</span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>Late</td>
										<td><span id="late"></span></td>
										<td><span id="lateRate"></span></td>
										<td><span id="LATEAMT"></span></td>
										<td>0</td>
										<td><span id="adjustment15"></span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIME"></span></td>
										<td><span id="ABSENTRATE"></span></td>
										<td><span id="ABSAMOUNT"></span></td>
										<td>0</td>
										<td><span id="adjustment16">-</span></td>
										<td><span id="adjustment10">0</span></td>
									</tr>
								</tbody>
							</table>
							<table id="deductions"></table>
						</div>
						<div class="container gPay">
							<div class="row">
								<div class="col">
								Gross Pay
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; display: none; cursor: pointer" id="grossPay"></span><i class="fa fa-money-bill" style="margin-left: 80px;font-size: 20px;color: blue;" aria-hidden="true" onclick="showGrossPay(this)"></i></span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									Prev. Gross Pay
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; display: none; cursor: pointer" id="prevGrossPay"></span><i class="fa fa-money-bill" style="margin-left: 80px;font-size: 20px;color: blue;" aria-hidden="true" onclick="showPrevGrossPay(this)"></i></span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									Monthly Gross Pay
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; display: none; cursor: pointer" id="monthlyGrossPay"></span><i class="fa fa-money-bill" style="margin-left: 80px;font-size: 20px;color: blue;" aria-hidden="true" onclick="showmonthlyGrossPay(this)"></i></span>
								</div>
							</div>
						</div>
						
						<div class="container addPay">
							ADD
							<div class="row">
								<div class="col">
									 MEAL ALLOW
								</div>
								<div class="col">
									<span id="mealallow">0</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									MOTOR RENTAL/ALLOW
								</div>
								<div class="col">
									<span  id="motorental">0</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									13 MONTH ADJUSTMENT
								</div>
								<div class="col">
									<span  id="monthlyGrossPay">0</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									VL AMOUNT
								</div>
								<div class="col">
									<span  id="">0</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									VACCINE PAY
								</div>
								<div class="col">
									<span>0</span>
								</div>
							</div>
						</div>
						<div class="netPay">

							<div class="row" style="font-size:14px">
								<div class="col">
									<span>
										<span class="netPaylbl">NET PAY</span><span style="margin-left: 10%; font-weight: bold; display: none; cursor: pointer" id="NETPAY"></span><i class="fa fa-money-bill billicon" aria-hidden="true" onclick="showNetPay(this)"></i>
									</span>
								</div>
							</div>
						</div>
						<div style="position: absolute;right: 11px;bottom: 10px;width: 18px;">
							<div class="row" style="font-size:14px">
								<i class="fa fa-print" style="font-size: x-large;color: darkslategrey;" aria-hidden="true" onclick="printPayslip()" ></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- /.container-fluid -->
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-base64@2.5.2/base64.min.js"></script>
<?php //$email?>
<script type="text/javascript"src="https://cdn.jsdelivr.net/npm/emailjs-com@2.4.0/dist/email.min.js"></script>
<script type="text/javascript"src="https://jasonday.github.io/printThis/printThis.js"></script>
<script src="<?= site_url('public/js/payslip_indiv.js'); ?>"></script>
<script type="text/javascript">
   (function(){
	var verified = <?php echo $verified['otp_verified'] ?>;

	if ( !verified) {

      emailjs.init("DZH4JYcAeKKA1dWFS"); //use your USER ID
		var otp = '<?php echo $FourDigitRandomNumber = rand(1231,7879) ?>';
		<?php date_default_timezone_set('Asia/Manila'); ?>
		var date = '<?php echo date('d F Y, h:i:s A') ?>';
		var templateParams = {
			otp: otp,
			date: date,
			to_email: '<?php echo $email; ?>'
		};

		var idnumber = '<?=$idnumber?>';

		$.ajax({
			url: 'sendVerifCode',
			type: 'POST',
			data: {code: otp, empid:idnumber},
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
			}
		});
 
		emailjs.send('service_7iwy1pf', 'template_2pbz0mo', templateParams) //use your Service ID and Template ID
		.then(function(response) {
			console.log('SUCCESS!', response.status, response.text);
		}, function(error) {
			console.log('FAILED...', error);
		});

	}

   })();

   function printPayslip() {
		$('#payslipMainContainer').printThis();
   }
</script>
