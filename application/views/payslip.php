<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style>
	.tablePay {
		table-layout: fixed;
		border-collapse: collapse;
		border: 1px solid purple;
	}

	div.payslipBody{
		margin: 4px, 4px;
		padding: 4px;
		width: 1095px;
		overflow-x: auto;
		overflow-y: auto;
		white-space: nowrap;
		height: 700px;
	}

	.tablePay td { 
		table-layout: fixed;
		/* width: 100%; */
		border-collapse: collapse;
		border: 1px solid #dfbdbd; 
		padding: 5px  
	}

	.tablePay th { 
		table-layout: fixed;
		/* width: 100%; */
		border-collapse: collapse;
		border: 1px solid #dfbfdf;
		padding: 6px;
		font-size: 10px; 
	}
	.payslipHeader {
		font-style: oblique;
		font-family: math;
		font-weight: bold;
		font-size: 20px;
	}
</style>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<?php if ($idnumber == '300146') { ?>
	<div style="margin-top: -20px;">
		<form id="frmPayslip">
			<div class="row">
				<div class="col-md-6">
					<label for="pp" class="col-sm-6 col-form-label">Payroll period</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" id="payroll_period" name='payroll_period'>
					</div>
				</div>
				<div class="col-md-6">
					<label for="pp" class="col-sm-6 col-form-label">Payroll cutoff</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" id="payroll_cutoff" name='payroll_cutoff' readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label for="pp" class="col-sm-6 col-form-label">Payroll Excel</label>
					<div class="col-sm-12">
						<input class="form-control" type="file" name='excel_file' id="fileUpload"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<span style="position: absolute;right: 146px;top: -35px; color: blue" id="res_message"></span>
					<button type="submit" class="btn btn-primary" id="upload" value="Submit" style="float: right; margin-top: -40px !important; margin-right: 5px"><i class="fa fa-save"></i> Submit</button>
				</div>
			</div>
		</form>
	</div>
	<hr />
	
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
							echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#payslipViewModal" onclick="viewPayslip('.$payslip['payslip_id'].')"><span style="cursor: pointer"><i class="fa fa-eye" aria-hidden="true"></i></span></button><button class="btn btn-danger" onclick="removePayslip('.$payslip['payslip_id'].')" style="margin-left: 5px"><span style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></span></button></td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="payslipViewModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
			<div class="modal-header">
					<div class="row">
						<div class="col-sm">
							<span class="payslipHeader">CEBU GENERAL SERVICES, INC.</span>				
							<span style="font-size: 11px;display: block;">RKD BLDG., A.S FORTUNA ST., BANILAD, MANDAUE CITY	</span>
						</div>
					</div>	

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<div style="right: 70px;top: 28px;position: absolute;">
					<input type="text" id="searchPayslip" class="form-control" placeholder="Type to search" style="float: right;margin-bottom: 5px; width: 240px">
				</div>
			</div>
			<div class="modal-body">
				<span style="text-decoration: underline;color: blue;cursor: pointer;font-weight: 800; display: none; margin-left: 25px;" id="showPayrollbtn" onclick="showPayroll()"> Back </span>
				<div id="allPayrollDiv">
					<div class="container">
						<div class="row" style="margin-left: -25px;">
							<div class="col-sm">
								<label for="pp" class="col-sm-6 col-form-label">Payroll period: </label>
								<span id="pperiodlbl" style="font-weight: light !important"></span>
							</div>
							<div class="col-sm">
								<label for="pp" class="col-sm-6 col-form-label">Payroll cutoff: </label>
								<span id="pcutofflbl" style="font-weight: light"></span>
							</div>
						</div>
					</div>
					<div class="payslipBody" id="payslipBody">
						<table id="payslipTbl" class="tablePay" style="font-size: 9px;"></table>
					</div>
				</div>
				<div id="paySlipDiv" style="border: 1px solid gray; display: none; margin-top: 15px;margin-bottom: 23px; background: lightgray;">
					<div class="container" style="margin-top: 10px;">
						<table style="font-size: 13px; width:100%">
							<tr>
								<td>ID NO</td>
								<td style="font-weight: bold;"><span id="idNumber"></span></td>
								<td>ACCT. NO.</td>
								<td><span id="accntNum" style="font-weight: bold;"></span></td>
							</tr>
							<tr>
								<td>NAME</td>
								<td style="font-weight: bold;"><span id="empName"></span><span style="display: block;font-size: 10px;"><label id="jobDescription"></label></span></td>
								<td>TIN</td>
								<td><span id="tinno" style="font-weight: bold;"></span></td>
							</tr>
						</table>
					</div>
					<div id="payslipContainer">
						<div style="margin-left: 25px; margin-top: 10px">
							<span style="font-size: 13px;font-weight: bold;color: blue;" id="previosRatelbl">PREVIOUS RATE</span>
							<table style="font-size:10px; width:70%" id="previosRateTbl">
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
										<td><span id="regDaysold"></span></td>
										<td><span style="cursor: pointer" id="basicRateprev"></span></span>
										</td>
										<td>
											<span id="basicPayold"></span>
										</td>
										<td><span id="regDays2old"></span></td>
										<td style="width: 80px;"><span id="regDaysrateold"></span></td>
										<td><span id="ADJUSTMENTAMTold">0</span></td>
									</tr>
									<tr>
										<td>Reg Overtime</td>
										<td><span id="regOTold">0</span></td>
										<td><span id="otRateold"></span></td>
										<td><span id="regOTAMTold"></span></td>
										<td><span id="regOT1old">0</span></td>
										<td><span id="regOTrate_1old"></span></td>
										<td><span id="regOTAMT_1old">0</span></td>
									</tr>
									<tr>
										<td>Sun Duty</td>
										<td><span id="sunDutyold"></span></td>
										<td><span id="sunDRateold"></span></td>
										<td><span id="SUNDUTYAMTold">0</span></td>
										<td><span id="sunDuty1old">0</span></td>
										<td><span id="sunDutyrate_1old">3</span></td>
										<td><span id="SUNDUTYAMT_1old">0</span></td>
									</tr>
									<tr>
										<td>Sun OT</td>
										<td><span id="SUNOTold"></span></td>
										<td><span id="sunDOTRateold"></span></td>
										<td><span id="SUNOTAMTold"></span></td>
										<td><span id="SUNOT1old">0</span></td>
										<td><span id="SUNOTRate2old">4</span></td>
										<td><span id="SUNOTAMOUNTold">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal Duty</td>
										<td><span id="SUNLEGALDUTYold">0</span></td>
										<td><span id="sunLRateold"></span></td>
										<td><span id="SUNLEGALAMTold"></span></td>
										<td><span id="SUNLEGALDUTY1old">0</td>
										<td><span id="sunLRate_1old">0</span></td>
										<td><span id="SUNLEGALAMT_1old">0</span></td>
									</tr>
									<tr>
										<td>Sun Legal OT</td>
										<td><span id="SUNLEGALOTold">0</span></td>
										<td><span id="sunLOTRateold"></span></td>
										<td><span id="SUNLEGALOTAMTold">0.00</span></td>
										<td><span id="SUNLEGALOT_1old">0</td>
										<td><span id="SUNLEGALOTrate_1old"></span></td>
										<td><span id="SUNLEGALOTAMT_1old"></span></td>
									</tr>
									<tr>
										<td>Spl Duty</td>
										<td><span id="SPECIALDUTYold">0</span></td>
										<td><span id="splDutyRateold"></span></td>
										<td><span id="SPLDUTYAMTold"></span></td>
										<td><span id="SPECIALDUTY_1old">0</span></td>
										<td><span id="splDutyRate_1old">7</span></td>
										<td><span id="SPLDUTYAMT_1old">0</span></td>
									</tr>
									<tr>
										<td>Spl OT</td>
										<td><span id="SPECIALOTold">0</span></td>
										<td><span id="splDutyOTRateold"></span></td>
										<td><span id="SPLOTAMTold"></span></td>
										<td><span id="SPECIALOT_1old">0</span></td>
										<td><span id="splDutyOTRate_1old"></span></td>
										<td><span id="SPLOTAMT_1old"></span></td>
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
										<td><span id="SPLSUNOTold">0</span></td>
										<td><span id="splSunOtRateold"></span></td>
										<td><span id="SPLSUNOTAMTold"></span></td>
										<td><span id="SPLSUNOT_1old">0</span></td>
										<td><span id="splSunOtRate_1old"></span></td>
										<td><span id="SPLSUNOTAMT_1old">0</span></td>
									</tr>
									<tr>
										<td>LEGAL HOL DUTY</td>
										<td><span id="LEGALHOLDUTYold">0</span></td>
										<td><span id="LEGALDUTYold">0</span></td>
										<td><span id="LEGALHOLDUTYAMTold1">0</span></td>
										<td><span id="LEGALHOLDUTY_1old1">0</td>
										<td><span id="LEGALDUTYRATE_1old1">0</span></td>
										<td><span id="LEGALHOLDUTYAMT_1old1">0</span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOTold">0</span></td>
										<td><span id="legHolyOTRateold">0</span></td>
										<td><span id="LEGALHOLOTAMTold">0</span></td>
										<td><span id="LEGALHOLOT_1old1">0</span></td>
										<td><span id="LEGALHOLOTRATE_1old1">0</span></td>
										<td><span id="LEGALHOLOTAMT_ 1old1">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td><span id="LEGALPAYBDAYPAYCountold"></span></td>
										<td><span id="LEGALPAYBDAYPAYold"></span></td>
										<td><span id="LEGALPAYBDAYPAYAMTold"></span><span id="LEGALPAYAMTold">0.00</span></td>
										<td>0</td>
										<td><span id="LEGALPAYBDAYPAYoldadj">0</span></td>
										<td><span id="">0.00</span></td>
									</tr>
									<tr>
										<td>Night Premium</td>
										<td><span id="NPold"></span></td>
										<td><span id="NPRATEold"></span></td>
										<td><span id="NPAMTold"></span></td>
										<td><span id="NP_1old"></span></td>
										<td><span id="NPRATE_1old"></span></td>
										<td><span id="NPAMT_1old"></span></td>
									</tr>
									<tr>
										<td>Late</td>
										<td><span id="lateold"></span></td>
										<td><span id="lateRateold"></span></td>
										<td><span id="LATEAMTold"></span></td>
										<td>0</td>
										<td><span id="lateRateoldadj"> 0</span></td>
										<td><span> 0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIMEold"></span></td>
										<td><span id="ABSENTRATEold"></span></td>
										<td><span id="ABSAMOUNTold"></span></td>
										<td>0</td>
										<td><span id="ABSENTRATEoldadj">0</span></td>
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
								<hr />
							</div>
							
							<span  style="font-size: 13px;font-weight: bold;color: blue;" id="newRatelbl">NEW RATE</span>
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
											<span style="cursor: pointer" id="basicRate"></span></span>
										</td>
										<td>
											<span id="basicPay"></span>
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
										<td>LEGAL HOL DUTY</td>
										<td><span id="LEGALHOLDUTY">0</span></td>
										<td><span id="LEGALDUTYRATEDDD">20</span></td>
										<td><span id="LEGALHOLDUTYAMT">0</span></td>
										<td><span id="LEGALHOLDUTY_11">0</td>
										<td><span id="LEGALDUTYRATE_11">0</span></td>
										<td><span id="LEGALHOLDUTYAMT_1">0</span></td>
									</tr>
									<tr>
										<td>Legal OT</td>
										<td><span id="LEGALHOLOT">0</span></td>
										<td><span id="legHolyOTRate">0</span></td>
										<td><span id="LEGALHOLOTAMT">0</span></td>
										<td><span id="LEGALHOLOT_1">0</span></td>
										<td><span id="LEGALHOLOTRATE_11">0</span></td>
										<td><span id="LEGALHOLOTAMT_ 11">0</span></td>
									</tr>
									<tr>
										<td>LEGAL PAY\B-DAY PAY</td>
										<td><span id="LEGALPAYBDAYPAYCount"></span></td>
										<td><span id="LEGALPAYBDAYPAYS">0.00</span></td>
										<td><span id="LEGALPAYBDAYPAYAMT"></span><span id="LEGALPAYAMT">11</span></td>
										<td>0</td>
										<td><span id="LEGALPAYBDAYPAYSadj">0</span></td>
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
										<td><span id="lateRateadj"> 0</span></td>
										<td><span> 0</span></td>
									</tr>
									<tr>
										<td>Absent</td>
										<td><span id="ABSENTUNDERTIME"></span></td>
										<td><span id="ABSENTRATE"></span></td>
										<td><span id="ABSAMOUNT"></span></td>
										<td>0</td>
										<td><span span id="ABSENTRATEadj">0</span></td>
										<td><span>0.00</span></td>
									</tr>
								</tbody>
							</table>
						</div>
						 <table id="deductions" style="font-size: 10px;float: right;margin-top: -30%;margin-right: 31px;"></table> 
						
						<div class="container gPay" style="font-size: 11px;font-weight: 700;">
							<div class="row" style="margin-top: 1%;">
								<div class="col-4">
									Gross Pay
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; cursor: pointer" id="grossPay"></span></span>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
									Monthly Gross Pay
								</div>
								<div class="col">
									<span><span style="position: absolute;"></span>
									<span style="font-weight: bold; cursor: pointer" id="monthlyGrossPay"></span></span>
								</div>
							</div>
						</div>
						
						<div class="container addPay" style="margin-top: 20px;font-size: 11px;">
							
							<div class="row">
								<div class="col">
									<b style="font-size: medium;">ADD</b>
								</div>
								<div class="col">
								</div>
							</div>
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
									<span  id="13THMONTHADJUSTMENT">0</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									VL AMOUNT
								</div>
								<div class="col">
									<span  id="VLpay">0</span>
								</div>
							</div>
						</div>
						<div class="netPay">
							<div class="row" style="font-size:14px">
								<span><span style="position: absolute;right: 297px;">NET PAY</span><span style="font-weight: bold;cursor: pointer;float: right; margin-right: 25px;padding-bottom: 10px;" id="NETPAY"></span></span>
							</div>
						</div>
						<div style="position: absolute;right: 11px;bottom: 10px;width: 18px;">
							<div class="row" style="font-size:14px">
								<i class="fa fa-print" style="font-size: x-large;color: darkslategrey;" aria-hidden="true" onclick="printPayslip()" ></i>
							</div>
						</div>
					</div>
				</div>
				<?php } else {
					 header("Location: /cgsiportal/PayslipIndiv");
				} ?>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-base64@2.5.2/base64.min.js"></script>
<script type="text/javascript"
   src="https://cdn.jsdelivr.net/npm/emailjs-com@2.4.0/dist/email.min.js">
</script>
<script src="<?= site_url('public/js/payslip.js'); ?>"></script>
