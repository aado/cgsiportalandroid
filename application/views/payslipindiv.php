<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= site_url('public/css/payslip.css'); ?>">

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
		<table id="paySlipTable" class="table" style="width:100%">
			<thead style="opacity: .5; font-size: 20px; color: dodgerblue">
				<tr>
					<th>Period</th>
					<!-- <th>Payroll Cut off</th> -->
					<!-- <th>Uploaded Date</th> -->
					<th>View</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($payslipList as $payslip) {
						if ($payslip['published'] == 1) {
							echo '<tr>';
							echo '<td><span style="font-weight: bold;color: cornflowerblue;">'.date('M d Y', strtotime($payslip['payroll_period'])).'</span><span style="font-size: 10px;
                            opacity: .5; display: block">Cut-off: '.$payslip['payroll_cutoff'].'</span></td>';
							if($payslip['payroll_period'] == '2023-10-20') {
								echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#payslipViewModal" onclick="viewPayslipwithadj('.$payslip['payslip_id'].','.$idnumber.')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button><span style="font-size: 10px;
                                opacity: .5; display: block">Up: '.date('M d Y', strtotime($payslip['created'])).'</span></td>';
							} else {
								echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#payslipViewModal" onclick="viewPayslip('.$payslip['payslip_id'].','.$idnumber.')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button><span style="font-size: 10px;
                                opacity: .5; display: block">Up: '.date('M d Y', strtotime($payslip['created'])).'</span></td>';
							}
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="payslipViewModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-body" id="payslipMainContainer" style="font-size: 1px">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="row" style="margin-left: 35%;margin-top: 10px;">
						<div class="col-sm">
							<span class="payslipHeader"><img class="img-profile" style="width: 60px;height: 52px;margin-top: 0px;margin-left: -65px; position:absolute" src="<?= site_url('public/img/cgsi.png'); ?>">CEBU GENERAL SERVICES, INC.</span>				
							<span style="font-size: 11px;display: block;">RKD BLDG., A.S FORTUNA ST., BANILAD, MANDAUE CITY	</span>
						</div>
					</div>	
					<div class="container" style="margin-top: 10px;">
						<table class="pc" style="font-size: 13px; width:100%;">
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
						<div class="payslipBody" style="margin-left: 10px; margin-top: 50px">
							<!-- <div style="font-size: 13px; color: blue; font-weight: bold;" id="lblold">OLD RATE</div> -->
							<table style="font-size:10px; width:70%;" id="oldrate">
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
										<td><span style="cursor: pointer" id="basicRate"></span></td>
										<td><span style="cursor: pointer" id="basicPay"></span></span></td>
										<td><span id="regDays2"></span></td>
										<td style="width: 80px;"><span id="regDaysrate"></span></td>
										<td><span id="ADJUSTMENTAMT">0</span></td>
									</tr>
									<tr>
										<td>Reg Overtime</td>
										<td><span id="regOT">0</span></td>
										<td><span id="otRate"></span></td>
										<td><span id="regOTAMT"></span></td>
										<td><span id="regOT1">0</span></td>
										<td><span id="regOTrate_1"></span></td>
										<td><span id="regOTAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Sun Duty</td>
										<td><span id="sunDuty"></span></td>
										<td><span id="sunDRate"></span></td>
										<td><span id="SUNDUTYAMT">0</span></td>
										<td><span id="sunDuty1">0</span></td>
										<td><span id="sunDutyrate_1">3</span></td>
										<td><span id="SUNDUTYAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Sun OT</td>
										<td><span id="SUNOT"></span></td>
										<td><span id="sunDOTRate"></span></td>
										<td><span id="SUNOTAMT"></span></td>
										<td><span id="SUNOT1">0</span></td>
										<td><span id="SUNOTRate2">4</span></td>
										<td><span id="SUNOTAMOUNT">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal Duty</td>
										<td><span id="SUNLEGALDUTY">0</span></td>
										<td><span id="sunLRate"></span></td>
										<td><span id="SUNLEGALAMT"></span></td>
										<td><span id="SUNLEGALDUTY1">0</td>
										<td><span id="sunLRate_1">0</span></td>
										<td><span id="SUNLEGALAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal OT</td>
										<td><span id="SUNLEGALOT">0</span></td>
										<td><span id="sunLOTRate"></span></td>
										<td><span id="SUNLEGALOTAMT">0.00</span></td>
										<td><span id="SUNLEGALOT_1">0</td>
										<td><span id="SUNLEGALOTrate_1"></span></td>
										<td><span id="SUNLEGALOTAMT_1"></span></td>
									</tr>
									<tr>
										<td>Spl Duty</td>
										<td><span id="SPECIALDUTY">0</span></td>
										<td><span id="splDutyRate"></span></td>
										<td><span id="SPLDUTYAMT"></span></td>
										<td><span id="SPECIALDUTY_1">0</span></td>
										<td><span id="splDutyRate_1">7</span></td>
										<td><span id="SPLDUTYAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Spl OT</td>
										<td><span id="SPECIALOT">0</span></td>
										<td><span id="splDutyOTRate"></span></td>
										<td><span id="SPLOTAMT"></span></td>
										<td><span id="SPECIALOT_1">0</span></td>
										<td><span id="splDutyOTRate_1"></span></td>
										<td><span id="SPLOTAMT_1"></span></td>
									</tr>
									<!-- <tr>
										<td>RATE ADJ</td>
										<td>0</td>
										<td><span id="ADJUSTMENT"></span></td>
										<td>-</td>
										<td>0</td>
										<td><span id="adjustment9">9</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr> -->
									<tr>
										<td>Spl Sun OT</td>
										<td><span id="SPLSUNOT">0</span></td>
										<td><span id="splSunOtRate"></span></td>
										<td><span id="SPLSUNOTAMT"></span></td>
										<td><span id="SPLSUNOT_1">0</span></td>
										<td><span id="splSunOtRate_1"></span></td>
										<td><span id="SPLSUNOTAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Legal Duty</td>
										<td><span id="LEGALHnewUTY"></span></td>
										<td><span id="LEGALDUTY"></span></td>
										<td><span id="LEGALHnewUTYAMT"></span></td>
										<td><span id="LEGALHnewUTY_1">0</td>
										<td><span id="LEGALDUTYRATE_1"></span></td>
										<td><span id="LEGALHnewUTYAMT_1"></span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOT"></span></td>
										<td><span id="legHolyOTRate"></span></td>
										<td><span id="LEGALHOLOTAMT"></span></td>
										<td><span id="LEGALHOLOT_1">0</span></td>
										<td><span id="LEGALHOLOTRATE_1">0</span></td>
										<td><span id="LEGALHOLOTAMT_ 1">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td><span id="LEGALPAYBDAYPAYCount"></span></td>
										<td><span id="LEGALPAYBDAYPAY"></span></td>
										<td><span id="LEGALPAYBDAYPAYAMT"></span></td>
										<td>0</td>
										<td><span id="">0</span></td>
										<td><span id="">0.00</span></td>
									</tr>
									<tr>
										<td>Night Premium</td>
										<td><span id="NP"></span></td>
										<td><span id="NPRATE"></span></td>
										<td><span id="NPAMT"></span></td>
										<td><span id="NP_1"></span></td>
										<td><span id="NPRATE_1"></span></td>
										<td><span id="NPAMT_1"></span></td>
									</tr>
									<tr>
										<td>Late</td>
										<td><span id="late"></span></td>
										<td><span id="lateRate"></span></td>
										<td><span id="LATEAMT"></span></td>
										<td>0</td>
										<td><span> 0</span></td>
										<td><span> 0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIME"></span></td>
										<td><span id="ABSENTRATE"></span></td>
										<td><span id="ABSAMOUNT"></span></td>
										<td>0</td>
										<td><span>0</span></td>
										<td><span>0.00</span></td>
									</tr>
								</tbody>
							</table>

							<div class="container gPay" style="font-size: 11px;font-weight: 700; margin-left: -20px;" id="grossPrev">
								<div class="row">
									<div class="col-4">
										Prev. Gross Pay
									</div>
									<div class="col">
										<span><span style="position: absolute;"></span>
										<span style="font-weight: bold; cursor: pointer" id="prevGrossPay"></span></span>
									</div>
								</div>
								<!-- <hr /> -->
							</div>

							<!-- new RATE -->
							<div style="font-size: 13px; color: blue; font-weight: bold;" id="lblnew">NEW RATE</div>
							<table style="font-size:10px; width:70%;" id="newrate">
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
										<td><span id="regDaysnew"></span></td>
										<td>
											<i class="fa fa-money-bill" style="margin-left: 0px;color: blue;" aria-hidden="true" onclick="showbasicRatenew(this)"></i>
											<span>
											<span style="cursor: pointer; display: none" id="basicRatenew"></span></span>
										</td>
										<td>
											<i class="fa fa-money-bill" style="margin-left: 0px;color: blue;" aria-hidden="true" onclick="showbasicPaynew(this)"></i><span style="display: none; cursor: pointer" id="basicPaynew"></span></span>
										</td>
										<td><span id="regDays2new"></span></td>
										<td style="width: 80px;"><span id="regDaysratenew"></span></td>
										<td><span id="ADJUSTMENTAMTnew">0</span></td>
									</tr>
									<tr>
										<td>Reg Overtime</td>
										<td><span id="regOTnew">0</span></td>
										<td><span id="otRatenew"></span></td>
										<td><span id="regOTAMTnew"></span></td>
										<td><span id="regOT1new">0</span></td>
										<td><span id="regOTrate_1new"></span></td>
										<td><span id="regOTAMT_1new">0</span></td>
									</tr>
									<tr>
										<td>Sun Duty</td>
										<td><span id="sunDutynew"></span></td>
										<td><span id="sunDRatenew"></span></td>
										<td><span id="SUNDUTYAMTnew">0</span></td>
										<td><span id="sunDuty1new">0</span></td>
										<td><span id="sunDutyrate_1new">3</span></td>
										<td><span id="SUNDUTYAMT_1new">0</span></td>
									</tr>
									<tr>
										<td>Sun OT</td>
										<td><span id="SUNOTnew"></span></td>
										<td><span id="sunDOTRatenew"></span></td>
										<td><span id="SUNOTAMTnew"></span></td>
										<td><span id="SUNOT1new">0</span></td>
										<td><span id="SUNOTRate2new">4</span></td>
										<td><span id="SUNOTAMOUNTnew">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal Duty</td>
										<td><span id="SUNLEGALDUTYnew">0</span></td>
										<td><span id="sunLRatenew"></span></td>
										<td><span id="SUNLEGALAMTnew"></span></td>
										<td><span id="SUNLEGALDUTY1new">0</td>
										<td><span id="sunLRate_1new">0</span></td>
										<td><span id="SUNLEGALAMT_1new">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal OT</td>
										<td><span id="SUNLEGALOTnew">0</span></td>
										<td><span id="sunLOTRatenew"></span></td>
										<td><span id="SUNLEGALOTAMTnew">0.00</span></td>
										<td><span id="SUNLEGALOT_1new">0</td>
										<td><span id="SUNLEGALOTrate_1new"></span></td>
										<td><span id="SUNLEGALOTAMT_1new"></span></td>
									</tr>
									<tr>
										<td>Spl Duty</td>
										<td><span id="SPECIALDUTYnew">0</span></td>
										<td><span id="splDutyRatenew"></span></td>
										<td><span id="SPLDUTYAMTnew"></span></td>
										<td><span id="SPECIALDUTY_1new">0</span></td>
										<td><span id="splDutyRate_1new">7</span></td>
										<td><span id="SPLDUTYAMT_1new">0</span></td>
									</tr>
									<tr>
										<td>Spl OT</td>
										<td><span id="SPECIALOTnew">0</span></td>
										<td><span id="splDutyOTRatenew"></span></td>
										<td><span id="SPLOTAMTnew"></span></td>
										<td><span id="SPECIALOT_1new">0</span></td>
										<td><span id="splDutyOTRate_1new"></span></td>
										<td><span id="SPLOTAMT_1new"></span></td>
									</tr>
									<tr>
										<td>Spl Sun OT</td>
										<td><span id="SPLSUNOTnew">0</span></td>
										<td><span id="splSunOtRatenew"></span></td>
										<td><span id="SPLSUNOTAMTnew"></span></td>
										<td><span id="SPLSUNOT_1new">0</span></td>
										<td><span id="splSunOtRate_1new"></span></td>
										<td><span id="SPLSUNOTAMT_1new">0</span></td>
									</tr>
									<tr>
										<td>Legal Duty</td>
										<td><span id="LEGALHnewUTYnew"></span></td>
										<td><span id="LEGALDUTYnew"></span></td>
										<td><span id="LEGALHnewUTYAMTnew"></span></td>
										<td><span id="LEGALHnewUTY_1new">0</td>
										<td><span id="LEGALDUTYRATE_1new"></span></td>
										<td><span id="LEGALHnewUTYAMT_1new"></span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOTnew"></span></td>
										<td><span id="legHolyOTRatenew"></span></td>
										<td><span id="LEGALHOLOTAMTnew"></span></td>
										<td><span id="LEGALHOLOT_1new">0</span></td>
										<td><span id="LEGALHOLOTRATE_1new">0</span></td>
										<td><span id="LEGALHOLOTAMT_ 1new">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td><span id="LEGALPAYBDAYPAYCountnew"></span></td>
										<td><span id="LEGALPAYBDAYPAYnew"></span></td>
										<td><span id="LEGALPAYBDAYPAYAMTnew"></span></td>
										<td>0</td>
										<td><span id="">0</span></td>
										<td><span id="">0.00</span></td>
									</tr>
									<tr>
										<td>Night Premium</td>
										<td><span id="NPnew"></span></td>
										<td><span id="NPRATEnew"></span></td>
										<td><span id="NPAMTnew"></span></td>
										<td><span id="NP_1new"></span></td>
										<td><span id="NPRATE_1new"></span></td>
										<td><span id="NPAMT_1new"></span></td>
									</tr>
									<tr>
										<td>Late</td>
										<td><span id="latenew"></span></td>
										<td><span id="lateRatenew"></span></td>
										<td><span id="LATEAMTnew"></span></td>
										<td>0</td>
										<td><span> 0</span></td>
										<td><span> 0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIMEnew"></span></td>
										<td><span id="ABSENTRATEnew"></span></td>
										<td><span id="ABSAMOUNTnew"></span></td>
										<td>0</td>
										<td><span>0</span></td>
										<td><span>0.00</span></td>
									</tr>
								</tbody>
							</table>
							<table id="deductions"></table>
						</div>
						<div class="container gPay">
							<div class="row">
								<div class="col">
								GROSS PAY
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; display: none; cursor: pointer" id="grossPay"></span><i class="fa fa-money-bill" style="margin-left: 80px;font-size: 20px;color: blue;" aria-hidden="true" onclick="showGrossPay(this)"></i></span>
								</div>
							</div>
							<!-- <div class="row">
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
							</div> -->
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
									<span  id="monthlyGrossPay3">0</span>
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

	<div class="modal fade" id="payslipViewModal2" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-body" id="payslipMainContainer2" style="font-size: 1px">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="row" style="margin-left: 35%;margin-top: 10px;">
						<div class="col-sm">
							<span class="payslipHeader"><img class="img-profile" style="width: 60px;height: 52px;margin-top: 0px;margin-left: -65px; position:absolute" src="<?= site_url('public/img/cgsi.png'); ?>">CEBU GENERAL SERVICES, INC.</span>				
							<span style="font-size: 11px;display: block;">RKD BLDG., A.S FORTUNA ST., BANILAD, MANDAUE CITY	</span>
						</div>
					</div>	
					<div class="container" style="margin-top: 10px;">
						<table class="pc" style="font-size: 13px; width:100%;">
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
						<div class="payslipBody" style="margin-left: 10px; margin-top: 50px">
							<table style="font-size:10px; width:70%;" id="fluid">
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
											<span style="display: none; cursor: pointer" id="basicRate"></span> <span style="cursor: pointer" id="basicRateprev"></span></span>
										</td>
										<td>
											<i class="fa fa-money-bill" style="margin-left: 0px;color: blue;" aria-hidden="true" onclick="showbasicPay(this)"></i><span style="display: none; cursor: pointer" id="basicPay"></span></span>
										</td>
										<td><span id="regDays2"></span></td>
										<td style="width: 80px;"><span id="regDaysrate"></span></td>
										<td><span id="ADJUSTMENTAMT">0</span></td>
									</tr>
									<tr>
										<td>Reg Overtime</td>
										<td><span id="regOT">0</span></td>
										<td><span id="otRate"></span></td>
										<td><span id="regOTAMT"></span></td>
										<td><span id="regOT1">0</span></td>
										<td><span id="regOTrate_1"></span></td>
										<td><span id="regOTAMT_1">0</span></td>
									</tr>
									<!-- <tr>
										<td>Reg Days Adj</td>
										<td><span id="regdaysadj">0</span></td>
										<td><span id="regdaysadjrate"></span></td>
										<td><span id="regdaysamt"></span></td>
										<td><span id="">0</span></td>
										<td><span id="prevbasicadj"></td>
										<td><span id="">0</span></td>
									</tr> -->
									<tr>
										<td>Sun Duty</td>
										<td><span id="sunDuty"></span></td>
										<td><span id="sunDRate"></span></td>
										<td><span id="SUNDUTYAMT">0</span></td>
										<td><span id="sunDuty1">0</span></td>
										<td><span id="sunDutyrate_1">3</span></td>
										<td><span id="SUNDUTYAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Sun OT</td>
										<td><span id="SUNOT"></span></td>
										<td><span id="sunDOTRate"></span></td>
										<td><span id="SUNOTAMT"></span></td>
										<td><span id="SUNOT1">0</span></td>
										<td><span id="SUNOTRate2">4</span></td>
										<td><span id="SUNOTAMOUNT">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal Duty</td>
										<td><span id="SUNLEGALDUTY">0</span></td>
										<td><span id="sunLRate"></span></td>
										<td><span id="SUNLEGALAMT"></span></td>
										<td><span id="SUNLEGALDUTY1">0</td>
										<td><span id="sunLRate_1">0</span></td>
										<td><span id="SUNLEGALAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal OT</td>
										<td><span id="SUNLEGALOT">0</span></td>
										<td><span id="sunLOTRate"></span></td>
										<td><span id="SUNLEGALOTAMT">0.00</span></td>
										<td><span id="SUNLEGALOT_1">0</td>
										<td><span id="SUNLEGALOTrate_1"></span></td>
										<td><span id="SUNLEGALOTAMT_1"></span></td>
									</tr>
									<tr>
										<td>Spl Duty</td>
										<td><span id="SPECIALDUTY">0</span></td>
										<td><span id="splDutyRate"></span></td>
										<td><span id="SPLDUTYAMT"></span></td>
										<td><span id="SPECIALDUTY_1">0</span></td>
										<td><span id="splDutyRate_1">7</span></td>
										<td><span id="SPLDUTYAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Spl OT</td>
										<td><span id="SPECIALOT">0</span></td>
										<td><span id="splDutyOTRate"></span></td>
										<td><span id="SPLOTAMT"></span></td>
										<td><span id="SPECIALOT_1">0</span></td>
										<td><span id="splDutyOTRate_1"></span></td>
										<td><span id="SPLOTAMT_1"></span></td>
									</tr>
									<!-- <tr>
										<td>RATE ADJ</td>
										<td>0</td>
										<td><span id="ADJUSTMENT"></span></td>
										<td>-</td>
										<td>0</td>
										<td><span id="adjustment9">9</span></td>
										<td><span id="adjustment2">0</span></td>
									</tr> -->
									<tr>
										<td>Spl Sun OT</td>
										<td><span id="SPLSUNOT">0</span></td>
										<td><span id="splSunOtRate"></span></td>
										<td><span id="SPLSUNOTAMT"></span></td>
										<td><span id="SPLSUNOT_1">0</span></td>
										<td><span id="splSunOtRate_1"></span></td>
										<td><span id="SPLSUNOTAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Legal Duty</td>
										<td><span id="LEGALHnewUTY"></span></td>
										<td><span id="LEGALDUTY"></span></td>
										<td><span id="LEGALHnewUTYAMT"></span></td>
										<td><span id="LEGALHnewUTY_1">0</td>
										<td><span id="LEGALDUTYRATE_1"></span></td>
										<td><span id="LEGALHnewUTYAMT_1"></span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOT"></span></td>
										<td><span id="legHolyOTRate"></span></td>
										<td><span id="LEGALHOLOTAMT"></span></td>
										<td><span id="LEGALHOLOT_1">0</span></td>
										<td><span id="LEGALHOLOTRATE_1">0</span></td>
										<td><span id="LEGALHOLOTAMT_ 1">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td><span id="LEGALPAYBDAYPAYCount"></span></td>
										<td><span id="LEGALPAYBDAYPAY"></span></td>
										<td><span id="LEGALPAYBDAYPAYAMT"></span></td>
										<td>0</td>
										<td><span id="">0</span></td>
										<td><span id="">0.00</span></td>
									</tr>
									<tr>
										<td>Night Premium</td>
										<td><span id="NP"></span></td>
										<td><span id="NPRATE"></span></td>
										<td><span id="NPAMT"></span></td>
										<td><span id="NP_1"></span></td>
										<td><span id="NPRATE_1"></span></td>
										<td><span id="NPAMT_1"></span></td>
									</tr>
									<tr>
										<td>Late</td>
										<td><span id="late"></span></td>
										<td><span id="lateRate"></span></td>
										<td><span id="LATEAMT"></span></td>
										<td>0</td>
										<td><span> 0</span></td>
										<td><span> 0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIME"></span></td>
										<td><span id="ABSENTRATE"></span></td>
										<td><span id="ABSAMOUNT"></span></td>
										<td>0</td>
										<td><span>0</span></td>
										<td><span>0.00</span></td>
									</tr>
								</tbody>
							</table>
							<table id="deductions"></table>
						</div>
						<div class="container gPay">
							<div class="row">
								<div class="col">
								GROSS PAY
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; display: none; cursor: pointer" id="grossPay"></span><i class="fa fa-money-bill" style="margin-left: 80px;font-size: 20px;color: blue;" aria-hidden="true" onclick="showGrossPay(this)"></i></span>
								</div>
							</div>
							<!-- <div class="row">
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
							</div> -->
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
									<span  id="monthlyGrossPay3">0</span>
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
