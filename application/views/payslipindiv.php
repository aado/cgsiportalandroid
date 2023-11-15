<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="<?= site_url('public/css/payslip.css'); ?>"> -->

<?php if(!$verified['otp_verified']) { ?>
<div class="container-fluid" id="otPContainer" style="margin-top: 40%;
">
	<div class="card vercard">
	<div class="card-body">
		<p class="card-text text-center" style="font-weight: bold;font-size: 20px;">
			Verification</p>
			
		<form id="frmOTP">
			<input type="hidden" name="idnumber" id="idnumber" value="<?=$idnumber?>">
			<p class="card-text text-center">You will get an Verification Code Via Email</p>
			<p class="card-text"><input type="text" name="otp" id="otp" class="form-control text-center" style="font-size:30px"></p>
			<span style="display: block;font-size: 12px;padding: 14px; text-align:center" id="timerLabel">Expire at: <span class="otpcount"></span></span>
			<span id="res_message" style="display: block; margin-bottom: 10px; text-align: center"></span>
			<button type="button" class="btn btn-danger w-100" style="display: none" id="resendVerif"><i class="fa fa-refresh" aria-hidden="true"></i> Resend OTP</button>
			<button type="submit" class="btn btn-primary w-100" id="verify"><i class="fa fa-check" aria-hidden="true"></i> Verify</button>
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
		<table id="paySlipTable" class="table" style="width:100%">
			<thead style="opacity: .5; font-size: 20px; color: dodgerblue">
				<tr>
					<th>Period</th>
					<th style="text-align: center">View</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($payslipList as $payslip) {
						if ($payslip['published'] == 1) {
							echo '<tr>';
							echo '<td><span style="color: cornflowerblue;">'.date('M d Y', strtotime($payslip['payroll_period'])).'</span><span style="font-size: 10px;
                            opacity: .5; display: block">Cut-off: '.$payslip['payroll_cutoff'].'</span></td>';
							if($payslip['payroll_period'] == '2023-10-20') {
								echo '<td style="text-align: center"><button class="btn btn-primary" data-toggle="modal" onclick="showPayslipWithAdj('.$payslip['payslip_id'].','.$idnumber.')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button><span style="font-size: 10px;
                                opacity: .5; display: block">Up: '.date('M d Y', strtotime($payslip['created'])).'</span></td>';
							} else {
								echo '<td style="text-align: center"><button class="btn btn-primary" data-toggle="modal" onclick="showPayslip('.$payslip['payslip_id'].','.$idnumber.')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button><span style="font-size: 10px;
                                opacity: .5; display: block">Up: '.date('M d Y', strtotime($payslip['created'])).'</span></td>';
							}
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
		<span style="text-decoration: underline;color: blue;cursor: pointer;font-weight: 800; display: none; margin-left: 25px;position: absolute;right: 15px;margin-top: 8px;font-size: 20px;" id="showPayrollbtn" onclick="showPayslipBtn()"><i class="fa fa-arrow-left" aria-hidden="true"></i> </span>				
		<div id="paySlipDiv" style="display: none; margin-top: 15px;margin-bottom: 23px;">
					<div class="container" style="margin-top: 10px;">
						<table class="table table-borderless" style="font-size: 13px; width:100%">
							<tr>
								<td>NAME</td>
								<td style="font-weight: bold;"><span id="empName" style="font-size: 15px"></span><span style="display: block;font-size: 10px;" id="jobDescription"></span><span id="idNumber" style="font-size: 11px"></span><span id="tinno" style="font-weight: bold;"></span></td>
							</tr>
							<tr>
								<td>ACOUNT NUMBER</td>
								<td style="font-weight: bold;"><span id="accntNum" style="font-weight: bold;"></span></td>
							</tr>
							<tr>
								<td>PERIOD</td>
								<td style="font-weight: bold;"><span id="payPeriod" style="font-weight: bold;"></span><span style="display: block;font-size: 10px;" id="pcutofflbl"></span></td>
							</tr>
							
						</table>
					</div>
					<div id="payslipContainer">

					<style>
						a:hover,a:focus{
							text-decoration: none;
							outline: none;
						}
						#accordion .panel{
							border: none;
							border-radius: 0;
							box-shadow: none;
							margin: 0 0 10px;
							overflow: hidden;
							position: relative;
						}
						#accordion .panel-heading{
							padding: 0;
							border: none;
							border-radius: 0;
							margin-bottom: 10px;
							z-index: 1;
							position: relative;
						}
						#accordion .panel-heading:before,
						#accordion .panel-heading:after{
							content: "";
							width: 50%;
							height: 20%;
							box-shadow: 0 15px 5px rgba(0, 0, 0, 0.4);
							position: absolute;
							bottom: 15px;
							left: 10px;
							transform: rotate(-3deg);
							z-index: -1;
						}
						#accordion .panel-heading:after{
							left: auto;
							right: 10px;
							transform: rotate(3deg);
						}
						#accordion .panel-title a{
							display: block;
							padding: 15px 70px 15px 70px;
							margin: 0;
							background: #fff;
							font-size: 13px;
							font-weight: 700;
							letter-spacing: 1px;
							/* color: #d11149; */
							border-radius: 0;
							box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1), 0 0 40px rgba(0, 0, 0, 0.1) inset;
							position: relative;
							text-decoration: none
						}
						#accordion .panel-title a:before,
						#accordion .panel-title a.collapsed:before{
							content: "\f106";
							font-family: "Font Awesome 5 Free";
							font-weight: 900;
							width: 55px;
							height: 100%;
							text-align: center;
							line-height: 50px;
							/* border-left: 2px solid #D11149; */
							position: absolute;
							top: 0;
							right: 0;
						}
						#accordion .panel-title a.collapsed:before{ content: "\f107"; }
						#accordion .panel-title a .icon{
							display: inline-block;
							width: 55px;
							height: 100%;
							/* border-right: 2px solid #d11149; */
							font-size: 20px;
							/* color: rgba(0,0,0,0.7); */
							line-height: 50px;
							text-align: center;
							position: absolute;
							top: 0;
							left: 0;
						}
						#accordion .panel-body{
							padding: 10px 20px;
							margin: 0 0 20px;
							/* border-bottom: 3px solid #d11149; */
							border-top: none;
							background: #fff;
							font-size: 15px;
							color: #333;
							line-height: 27px;
						}

					</style>

					<div class="">
							<div class="row">
								<div class="col-md-6">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														<i class="icon fa fa-globe"></i>
														BASIC EARNINGS
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in shadow" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body">
													<p class="row">
													<div style="margin-top: 10px">
													<span  style="font-size: 13px;font-weight: bold;color: blue;" id="newRatelbl">NEW RATE</span>
														<table style="font-size:14px;" class="table table-borderless">
															<thead>
																<th>EARNINGS<span style="display: block;font-size: 10px;color: blue;">NO</span><span style="display: block;font-size: 10px;color: blue;">ADJ NO</span></th>
																<!-- <th></th> -->
																<th>RATE<span style="display: block;font-size: 10px;color: blue;">AMOUNT</span><span style="display: block;font-size: 10px;color: blue;">ADJ AMT</span></th>
																<!-- <th>AMOUNT</th>
																<th></th>
																<th>ADJUSTMENT</th>
																<th></th> -->
															</thead>
															<tbody>
																<tr>
																	<td>Reg Days work <span id="regDays"  style="display: block;color: blue; font-size: smaller;"></span><span id="regDays2" style="display: block; font-size: smaller; color: blue"></span></td>
																	<!-- <td></td> -->
																	<td>
																		<span style="cursor: pointer" id="basicRate"></span><span id="basicPay" style="display: block;color: blue;font-size: smaller;"></span><span id="regDaysrate" style="display: block;"></span><span id="ADJUSTMENTAMT"  style="display: block;color: blue; font-size: smaller">0</span></span>
																	</td>
																	<!-- <td>
																		<span id="basicPay"></span>
																	</td>
																	<td><span id="regDays2" style="display: block; font-size: smaller;"></span></td>
																	<td style="width: 80px;"><span id="regDaysrate"></span><span id="ADJUSTMENTAMT">0</span></td>
																	<!-- <td><span id="ADJUSTMENTAMT">0</span></td> -->
																</tr>
																<tr>
																	<td>Reg Overtime<span id="regOT" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="regOT">0</span></td> -->
																	<td><span id="otRate"></span><span id="regOTAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="regOTAMT"></span></td>
																	<td><span id="regOT1">0</span></td>
																	<td><span id="regOTrate_1"></span></td>
																	<td><span id="regOTAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Duty<span id="sunDuty" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="sunDuty"></span></td> -->
																	<td><span id="sunDRate"></span><span id="SUNDUTYAMT" style="display: block;color: blue;font-size: smaller;">0</span></td>
																	<!-- <td><span id="SUNDUTYAMT">0</span></td>
																	<td><span id="sunDuty1">0</span></td>
																	<td><span id="sunDutyrate_1">3</span></td>
																	<td><span id="SUNDUTYAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun OT<span id="SUNOT" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="SUNOT"></span></td> -->
																	<td><span id="sunDOTRate"></span><span id="SUNOTAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SUNOTAMT"></span></td>
																	<td><span id="SUNOT1">0</span></td>
																	<td><span id="SUNOTRate2">4</span></td>
																	<td><span id="SUNOTAMOUNT">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Legal Duty<span id="SUNLEGALDUTY" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SUNLEGALDUTY">0</span></td> -->
																	<td><span id="sunLRate"></span><span id="SUNLEGALAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SUNLEGALAMT"></span></td>
																	<td><span id="SUNLEGALDUTY1">0</td>
																	<td><span id="sunLRate_1">0</span></td>
																	<td><span id="SUNLEGALAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Legal OT<span id="SUNLEGALOT" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SUNLEGALOT">0</span></td> -->
																	<td><span id="sunLOTRate"></span><span id="SUNLEGALOTAMT" style="display: block;color: blue;font-size: smaller;">0.00</span></td>
																	<!-- <td><span id="SUNLEGALOTAMT">0.00</span></td>
																	<td><span id="SUNLEGALOT_1">0</td>
																	<td><span id="SUNLEGALOTrate_1"></span></td>
																	<td><span id="SUNLEGALOTAMT_1"></span></td> -->
																</tr>
																<tr>
																	<td>Spl Duty<span id="SPECIALDUTY" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPECIALDUTY">0</span></td> -->
																	<td><span id="splDutyRate"></span><span id="SPLDUTYAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLDUTYAMT"></span></td>
																	<td><span id="SPECIALDUTY_1">0</span></td>
																	<td><span id="splDutyRate_1">7</span></td>
																	<td><span id="SPLDUTYAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>Spl OT<span id="SPECIALOT" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPECIALOT">0</span></td> -->
																	<td><span id="splDutyOTRate"></span><span id="SPLOTAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLOTAMT"></span></td>
																	<td><span id="SPECIALOT_1">0</span></td>
																	<td><span id="splDutyOTRate_1"></span></td>
																	<td><span id="SPLOTAMT_1"></span></td> -->
																</tr>
																<tr>
																	<td>Spl Sun OT<span id="SPLSUNOT" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPLSUNOT">0</span></td> -->
																	<td><span id="splSunOtRate"></span><span id="SPLSUNOTAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLSUNOTAMT"></span></td>
																	<td><span id="SPLSUNOT_1">0</span></td>
																	<td><span id="splSunOtRate_1"></span></td>
																	<td><span id="SPLSUNOTAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>LEGAL HOL DUTY<span id="LEGALHOLDUTY" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="LEGALHOLDUTY">0</span></td> -->
																	<td><span id="LEGALDUTYRATEDDD">20</span><span id="LEGALHOLDUTYAMT" style="display: block;color: blue;font-size: smaller;">0</span></td>
																	<!-- <td><span id="LEGALHOLDUTYAMT">0</span></td>
																	<td><span id="LEGALHOLDUTY_11">0</td>
																	<td><span id="LEGALDUTYRATE_11">0</span></td>
																	<td><span id="LEGALHOLDUTYAMT_1">0</span></td> -->
																</tr>
																<tr>
																	<td>Legal OT<span id="LEGALHOLOT" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="LEGALHOLOT">0</span></td> -->
																	<td><span id="legHolyOTRate">0</span><span id="LEGALHOLOTAMT" style="display: block;color: blue;font-size: smaller;">0</span></td>
																	<!-- <td><span id="LEGALHOLOTAMT">0</span></td>
																	<td><span id="LEGALHOLOT_1">0</span></td>
																	<td><span id="LEGALHOLOTRATE_11">0</span></td>
																	<td><span id="LEGALHOLOTAMT_ 11">0</span></td> -->
																</tr>
																<tr>
																	<td>LEGAL PAY\B-DAY PAY<span id="LEGALPAYBDAYPAYCount" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="LEGALPAYBDAYPAYCount"></span></td> -->
																	<td><span id="LEGALPAYBDAYPAYS">0.00</span><span id="LEGALPAYBDAYPAYAMT" style="display: block;color: blue;font-size: smaller;"></span><span id="LEGALPAYAMT" style="display: block;color: blue;font-size: smaller;">11</span></td>
																	<!-- <td><span id="LEGALPAYBDAYPAYAMT"></span><span id="LEGALPAYAMT">11</span></td>
																	<td>0</td>
																	<td><span id="LEGALPAYBDAYPAYSadj">0</span></td>
																	<td><span id="">0.00</span></td> -->
																</tr>
																<tr>
																	<td>Night Premium<span id="NP" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="NP"></span></td> -->
																	<td><span id="NPRATE"></span><span id="NPAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="NPAMT"></span></td>
																	<td><span id="NP_1"></span></td>
																	<td><span id="NPRATE_1"></span></td>
																	<td><span id="NPAMT_1"></span></td> -->
																</tr>
																<tr>
																	<td>Late<span id="late" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="late"></span></td> -->
																	<td><span id="lateRate"></span><span id="LATEAMT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="LATEAMT"></span></td>
																	<td>0</td>
																	<td><span id="lateRateadj"> 0</span></td>
																	<td><span> 0</span></td> -->
																</tr>
																<tr>
																	<td>Absent<span id="ABSENTUNDERTIME" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="ABSENTUNDERTIME"></span></td> -->
																	<td><span id="ABSENTRATE"></span><span id="ABSAMOUNT" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="ABSAMOUNT"></span></td>
																	<td>0</td>
																	<td><span span id="ABSENTRATEadj">0</span></td>
																	<td><span>0.00</span></td> -->
																</tr>
															</tbody>
														</table>

														<span style="font-weight: bold;color: blue;" id="previosRatelbl">PREVIOUS RATE</span>
														<!-- margin-left: -25px !important; -->
														<table class="table table-borderless" style="font-size:14px;" id="previosRateTbl"> 
															<thead>
																<th>EARNINGS<span style="display: block;font-size: 10px;color: blue;">NO</span><span style="display: block;font-size: 10px;color: blue;">ADJ NO</span></th>
																<!-- <th></th> -->
																<th>RATE<span style="display: block;font-size: 10px;color: blue;">AMOUNT</span> <span style="display: block;font-size: 10px;color: #bc6be3;">ADJ AMT</span></th>
																<!-- <th>AMOUNT</th>
																<th></th>
																<th>ADJUSTMENT</th>
																<th></th> -->
															</thead>
															<tbody>
																<tr>
																	<td>Reg Days work<span id="regDaysold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="regDaysold"></span></td> -->
																	<td><span style="cursor: pointer" id="basicRateprev"></span><span id="basicPayold" style="display: block;color: blue;font-size: smaller;"></span></span>
																	</td>
																	<!-- <td>
																		<span id="basicPayold"></span>
																	</td>
																	<td><span id="regDays2old"></span></td>
																	<td style="width: 80px;"><span id="regDaysrateold"></span></td>
																	<td><span id="ADJUSTMENTAMTold">0</span></td> -->
																</tr>
																<tr>
																	<td>Reg Overtime<span id="regOTold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="regOTold">0</span></td> -->
																	<td><span id="otRateold"></span><span id="regOTAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="regOTAMTold"></span></td>
																	<td><span id="regOT1old">0</span></td>
																	<td><span id="regOTrate_1old"></span></td>
																	<td><span id="regOTAMT_1old">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Duty<span id="sunDutyold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="sunDutyold"></span></td> -->
																	<td><span id="sunDRateold"></span><span id="SUNDUTYAMTold" style="display: block;color: blue;font-size: smaller;">0</span></td>
																	<!-- <td><span id="SUNDUTYAMTold">0</span></td>
																	<td><span id="sunDuty1old">0</span></td>
																	<td><span id="sunDutyrate_1old">3</span></td>
																	<td><span id="SUNDUTYAMT_1old">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun OT<span id="SUNOTold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="SUNOTold"></span></td> -->
																	<td><span id="sunDOTRateold"></span><span id="SUNOTAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SUNOTAMTold"></span></td>
																	<td><span id="SUNOT1old">0</span></td>
																	<td><span id="SUNOTRate2old">4</span></td>
																	<td><span id="SUNOTAMOUNTold">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Legal Duty<span id="SUNLEGALDUTYold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SUNLEGALDUTYold">0</span></td> -->
																	<td><span id="sunLRateold"></span><span id="SUNLEGALAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SUNLEGALAMTold"></span></td>
																	<td><span id="SUNLEGALDUTY1old">0</td>
																	<td><span id="sunLRate_1old">0</span></td>
																	<td><span id="SUNLEGALAMT_1old">0</span></td> -->
																</tr>
																<tr>
																	<td>Sun Legal OT<span id="SUNLEGALOTold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SUNLEGALOTold">0</span></td> -->
																	<td><span id="sunLOTRateold"></span><span id="SUNLEGALOTAMTold" style="display: block;color: blue;font-size: smaller;">0.00</span></td>
																	<!-- <td><span id="SUNLEGALOTAMTold">0.00</span></td>
																	<td><span id="SUNLEGALOT_1old">0</td>
																	<td><span id="SUNLEGALOTrate_1old"></span></td>
																	<td><span id="SUNLEGALOTAMT_1old"></span></td> -->
																</tr>
																<tr>
																	<td>Spl Duty<span id="SPECIALDUTYold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPECIALDUTYold">0</span></td> -->
																	<td><span id="splDutyRateold"></span><span id="SPLDUTYAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLDUTYAMTold"></span></td>
																	<td><span id="SPECIALDUTY_1old">0</span></td>
																	<td><span id="splDutyRate_1old">7</span></td>
																	<td><span id="SPLDUTYAMT_1old">0</span></td> -->
																</tr>
																<tr>
																	<td>Spl OT<span id="SPECIALOTold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPECIALOTold">0</span></td> -->
																	<td><span id="splDutyOTRateold"></span><span id="SPLOTAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLOTAMTold"></span></td>
																	<td><span id="SPECIALOT_1old">0</span></td>
																	<td><span id="splDutyOTRate_1old"></span></td>
																	<td><span id="SPLOTAMT_1old"></span></td> -->
																</tr>
																<tr>
																	<td>Spl Sun OT<span id="SPLSUNOTold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="SPLSUNOTold">0</span></td> -->
																	<td><span id="splSunOtRateold"></span><span id="SPLSUNOTAMTold" style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="SPLSUNOTAMTold"></span></td>
																	<td><span id="SPLSUNOT_1old">0</span></td>
																	<td><span id="splSunOtRate_1old"></span></td>
																	<td><span id="SPLSUNOTAMT_1old">0</span></td> -->
																</tr>
																<tr>
																	<td>LEGAL HOL DUTY<span id="LEGALHOLDUTYold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="LEGALHOLDUTYold">0</span></td> -->
																	<!-- <td><span id="LEGALDUTYold">0</span></td>
																	<td><span id="LEGALHOLDUTYAMTold1">0</span></td>
																	<td><span id="LEGALHOLDUTY_1old1">0</td>
																	<td><span id="LEGALDUTYRATE_1old1">0</span></td>
																	<td><span id="LEGALHOLDUTYAMT_1old1">0</span></td> -->
																</tr>
																<tr>
																	<td>Legal OT<span id="LEGALHOLOTold" style="display: block;color: blue; font-size: smaller;;">0</span></td>
																	<!-- <td><span id="LEGALHOLOTold">0</span></td> -->
																	<td><span id="legHolyOTRateold">0</span><span id="LEGALHOLOTAMTold"  style="display: block;color: blue;font-size: smaller;">0</span></td>
																	<!-- <td><span id="LEGALHOLOTAMTold">0</span></td>
																	<td><span id="LEGALHOLOT_1old1">0</span></td>
																	<td><span id="LEGALHOLOTRATE_1old1">0</span></td>
																	<td><span id="LEGALHOLOTAMT_ 1old1">0</span></td> -->
																</tr>
																<tr>
																	<td>LEGAL PAY\B-DAY PAY<span id="LEGALPAYBDAYPAYCountold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="LEGALPAYBDAYPAYCountold"></span></td> -->
																	<td><span id="LEGALPAYBDAYPAYold"></span><span id="LEGALPAYBDAYPAYAMTold"  style="display: block;color: blue;font-size: smaller;"></span><span id="LEGALPAYAMTold"  style="display: block;color: blue;font-size: smaller;">0.00</span></td>
																	<!-- <td><span id="LEGALPAYBDAYPAYAMTold"></span><span id="LEGALPAYAMTold">0.00</span></td>
																	<td>0</td>
																	<td><span id="LEGALPAYBDAYPAYoldadj">0</span></td>
																	<td><span id="">0.00</span></td> -->
																</tr>
																<tr>
																	<td>Night Premium<span id="NPold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="NPold"></span></td> -->
																	<td><span id="NPRATEold"></span><span id="NPAMTold"  style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="NPAMTold"></span></td>
																	<td><span id="NP_1old"></span></td>
																	<td><span id="NPRATE_1old"></span></td>
																	<td><span id="NPAMT_1old"></span></td> -->
																</tr>
																<tr>
																	<td>Late<span id="lateold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="lateold"></span></td> -->
																	<td><span id="lateRateold"></span><span id="LATEAMTold"  style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="LATEAMTold"></span></td>
																	<td>0</td>
																	<td><span id="lateRateoldadj"> 0</span></td>
																	<td><span> 0</span></td> -->
																</tr>
																<tr>
																	<td>Absent<span id="ABSENTUNDERTIMEold" style="display: block;color: blue; font-size: smaller;;"></span></td>
																	<!-- <td><span id="ABSENTUNDERTIMEold"></span></td> -->
																	<td><span id="ABSENTRATEold"></span><span id="ABSAMOUNTold"  style="display: block;color: blue;font-size: smaller;"></span></td>
																	<!-- <td><span id="ABSAMOUNTold"></span></td>
																	<td>0</td>
																	<td><span id="ABSENTRATEoldadj">0</span></td>
																	<td><span>0.00</span></td> -->
																</tr>
															</tbody>
														</table>
														
													</div>
													</p>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingThree">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
														<i class="icon fa fa-briefcase"></i>
														DEDUCTIONS
													</a>
												</h4>
											</div>
											<div id="collapseThree" class="panel-collapse collapse shadow" role="tabpanel" aria-labelledby="headingThree">
												<div class="panel-body">
													<table collspading="0" class="table table-borderless" id="deductions" style="font-size: 14px;"></table> 
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingTwo">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														<i class="icon fa fa-briefcase"></i>
														ADDITIONAL
													</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse shadow" role="tabpanel" aria-labelledby="headingTwo">
												<div class="panel-body">
													<p>
														<div class="container addPay row" style="margin-top: 20px;font-size: 14px;">
														<!-- <div class="row">
															<div class="col">
																<b style="font-size: medium;">ADD</b>
															</div>
															<div class="col">
															</div>
														</div> -->
														<table class="table table-borderless">
															<thead>
																<th colspan="2" style="text-center">ADDITIONAL</th>
															</thead>
															<tbody>
																<tr>
																	<td>MEAL ALLOW</td>
																	<td><span id="mealallow">0</span></td>
																</tr>
																<tr>
																	<td>MOTOR RENTAL/ALLOW</td>
																	<td><span  id="motorental">0</span></td>
																</tr>
																<tr>
																	<td>13 MONTH ADJUSTMENT</td>
																	<td><span id="13THMONTHADJUSTMENT">0</span></td>
																</tr>
																<tr>
																	<td>VL AMOUNT</td>
																	<td><span id="VLpay">0</span></td>
																</tr>
															</tbody>
														</table>
														</div>
													</p>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingFour">
												<h4 class="panel-title">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
														<i class="icon fa fa-address-card"></i>
														NET PAY
													</a>
												</h4>
											</div>
											<div id="collapseFour" class="panel-collapse collapse shadow" role="tabpanel" aria-labelledby="headingFour">
												<div class="panel-body">
													<p class="row">
														<!-- <div class="container gPay" style="font-size: 11px;font-weight: 700;" id="grossPrev">
															<div class="prgpay">
																<div class="row" style="font-size:14px">
																	<span><span style="right: 297px;">PREV. GROSS PAY</span><span style="cursor: pointer;float: right; margin-right: 25px;padding-bottom: 10px;" id="prevGrossPay"></span></span>
																</div>
															</div>
														</div> -->
														<div class="gPay">
															<div class="row" style="font-size:14px">
																<span><span style="right: 297px;">GROSS PAY</span><span style="font-weight: bold;cursor: pointer;float: right; margin-right: 25px;padding-bottom: 10px;" id="grossPayAll"></span><span style="font-weight: bold;cursor: pointer;float: right; margin-right: 25px;padding-bottom: 10px;" id="grossPayAllWithOut"></span></span>
															</div>
														</div>
														<div class="netPay">
															<div class="row" style="font-size:14px">
																<span><span style="right: 297px;">NET PAY</span><span style="font-weight: bold;cursor: pointer;float: right; margin-right: 25px;padding-bottom: 10px;" id="NETPAY"></span></span>
															</div>
														</div> 
													</p>
												</div>
											</div>
										</div>
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

        //use your USER ID
		var otp = '<?php echo $FourDigitRandomNumber = rand(1231,7879) ?>';
		<?php date_default_timezone_set('Asia/Manila'); ?>
		var date = '<?php echo date('d F Y, h:i:s A') ?>';
		var idnumber = '<?=$idnumber?>';
		emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj"); //use your USER ID

		const toSend =  {
			otp: otp,
			date: date,
			to_email: '<?php echo $email; ?>',
			name: '<?php echo strtoupper($fullname); ?>'
		};

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

		emailjs.send('service_37v4ai9', 'template_csnv174', toSend) //use your Service ID and Template ID
		.then(function(response) {
			console.log('SUCCESS!', response.status, response.text);
		}, function(error) {
			console.log('FAILED...', error);
		});

	}

   })();

   function printPayslip() {
		$('#payslipMainContainer').printThis();
		$("#basicRate").click();
   }
</script>
